<?php

    include("./php/bd.php");
    $query = "
        SELECT *
        FROM Aluno
        ORDER BY id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todosAlunos = $stmt -> fetchAll();

    $query = "
        SELECT t.id AS turmaId, a.nome AS anoLetivo, c.nome AS curso
        FROM Turma AS t
            INNER JOIN Curso AS c ON t.idCurso = c.id
            INNER JOIN AnoLetivo AS a ON t.idAnoLetivo = a.id
        ORDER BY turmaId;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todasTurmas = $stmt -> fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/formGestao.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/hiddenContent.js"></script>

    <title>Document</title>
</head>
<body>
    <header>
        <div class="headerLeft">
            <div class="logoContainer">
                <a href="home.html">
                    <p>Logotipo</p>
                </a>
            </div>
            <div class="navbar">
                
                <a href="home.html" class="navBarItem">Homepage</a>
                <a href="disciplinas.html" class="navBarItem">Disciplinas</a>
                <a href="calendario.html" class="navBarItem">Calendario</a>
            </div>
        </div>
        <div class="headerProfile">
            <div class="dropdownBox">
                <img onclick="notificacaoMenuFun()" class="profileNotificacoes " src="images/bell.png" alt="">
                <div id="notificacoesMenu" class="notificacoesMenu ">
                    <p>
                        Prof.Paulo Lava. É para entregar...
                    </p>
                    <p>
                        Prof.Paulo Lava. É para entregar...
                    </p>
                    <p>
                        Prof.Paulo Lava. É para entregar...
                    </p>
                    <p>
                        Prof.Paulo Lava. É para entregar...
                    </p>
                    <a href="" class="notificacoesBtn">
                        Todas
                    </a>
                </div>
              </div>
            
            <div class="dropdownBoxProfile">
                <a  href="profile.html"><img class="profileImg " src="images/user.png" alt=""></a>
                <div id="profileMenu" class="profileMenus">
                  <a href="#">Perfil</a>
                  <a href="#">Definições</a>
                  <a href="#">logout</a>
                </div>
              </div>

        </div>
        
    </header>
    <div class="mainContainer">
        <div class="formContainerPessoas">
            <div class="formBox">
                <form action="php/adicionar_aluno.php" method="POST">
                    <p>Adicionar Aluno</p>
                    <div class="formRow">
                        <label for="nomeAluno">Nome:<sup>*</sup></label>
                        <input type="text" name="nomeAluno" required>
                    </div>
                    <div class="formRow">
                        <label for="numberAluno">Número de Aluno:</label>
                        <input type="number" name="numberAluno">
                    </div>
                    <div class="formRow">
                        <label for="emailAluno">Email:<sup>*</sup></label>
                        <input type="email" name="emailAluno" required>
                    </div>
                    <div class="formRow">
                        <label for="passwordAluno">Password:<sup>*</sup></label>
                        <input type="password" name="passwordAluno" required>
                    </div>
                    <div class="formRow">
                        <label for="turmaAluno">Selecione turma:<sup>*</sup></label>
                        <select name="turmaAluno">
                            <?php
                                foreach($todasTurmas as $turma) {
                                    echo "
                                        <option value='".$turma["turmaId"]."'>
                                            ".$turma["curso"]." - ".$turma["anoLetivo"]."
                                        </option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <input type="submit" value="Adicionar">
                </form> 
            </div>



            <div class="formBox">
                <form action="php/adicionar_professor.php" method="POST">
                    <p>Adicionar Professor</p>
                    <div class="formRow">
                        <label for="nomeProfessor">Nome:<sup>*</sup></label>
                        <input type="text" name="nomeProfessor" required>
                    </div>
                    <div class="formRow">
                        <label for="numberProfessor">Número de professor:</label>
                        <input type="number" name="numberProfessor">
                    </div>
                    <div class="formRow">
                        <label for="emailProfessor">Email:<sup>*</sup></label>
                        <input type="email" name="emailProfessor" required>
                    </div>
                    <div class="formRow">
                        <label for="passwordProfessor">Password:<sup>*</sup></label>
                        <input type="password" name="passwordProfessor" required>
                    </div>
                    <input type="submit" value="Adicionar">
                </form>
            </div> 
        </div>



        <div class="formContainerDisciplinas">
            <div class="formBox">
                <form action="php/adicionar_disciplina.php" method="POST">
                    <p>Adicionar Disciplina</p>
                    <div class="formRow">
                        <label for="nomeDisciplina">Nome:</label>
                        <input type="text" name="nomeDisciplina">
                    </div>
                    <input type="submit" value="Adicionar">
                </form>
            </div>



            <div class="formBox">
                <form action="">
                    <p>Adicionar Professor á disciplina</p>
                    <div class="formRow">
                        <label for="selectAluno">Aluno:</label>
                        <select name="opcaoAluno">
                            <option value="alunoA">Aluno A</option>
                            <option value="alunoB">Aluno B</option>
                        </select>
                    </div>
                    <div class="formRow">
                        <label for="selectDisciplina">Selecione disciplina:</label>
                        <select name="opcaoDisciplina">
                            <option value="disciplinaA">Disciplina A</option>
                            <option value="disciplinaB">Disciplina B</option>
                        </select>
                    </div>
                    <input type="submit" value="Adicionar">
                </form>
            </div>
        </div>
        <div class="searchbar">
            <button>
                ok
            </button>
            <input type="text" name="search" placeholder="search">
        </div>
        
        <p>Lista alunos</p>
        <div class="formContainerListaAlunos">
            <div class="listaAluno">
                <div class="numeroAluno">
                    <p>ID Aluno</p>
                </div>
                <div class="nomeAluno">
                    <p>Nome</p>
                </div>
                <div class="mailAluno">
                    <p>Email</p>
                </div>
                <div class="removeAluno">
                    <p>Remover</p>
                </div>
            </div>
            <?php
                foreach($todosAlunos as $aluno) {
                    echo "
                        <div class='listaAluno'>
                            <div class='numeroAluno'>
                                <p>". $aluno["id"] ."</p>
                            </div>
                            <div class='nomeAluno'>
                                <p>". $aluno["nome"] ."</p>
                            </div>
                            <div class='mailAluno'>
                                <p>". $aluno["email"] ."</p>
                            </div>
                            <div class='removeAluno'>
                                <a href='./php/eliminar_aluno.php?id=". $aluno["id"] ."'>
                                    <img width='25' height='25' src='./images/trash.svg'>    
                                </a>
                            </div>
                        </div>
                    ";
                }
            ?>
        </div>
    </div>
</body>
</html>