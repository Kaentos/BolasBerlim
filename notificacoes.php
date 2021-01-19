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
    <link rel="stylesheet" href="css/notificacoes.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/hiddenContent.js"></script>

    <title>Document</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="mainContainer">
       <div class="notificacoesTitulo">
           <h1>Notificacoes</h1>
           <a href="home.html" class="titlebtn">Marcar tudo como visto</a>
       </div>
       <div class="notificacoesContainer">
           <div class="notificacoesRow">
               <div class="notificacaoColuna">
                    Matematica
               </div>
               <div class="notificacaoColuna">
                    Prof. Paulo
                </div>
                <div class="notificacaoColuna">
                    Por favor tragam bolas....
                </div>
                <div class="notificacaoColuna">
                    21/01/1921 | 19:30:20
                </div>
                <div class="notificacaoColuna">
                    <label class="container">
                        <input type="checkbox" checked="checked">
                        <span class="checkmark"></span>
                  </label>
                </div>
           </div>
           <div class="notificacoesRow">
            <div class="notificacaoColuna">
                 Desen Web
            </div>
            <div class="notificacaoColuna">
                 Prof. Carlos
             </div>
             <div class="notificacaoColuna">
                 Peço a todos os alunos......
             </div>
             <div class="notificacaoColuna">
                 21/01/1921 | 20:20:20
             </div>
             <div class="notificacaoColuna">
                 <label class="container">
                     <input type="checkbox" >
                     <span class="checkmark"></span>
               </label>
             </div>
        </div>
       </div>
    </div>
</body>
</html>