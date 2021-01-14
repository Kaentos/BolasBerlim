<?php

if ( isset($_POST["user"]) && isset($_POST["password"]) ) {
    include("bd.php");
    include("funcoes.php");

    if (strpos($_POST["user"], "@abccampus.pt")) {
        $query = "
            SELECT *
            FROM Aluno
            WHERE email = :email AND password = MD5(:password);
        ";
        $nivel_acesso = 10;
    } elseif (strpos($_POST["user"], "@abc.pt")) {
        $query = "
            SELECT *
            FROM Professor
            WHERE email = :email AND password = MD5(:password);
        ";
        $nivel_acesso = 5;
    } elseif (strpos($_POST["user"], "@abcadmin.pt")) {
        $query = "
            SELECT *
            FROM Aluno
            WHERE email = :email AND password = MD5(:password);
        ";
        $nivel_acesso = 1
    } else {
        mostraAlert("Dados incorretos!");
        gotoIndex();
    }
}

$user = $_GET["user"];
$pwd = $_GET["password"];

if ($user == "admin" && $pwd == "admin") {
    header("refresh:0;url=../home.html");
}else {
    echo("Utilizador Errado!");
    header("refresh:5;url=../login.html");
}
?>