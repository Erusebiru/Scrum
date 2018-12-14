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

		include 'connection.php';
		$proyecto = "Scrum";
		$sprints = getSprints($conn,$proyecto);
	?>
<div class="contenedor">
		<div id="divcabecera" class = "col s12 m12 l12" >
	      <nav>
	        <div class = "nav-wrapper">
	          <a href = "#" class = "brand-logo nombrelogo">Administración de proyectos</a>
	          <a href="#!" class="brand-logo center"><img src="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png"></a>
	          <ul id="nav-mobile" class="right hide-on-med-and-down">
		          <li class="grey-text lighten-5">Usuario: <?php echo $user ?></li>
		          <li><a href="logout.php"><i class="material-icons grey-text">exit_to_app</i></a></li>
		      </ul>
	        </div>
	      </nav>
	    </div>
		
		<div id="TablaSprints">
			<?
				echo "<h4>Listado de Sprints</h4>";
				$numSprint = 1;
				foreach($sprints as $sprint){
					?>
						<div class="sprint">
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
															<td><?=$spec['numero']?></td>
															<td><?=$spec['horas']?></td>
															<td><?=$spec['estado']?></td>
														</tr>									
														<?
													}?>
												</table>
											</li>
											<li><label>Añadir especificación: </label><input type="text" class="input-field" name="addSpec"></li>
										</ul>
									</li>
								<?$numSprint++;?>
							</ul>
						</div>
					<?
				}
			?>
		</div>

		<?
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