<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
        exit();
    }
    seAdminVaiDashboard();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/aulaaluno.css">
    <script src="js/hiddenContent.js"></script>

    <title>Disciplina</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="mainContainer">
        <div class="tituloContainer">
            <p>titulo</p>
        </div>
        <div class="listaAulas">
            lista inicio
            <div class="aulaContainer">
                <div class="aulaTitulo">
                    Aula 1 - 20/10/1928 | 8:30 - 20:30
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
                    <div class="aulaColumnRight">
                        column 4
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
                    <div class="aulaColumnRight">
                        column 4
                    </div>
                </div>
            </div>
            lista end
        </div>
    </div>
</body>
</html>