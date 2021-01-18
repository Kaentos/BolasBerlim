<?php
    include("bd.php");
    include("funcoes.php");

    if ( isset($_POST["nomeAluno"]) && isset($_POST["numberAluno"]) && isset($_POST["emailAluno"]) && isset($_POST["passwordAluno"]) && isset($_POST["turmaAluno"]) ) {
        $aluno = array(
            "id" => strlen($_POST["numberAluno"]) == 0 ? null : $_POST["nomeAluno"],
            "nome" => $_POST["nomeAluno"],
            "email" => $_POST["emailAluno"],
            "password" => md5($_POST["passwordAluno"]),
            "idTurma" => $_POST["turmaAluno"]
        );

        if ( strlen($aluno["nome"]) <= 4 ) {
            mostraAlert("Nome de aluno muito curto!");
            gotoFormGestao();
            exit();
        }
        if ( strlen($aluno["email"]) <= 4 || strpos($aluno["email"], "@abccampus.pt") == false ) {
            mostraAlert("Email inválido!");
            gotoFormGestao();
            exit();
        }
        if ( strlen($_POST["passwordAluno"]) <= 4 ) {
            mostraAlert("Password muito fraca!");
            gotoFormGestao();
            exit();
        }

        $query = "
            SELECT *
            FROM Aluno
            WHERE email = :email;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> bindValue("email", $aluno["email"]);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Email já existe!");
            gotoFormGestao();
            exit();
        }

        if ($aluno["id"] != null) {
            $query = "
                SELECT *
                FROM Aluno
                WHERE id = :id;
            ";
            $stmt = $dbo -> prepare($query);
            $stmt -> bindValue("id", $aluno["id"]);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
                mostraAlert("ID de aluno já existe!");
                gotoFormGestao();
                exit();
            }
        }

        if ($aluno["id"] == null) {
            $query = "
                INSERT INTO Aluno (nome, email, password, idTurma) VALUES (:nome, :email, :password, :idTurma);
            ";
            unset($aluno["id"]);
        } else {
            $query = "
                INSERT INTO Aluno (id, nome, email, password, idTurma) VALUES (:id, :nome, :email, :password, :idTurma);
            ";
        }
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($aluno);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Adicionou o aluno!");
            gotoFormGestao();
            exit();
        } else {
            die("<h1>Erro critico, por favor proceda ao pedido de debug.</h1>");
        }
        

    } else {
        mostraAlert("Campos de aluno inválidos!");
        gotoFormGestao();
        die();
    }
    

?>