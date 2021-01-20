<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
        exit();
    }
    seAdminVaiDashboard();

    include("./php/bd.php");

    $eVisitante = false;
    if ( isset($_GET["id"]) && isset($_GET["tipo"]) ) {
        $tempTipo = $_GET["tipo"];
        if (strcmp($tempTipo,TIPO_ALUNO) == 0 || strcmp($tempTipo,TIPO_PROFESSOR) == 0 ) {
            $eVisitante = true;
            $toList = array(
                "idUser" => $_GET["id"],
                "tipo" => $tempTipo
            );
        } else {
            gotoIndex();
            exit();
        }   
    } else {
        $toList = array(
            "idUser" => $loginData["idUser"],
            "tipo" => $loginData["tipo"]
        );
    }

    if ( strcmp($toList["tipo"],TIPO_ALUNO) == 0 ) {
        $query = "
            SELECT a.id, a.nome, a.email, a.ultimo_login, c.nome AS curso, al.nome AS anoLetivo
            FROM Aluno AS a
                INNER JOIN Turma AS t ON a.idTurma = t.id
                INNER JOIN AnoLetivo AS al ON t.idAnoLetivo = al.id
                INNER JOIN Curso AS c ON t.idCurso = c.id
            WHERE a.id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $toList["idUser"]);
        $stmt -> execute();
        if ($stmt -> rowCount() != 1) {
            header("location: ./php/logout.php");
            die();
        }
        $infoPerfil = $stmt -> fetch();
    } elseif ( strcmp($toList["tipo"],TIPO_PROFESSOR) == 0 ) {
        $query = "
            SELECT *
            FROM Professor AS p
            WHERE p.id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $toList["idUser"]);
        $stmt -> execute();
        if ($stmt -> rowCount() != 1) {
            header("location: ./php/logout.php");
            die();
        }
        $infoPerfil = $stmt -> fetch();
        
        $query = "
            SELECT d.nome AS disciplina, c.nome AS curso
            FROM Professor AS p
                INNER JOIN Disciplina_Professor AS dp ON p.id = dp.idProfessor
                INNER JOIN Disciplina AS d ON dp.idDisciplina = d.id
                INNER JOIN Curso_Disciplina AS cd ON d.id = cd.idDisciplina
                INNER JOIN Curso AS c ON cd.idCurso = c.id
            WHERE p.id = :id
            ORDER BY c.nome, d.nome;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $toList["idUser"]);
        $stmt -> execute();
        $profDisciplinas = $stmt -> fetchAll();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/hiddenContent.js"></script>
    <title>Perfil | <?php echo $infoPerfil["nome"]; ?></title>
    <link rel="icon" href="images/logo.svg">
</head>
<body>
    <?php
        include("navbar.php");
    ?>
        
    <div class="container">
        <div class="imgContainer">
            <img class="profileImg" src="images/maleAvatar.svg" alt="">
        </div>
        <div class="infoContainer">
            <?php
                if( strcmp($toList["tipo"],TIPO_ALUNO) == 0 ) {
                    echo "
                        <p>
                            <b>Número de aluno</b>: ".$infoPerfil["id"]."
                        </p>
                        <p>
                            <b>Nome</b>: ".$infoPerfil["nome"]."
                        </p>
                        <p>
                            <b>Email</b>: ".$infoPerfil["email"]."
                        </p>
                        <p>
                            <b>Turma</b>: ".$infoPerfil["curso"]." (".$infoPerfil["anoLetivo"].")
                        </p>
                    ";
                } elseif ( strcmp($toList["tipo"],TIPO_PROFESSOR) == 0 ) {
                    echo "
                        <p>
                            <b>Número de professor</b>: ".$infoPerfil["id"]."
                        </p>
                        <p>
                            <b>Nome</b>: ".$infoPerfil["nome"]."
                        </p>
                        <p>
                            <b>Email</b>: ".$infoPerfil["email"]."
                        </p>
                    ";
                    echo "<p>Disciplinas (Curso) que leciona: </p>";
                    if (count($profDisciplinas) == 0) {
                        echo "<p>Nenhuma</p>";
                    } else {
                        foreach($profDisciplinas as $disciplina) {
                            echo "
                                <p>
                                    > ".$disciplina["disciplina"]." (".$disciplina["curso"].")
                                </p>
                            ";
                        }
                    }
                } else {
                    session_destroy();
                    die("Erro critico, contacte um administrador!");
                }
            ?>
        </div>
        <?php

            if(!$eVisitante) {
                echo "
                    <div class='submitBtn'>
                        <a href='editData.php' class='editarbtn'>Editar dados</a> 
                    </div>
                ";
            }
        ?>
        <div class="acessoContainer">
            <p>
                Último acesso em: <?php echo date("d-m-Y \á\s H:i:s", strtotime($infoPerfil["ultimo_login"])) ?>
            </p>
        </div>
        
    </div>
</body>
</html>