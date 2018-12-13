<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link type="text/css" rel="stylesheet" href="css/style.css"/>
	<script type="text/javascript" src="js/clases.js"></script>
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">      
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
	<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
	<link rel="shortcut icon" href="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png"> 
	<script type="text/javascript" src="js/script.js" defer></script>
</head>
<body>
	<?
		session_start();
		if(isset($_SESSION['user'])){
			$user = $_SESSION['user'];
		}else{
			header('Location: '."login.php");
		}

		$conn = mysqli_connect('localhost','Admin','Admin','proyectoscrum');
		//userData($conn,$user);
	?>
<div class="contenedor">
		<div id="divcabecera" class = "col s12 m12 l12" >
	      <nav>
	        <div class = "nav-wrapper">
	          <a href = "#" class = "brand-logo nombrelogo">Administración de proyectos</a>
	          <a href="#!" class="brand-logo center"><img src="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png"></a>
	          <ul id="nav-mobile" class="right hide-on-med-and-down">
		          <!--li><a href="#"><span>Pestaña1</span></a></li>
		          <li><a href="#"><span>Pestaña2</span></a></li>
		          <li><a href="#"><span>Pestaña3</span></a></li>
		          <li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>-->
		          <li class="grey-text lighten-5">Usuario: <?php echo $user ?></li>
		          <li><a href="logout.php"><i class="material-icons grey-text">exit_to_app</i></a></li>
		      </ul>

	        </div>
	      </nav>
	    </div>
		<div class="proyect-list">
			<div class="proyect-title">Proyectos</div>
			<div class="proyect-table">
				<ul>
				<?

				while($registre = mysqli_fetch_assoc($proyectos)){
						$nombre_proyecto=$registre['nombre_proyecto'];
						echo "<li>";
						echo '<a href="#" onclick="vistaProyecto()" name="'.$nombre_proyecto.'">'.$registre['nombre_proyecto']?></a>
						</li> <?
					}
				?>
				</ul>

			</div>
			
			
		</div>

</body>
</html>