<?php
    include("funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
    }
    seAdminVaiDashboard();
    if (strcmp($loginData["tipo"], TIPO_PROFESSOR) != 0) {
        gotoIndex();
    }

    if (isset($_GET["id"]) && isset($_GET["turma"]) && isset($_GET["disciplina"])) {
        include("bd.php");
        

        $idTurma = $_GET["turma"];
        $idDisciplina = $_GET["disciplina"];

        $query = "
            DELETE FROM Codigo
            WHERE id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $_GET["id"]);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Apagou com sucesso!");
            gotoAulaProfessor($idTurma, $idDisciplina);
            exit();
        } else {
            mostraAlert("Não foi possivel apagar!");
            gotoAulaProfessor($idTurma, $idDisciplina);
            exit();
        }
    }

?>