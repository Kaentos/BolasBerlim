<?php
	include("bd.php");
	include("funcoes.php");
	
	if(isset($_POST["user"]) and isset($_POST["password"])){
		
		$user = array(
			"email" => $_POST["user"],
			"password" => md5($_POST["password"])
		);
		

		if ( strpos($user["email"], "@abc.pt") ) {
			$tabela = "Professor";
			$tipo = TIPO_PROFESSOR;
		} elseif ( strpos($user["email"], "@abccampus.pt") ) {
			$tabela = "Aluno";
			$tipo = TIPO_ALUNO;
		} elseif ( strpos($user["email"], "@abcadmin.pt") ) {
			$tabela = "Administrador";
			$tipo = TIPO_PROFESSOR;
		} else {
			die("Pichota errada comparsa");
		}

		$query = "
			SELECT *
			FROM ".$tabela."
			WHERE email = :email AND password = :password;
		";
		// prepara a query
		$stmt = $dbo -> prepare($query);
		$stmt -> execute($user);

		if ($stmt -> rowCount() == 1) {
			$user = $stmt -> fetch();
			$_SESSION["login_data"] = array (
				"idUser" => $user["id"],
				"idTurma" => $user["idTurma"],
				"tipo" => $tipo
			);
			header("location: ../home.html");
			die();
		} else {
			exit("népias brother");
		}
		
	}else{
		exit('Preencha o utilizador e password');
	}
?>