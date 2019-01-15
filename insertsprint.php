<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		print_r($_POST);
		if($_SERVER["REQUEST_METHOD"] == "POST") {

			$idproyecto = $_POST['idproyecto'];
			$inicio = $_POST['inicio'];
			$fin = $_POST['fin'];
			$horastotales = $_POST['horastotales'];

			include 'connection.php';

			//Inserción del sprint en la base de datos
			$query = "INSERT INTO sprints (horasTotales,Fecha_Inicio,Fecha_Fin,id_proyecto) VALUES ('$horastotales','$inicio','$fin','$idproyecto')";

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