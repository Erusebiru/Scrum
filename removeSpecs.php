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

			//Modificación de estado en la base de datos por cada especificacion
			for ($i=0;$i<$num_specs;$i++){

				$query = "UPDATE especificaciones SET estado='backlog',id_sprint=null where nombre_spec='".$spec[0][$i]."'";

				mysqli_query($conn, $query);
			}



			//Eliminar sprint de la bbdd
			$query = "DELETE FROM `sprints` WHERE id_sprint = '$id_sprint'";


			if (mysqli_query($conn, $query)) {
				echo "Sprint eliminado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}

			header('Location: '."vistaproyecto.php");
		}

	?>

</body>
</html>