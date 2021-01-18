<?php
    session_start();
    date_default_timezone_set("Europe/Lisbon");

    define("TIPO_ADMIN", "Administrador");
    define("TIPO_ALUNO", "Aluno");
    define("TIPO_PROFESSOR", "Professor");
    define("TAMANHO_CODIGO", 6);

    // https://stackoverflow.com/questions/4356289/php-random-string-generator
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

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
            exit();
        }
    }

    function gotoAulaProfessor($turma, $disciplina) {
        echo "
            <script type='text/javascript'>
                window.location.href = '/Real-Learn/aulaProfessor.php?turma=".$turma."&disciplina=".$disciplina."';
            </script>
        ";
    }

    function gotoAulaAluno($disciplina) {
        echo "
            <script type='text/javascript'>
                window.location.href = '/Real-Learn/aulaAluno.php?disciplina=".$disciplina."';
            </script>
        ";
    }

    function seNaoAdminVaiIndex() {
        if ($_SESSION["login_data"]["tipo"] != TIPO_ADMIN) {
            gotoIndex();
        }
    }

?>