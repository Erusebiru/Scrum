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
	<meta charset="UTF-8">
</head>
<body>
	<?
		session_start();
		if(isset($_SESSION['user'])){
			$user = $_SESSION['user'];
		}else{
			header('Location: '."login.php");
		}

		include 'connection.php';
		$nombre_proyecto = $_POST["selectedProyect"];
		$sprints = getSprints($conn,$nombre_proyecto);

		$proyecto = findProyects($conn,$nombre_proyecto);
		$hoy = date('Y-m-d');
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

	    <div id="TablaProyectos">
	    	<h4><?= $nombre_proyecto ?></h4>
			<ul id="list">
				<?
				echo "<li>Descripcion: ".$proyecto[0]['descripcion_proyecto']."</li>";
				echo "<li>ScrumMaster: ".$proyecto[0]['ScrumMaster']."</li>";
				echo "<li>ProductOwner: ".$proyecto[0]['ProductOwner']."</li>";
				echo "<li>Grupos: </li>";
				foreach($proyecto as $grupo){
					echo "<li>".$grupo['nombre_grupo']."</li>";
				}

				?>
			</ul>



<!--descripcion_proyecto,grupos.nombre_grupo,u1.nombre_usuario, u2.nombre_usuario -->
			<?
			?>
	    </div>
		
		<div id="TablaSprints">
			<?
				echo "<h4>Listado de Sprints</h4>";
				$numSprint = 1;
				foreach($sprints as $sprint){
					if($hoy < $sprint['Fecha_Fin']){
						?><div class="sprint sprint-actual"><?
					}else{
						?><div class="sprint sprint-anterior"><?
					}
					?>

						
							<?echo "<h6 onclick='showSprint(this)'>Sprint ".$numSprint."</h6>";
							?><ul id="list" class="plegado" name="primero"><?
									echo "<li>Horas Totales: ".$sprint['horasTotales']."</li>";
									echo "<li>Fecha de inicio: ".$sprint['Fecha_Inicio']."</li>";
									
									echo "<li>Fecha de fin: ".$sprint['Fecha_Fin']."</li>";
									?><li><p class="title">Especificaciones</p> <br>
										<ul>
											<li>
												<table>
													<tr>
														<th>Nº de especificación</th>
														<th>Horas Asignadas</th>
														<th>Estado</th>
													</tr>
													<?$specs = getSpecs($conn,$sprint['id_sprint']);
													foreach($specs as $spec){
														?>
														<tr>
															<td><?=$spec['nombre_spec']?></td>
															<td><?=$spec['horas']?></td>
															<td><?=$spec['estado']?></td>
														</tr>									
														<?
													}?>
												</table>
											</li>
										</ul>
									</li>
								<?$numSprint++;?>
							</ul>
						</div>
					<?
				}
			?>
		</div>

		<!--<div class="proyect-list">
			<div class="proyect-title">Proyectos</div>
			<div class="proyect-table">
				<div class="col s10 m10 l10 offset-s2 offset-m2 offset-l2">
				<?

				/*while($registre = mysqli_fetch_assoc($proyecto)){
						
						$descripcion_proyecto = $registre['descripcion_proyecto'];
						$scrumMaster_proyecto = $registre['ScrumMaster'];
						$productOwner_proyecto = $registre['ProductOwner'];
						$gruposProyecto = $registre['nombre_grupo'];
						?>
						<div class ="col s12 m12 l12">
							<? $nombre_proyecto ?>
						</div>
						<div class ="col s12 m12 l12">
							<span>hola</span>
						</div>
						<?

						echo "<li>";
						echo '<a href="vistaproyecto.php" name="'.$nombre_proyecto.'">'.$registre['nombre_proyecto']?></a>
						</div> <?
					}*/
				?>
				</ul>

			</div>
			
			
		</div>
		<div class="row">
			<div class="col card hoverable push-s1 s10 push-m2 m8 push-l4 l4 new-proyect-view-box"></div>
		</div>
	</div>

	<div class="window-message">
		<div class="error"></div>
	</div>-->
	<?

	function findProyects($conn,$proyectName){
		$consulta_proyecto = "SELECT proyectos.descripcion_proyecto,grupos.nombre_grupo ,u1.nombre_usuario AS 'ScrumMaster', u2.nombre_usuario AS 'ProductOwner' FROM proyectos, gruposproyectos, grupos,usuarios u1, usuarios u2 WHERE proyectos.id_proyecto = gruposproyectos.id_proyecto AND grupos.id_grupo = gruposproyectos.id_grupo AND proyectos.nombre_proyecto='".$proyectName."' AND proyectos.ScrumMaster = u1.id_usuario AND proyectos.ProductOwner = u2.id_usuario;";

		$query=mysqli_query($conn,$consulta_proyecto);
			$proyectos = [];
			while($registre = mysqli_fetch_assoc($query)){
				$proyectos[] = $registre;
			}
			print_r($proyectos);
			return ($proyectos);
	}

	function getSprints($conn,$proyecto){
		$query = "SELECT sprints.* FROM sprints,proyectos WHERE sprints.id_proyecto = proyectos.id_proyecto AND proyectos.nombre_proyecto = '$proyecto'";
		$sprints = [];
		$result = mysqli_query($conn, $query);
		while($registre = mysqli_fetch_assoc($result)){
			$sprints[] = $registre;
		}
		return $sprints;
	}

	function getSpecs($conn,$idsprint){
		$query = "SELECT * FROM especificaciones WHERE id_sprint = '$idsprint'";
		$specs = [];
		$result = mysqli_query($conn, $query);
		while($registre = mysqli_fetch_assoc($result)){
			$specs[] = $registre;
		}
		return $specs;
	}
	?>
</body>
</html>