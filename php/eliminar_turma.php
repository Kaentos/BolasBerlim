<?php

    if (isset($_GET["id"])) {
        include("bd.php");
        include("funcoes.php");

        $query = "
            DELETE FROM Turma
            WHERE id = :id;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("id", $_GET["id"]);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Apagou com sucesso!");
            gotoFormGestao();
        } else {
            mostraAlert("Não apagou!");
            gotoFormGestao();
        }
    }

?>