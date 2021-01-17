<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
    }
    seAdminVaiDashboard();
    include("./php/bd.php");

    if (strcmp($loginData["tipo"], TIPO_ALUNO) == 0) {
        $query = "
            SELECT d.id AS id, d.nome AS nome
            FROM Turma AS t
                INNER JOIN Curso AS c ON t.idCurso = c.id
                INNER JOIN Curso_Disciplina AS cd ON c.id = cd.idCurso
                INNER JOIN Disciplina AS d ON cd.idDisciplina = d.id
            WHERE t.id = :id
            ORDER BY d.nome;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $loginData["idTurma"]);
    } elseif (strcmp($loginData["tipo"], TIPO_PROFESSOR) == 0) {
        $eProfessor = true;
        $query = "
            SELECT al.nome AS anoLetivo, c.nome AS curso, t.id AS idTurma, d.id AS id, d.nome AS nome
            FROM Turma AS t
                INNER JOIN AnoLetivo AS al ON t.idAnoLetivo = al.id
                INNER JOIN Curso AS c ON t.idCurso = c.id
                INNER JOIN Curso_Disciplina AS cd ON c.id = cd.idCurso
                INNER JOIN Disciplina AS d ON cd.idDisciplina = d.id
                INNER JOIN Disciplina_Professor AS dp ON d.id = dp.idDisciplina
                INNER JOIN Professor AS p ON dp.idProfessor = p.id
            WHERE p.id = :id
            ORDER BY al.nome, c.nome, d.nome;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $loginData["idUser"]);
    } else {
        gotoLogout();
        exit();
    }

    $stmt -> execute();
    $todasDisciplinas = $stmt -> fetchAll();
    if (count($todasDisciplinas) == 0) {
        die("Erro critico. Por favor contacte um administrador.");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/disciplinas.css">
    <script src="js/hiddenContent.js"></script>

    <title>Todas as disciplinas</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="mainContainer">
        <div class="searchbar">
            <button>
                ok
            </button>
            <input type="text" name="search" placeholder="search">
        </div>
        <div class="disciplinasContainer">
            <?php
                if ( isset($todasDisciplinas) ) {
                    if ( isset($eProfessor) && $eProfessor ) {
                        foreach($todasDisciplinas as $disciplina) {
                            echo "
                                <div class='disciplina'>
                                    <a href='aulaProfessor.php?turma=".$disciplina["idTurma"]."&disciplina=".$disciplina["id"]."'>
                                        ".$disciplina["curso"]." (".$disciplina["anoLetivo"].") - ".$disciplina["nome"]."
                                        </a>
                                </div>
                            ";
                        }
                    } else {
                        foreach($todasDisciplinas as $disciplina) {
                            echo "
                                <div class='disciplina'>
                                    <a href='aulaAluno.php?disciplina=".$disciplina["id"]."'>
                                        ".$disciplina["nome"]."
                                    </a>
                                </div>
                            ";
                        }
                    }
                }
            ?>
        </div>
    </div>
    
</body>
</html>