<?php
    include("funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
        exit();
    }
    if (strcmp($loginData["tipo"], TIPO_PROFESSOR) != 0) {
        gotoIndex();
        exit();
    }

    if ( isset($_POST["codigo"]) && isset($_POST["minutos"]) && isset($_POST["turma"]) && isset($_POST["disciplina"]) ) {
        $info = array(
            "codigo" => $_POST["codigo"],
            "minutos" => $_POST["minutos"],
            "idTurma" => $_POST["turma"],
            "idDisciplina" => $_POST["disciplina"],
            "idProfessor" => $loginData["idUser"]
        );
        include("bd.php");
        if (strlen($info["codigo"]) == TAMANHO_CODIGO) {
            $query = "
                SELECT *
                FROM Codigo
                WHERE nome = :codigo
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("codigo", $info["codigo"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                die("codigo em uso");
            }
        } else {
            die("codigo nao valido");
        }

        if ($info["minutos"] < 1 || $info["minutos"] > 30) {
            die("minutos inválidos");
        }

        $query = "
            INSERT INTO Codigo (nome, data_criacao, data_fim, idProfessor, idDisciplina, idTurma)
            VALUES (:codigo, :dataCriacao, :dataFim, :idProfessor, :idDisciplina, :idTurma);
        ";
        $dataAtual = date('Y-m-d H:i:s');
        $dataFim = date('Y-m-d H:i:s', strtotime("+".$info["minutos"]." minutes", strtotime($dataAtual)));
        $info["dataCriacao"] = $dataAtual;
        $info["dataFim"] = $dataFim;
        unset($info["minutos"]);
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($info);
        if ($stmt -> rowCount() == 1) {
            exit("sucesso");
        } else {
            exit("fail");
        }


    } else {
        gotoIndex();
    }

?>