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
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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

		if (isset($_SESSION['selectedProyect']) || $_SESSION['selectedProyect']!=null) {
			$nombre_proyecto = $_SESSION['selectedProyect'];
			$tipo_usuario = $_SESSION['tipo_usuario'];
		}
		else {
			$nombre_proyecto = $_POST["selectedProyect"];
			$_SESSION['selectedProyect'] = $nombre_proyecto;
			$tipo_usuario = $_POST['tipoUsuario'];
			$_SESSION['tipo_usuario'] = $tipo_usuario;
		}

		echo "<script>var global_tipoUsuario = '".$tipo_usuario."'</script>";
		
		$sprints = getSprints($conn,$nombre_proyecto);
		$specs = getSpecs($conn);
		$proyecto = findProyects($conn,$nombre_proyecto);
		$hoy = date('Y-m-d');
		$dema = mktime(0,0,0, date("m"), date("d")+1, date("Y"))
	?>

	<div class="contenedor">
		<div id="divcabecera" class = "col s12 m12 l12" >
	      <nav>
	        <div class = "nav-wrapper">
	          <a href = "#" class = "brand-logo nombrelogo">Administración de proyectos</a>
	          <a href="proyectos.php" class="brand-logo center"><img src="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png"></a>
	          <ul id="nav-mobile" class="right hide-on-med-and-down">
		          <li class="grey-text lighten-5">Usuario: <?php echo $user ?></li>
		          <li><a href="logout.php"><i class="material-icons grey-text">exit_to_app</i></a></li>
		      </ul>
	        </div>
	      </nav>
	    </div>

	    <div class="container">
	    	<div class="row">

		    	<div id="TablaProyectos" class="col s12 m12 l12 tabla-vistaproyectos">
		    		<h4><?= $nombre_proyecto ?></h4>
		    		<div class='proyecto' id="<?=$proyecto[0]['id_proyecto']?>">
						<table>
							<tr> 
							<?
							if (isset($proyecto[0])) {
								
								echo "<td><b>Descripción:</b></td><td>".$proyecto[0]['descripcion_proyecto']."</td></tr>";
								echo "<td><b>ScrumMaster:</b></td><td>".$proyecto[0]['ScrumMaster']."</td></tr>";
								echo "<td><b>ProductOwner:</b></td><td>".$proyecto[0]['ProductOwner']."</td></tr>";
								echo "<td><b>Grupos:</td></b><td>";
								foreach($proyecto as $grupo){
									echo $grupo['nombre_grupo']." <br>";
								}
								echo "</td>";
								}
							?>
							</tr>
						</table>
					</div>
		   		</div>

		   		<div id="TablaSprints" class="col s5 m5 l5 tabla-vistaproyectos">
				<?
					echo "<h4>Listado de Sprints</h4>";
					$numSprint = 1;
					foreach($sprints as $sprint){

						if(comprobarFecha($hoy,$sprint) == "actual"){

							?><div  class="sprint sprint-actual">
								
								<i onclick="cambiarIcono()"  id="abierto"  class="material-icons">lock</i><?

						}else if(comprobarFecha($hoy,$sprint) == "proximo"){
							?><div class="sprint sprint-proximo">
								<i  onclick="cambiarIconoProximo(this)" id="proximo" class="material-icons">lock</i><?

						}else{
							?><div id=<?= $sprint['id_sprint']?> class="sprint sprint-anterior">

								<i id="cerrado" class="material-icons">lock</i><?
						}?>
								<?echo "<h6  onclick='showSprint(this)'>Sprint ".$numSprint."</h6>";
								?><ul class="plegado" name="primero"><?
									$fechaInicio = date("d-m-Y", strtotime($sprint['Fecha_Inicio']));
									$fechaFin = date("d-m-Y", strtotime($sprint['Fecha_Fin']));

									$id_sprint = $sprint['id_sprint'];
									?>
									<li>
										<p class="title">Información</p>

										<?
										if(comprobarFecha($hoy,$sprint) == "proximo" && $tipo_usuario=='scrumMaster'){ ?>
											<i onclick="deleteSprint('<?=$numSprint?> ','<?=$id_sprint?>')" class="material-icons deleteicon">delete</i>
										<? } ?>
										<ul>
											<li>
												<table>
													<tr>
														<th>Horas totales</th>
														<th>Fecha de inicio</th>
														<th>Fecha de fin</th>
													</tr>

													<tr class="sprintData">
														<td><input class='modificarEsp' type='text' value="<?=$sprint['horasTotales']?>" disabled></td>
														<td name="fechaInicio"><input class='modificarEsp' type='text' value="<?=$fechaInicio?>" disabled></td>
														<td name="fechaFin"><input class='modificarEsp' type='text' value="<?=$fechaFin?>" disabled></td>
													</tr>
												</table>
											</li>
										</ul>
									</li>
									<li>
										<p class="title">Especificaciones</p>
										<ul>
											<?if(comprobarFecha($hoy,$sprint) == "proximo"){
												?><li name="dropBoard" sprint="<?=$numSprint?>"><?
											}else{
												?><li><?
											}?>
												<table>
													<tr>
														<th>Tarea</th>
														<th>Horas Asignadas</th>
														<th>Estado</th>
													</tr>
													<tr><i  class="material-icons right">add_circle_outline</i></tr>
													<?$specsSprint = getSpecsSprint($conn,$sprint['id_sprint']);
													foreach($specsSprint as $spec){
														?>
														<tr name="specs<?=$numSprint?>">
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
									<button onclick="modificarSprint(this)" class="btn waves-effect waves-light" id="enviarEsp" type="submit">Modificar<i  class="material-icons right">send</i></button>
								</ul>
							</div>
						<?
					}

					if($tipo_usuario == "scrumMaster"){?>
						<div class="newSprint">
							<a href="#modify" class="btn waves-effect waves-light openmodal">Añadir nuevo Sprint</a>
						</div>
					<?}?>

					<div class="cuadro" id="modify">
			            <div class="centro">
			            	<form action="insertsprint.php" method="POST">
			            		<label for="numSprint">Número de Sprint</label>
			            		<input type="number" name="numSprint" disabled value="<?=$numSprint?>">
			            		<label for="inicio">Fecha de inicio</label>
			            		<input type="date" name="inicio" min="<?=$hoy?>" required>
			            		<label for="fin">Fecha de fin</label>
			            		<input type="date" name="fin" required>
			            		<label for="horastotales">Horas totales</label>
			            		<input type="number" name="horastotales" min="1" required>
								<br><br>
								<input type="hidden" name="idproyecto" value>
			            		<button class="btn waves-effect waves-light" type="button" name="action" onclick="checkSprints(this)">Crea
			    					<i class="material-icons right">send</i>
			  					</button>
			  					<a href="#close" title="Close" ></a>
		            		</form>
			            </div>
		        	</div>
				</div>

				<div id="TablaEspecificaciones" class="col s6 m6 l6 offset-m1 offset-l1 tabla-vistaproyectos">
					<?echo "<h4>Listado de Especificaciones</h4>";
					$numSpec = 1;
					?>
					<div class="especificacion">
						<table class="board">
							<tr>
								<th>Número de especificación</th>
								<th>Tarea</th>
								<th>Estado</th>
								<th></th>
							</tr>
						<?
						foreach($specs as $spec){
							?>
							<tr class="spec tarea" draggable="true">
								<td name="numSpec"><?=$numSpec?></td>
								<td><?=$spec['nombre_spec']?></td>
								<td><?=$spec['estado']?></td>
								<?if($tipo_usuario == "productOwner"){
									?><td><img class="upside" src="images/up.png"><img class="downside" src="images/down.png"><img class="del" src="images/del.png"></td><?
								}?>
							</tr>
							<?
							$numSpec++;
						}
						?>
						</table>
						<br>
						<?if($tipo_usuario === "productOwner"){?>
							<div class="row">
			            		<div class="col s12">
			                		<div class="row">
			                    		<div class="input-field col s6">
			                        		<input id="newSpec" type="text" class="validate">
			                        		<label for="newSpec">Añadir especificación</label>
			                    		</div>
					                    <div class="input-field col s6">
					                        <button class="btn waves-effect waves-light" type="submit" onclick="addNewSpec()">Añadir</button>
					                    </div>
			                		</div>
			           			</div>
			        		</div>
			        	

			        </div>
				</div>
		        <?}?>
			</div>
				
			<div class="sprint-id-box"></div>
			<div class="remove-specs-box"></div>
			
		</div>
		<div class="window-message">
			<div class="error"></div>
		</div>
		</div>
		<?

		function comprobarFecha($hoy,$sprint){
			if($hoy >= $sprint['Fecha_Inicio'] && $hoy <= $sprint['Fecha_Fin']){
				return "actual";
			}else if($hoy < $sprint['Fecha_Inicio']){
				return "proximo";
			}else{
				return "pasado";
			}
		}


		function findProyects($conn,$proyectName){
			$consulta_proyecto = "SELECT proyectos.id_proyecto,proyectos.descripcion_proyecto,grupos.nombre_grupo ,u1.nombre_usuario AS 'ScrumMaster', u2.nombre_usuario AS 'ProductOwner' FROM proyectos, gruposproyectos, grupos,usuarios u1, usuarios u2 WHERE proyectos.id_proyecto = gruposproyectos.id_proyecto AND grupos.id_grupo = gruposproyectos.id_grupo AND proyectos.nombre_proyecto='".$proyectName."' AND proyectos.ScrumMaster = u1.id_usuario AND proyectos.ProductOwner = u2.id_usuario;";

			$query=mysqli_query($conn,$consulta_proyecto);
				$proyectos = [];
				while($registre = mysqli_fetch_assoc($query)){
					$proyectos[] = $registre;
				}
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

		function getSpecsSprint($conn,$idsprint){
			$query = "SELECT * FROM especificaciones WHERE id_sprint = '$idsprint'";
			$specs = [];
			$result = mysqli_query($conn, $query);
			while($registre = mysqli_fetch_assoc($result)){
				$specs[] = $registre;
			}
			return $specs;
		}

		
		function getSpecs($conn){
			$query = "SELECT * FROM especificaciones WHERE estado='backlog' ORDER BY id_sprint";
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