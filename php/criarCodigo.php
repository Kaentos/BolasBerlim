<?php
    include("funcoes.php");
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

    if ( isset($_POST["codigo"]) && isset($_POST["minutos"]) && isset($_POST["turma"]) && isset($_POST["disciplina"]) ) {
        $info = array(
            "codigo" => $_POST["codigo"],
            "idTurma" => $_POST["turma"],
            "idDisciplina" => $_POST["disciplina"],
            "idProfessor" => $loginData["idUser"]
        );
        $minutos = $_POST["minutos"];
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
                mostraAlert("Código ".$info["codigo"]." já criado!");
                gotoAulaProfessor($info["idTurma"], $info["idDisciplina"]);
                exit();
            }
        } else {
            mostraAlert("Código ".$info["codigo"]." inválido, precisa de ser 6 caracteres!");
            gotoAulaProfessor($info["idTurma"], $info["idDisciplina"]);
            exit();
        }

        if ($minutos < 1 || $minutos > 30) {
            mostraAlert("Minutos ".$minutos." fora de limites!");
            gotoAulaProfessor($info["idTurma"], $info["idDisciplina"]);
            exit();
        }

        $query = "
            INSERT INTO Codigo (nome, data_criacao, data_fim, idProfessor, idDisciplina, idTurma)
            VALUES (:codigo, :dataCriacao, :dataFim, :idProfessor, :idDisciplina, :idTurma);
        ";
        $dataAtual = date('Y-m-d H:i:s');
        $dataFim = date('Y-m-d H:i:s', strtotime("+".$minutos." minutes", strtotime($dataAtual)));
        $info["dataCriacao"] = $dataAtual;
        $info["dataFim"] = $dataFim;
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($info);
        if ($stmt -> rowCount() == 1) {
            mostraAlert("Código ".$info["codigo"]." criado com sucesso! Expira em $minutos minutos.");
            gotoAulaProfessor($info["idTurma"], $info["idDisciplina"]);
            exit();
        } else {
            die("Erro critico, contacte um administrado!");
        }
    } else {
        gotoIndex();
    }

?>