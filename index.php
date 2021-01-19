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
    }
    $stmt -> execute();
    $todasDisciplinas = $stmt -> fetchAll();
    if (count($todasDisciplinas) == 0) {
        die("Erro critico. Por favor contacte um administrador.");
    }
    $dataAtual = new DateTime();
    $dataAtual->setISODate(date("Y"), date("W"));
    $semanaPeriod = new DatePeriod(
        new DateTime($dataAtual->format("Y-m-d")),
        new DateInterval('P1D'),
        new DateTime($dataAtual->modify("+7 days")->format("Y-m-d"))
    );
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
        <h1>
            Semana <?php echo date("W"." \d\\e Y"); ?>
        </h1>
        <div class="diasSemana">
            <?php
                foreach($semanaPeriod as $dataOmg) {
                    $diaDaSemana = date("w", strtotime($dataOmg->format("Y-m-d")));
                    if ($diaDaSemana == date("w")) {
                        echo "<div class='dia hoje'>";
                    } else {
                        echo "<div class='dia'>";
                    }
                    switch($diaDaSemana) {
                        case 0:
                            $nomeDia = "Domingo";
                        break;
                        case 1:
                            $nomeDia = "Segunda";
                        break;
                        case 2:
                            $nomeDia = "Terça";
                        break;
                        case 3:
                            $nomeDia = "Quarta";
                        break;
                        case 4:
                            $nomeDia = "Quinta";
                        break;
                        case 5:
                            $nomeDia = "Sexta";
                        break;
                        case 6:
                            $nomeDia = "Sábado";
                        break;
                                
                    }
                    echo "<div>$nomeDia</div><div>".$dataOmg->format("d-m-Y")."</div></div>";
                }
            ?>
        </div>
        <div class="content">
            <h1>
                Disciplinas
            </h1>
            <div class="disciplinasContainer">
                <?php
                    if ( isset($todasDisciplinas) ) {
                        $i = 0;
                        define("MAX", 5);
                        if ( isset($eProfessor) && $eProfessor ) {
                            foreach($todasDisciplinas as $disciplina) {
                                echo "
                                    <div class='disciplina'>
                                        <a href='aulaProfessor.php?turma=".$disciplina["idTurma"]."&disciplina=".$disciplina["id"]."'>
                                            ".$disciplina["curso"]." (".$disciplina["anoLetivo"].") - ".$disciplina["nome"]."
                                            </a>
                                    </div>
                                ";
                                $i = $i + 1;
                                if ($i == MAX) {
                                    break;
                                }
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
                                $i = $i + 1;
                                if ($i == MAX) {
                                    break;
                                }
                            }
                        }
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