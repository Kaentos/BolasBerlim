<?php
    include("./php/funcoes.php");
    if (getLoginData() != null) {
        header("location: ./");
        die();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="loginTitle">
        <h1>
            Plataforma e-Learning <br>
            Real-Learn
        </h1>
    </div>
    <div class="container">
        <div class="imgContainer">
            <h1>
                Iniciar Sessão
            </h1>
            <!--<img class="profileImg" src="images/user.png" alt="">-->
        </div>
        <div class="formContainer">
            <form action="./php/login.php" method="POST">
                <div class="formFields">
                    <label for="user">User</label>
                    <input type="text" name="user" >
                    <label for="password">Password</label>
                    <input type="password" name="password" >
                    <br>
                    <a href="#">Forget Password</a>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>