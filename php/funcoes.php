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
                window.location.href = '/Real-Learn/formGestao.php';
            </script>
        ";
    }

    function gotoLogin() {
        echo "
            <script type='text/javascript'>
                window.location.href = '/Real-Learn/login.php';
            </script>
        ";
    }

    function gotoLogout() {
        echo "
            <script type='text/javascript'>
                window.location.href = '/Real-Learn/php/logout.php';
            </script>
        ";
    }

    function gotoIndex() {
        echo "
            <script type='text/javascript'>
                window.location.href = '/Real-Learn/';
            </script>
        ";
    }

    function seAdminVaiDashboard() {
        if ($_SESSION["login_data"]["tipo"] == TIPO_ADMIN) {
            echo "
                <script type='text/javascript'>
                    window.location.href = '/Real-Learn/formGestao.php';
                </script>
            ";
        }
    }

    function seNaoAdminVaiIndex() {
        if ($_SESSION["login_data"]["tipo"] != TIPO_ADMIN) {
            gotoIndex();
        }
    }

?>