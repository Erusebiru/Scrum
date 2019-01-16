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
			//echo ($spec[0][1]);
			
			include 'connection.php';

			//Modificación de estado en la base de datos por cada especificacion
			for ($i=0;$i<$num_specs;$i++){

				$query = "UPDATE especificaciones SET estado='backlog',id_sprint=null where nombre_spec='".$spec[0][$i]."'";

				mysqli_query($conn, $query);
			}

			//header('Location: '."vistaproyecto.php");
		}
	?>

</body>
</html>