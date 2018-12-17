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
		header('Location: proyectos.php');

	} else {
		$user = $_POST["username"];
		

		$conn = mysqli_connect('localhost','Admin','Admin');
		mysqli_select_db($conn, 'proyectoscrum');

		$consulta_user ="SELECT nombre_usuario FROM usuarios where nombre_usuario='".$user."';";

		$user_comprovar = mysqli_num_rows(mysqli_query($conn,$consulta_user));
		
		if ($user_comprovar == 0) {
			$error = "errorUser";
			$_SESSION['error'] = $error;
			header('Location: recuperarPassword.php');
			}
		}

    $to = "kalouan@iesesteveterradas.cat";
    $subject = "Checking PHP mail";
    $message = "PHP mail works just fine";
    $headers = "From:ubuntu@gfjkghjkflk.com";
    mail($to,$subject,$message, $headers);
    echo "The email message was sent.";
    
		
	?>




</body>
</html>