<?php

    include("bd.php");
    include("funcoes.php");

    if ( isset($_POST["opcaoAnoLetivo"]) && isset($_POST["opcaoCurso"]) ) {
        
        
        $turma = array(
            "idCurso" => $_POST["opcaoCurso"],
            "idAnoLetivo" => $_POST["opcaoAnoLetivo"]
        );

        $query = "
            SELECT c.nome AS curso, a.nome AS anoLetivo
            FROM Turma AS t
                INNER JOIN Curso AS c ON t.idCurso = c.id
                INNER JOIN AnoLetivo AS a ON t.idAnoLetivo = a.id
            WHERE t.idCurso = :idCurso AND t.idAnoLetivo = :idAnoLetivo;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($turma);
        if ($stmt -> rowCount() > 0) {
            $result = $stmt -> fetch();
            mostraAlert("Já existe a turma ".$result["curso"]." - ".$result["anoLetivo"]."!");
            gotoFormGestao();
            die();
        }

        $query = "
            INSERT INTO Turma (idCurso, idAnoLetivo) VALUES (:idCurso, :idAnoLetivo);
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($turma);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Adicionou a turma com sucesso!");
            gotoFormGestao();
            die();
        } else {
            die("<h1>Erro critico, por favor proceda ao pedido de debug.</h1>");
        }
        

    } else {
        mostraAlert("Campos de turma inválidos!");
        gotoFormGestao();
        die();
    }

?>