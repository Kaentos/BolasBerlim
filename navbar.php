<header>
    <div class="headerLeft">
        <div class="logoContainer">
            <a href="index.php">
               <img src="images/logo.svg" alt="" srcset="">
            </a>
        </div>
        <div class="navbar">
            <?php
                if(getLoginData() != null) {
                    $navbar_dados = $_SESSION["login_data"];
                    if ( strcmp(TIPO_ADMIN,$navbar_dados["tipo"]) == 0 ) {
                        echo "
                            <a href='/Real-Learn/formGestao.php' class='navBarItem'>
                                Dashboard
                            </a>
                        ";
                    } else {
                        echo "
                            <a href='/Real-Learn/' class='navBarItem'>
                                Homepage
                            </a>
                            <a href='/Real-Learn/disciplinas.php' class='navBarItem'>
                                Disciplinas
                            </a>
                            <a href='/Real-Learn/calendario.php' class='navBarItem'>
                                Calendario
                            </a>
                        ";
                    }
                        
                }
            ?>
            
        </div>
    </div>
    <div class="headerProfile">
        <?php
            if(isset($navbar_dados)) {
                echo "
                    <div class='dropdownBox'>
                        <img onclick='notificacaoMenuFun()' class='profileNotificacoes' src='images/bell.png'>
                        <div id='notificacoesMenu' class='notificacoesMenu'>
                            <p>
                                Prof.Paulo Lava. É para entregar...
                            </p>
                            <p>
                                Prof.Paulo Lava. É para entregar...
                            </p>
                            <p>
                                Prof.Paulo Lava. É para entregar...
                            </p>
                            <p>
                                Prof.Paulo Lava. É para entregar...
                            </p>
                            <a href='notificacoes.html' class='notificacoesBtn'>
                                Todas
                            </a>
                        </div>
                    </div>
                    <div class='dropdownBoxProfile'>
                        <a href='profile.html'>
                            <img class='profileImg' src='images/user.png'>
                        </a>
                        <div id='profileMenu' class='profileMenus'>
                            <a href='./profile.php'>Perfil</a>
                            <a href='#'>Definições</a>
                            <a href='./php/logout.php'>Logout</a>
                        </div>
                    </div>
                ";
            } else {
                echo "
                    <div class='dropdownBoxProfile'>
                        <a href='login.php'>
                            Login
                        </a>
                    </div>
                ";
            }
        ?>
        
    </div>        
</header> 