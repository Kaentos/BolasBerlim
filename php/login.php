<?php

$user = $_GET["user"];
$pwd = $_GET["password"];

if ($user == "admin" && $pwd == "admin") {
    header("refresh:0;url=../home.html");
}else {
    echo("Utilizador Errado!");
    header("refresh:5;url=../login.html");
}
?>