<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
    }
    seAdminVaiDashboard();

    include("./php/bd.php");
    $query = "
        SELECT d.id AS id, d.nome AS nome
        FROM Turma AS t
            INNER JOIN Curso AS c ON t.idCurso = c.id
            INNER JOIN Curso_Disciplina AS cd ON c.id = cd.idCurso
            INNER JOIN Disciplina AS d ON cd.idDisciplina = d.id
        WHERE t.id = :id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindValue("id", $loginData["idTurma"]);
    $stmt -> execute();
    $todasDisciplinas = $stmt -> fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/hiddenContent.js"></script>

    <title>Página inicial</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="mainContainer">
        <div class="diasSemana">
            <div class="dia">
                <p>Segunda</p>
            </div>
            <div class="dia">
                <p>Terça</p>
            </div>
            <div class="dia">
                <p>Quarta</p>
            </div>
            <div class="dia">
                <p>Quinta</p>
            </div>
            <div class="dia">
                <p>Sexta</p>
            </div>
            <div class="dia">
                <p>Sabado</p>
            </div>
            <div class="dia">
                <p>Domingo</p>
            </div>
        </div>
        <div class="content">
            <div class="disciplinasContainer">
                <?php
                    foreach($todasDisciplinas as $disciplina) {
                        echo "
                            <div class='disciplina'>
                                <a href='aulaAluno.php?disciplina=".$disciplina["id"]."'>".$disciplina["nome"]."</a>
                            </div>
                        ";
                    }
                ?>
            </div>
            
            <div class="infoContainer">
                <div class="compromissosContainer">
                    <div class="compromissosRow">
                        <div class="compromissosData">
                            21/10/2020
                        </div>
                        <div class="compromissosBox">
                            Apresentação de Base de Dados
                        </div>
                    </div>
                    <div class="compromissosRow">
                        <div class="compromissosData">
                            21/10/2020
                        </div>
                        <div class="compromissosBox">
                            Apresentação de Base de Dados
                        </div>
                    </div>
                </div>
                <div class="notificacoesContainer">
                    <div class="notificacoesRow">
                        <div class="notificacoesName">
                            Prof.Carlos
                        </div>
                        <div class="notificacoesBox">
                            Peço a todos os alunos......
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>