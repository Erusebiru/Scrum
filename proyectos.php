<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link type="text/css" rel="stylesheet" href="css/style.css"/>
	<script type="text/javascript" src="js/script.js" defer></script>
	<script type="text/javascript" src="js/clases.js"></script>
</head>
<body>
	<div class="contenedor">
		<div class="proyect-list">
			<div class="proyect-title">Proyectos</div>
			<div class="proyect-table">
				<ul>
				<?
					for($i=1;$i<30;$i++){
						?><li>
							<a href="#">Proyecto <?=$i?></a>
						</li><?
					}
				?>
				</ul>
			</div>
		</div>
	</div>

	<div class="window-message">
		<div class="error">
			<div class="image-error">
				<span id="error-message">ERROR</span>
			</div>
		</div>
	</div>
</body>
</html>