<?php
    include("./php/funcoes.php");
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
    <link rel="icon" href="images/logo.svg">
    <title>Admin | Dashboard</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="mainContainer">
    <div class="formContainerDisciplinas">
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

    </div>
    <div class="listasContainer">

            <div class="formContainerListaDuo">
                <div class="searchbar">
                    <p>Lista Cursos</p>
                    <div class="search">
                        <button>
                            ok
                        </button>
                        <input type="text" name="search" placeholder="search">
                    </div>
                </div>
                <div class="listaAluno">
                    <div class="dataColum">
                        <p class="titleBold">ID curso</p>
                    </div>
                    <div class="dataColum">
                        <p class="titleBold">Nome</p>
                    </div>
                    <div class="dataColum">
                        <p class="titleBold"> Remover</p>
                    </div>
                </div>
                <div class="ListContent">
                <?php
                    foreach($todosCursos as $curso) {
                        echo "
                            <div class='listaAluno'>
                                <div class='dataColum'>
                                    <p>". $curso["id"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $curso["nome"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <a href='./php/eliminar_curso.php?id=". $curso["id"] ."'>
                                        <img width='25' height='25' src='./images/trash.svg'>    
                                    </a>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
                
            </div>

       
            
            <div class="formContainerListaDuo">
                <div class="searchbar">
                    <p>Lista Disciplinas</p>
                    <div class="search">
                        <button>
                            ok
                        </button>
                        <input type="text" name="search" placeholder="search">
                    </div>
                </div>
                <div class="listaAluno">
                    <div class="dataColumTitle">
                        <p class="titleBold">ID disciplina</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Nome</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Remover</p>
                    </div>
                </div>
                <div class="ListContent">
                    <?php
                        foreach($todasDisciplinas as $disciplina) {
                            echo "
                                <div class='listaAluno'>
                                    <div class='dataColum'>
                                        <p>". $disciplina["id"] ."</p>
                                    </div>
                                    <div class='dataColum'>
                                        <p>". $disciplina["nome"] ."</p>
                                    </div>
                                    <div class='dataColum'>
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
        </div>
        <div class="formContainerDisciplinas">
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

    </div>
    <div class="listasContainer">

            <div class="formContainerListaDuo">
                <div class="searchbar">
                    <p>Lista Cursos</p>
                    <div class="search">
                        <button>
                            ok
                        </button>
                        <input type="text" name="search" placeholder="search">
                    </div>
                </div>
                <div class="listaAluno">
                    <div class="dataColum">
                        <p class="titleBold">ID curso</p>
                    </div>
                    <div class="dataColum">
                        <p class="titleBold">Nome</p>
                    </div>
                    <div class="dataColum">
                        <p class="titleBold">Remover</p>
                    </div>
                </div>
                <div class="ListContent">
                <?php
                    foreach($todosCursos as $curso) {
                        echo "
                            <div class='listaAluno'>
                                <div class='dataColum'>
                                    <p>". $curso["id"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $curso["nome"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <a href='./php/eliminar_curso.php?id=". $curso["id"] ."'>
                                        <img width='25' height='25' src='./images/trash.svg'>    
                                    </a>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
                
            </div>

       
            
            <div class="formContainerListaDuo">
                <div class="searchbar">
                    <p>Lista turmas</p>
                    <div class="search">
                        <button>
                            ok
                        </button>
                        <input type="text" name="search" placeholder="search">
                    </div>
                </div>
                <div class="listaAluno">
                    <div class="dataColumTitle">
                        <p class="titleBold">ID turma</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Curso</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Ano letivo</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Remover</p>
                    </div>
                </div>
                <div class="ListContent">
                    <?php
                        foreach($todasTurmas as $turma) {
                            echo "
                                <div class='listaAluno'>
                                    <div class='dataColum'>
                                        <p>". $turma["turmaId"] ."</p>
                                    </div>
                                    <div class='dataColum'>
                                        <p>". $turma["curso"] ."</p>
                                    </div>
                                    <div class='dataColum'>
                                        <p>". $turma["anoLetivo"] ."</p>
                                    </div>
                                    <div class='dataColum'>
                                        <a href='./php/eliminar_turma.php?id=". $turma["turmaId"] ."'>
                                            <img width='25' height='25' src='./images/trash.svg'>    
                                        </a>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
               
            </div>
        </div>
        <div class="formContainerDisciplinas">
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
    <div class="listasContainer">

        <div class="formContainerListaDuo">
            <div class="searchbar">
                <p>Lista Professores</p>
                <div class="search">
                    <button>
                        ok
                    </button>
                    <input type="text" name="search" placeholder="search">
                </div>
            </div>
            <div class="listaAluno">
                <div class="dataColumTitleLarge">
                    <p class="titleBold">ID Professor</p>
                </div>
                <div class="dataColumTitleLarge">
                    <p class="titleBold">Nome</p>
                </div>
                <div class="dataColumTitleLarge">
                    <p class="titleBold">Email</p>
                </div>
                <div class="dataColumTitleLarge">
                    <p class="titleBold">Remover</p>
                </div>
            </div>
            <div class="ListContent">
                <?php
                    foreach($todosProfessores as $professor) {
                        echo "
                            <div class='listaAluno'>
                                <div class='dataColum'>
                                    <p>". $professor["id"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $professor["nome"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $professor["email"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <a href='./php/eliminar_professor.php?id=". $professor["id"] ."'>
                                        <img width='25' height='25' src='./images/trash.svg'>    
                                    </a>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>

       
            
            <div class="formContainerListaDuo">
                <div class="searchbar">
                    <p>Lista Disciplinas</p>
                    <div class="search">
                        <button>
                            ok
                        </button>
                        <input type="text" name="search" placeholder="search">
                    </div>
                </div>
                <div class="listaAluno">
                    <div class="dataColumTitle">
                        <p class="titleBold">ID disciplina</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Nome</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Remover</p>
                    </div>
                </div>
                <div class="ListContent">
                    <?php
                        foreach($todasDisciplinas as $disciplina) {
                            echo "
                                <div class='listaAluno'>
                                    <div class='dataColum'>
                                        <p>". $disciplina["id"] ."</p>
                                    </div>
                                    <div class='dataColum'>
                                        <p>". $disciplina["nome"] ."</p>
                                    </div>
                                    <div class='dataColum'>
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
        </div>
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





        </div>
        <div class="listasContainer">
            <div class="formContainerListaFull">
                <div class="searchbar">
                    <p>Lista Alunos</p>
                    <div class="search">
                        <button>
                            ok
                        </button>
                        <input type="text" name="search" placeholder="search">
                    </div>
                </div>
                
                
                <div class="listaAluno">
                    <div class="dataColumTitle">
                        <p class="titleBold">ID Aluno</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Nome</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Email</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Turma</p>
                    </div>
                    <div class="dataColumTitle">
                        <p class="titleBold">Remover</p>
                    </div>
                </div>
                <?php
                    foreach($todosAlunos as $aluno) {
                        echo "
                            <div class='listaAluno'>
                                <div class='dataColum'>
                                    <p>". $aluno["id"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $aluno["nome"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $aluno["email"] ."</p>
                                </div>
                                <div class='dataColum'>
                                    <p>". $aluno["anoLetivo"] ." - ". $aluno["curso"] ."</p>
                                </div>
                                <div class='dataColum'>
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

       
    </div>
</body>
</html>