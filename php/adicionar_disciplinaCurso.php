<?php
    include("bd.php");
    include("funcoes.php");

    if ( isset($_POST["opcaoDisciplina"]) && isset($_POST["opcaoCurso"]) ) {
        
        
        $cursoDisciplina = array(
            "idCurso" => $_POST["opcaoCurso"],
            "idDisciplina" => $_POST["opcaoDisciplina"]
        );

        $query = "
            SELECT c.nome AS curso, d.nome AS disciplina
            FROM Curso_Disciplina AS cd
                INNER JOIN Curso AS c ON cd.idCurso = c.id
                INNER JOIN Disciplina AS d ON cd.idDisciplina = d.id
            WHERE idCurso = :idCurso AND idDisciplina = :idDisciplina;
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($cursoDisciplina);
        if ($stmt -> rowCount() > 0) {
            $result = $stmt -> fetch();
            mostraAlert("Já existe ".$result["disciplina"]." em ".$result["curso"]."!");
            gotoFormGestao();
            die();
        }

        $query = "
            INSERT INTO Curso_Disciplina (idCurso, idDisciplina) VALUES (:idCurso, :idDisciplina);
        ";
        $stmt = $dbo -> prepare($query);
        $stmt -> execute($cursoDisciplina);
        if ($stmt -> rowCount() > 0) {
            mostraAlert("Adicionou a disciplina ao curso!");
            gotoFormGestao();
            die();
        } else {
            die("<h1>Erro critico, por favor proceda ao pedido de debug.</h1>");
        }
        

    } else {
        mostraAlert("Campos de disciplina e curso inválidos!");
        gotoFormGestao();
        die();
    }
    

?>