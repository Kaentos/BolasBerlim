<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
        exit();
    }
    seAdminVaiDashboard();

    if (strcmp($loginData["tipo"], TIPO_PROFESSOR) != 0) {
        gotoIndex();
        exit();
    }

    include("./php/bd.php");
    if ( !isset($_GET["turma"]) || !isset($_GET["disciplina"]) ) {
        gotoIndex();
        exit();
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

    $query = "
        SELECT c.id, c.nome, c.data_criacao AS dataCriacao, c.data_fim AS dataFim
        FROM Codigo AS c
        WHERE idTurma = :idTurma AND idDisciplina = :idDisciplina
        ORDER BY dataFim DESC;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> bindValue("idTurma", $idTurma);
    $stmt -> bindValue("idDisciplina", $idDisciplina);
    $stmt -> execute();
    if ($stmt -> rowCount() == 0) {
        echo "não há codigos";
    } else {
        $todosCodigos = $stmt -> fetchAll();
        $finalCodigos = array();
        foreach($todosCodigos as $codigo) {
            $query = "
                SELECT a.nome AS nomeAluno, ca.data_presenca AS dataMarcacao
                FROM Codigo AS c
                    INNER JOIN Codigo_Aluno AS ca ON c.id = ca.idCodigo
                    INNER JOIN Aluno AS a ON ca.idAluno = a.id
                WHERE c.nome = :codigo
                ORDER BY a.nome;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("codigo", $codigo["nome"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                $finalCodigos[$codigo["nome"]] = $stmt -> fetchAll();
            }
        }
    }

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

        <!-- Lista códigos -->
        <div class="hiddenDivs">
            <div class="listaAlunosContainer" id="listaCodigos">
                <div class="tituloHidden">
                    <h2>Todos os Codigos</h2>
                    <img src="images/fechar.png" onclick="listaTodosCodigos()" />
                </div>
                <div class="hiddenContent">
                    <div class="hiddenRowTable">
                        <div class="dataColum">
                            <p>Código</p>
                        </div>
                        <div class="dataColum">
                            <p>Data Inicio</p>
                        </div>
                        <div class="dataColum">
                            <p>Data Fim</p>
                        </div>
                        <div class="dataColum">
                            <p>Ações</p>
                        </div>
                    </div>

                    <?php

                        if (isset($todosCodigos)) {
                            foreach($todosCodigos as $codigo) {
                                echo "
                                    <div class='hiddenRowTable'>
                                        <div class='dataColum'>
                                            <p>
                                                ".$codigo["nome"]."
                                            </p>
                                        </div>
                                        <div class='dataColum'>
                                            <p>
                                                ".$codigo["dataCriacao"]."
                                            </p>
                                        </div>
                                        <div class='dataColum'>
                                            <p>
                                                ".$codigo["dataFim"]."
                                            </p>
                                        </div>
                                        <div class='dataColum'>
                                            <div class='dataOption'>
                                                <div class='dataOptionRow'  onclick='verCodigo()'> 
                                                    <img src='images/lista.png'> Alunos
                                                </div>                  
                                                <div class='dataOptionRow'> 
                                                    <a href='./php/eliminar_codigo.php?id=".$codigo["id"]."&turma=$idTurma&disciplina=$idDisciplina'>
                                                        <img src='images/trash.svg'> Remover
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        }

                    ?>
                </div>
            </div>
        </div>

        <!-- Info solo código -->
        <div class="hiddenDivs">
            <div class="listaAlunosContainer" id="verCodigo">
                <div class="tituloHidden">
                    <h2>Codigo XXXX</h2>
                    <img src="images/fechar.png" onclick="verCodigo()" />
                </div>
                <div class="hiddenContent">
                    <div class="hiddenRowTable">
                        <div class="dataColum">
                            <p>Aluno</p>
                        </div>
                        <div class="dataColum">
                            <p>Data Inserção</p>
                        </div>
                    </div>
                    <div class="hiddenRowTable">
                        <div class="dataColum">
                            <p>Aluno1</p>
                        </div>
                        <div class="dataColum">
                            <p>2020-01-01 18-18-00</p>
                        </div>
                    </div>
                    <div class="hiddenRowTable">
                        <div class="dataColum">
                            <p>Alun2</p>
                        </div>
                        <div class="dataColum">
                            <p>2020-01-01 18-18-00</p>
                        </div>
                    </div>
                    <div class="hiddenRowTable">
                        <div class="dataColum">
                            <p>Aluno3</p>
                        </div>
                        <div class="dataColum">
                            <p>2020-01-01 18-18-00</p>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>

        <!-- Criar novo código -->
        <div class="hiddenDivs">
            <div class="listaAlunosContainer" id="criarCodigo">
                <div class="tituloHidden">
                    <h2>Criar Novo Codigo</h2>
                    <img src="images/fechar.png" onclick="criarCodigo()" />
                </div>
                <div class="hiddenContent">
                    <form action="./php/criarCodigo.php" method="POST">
                        <input type="hidden" name="turma" value='<?php echo $idTurma ?>'>
                        <input type="hidden" name="disciplina" value='<?php echo $idDisciplina ?>'>
                        
                        <div class="hiddenRow">
                            <label for="codigoNome">Codigo*</label>
                            <input type="text" id="unico_codigo" name="codigo" value='<?php echo $codigo ?>' readonly>
                            <button type="button" onclick="copiarCodigo()">Copiar</button>
                        </div>
                        <div class="hiddenRow">
                            <label for="codigoNome">Limite em minutos*</label>
                            <input type="number" name="minutos" min="1" max="30" value="5" required>
                            1 a 30 minutos
                        </div>
                        <br>
                        <input type="submit" value="Adicionar">
                    </form>
                </div>
            </div>
        </div>

        <!-- Criar notificação -->
        <div class="hiddenDivs">
            <div class="listaAlunosContainer" id="criarNotificacao">
                <div class="tituloHidden">
                    <h2>Criar Notificação</h2>
                    <img src="images/fechar.png" onclick="criarNotificacao()" />
                </div>
                <div class="hiddenContent">
                    <form action="" method="POST">
                        <div class="hiddenRow">
                            <label for="codigoNome">Texto*</label>
                            <input type="text" name="codigoNome" id="">
                        </div>
                        <br>
                        <input type="submit" value="Adicionar">
                    </form>
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
                <button class="titlebtn" onclick="listaTodosCodigos()">Todos Codigos</button>
                <button class="titlebtn" onclick="criarCodigo()">Criar Codigo</button>
                <button class="titlebtn" onclick="criarNotificacao()">Criar Notificação</button>
            </div>
        </div>
        <div class="listaAulas">
            lista inicio
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
