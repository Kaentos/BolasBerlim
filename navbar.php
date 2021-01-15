<header>
    <div class="headerLeft">
        <div class="logoContainer">
            <a href="home.html">
                <p>Logotipo</p>
            </a>
        </div>
        <div class="navbar">
            <a href="home.html" class="navBarItem">Homepage</a>
            <a href="disciplinas.html" class="navBarItem">Disciplinas</a>
            <a href="calendario.html" class="navBarItem">Calendario</a>
        </div>
    </div>
    <div class="headerProfile">
        <?php
            if(getLoginData() != null) {
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
                            <a href='' class='notificacoesBtn'>
                                Todas
                            </a>
                        </div>
                    </div>
                    <div class='dropdownBoxProfile'>
                        <a href='profile.html'>
                            <img class='profileImg' src='images/user.png'>
                        </a>
                        <div id='profileMenu' class='profileMenus'>
                            <a href='#'>Perfil</a>
                            <a href='#'>Definições</a>
                            <a href='./php/logout.php'>logout</a>
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