<!DOCTYPE html>
<html>
<head>
	<title>Cambiar Contraseña</title>
</head>
<body>
	

<?php
	session_start();
	session_destroy();
	session_start();



	if(isset($_SESSION['user'])){
		header('Location: proyectos.php');

	} else {
		$user = $_POST["username"];
		

		$conn = mysqli_connect('localhost','Admin','Admin');
		mysqli_select_db($conn, 'proyectoscrum');

		$consulta_user ="SELECT nombre_usuario FROM usuarios where nombre_usuario='".$user."';";

		$user_comprovar = mysqli_num_rows(mysqli_query($conn,$consulta_user));
		
		if ($user_comprovar == 0) {
			$error = "errorUser";
			$_SESSION['error'] = $error;
			header('Location: recuperarPassword.php');
			}
		}


   // $to = "kalouan@iesesteveterradas.cat";
   // $subject = "Checking PHP mail";
   // $message = "PHP mail works just fine";
   //$headers = "From:ubuntu@gfjkghjkflk.com";
   // mail($to,$subject,$message, $headers);
   
    
		
	?>
	<div class="s12 m12 l12"><br> <br></div>    
      <div id="formulario" class="col m8 s8 l8 offset-m2 offset-s2 offset-l2 center z-depth-3">
        <form class = "col l12" method="post" name="formemail" action="recuperarPasswordValidar.php">
          <div align="center" class = "center input-field col l12">
            <i class = "material-icons prefix">account_circle</i>
            <input placeholder = "Username" name = "username" type = "text" class = "active validate" required />
            <label for = "username">Username</label>
          </div>

          <div class = "col l12">
            <button class="btn waves-effect waves-light grey darken-2" type="submit" name="action">Enviar
            <i class="material-icons right">send</i>
          </div>
        </form>
      </div>
    </div>
  </div>



</body>
</html>
