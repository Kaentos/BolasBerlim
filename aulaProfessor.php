<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
    }
    seAdminVaiDashboard();

    include("./php/bd.php");
    if ( !isset($_GET["turma"]) || !isset($_GET["disciplina"]) ) {
        gotoIndex();
    }
    $idTurma = $_GET["turma"];
    $idDisciplina = $_GET["turma"];
    
    do {
        $codigo = generateRandomString(TAMANHO_CODIGO);
        $query = "
            SELECT *
            FROM Codigo
            WHERE nome = :codigo
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("codigo", $codigo);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            continue;
        } else {
            break;
        }
    } while (true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/aulaprofessor.css" />
    <script src="js/hiddenContent.js"></script>
    <title>Disciplina</title>
    <script>
        function copiarCodigo() {
            let copyText = document.getElementById("unico_codigo");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand("copy");
        } 
    </script>
</head>

<body>
    <?php
        include("navbar.php");
    ?>
    <div class="hiddenDivs">
        <div class="listaAlunosContainer" id="listaAlunosContainer">
            <div class="tituloAlunos">
                <div class="descricaoWindow">
                    <h2>Todos os Alunos</h2>
                </div>
                <div class="exitWindow">
                    <img src="images/fechar.png" onclick="listaAlunosMenu()" />
                </div>
            </div>

            <div class="listaAlunos">
                <div class="descricaoLista">
                    <p>Nome:</p>
                    <p>Número:</p>
                </div>
                <div class="listaAlunoRow">
                    <p>Carlos</p>
                    <p>19212323</p>
                </div>
                <div class="listaAlunoRow">
                    <p>Raquel</p>
                    <p>19212323</p>
                </div>
                <div class="listaAlunoRow">
                    <p>Maria</p>
                    <p>19212323</p>
                </div>
            </div>
        </div>
        <div class="listaFicheirosContainer" id="listaFicheirosContainer">
            <div class="tituloWindow">
                <div class="descricaoWindow">
                    <h2>Submissão Trabalho 1</h2>
                </div>
                <div class="exitWindow">
                    <img src="images/fechar.png" onclick="listaFicheirosMenu()" />
                </div>
            </div>
            <div class="listaFicheiros">
                <div class="descricaoListaFicheiro">
                    <p>Submissões:</p>
                </div>
                <div class="listaFicheiroRow">
                    <div class="dataFicheiro">
                        <p>21/10/2020 - 20:20:21</p>
                    </div>
                    <div class="nomeUtilizador">
                        <p>Carlos</p>
                    </div>
                    <div class="download">
                        <p>Download</p>
                    </div>
                </div>
                <div class="listaFicheiroRow">
                    <div class="dataFicheiro">
                        <p>21/10/2020 - 20:20:21</p>
                    </div>
                    <div class="nomeUtilizador">
                        <p>Carlos</p>
                    </div>
                    <div class="download">
                        <p>Download</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mainContainer">
        <div class="tituloContainer">
            <div class="tituloDescricao">
                <p>titulo</p>
                <button class="titlebtn" onclick="listaAlunosMenu()">Alunos</button>
            </div>
            <div class="titulobotoes">
                <a href="#.html" class="titlebtn">Todos os codigos</a>
                <a href="#.html" class="titlebtn">Criar código</a>
                <a href="#.html" class="titlebtn">Criar notificação</a>
            </div>
        </div>
        <div class="listaAulas">
            lista inicio
            <form action="./php/criarCodigo.php" method="POST">
                Criar codigo
                <input type="hidden" name="turma" value='<?php echo $idTurma ?>'>
                <input type="hidden" name="disciplina" value='<?php echo $idDisciplina ?>'>
                <input type="text" id="unico_codigo" name="codigo" value='<?php echo $codigo ?>' readonly>
                <button type="button" onclick="copiarCodigo()">Copiar</button>
                Limite em minutos<sup>*</sup>
                <input type="number" name="minutos" min="1" max="30" value="5" required>
                Minimo 1 | Máximo 30 minutos
                <input type="submit" value="criar">
            </form>
            <div class="aulaContainer">
                <div class="aulaHeader">
                    <div class="aulaTitulo">
                        Aula 1 - 20/10/1928 | 8:30 - 20:30
                        <div class="profMenu">
                            <div>
                                <a href="">
                                    <img src="images/visto.png" alt="" class="profbtn"/>
                                </a>
                            </div>
                            <div>
                                <a href="">
                                    <img src="images/apagar.png" alt="" class="profbtn"/>
                                </a>
                            </div>
                            <div>
                                <a href="">
                                    <img src="images/lista.png" alt="" class="profbtn"/>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="inserirFicheiro">
                        Novo Item
                        <a href="">
                            <img src="images/plus.png" alt="" class="plusIcon"/>
                        </a>
                    </div>
                </div>
                <div class="aulaContent">
                    <div class="aulaColumn">
                        column 1
                        <div class="aulaFicheiros">
                            <div class="aulaFile">
                                <a href="">
                                    ficheiro1.docx
                                </a>
                                <div class="profMenu">
                                    <div>
                                        <a href="">
                                            <img src="images/visto.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="">
                                            <img src="images/apagar.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="">
                                            <img src="images/lista.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="aulaFile">
                                <a href="">
                                    ficheiro2.docx
                                </a>
                                <div class="profMenu">
                                    <div>
                                        <a href="">
                                            <img src="images/visto.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="">
                                            <img src="images/apagar.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="">
                                            <img src="images/lista.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aulaSubmicoes">
                            <div class="aulasubmicao">
                                <h4>Submissão Trabalho 1</h4>
                                <div class="profMenu">
                                    <div>
                                        <a href="">
                                            <img src="images/visto.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="">
                                            <img src="images/apagar.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <button>
                                            <img src="images/lista.png" onclick="listaFicheirosMenu()"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="aulasubmicao">
                                <h4>Titulo 2</h4>
                                <div class="profMenu">
                                    <div>
                                        <a href="">
                                            <img src="images/visto.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="">
                                            <img src="images/apagar.png" alt="" class="profbtn"/>
                                        </a>
                                    </div>
                                    <div>
                                        <button>
                                            <img src="images/lista.png" onclick="listaFicheirosMenu()"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aulaColumnRight">column 4</div>
                    </div>
                </div>
                <h2>Nova Aula</h2>
                <div class="newAula">
                    <input type="text" name="nomeAula" />
                    <a href="">
                        <img src="images/plus.png" alt="" class="plusIcon" />
                    </a>
                </div>
                lista end
            </div>
        </div>
    </div>
</body>
</html>
