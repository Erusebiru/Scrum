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

		$_SESSION['selectedProyect']=null;

		include 'connection.php';
		userData($conn,$user);
		findUsers($conn);
		findGroups($conn);
		$proyectos = findProyects($conn,$user,$tipo_usuario,$grupo);
	?>

	<div class="contenedor">
		<div id="divcabecera" class = "col s12 m12 l12" >
	      <nav>
	        <div class = "nav-wrapper">
	          <a href = "#" class = "brand-logo nombrelogo">Proyectos</a>
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
						echo '<a href="#"  onclick="vistaProyecto(this)" name="'.$nombre_proyecto.'">'.$registre['nombre_proyecto']?></a>
						</li> <?
					}
				?>
				</ul>
			</div>
			
			
		</div>
		<div class="row">
			<div class="col card hoverable push-s1 s10 push-m2 m8 push-l4 l4 new-proyect-box"></div>
		</div>
		<div class="row">
			<div hidden="True" class="col card hoverable push-s1 s10 push-m2 m8 push-l4 l4 new-proyect-view-box"></div>
		</div>
	</div>

	<div class="window-message">
		<div class="error"></div>
	</div>
	<?

	function userData($conn,$user){

		$consulta_datos = "SELECT usuarios.id_usuario, tipos_usuario.nombre_tipo, usuarios.id_grupo FROM usuarios, tipos_usuario WHERE tipos_usuario.id_tipo_usuario = usuarios.id_tipo_usuario AND usuarios.nombre_usuario = '$user';";

		$result = mysqli_query($conn, $consulta_datos);
		global $id, $tipo_usuario, $grupo;
		while($registre = mysqli_fetch_assoc($result)){
			$id = $registre['id_usuario'];
			$tipo_usuario = $registre['nombre_tipo'];
			$grupo = $registre['id_grupo'];
			?><script>var global_tipoUsuario = "<?=$tipo_usuario?>"</script><?
		}
	}

	function findProyects($conn,$user,$tipo_usuario,$grupo){
		if($tipo_usuario == "scrumMaster"){
			$proyectos = proyectos_scrumMaster($conn,$user);
		}else if($tipo_usuario == "productOwner"){
			$proyectos = proyectos_ProductOwner($conn,$user);
		}else{
			$proyectos = proyectos_Developer($conn,$grupo);
		}
	
		return $proyectos;
	}

	function proyectos_scrumMaster($conn,$user) {
    	$consulta_proyectos_scrumMaster = "SELECT nombre_proyecto FROM proyectos WHERE ScrumMaster=(SELECT id_usuario FROM usuarios where nombre_usuario ='".$user."');";
    	return (mysqli_query($conn,$consulta_proyectos_scrumMaster));
    }

    function proyectos_ProductOwner($conn,$user) {
    	$consulta_proyectos_productOwner = "SELECT nombre_proyecto FROM proyectos WHERE ProductOwner=(SELECT id_usuario FROM usuarios where nombre_usuario ='".$user."');";
    	return (mysqli_query($conn,$consulta_proyectos_productOwner));
    }

    function proyectos_Developer($conn,$grupo) {
    	$consulta_proyectos_developer = "SELECT nombre_proyecto FROM proyectos, gruposproyectos WHERE gruposproyectos.id_proyecto = proyectos.id_proyecto AND id_grupo=".$grupo.";";
    	return (mysqli_query($conn,$consulta_proyectos_developer));
    }

	function findUsers($conn){
		$consulta_Persones = "SELECT usuarios.id_usuario, usuarios.nombre_usuario, tipos_usuario.nombre_tipo FROM usuarios, tipos_usuario WHERE tipos_usuario.id_tipo_usuario = usuarios.id_tipo_usuario;";
		$results = mysqli_query($conn,$consulta_Persones);

        echo "<script>";
        while($persona = mysqli_fetch_array($results)) {
        	
       		 echo "var persona = new Persona(" . $persona['id_usuario'] . ",'" . $persona['nombre_usuario'] . "','" . $persona['nombre_tipo'] . "');";
       		 echo "global_personas.push(persona);";
       	}
       	echo "</script>";
	}

	function findGroups($conn){
		$consulta_Grups = "SELECT id_grupo, nombre_grupo FROM grupos;";
		$results = mysqli_query($conn,$consulta_Grups);
			if (!$results) {
                 $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
                 $message .= 'Consulta realitzada: ' . $consulta_projectes;
                 die($message);
         		}
        echo "<script>";
        while($grup = mysqli_fetch_array($results)) {
       		 echo "var grup = new Grupo(" . $grup['id_grupo'] . ",'" . $grup['nombre_grupo'] . "');";
       		 echo "global_grupos.push(grup);";
       	}
       	echo "</script>";
	}


	?>
</body>
</html>
