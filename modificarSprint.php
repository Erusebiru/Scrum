<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			//print_r($_POST);
			$id_sprint = $_POST['id_sprint'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			$num_specs = $_POST['num_specs'];
			$spec[] = $_POST['spec'];
			$horas = $_POST['horas'];

			include 'connection.php';

			//Eliminar sprint de la bbdd
			$query = "UPDATE sprints SET Fecha_Inicio='$startDate' , Fecha_Fin='$endDate' , horasTotales='$horas' WHERE id_sprint='$id_sprint'";
			echo $query;
			if (mysqli_query($conn, $query)) {
				echo "Sprint modificado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}


			//$query2 = "UPDATE especificaciones SET "

			header('Location: '."vistaproyecto.php");
		}
	?>
</body>
</html>