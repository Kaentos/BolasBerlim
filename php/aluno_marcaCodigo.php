<?php

    include("funcoes.php");
    include("bd.php");
    if (isset($_POST["codigo"]) && isset($_POST["idDisciplina"])) {
        $loginData = getLoginData();
        if ($loginData == null) {
            gotoLogin();
            exit();
        }

        if (strcmp($loginData["tipo"], TIPO_ALUNO) != 0 ) {
            gotoIndex();
            exit();
        }

        $infoCodigo = array(
            "codigo" => $_POST["codigo"],
            "idTurma" => $loginData["idTurma"],
            "idDisciplina" => $_POST["idDisciplina"]
        );
        $query = "
            SELECT *
            FROM Codigo
            WHERE nome = :codigo AND idTurma = :idTurma AND idDisciplina = :idDisciplina;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($infoCodigo);
        if ($stmt -> rowCount() != 1) {
            exit("Não válido");
        }
        exit("válido");
    }

?>