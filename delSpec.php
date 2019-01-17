<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			print_r($_POST);
			$spec = $_POST['spec'];

			include 'connection.php';

			//Eliminar sprint de la bbdd
			$query = "DELETE FROM `especificaciones` WHERE nombre_spec = '$spec'";
/*

			if (mysqli_query($conn, $query)) {
				echo "Sprint eliminado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}

			header('Location: '."vistaproyecto.php");*/
		}
	?>
</body>
</html>