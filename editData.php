<?php
    include("./php/funcoes.php");
    $loginData = getLoginData();
    if ($loginData == null) {
        gotoLogin();
    }
    seAdminVaiDashboard();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editData.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/hiddenContent.js"></script>
    <link rel="icon" href="images/logo.svg">
    <title>Editar dados</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="mainContainer">
        <p>Definições</p>
        <div class="formContainerPessoas">
            <div class="formBox">
                <form action="">
                    <p>Alterar dados</p>
                    <div class="formRow">
                        <div class="userImage">
                            <img class="profileImg" src="images/user.png" alt="">
                        </div>
                        <input type="file" name="userImage" accept="image/png, image/jpeg" > 
                        
                    </div>
                    <div class="formRow">
                        Comunicação
                    </div>
                    <div class="formRow">
                        <label for="facebook">Facebook:</label>
                        <input type="text" name="facebook" placeholder="facebook.com/jose.santos.88">
                    </div>
                    <div class="formRow">
                        <label for="twitter">Twitter:</label>
                        <input type="text" name="twitter" placeholder="twitter.com/JSaint">
                    </div>
                    <div class="formRow">
                        <label for="reddit">Reddit:</label>
                        <input type="text" name="reddit">
                    </div>
                    
                    <input type="submit" value="Alterar">
                </form> 
            </div>
            <div class="formBox">
                <form action="">
                    <p>Mudar Password</p>
                    <div class="formRow">
                        <label for="atualPass">Atual:</label>
                        <input type="text" name="atualPass">
                    </div>
                    <div class="formRow">
                        <label for="newPass">Nova:</label>
                        <input type="text" name="newPass">
                    </div>
                    <div class="formRow">
                        <label for="confirmPass">Confirmar:</label>
                        <input type="text" name="confirmPass">
                    </div>
                    
                    <input type="submit" value="Editar">
                </form>
            </div> 
        </div>

    </div>
</body>
</html>