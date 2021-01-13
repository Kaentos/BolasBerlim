<?php
    include("bd.php");
    include("funcoes.php");

    if ( isset($_POST["opcaoDisciplina"]) && isset($_POST["opcaoProfessor"]) ) {
        
        
        $disciplinaProfessor = array(
            "idDisciplina" => $_POST["opcaoDisciplina"],
            "idProfessor" => $_POST["opcaoProfessor"]
        );

        $query = "
            SELECT d.nome AS disciplina, p.nome AS professor
            FROM Disciplina_Professor AS dp
                INNER JOIN Disciplina AS d ON dp.idDisciplina = d.id
                INNER JOIN Professor AS p ON dp.idProfessor = p.id
            WHERE dp.idDisciplina = :idDisciplina AND dp.idProfessor = :idProfessor;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($disciplinaProfessor);
        if ($stmt -> rowCount() > 0) {
            $result = $stmt -> fetch();
            mostraAlert("Já existe ".$result["professor"]." a dar ".$result["disciplina"]."!");
            gotoFormGestao();
            die();
        }

        $query = "
            INSERT INTO Disciplina_Professor (idDisciplina, idProfessor) VALUES (:idDisciplina, :idProfessor);
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($disciplinaProfessor);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Associou professor à disciplina com sucesso!");
            gotoFormGestao();
            die();
        } else {
            die("<h1>Erro critico, por favor proceda ao pedido de debug.</h1>");
        }

    } else {
        mostraAlert("Campos de disciplina e professor inválidos!");
        gotoFormGestao();
        die();
    }

?>