<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		if($_SERVER["REQUEST_METHOD"] == "POST") {

			print_r($_POST);
			$num_specs = $_POST['num_specs'];
			$spec[] = $_POST['spec'];
			$id_sprint = $_POST['id_sprint'];

			
			include 'connection.php';

			// //Modificación de estado en la base de datos por cada especificacion

			$query = "UPDATE sprints SET horasTotales='".$horasTotales."',Fecha_Inicio='".$fechaInicio."',Fecha_Fin='".$fechaFin."' where id_sprint='".$id_sprint."'";

			mysqli_query($conn, $query);

			if (mysqli_query($conn, $query)) {
				echo "Sprint modificado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}

			header('Location: '."vistaproyecto.php");
		}

	?>

</body>
</html>