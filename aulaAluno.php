<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
        exit();
    }
    seAdminVaiDashboard();
    
    if( isset($_GET["disciplina"]) ) {
        $idDisciplina = $_GET["disciplina"];

        include("./php/bd.php");

        $query = "
            SELECT a.id
            FROM Turma as T
                INNER JOIN Aluno AS a ON t.id = a.idTurma
            WHERE a.id = :idAluno;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute(array("idAluno" => $loginData["idUser"]));
        if ($stmt -> rowCount() != 1) {
            gotoIndex();
            exit();
        }

        $query = "
            SELECT c.nome AS curso, al.nome AS anoLetivo, d.nome AS disciplina
            FROM Turma AS t
                INNER JOIN AnoLetivo AS al ON t.idAnoLetivo = al.id
                INNER JOIN Curso AS c ON t.idCurso = c.id
                INNER JOIN Curso_Disciplina AS cd ON c.id = cd.idCurso
                INNER JOIN Disciplina AS d ON cd.idDisciplina = d.id
            WHERE t.id = :idTurma AND d.id = :idDisciplina;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute(array(
            "idTurma" => $loginData["idTurma"],
            "idDisciplina" => $idDisciplina
        ));
        $titulo = $stmt -> fetch();
        if ($titulo == false) {
            gotoIndex();
            exit();
        }

        $query = "
            SELECT p.id, p.nome
            FROM Turma AS t
                INNER JOIN AnoLetivo AS al ON t.idAnoLetivo = al.id
                INNER JOIN Curso AS c ON t.idCurso = c.id
                INNER JOIN Curso_Disciplina AS cd ON c.id = cd.idCurso
                INNER JOIN Disciplina AS d ON cd.idDisciplina = d.id
                INNER JOIN Disciplina_Professor as dp ON d.id = dp.idDisciplina
                INNER JOIN Professor AS p ON dp.idProfessor = p.id
            WHERE t.id = :idTurma AND d.id = :idDisciplina
            ORDER BY p.nome;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("idTurma", $loginData["idTurma"]);
        $stmt -> bindValue("idDisciplina", $idDisciplina);
        $stmt -> execute();
        $todosProfessores = $stmt -> fetchAll();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/aulaaluno.css">
    <script src="js/hiddenContent.js"></script>

    <title>
        <?php
            echo $titulo["disciplina"] ." | ". $titulo["curso"];
        ?>
    </title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <!-- Inserir código -->
    <div class="hiddenDivs">
        <div class="inserirCodigoContainer" id="inserirCodigo">
            <div class="tituloHidden">
                <h2>Inserir Codigo</h2>
                <img src="images/fechar.png" onclick="inserirCodigo()" />
            </div>
            <div class="hiddenContent">
                <form action="./php/aluno_marcaCodigo.php" method="POST">
                    
                    <div class="hiddenRow">
                        <label for="codigoNome">Codigo*</label>
                        <input type="text" name="codigo">
                        <input type="hidden" name="idDisciplina" value="<?php echo $idDisciplina  ?>">
                    </div>
                    Professor(es):
                    <?php
                        foreach($todosProfessores as $prof) {
                            echo "
                                <a href='/Real-Learn/profile.php?id=".$prof["id"]."&tipo=".TIPO_PROFESSOR."'>
                                    ".$prof["nome"]."
                                </a><br>
                            ";
                        }
                    ?>
                    <br>
                    <input type="submit" value="Confirmar Presença">
                </form>
            </div>
        </div>
    </div>
    <div class="mainContainer">
        <div class="tituloContainer">
            <p>
                <?php echo $titulo["disciplina"] ?>
            </p>

            <div class="titulobotoes">
                <button class="titlebtn" onclick="inserirCodigo()">Inserir Codigo</button>
            </div>
        </div>
        
        <div class="listaAulas">
            
            <div class="aulaContainer">
                <div class="aulaTitulo">
                    Aula 1 - 20/10/1928 | 8:30 - 20:30
                </div>
                <div class="aulaContent">
                    <div class="aulaColumn">
                        <div class="aulaFicheiros">
                            <div class="aulaFile">
                                <a href="">ficheiro1.docx</a>
                                <input type="checkbox" name="ficheiro1">
                            </div>
                        </div>
                        <div class="aulaFicheiros">
                            <div class="aulaFile">
                                <a href="">ficheiro1.docx</a>
                                <input type="checkbox" name="ficheiro1">
                            </div>
                        </div>
                        <div class="aulaSubmicoes">
                            <div class="aulasubmicao">
                                <form action="">
                                    <h4>Titulo 1</h4>
                                    <input type="file" name="explorador" id="">
                                    <br>
                                    <input type="submit" value="submit">
                                </form>
                            </div>
                           <div class="aulasubmicao">
                            <form action="">
                                <h4>Titulo 2</h4>
                                <input type="file" name="explorador" id="">
                                <br>
                                <input type="submit" value="submit">
                            </form>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aulaContainer">
                <div class="aulaTitulo">
                    Aula 2 - 20/10/1928 | 8:30 - 20:30
                </div>
                <div class="aulaContent">
                    <div class="aulaColumn">
                        column 1
                        <div class="aulaFicheiros">
                            <div class="aulaFile">
                                <a href="">ficheiro1.docx</a>
                                <input type="checkbox" name="ficheiro1">
                            </div>
                            <div class="aulaFile">
                                <a href="">ficheiro2.docx</a>
                                <input type="checkbox" name="ficheiro2">
                            </div>
                        </div>
                        <div class="aulaSubmicoes">
                            <div class="aulasubmicao">
                                <form action="">
                                    <h4>Titulo 1</h4>
                                    <input type="file" name="explorador" id="">
                                    <br>
                                    <input type="submit" value="submit">
                                </form>
                            </div>
                           <div class="aulasubmicao">
                            <form action="">
                                <h4>Titulo 2</h4>
                                <input type="file" name="explorador" id="">
                                <br>
                                <input type="submit" value="submit">
                            </form>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>