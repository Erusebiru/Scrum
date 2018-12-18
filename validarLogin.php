<!DOCTYPE html>
<html>
<head>
	<title>Validacion</title>
</head>
<body>

<?php
	session_start();
	session_destroy();
	session_start();
	if(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
		$password = $_SESSION['password'];
		header('Location: proyectos.php');

	} else {
		$user = $_POST["username"];
		$password = $_POST["password"];

		include 'connection.php';

		$consulta_user ="SELECT nombre_usuario FROM usuarios where nombre_usuario='".$user."';";
		$consulta_psw = "SELECT nombre_usuario FROM usuarios where nombre_usuario='".$user."' and password=sha2('".$password."',512);";

		$user_comprovar = mysqli_num_rows(mysqli_query($conn,$consulta_user));
		
		if ($user_comprovar != 0) {
			$psw_comprovar = mysqli_num_rows(mysqli_query($conn,$consulta_psw));
			if ($psw_comprovar != 0) {
				$_SESSION['user'] = $user;
				header('Location: proyectos.php');
			}
			else {
						
				$error = "errorPsw";
				$_SESSION['error'] = $error;
				header('Location: login.php');


				}
			}
		else {
				$error = "errorUser";
				$_SESSION['error'] = $error;
				header('Location: login.php');
			}

		}

	?>




</body>
</html>