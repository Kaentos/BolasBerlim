<?php
    include("bd.php");
    include("funcoes.php");
    if (isset($_POST["codigoNome"]) && isset($_POST["visivel"]) && isset($_FILES["file"])) {
        if ($_FILES["fileToUpload"]["size"] > RL_FILE_MAX_SIZE) {
            die("O ficheiro é demasiado grande");
        }
        $code = uniqid("userfile_", true);
        $target_file = RL_FILE_DIR.basename($_FILES["file"]["name"]);

        $query = "
            INSERT INTO ficheiro (nome, codigo, ordem, e_visivel, data_criacao 
        ";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>