<!DOCTYPE html>
<html>
<head>
	
  <link rel="stylesheet" href="css/style.css"> 
  <title>Cambio de Password</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">      
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
  <link rel="shortcut icon" href="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png">
  <script type="text/javascript" src="js/script.js" defer>
  	
  </script>
  <script type="text/javascript" src="js/clases.js"></script>
</head>
<body>
	<?php
	if (isset($_POST['Password'])) {
		include 'connection.php';
		/*$consulta_token="UPDATE usuarios set password where token='".$token."'";
		$query = "UPDATE usuarios SET token = '$token' WHERE nombre_usuario = '$user'";*/
    echo "CORRECTO";
	}else{	
    
	}
?>
    <div class="container">
      <div class = "row" style = "width:100%;">
        <div id="divcabecera" class = "col s12 m12 l12" >
          <nav>
            <div class = "nav-wrapper">
              <a href = "#" class = "brand-logo nombrelogo">Cambiar Password</a>
              <a href="#!" class="brand-logo center"><img src="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png"></a>
            </div>
          </nav>
        </div>
        <div class="parallax"><img src="https://cdn.pixabay.com/photo/2016/06/02/02/38/mesh-1430108_960_720.png"></div>
        <div class="s12 m12 l12"><br> <br></div>    
        <div id="formulario" class="col m8 s8 l8 offset-m2 offset-s2 offset-l2 center z-depth-3">
          <form class = "col l12" method="post" action="#" id="formpass" >
            <div align="center" class = "center input-field col l12">
              <input placeholder = "Password" name = "Password" id="primerPassword" type = "password" class = "active validate" required />
              <label for = "username">Password</label>
            </div>
            <div align="center" class = "center input-field col l12">
              <input placeholder = "Password" name = "Password2" id="segundoPassword"type = "password" class = "active validate" required />
              <label for = "username">Password</label>
            </div>

            <div class = "col l12">
          </form>
          <div class="button" onclick="compararPassword()">Cambiar Password</div>
        </div>
      </div>
      </div>
    </div>
    <div class="window-message">
      <div class="error"></div>
    </div>
	
	 
	


</body>
</html>