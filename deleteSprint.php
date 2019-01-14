<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		if($_SERVER["REQUEST_METHOD"] == "POST") {

			$id_sprint = $_POST['id_sprint'];

			include 'connection.php';

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