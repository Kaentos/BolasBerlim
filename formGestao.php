<?php

    include("./php/bd.php");
    $query = "
        SELECT a.id, a.nome, a.email, c.nome AS curso, al.nome AS anoLetivo
        FROM Aluno AS a
            INNER JOIN Turma AS t ON a.idTurma = t.id
            INNER JOIN Curso AS c ON t.idCurso = c.id
            INNER JOIN AnoLetivo al ON t.idAnoLetivo = al.id
        ORDER BY a.id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todosAlunos = $stmt -> fetchAll();

    $query = "
        SELECT t.id AS turmaId, a.nome AS anoLetivo, c.nome AS curso
        FROM Turma AS t
            INNER JOIN Curso AS c ON t.idCurso = c.id
            INNER JOIN AnoLetivo AS a ON t.idAnoLetivo = a.id
        ORDER BY anoLetivo, curso;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todasTurmas = $stmt -> fetchAll();

    $query = "
        SELECT *
        FROM Disciplina
        ORDER BY nome;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todasDisciplinas = $stmt -> fetchAll();

    $query = "
        SELECT *
        FROM Curso
        ORDER BY id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todosCursos = $stmt -> fetchAll();

    $query = "
        SELECT *
        FROM Professor
        ORDER BY id;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todosProfessores = $stmt -> fetchAll();

    $query = "
        SELECT *
        FROM AnoLetivo
        ORDER BY nome;
    ";
    $stmt = $dbo -> prepare($query);
    $stmt -> execute();
    $todosAnosLetivos = $stmt -> fetchAll();

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
                                            ".$turma["anoLetivo"]." - ".$turma["curso"]."
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

            <div class="formBox">
                <form action="php/adicionar_curso.php" method="POST">
                    <p>Adicionar curso</p>
                    <div class="formRow">
                        <label for="nomeCurso">Nome:</label>
                        <input type="text" name="nomeCurso">
                    </div>
                    <input type="submit" value="Adicionar">
                </form>
            </div>
        </div>


        <div class="formContainerPessoas">
            <div class="formBox">
                <form action="php/adicionar_turma.php" method="POST">
                    <p>Criar turma</p>
                    <div class="formRow">
                        <label for="opcaoCurso">Selecione curso:<sup>*</sup></label>
                        <select name="opcaoCurso">
                            <?php
                                foreach($todosCursos as $curso) {
                                    echo "
                                        <option value='".$curso["id"]."'>
                                            ".$curso["nome"]."
                                        </option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="formRow">
                        <label for="opcaoAnoLetivo">Selecione ano letivo:<sup>*</sup></label>
                        <select name="opcaoAnoLetivo">
                            <?php
                                foreach($todosAnosLetivos as $anoLetivo) {
                                    echo "
                                        <option value='".$anoLetivo["id"]."'>
                                            ".$anoLetivo["nome"]."
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

            <div class="formBox">
                <form action="php/adicionar_curso.php" method="POST">
                    <p>Adicionar curso</p>
                    <div class="formRow">
                        <label for="nomeCurso">Nome:</label>
                        <input type="text" name="nomeCurso">
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
                <form action="php/adicionar_disciplinaCurso.php" method="POST">
                    <p>Associar disciplina a curso</p>
                    <div class="formRow">
                        <label for="opcaoDisciplina">Selecione disciplina:</label>
                        <select name="opcaoDisciplina">
                            <?php
                                foreach($todasDisciplinas as $disciplina) {
                                    echo "
                                        <option value='".$disciplina["id"]."'>
                                            ".$disciplina["nome"]."
                                        </option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="formRow">
                        <label for="opcaoCurso">Selecione curso:</label>
                        <select name="opcaoCurso">
                            <?php
                                foreach($todosCursos as $curso) {
                                    echo "
                                        <option value='".$curso["id"]."'>
                                            ".$curso["nome"]."
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
                <form action="./php/adicionar_professorDisciplina.php" method="POST">
                    <p>Adicionar Professor á disciplina</p>
                    <div class="formRow">
                        <label for="selectAluno">Professor:</label>
                        <select name="opcaoProfessor">
                            <?php
                                foreach($todosProfessores as $professor) {
                                    echo "
                                        <option value='".$professor["id"]."'>
                                            ".$professor["id"]." - ".$professor["nome"]."
                                        </option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="formRow">
                        <label for="selectDisciplina">Selecione disciplina:</label>
                        <select name="opcaoDisciplina">
                            <?php
                                foreach($todasDisciplinas as $disciplina) {
                                    echo "
                                        <option value='".$disciplina["id"]."'>
                                            ".$disciplina["nome"]."
                                        </option>
                                    ";
                                }
                            ?>
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
                <div class="mailAluno">
                    <p>Turma</p>
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
                            <div class='mailAluno'>
                                <p>". $aluno["anoLetivo"] ." - ". $aluno["curso"] ."</p>
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

        <p>Lista professores</p>
        <div class="formContainerListaAlunos">
            <div class="listaAluno">
                <div class="numeroAluno">
                    <p>ID Professor</p>
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
                foreach($todosProfessores as $professor) {
                    echo "
                        <div class='listaAluno'>
                            <div class='numeroAluno'>
                                <p>". $professor["id"] ."</p>
                            </div>
                            <div class='nomeAluno'>
                                <p>". $professor["nome"] ."</p>
                            </div>
                            <div class='mailAluno'>
                                <p>". $professor["email"] ."</p>
                            </div>
                            <div class='removeAluno'>
                                <a href='./php/eliminar_professor.php?id=". $professor["id"] ."'>
                                    <img width='25' height='25' src='./images/trash.svg'>    
                                </a>
                            </div>
                        </div>
                    ";
                }
            ?>
        </div>

        <p>Lista cursos</p>
        <div class="formContainerListaAlunos">
            <div class="listaAluno">
                <div class="numeroAluno">
                    <p>ID curso</p>
                </div>
                <div class="nomeAluno">
                    <p>Nome</p>
                </div>
                <div class="removeAluno">
                    <p>Remover</p>
                </div>
            </div>
            <?php
                foreach($todosCursos as $curso) {
                    echo "
                        <div class='listaAluno'>
                            <div class='numeroAluno'>
                                <p>". $curso["id"] ."</p>
                            </div>
                            <div class='nomeAluno'>
                                <p>". $curso["nome"] ."</p>
                            </div>
                            <div class='removeAluno'>
                                <a href='./php/eliminar_curso.php?id=". $curso["id"] ."'>
                                    <img width='25' height='25' src='./images/trash.svg'>    
                                </a>
                            </div>
                        </div>
                    ";
                }
            ?>
        </div>

        <p>Lista disciplinas</p>
        <div class="formContainerListaAlunos">
            <div class="listaAluno">
                <div class="numeroAluno">
                    <p>ID disciplina</p>
                </div>
                <div class="nomeAluno">
                    <p>Nome</p>
                </div>
                <div class="removeAluno">
                    <p>Remover</p>
                </div>
            </div>
            <?php
                foreach($todasDisciplinas as $disciplina) {
                    echo "
                        <div class='listaAluno'>
                            <div class='numeroAluno'>
                                <p>". $disciplina["id"] ."</p>
                            </div>
                            <div class='nomeAluno'>
                                <p>". $disciplina["nome"] ."</p>
                            </div>
                            <div class='removeAluno'>
                                <a href='./php/eliminar_disciplina.php?id=". $disciplina["id"] ."'>
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