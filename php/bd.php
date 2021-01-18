<?php
    define("HOST_BD", "localhost");
    define("USER_BD", "root");
    define("PASS_BD", "");
    define("NOME_BD", "ABCSTUDIOS");
    try {
        $dbo = new PDO("mysql:host=". HOST_BD .";dbname=".NOME_BD.";charset=utf8", USER_BD, PASS_BD);
    } catch (PDOException $e) {
        die("Erro a conectar à base de dados.");
    }
?>
