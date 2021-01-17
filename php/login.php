<?php
	if(isset($_POST["user"]) and isset($_POST["password"])){
		include("bd.php");
		include("funcoes.php");
		
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
			$tipo = TIPO_ADMIN;
		} else {
			mostraAlert("Email inválido!");
			gotoLogin();
			exit();
		}

		$query = "
			SELECT *
			FROM ".$tabela."
			WHERE email = :email AND password = :password;
		";
		$stmt = $dbo -> prepare($query);
		$stmt -> execute($user);

		if ($stmt -> rowCount() == 1) {
			$user = $stmt -> fetch();
			$dataAgora = date("Y-m-d H:i:s");
			$query = "
				UPDATE $tabela
				SET ultimo_login = :agora
				WHERE id = :idUser
			";
			$stmt = $dbo -> prepare($query);
			$stmt -> bindValue("agora", $dataAgora);
			$stmt -> bindValue("idUser", $user["id"]);
			$stmt -> execute();
			if ($stmt -> rowCount() != 1) {
				session_destroy();
				die("Erro critico por favor contacte um administrador!");
			}

			if (isset($user["idTurma"])) {
				$_SESSION["login_data"] = array (
					"idUser" => $user["id"],
					"idTurma" => $user["idTurma"],
					"tipo" => $tipo
				);
			} else {
				$_SESSION["login_data"] = array (
					"idUser" => $user["id"],
					"tipo" => $tipo
				);
			}
			gotoIndex();
			exit();
		} else {
			mostraAlert("Dados incorretos!");
			gotoLogin();
			exit();
		}
		
	}else{
		mostraAlert("Dados incorretos!");
		gotoLogin();
		exit();
	}
?>