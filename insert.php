<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		if($_SERVER["REQUEST_METHOD"] == "POST") {

			$nombreproyecto = $_POST['ProyectName'];
			if(isset($_POST['descripcion'])){
				$descripcion = $_POST['descripcion'];
			}else{
				$descripcion = null;
			}
			$productowner = $_POST['productOwner'];
			$scrummaster = $_POST['scrumMaster'];

			include 'connection.php';

			//Inserción del proyecto en la base de datos
			$query = "INSERT INTO proyectos (nombre_proyecto,descripcion_proyecto,ScrumMaster,ProductOwner) VALUES ('$nombreproyecto','$descripcion','$scrummaster','$productowner')";

			if (mysqli_query($conn, $query)) {
				echo "Proyecto insertado correctamente";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($conn);
			}

			$query = "SELECT id_proyecto FROM proyectos WHERE nombre_proyecto = '$nombreproyecto';";
			$result = mysqli_query($conn, $query);
			while($registre = mysqli_fetch_assoc($result)){
				$idproyecto = $registre['id_proyecto'];
			}

			foreach($_POST['grupos'] as $grupo){
				$query = "INSERT INTO gruposproyectos (id_proyecto,id_grupo) VALUES ('$idproyecto','$grupo')";
			}

			header('Location: '."proyectos.php");
		}
	?>
</body>
</html>