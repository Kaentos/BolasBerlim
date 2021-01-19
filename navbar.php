<header>
    <div class="navbar">
        <div class="headerLeft">
            <div class="logoContainer">
                <a href="index.php">
                <img class="logoNavbar" src="images/logo.svg" alt="" srcset="">
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
                                <a href='/Real-Learn/calendario.html' class='navBarItem'>
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
                            <img onclick='notificacaoMenuFun()' class='profileNotificacoes' src='images/sent.svg'>
                            <div id='notificacoesMenu' class='notificacoesMenu'>
                                <div>
                                    <p>
                                        Paulo Lava: É para entregar...
                                    </p>
                                </div>
                                <div>
                                    <p>
                                        Paulo Lava: É para entregar...
                                    </p>
                                </div>
                                <div>
                                    <p>
                                        Paulo Lava: É para entregar...
                                    </p>
                                </div>
                                <div>
                                    <p>
                                        Paulo Lava: É para entregar...
                                    </p>
                                </div>
                                <a href='notificacoes.php' class='notificacoesBtn'>
                                    Ver todas
                                </a>
                            </div>
                        </div>
                        <div class='dropdownBoxProfile'>
                            <a href='profile.php'>
                                <img class='profileImg' src='images/mailAvatar.svg'>
                            </a>
                            <div id='profileMenu' class='profileMenus'>
                                <div>
                                    <a href='./profile.php'>Perfil</a>
                                </div>
                                <div>
                                    <a href='#'>Definições</a>
                                </div>
                                <div>
                                    <a href='./php/logout.php'>Logout</a>
                                </div>
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
  </div>
</header> 