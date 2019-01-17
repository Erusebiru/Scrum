<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		print_r($_POST);
		if($_SERVER["REQUEST_METHOD"] == "POST") {

			$idproyecto = $_POST['spec'];
			echo $idproyecto;
			include 'connection.php';

			//Inserción del sprint en la base de datos
			$query = "INSERT INTO especificaciones (nombre_spec,estado,id_proyecto) VALUES ('$idproyecto','backlog',2)";

			if (mysqli_query($conn, $query)) {
				echo "Proyecto insertado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}

			header('Location: '."vistaproyecto.php");
		}
	?>
</body>
</html>