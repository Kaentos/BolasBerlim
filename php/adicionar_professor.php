<?php
    include("bd.php");
    include("funcoes.php");

    if ( isset($_POST["nomeProfessor"]) && isset($_POST["numberProfessor"]) && isset($_POST["emailProfessor"]) && isset($_POST["passwordProfessor"]) ) {
        
        
        $professor = array(
            "id" => strlen($_POST["numberProfessor"]) == 0 ? null : $_POST["numberProfessor"],
            "nome" => $_POST["nomeProfessor"],
            "email" => $_POST["emailProfessor"],
            "password" => md5($_POST["passwordProfessor"])
        );

        if ( strlen($professor["nome"]) <= 4 ) {
            mostraAlert("Nome de professor muito curto!");
            gotoFormGestao();
        }
        if ( strlen($professor["email"]) <= 4 && strpos($professor["email"], "@abc.pt") == false ) {
            mostraAlert("Email de professor inválido!");
            gotoFormGestao();
        }
        if ( strlen($_POST["passwordProfessor"]) <= 4 ) {
            mostraAlert("Password muito fraca!");
            gotoFormGestao();
        }

        $query = "
            SELECT *
            FROM Professor
            WHERE email = :email;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("email", $professor["email"]);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Email de professor já existe!");
            gotoFormGestao();
        }

        if ($professor["id"] != null) {
            $query = "
                SELECT *
                FROM Professor
                WHERE id = :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("id", $professor["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                mostraAlert("ID de professor já existe!");
                gotoFormGestao();
            }
        }

        if ($professor["id"] == null) {
            $query = "
                INSERT INTO Professor (nome, email, password) VALUES (:nome, :email, :password);
            ";
            unset($professor["id"]);
        } else {
            $query = "
                INSERT INTO Professor (id, nome, email, password) VALUES (:id, :nome, :email, :password);
            ";
        }
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($professor);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Adicionou o professor!");
            gotoFormGestao();
        } else {
            die("<h1>Erro critico, por favor proceda ao pedido de debug.</h1>");
        }
        

    } else {
        mostraAlert("Campos de professor inválidos!");
        gotoFormGestao();
    }
    

?>