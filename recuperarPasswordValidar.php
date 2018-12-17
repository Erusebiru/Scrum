<!DOCTYPE html>
<html>
<head>
	<title>Validacion</title>
</head>
<body>
	

<?php
	session_start();

	if(isset($_SESSION['user'])){
		header('Location: proyectos.php');

	} else {
		$user = $_POST["username"];
		include 'connection.php';
		$query = "SELECT * FROM usuarios where nombre_usuario = '$user'";
		$result = mysqli_query($conn,$query);
		$check = mysqli_num_rows($result);
		if($check != 0){
			while($registre = mysqli_fetch_assoc($result)){
				$email = $registre['email'];
			}
		}else{
			$error = "errorUser";
			$_SESSION['error'] = $error;
			header('Location: recuperarPassword.php');
			}
		}
		$token = md5(uniqid(mt_rand()));

		insertToken($token,$conn,$user);

		mail($email,"Recuperar Contraseña","Ve a la pagina siguiente para cambiar la contraseña de tu usuario: http://www.khalidomain.ml/Scrum/cambiarPassword.php?token=".$token,"from: ubuntu@blablaslba.com");
   		echo "Se ha enviado un email a tu cuenta de correo electronico para el cambio de contraseña.";
		

		function insertToken($token,$conn,$user){
			$query = "UPDATE usuarios SET token = '$token' WHERE nombre_usuario = '$user'";
			$_SESSION['token']=$token;
			if (mysqli_query($conn, $query)) {
				echo "Token insertado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}
		}
	?>
</body>
</html>
