<?php
    include("bd.php");
    include("funcoes.php");

    if ( isset($_POST["nomeCurso"]) ) {
        
        
        $curso = array(
            "nome" => $_POST["nomeCurso"]
        );

        if ( strlen($curso["nome"]) <= 4 ) {
            mostraAlert("Nome de curso muito curto!");
            gotoFormGestao();
            die();
        }

        $query = "
            SELECT *
            FROM Curso
            WHERE LOWER(nome) = LOWER(:nome);
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($curso);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Nome de curso já existente!");
            gotoFormGestao();
            die();
        }

        $query = "
            INSERT INTO Curso (nome) VALUES (:nome);
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($curso);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Adicionou curso!");
            gotoFormGestao();
            die();
        } else {
            die("<h1>Erro critico, por favor proceda ao pedido de debug.</h1>");
        }
        

    } else {
        mostraAlert("Campos de curso inválidos!");
        gotoFormGestao();
        die();
    }
    

?>