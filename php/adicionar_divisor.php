<?php
    include("bd.php");
    include("funcoes.php");
    if (isset($_POST["nomeAula"]) && isset($_POST["disciplina"]) && isset($_POST["turma"])) {
        if (strlen($_POST["nomeAula"]) <= 4) {
            mostraAlert("Nome da aula tem que ter no mínimo 4 caracteres");
            gotoAulaProfessor($_POST["turma"], $_POST["disciplina"]);
            die();
        }
        $query = "
            INSERT INTO divisor (nome, idTurma, idDisciplina) 
            VALUES (:nome, :idTurma, :idDisciplina);
        ";
        $stmt = $dbo->prepare($query);
        $stmt->bindValue("nome", $_POST["nomeAula"]);
        $stmt->bindValue("idTurma", $_POST["turma"]);
        $stmt->bindValue("idDisciplina", $_POST["disciplina"]);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            mostraAlert("Erro ao adicionar divisor");
            gotoAulaProfessor($_POST["turma"], $_POST["disciplina"]);
            die();
        } else {
            mostraAlert("Divisor adicionado");
            gotoAulaProfessor($_POST["turma"], $_POST["disciplina"]);
            die();
        }
    } else {
        gotoIndex();
        die();
    }
?>