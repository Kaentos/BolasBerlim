<?php
    session_start();

    define("TIPO_ADMIN", "Administrador");
    define("TIPO_ALUNO", "Aluno");
    define("TIPO_PROFESSOR", "Professor");

    function getLoginData() {
        if ( isset($_SESSION["login_data"]) ) {
            return $_SESSION["login_data"];
        } else {
            return null;
        }
    }

    function mostraAlert($msg) {
        echo "
            <script>
                alert('".$msg."');
            </script>
        ";
    }

    function gotoFormGestao() {
        echo "
            <script type='text/javascript'>
                window.location.href = '../formGestao.php';
            </script>
        ";
    }

    function gotoLogin() {
        echo "
            <script type='text/javascript'>
                window.location.href = '../login.php';
            </script>
        ";
    }

?>