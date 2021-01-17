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
        $dataAtual = date("Y-m-d H:i:s");

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
            $query = "
                SELECT *
                FROM Codigo
                WHERE idTurma = :idTurma AND idDisciplina = :idDisciplina;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> execute(array("idTurma" => $infoCodigo["idTurma"], "idDisciplina" => $infoCodigo["idDisciplina"]));
            print_r($stmt -> fetchAll());
            exit("Não válido");
        }
        $idCodigo  = $stmt -> fetch();

        if (new DateTime($dataAtual) > new DateTime($idCodigo["data_fim"]) ) {
            mostraAlert("Já passou o tempo limite para o código: " . $idCodigo["nome"]);
            gotoAulaAluno($infoCodigo["idDisciplina"]);
            exit();
        }
        
        $query = "
            SELECT *
            FROM Codigo_Aluno
            WHERE idCodigo = :idCodigo AND idAluno = :idAluno;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("idCodigo", $idCodigo["id"]);
        $stmt -> bindValue("idAluno", $loginData["idUser"]);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Já marcou a sua presença com o código: " . $idCodigo["nome"]);
            gotoAulaAluno($infoCodigo["idDisciplina"]);
            exit();
        }
        $query = "
            INSERT INTO Codigo_Aluno (idCodigo, idAluno, data_presenca) VALUES 
                (:idCodigo, :idAluno, :dataAtual);
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("idCodigo", $idCodigo["id"]);
        $stmt -> bindValue("idAluno", $loginData["idUser"]);
        $stmt -> bindValue("dataAtual", $dataAtual);
        $stmt -> execute();
        if ($stmt -> rowCount() == 1) {
            mostraAlert("Efetuou a sua presença com sucesso!");
            gotoAulaAluno($infoCodigo["idDisciplina"]);
            exit();
        } else {
            die("Erro critico, por favor contacte um administrador e diga ao respetivo professor que ocorreu este mesmo erro!");
        }
    }

?>