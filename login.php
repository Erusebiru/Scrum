<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/style.css"> 
  <title>Login</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">      
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
  <link rel="shortcut icon" href="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png">
  <script type="text/javascript" src="js/script.js" defer></script>
  
</head>
<body>
  <?php
    session_start();
    if(isset($_SESSION['user'])){
      header('Location: proyectos.php');
    }
  ?>
  <div class="container">
    <div class = "row" style = "width:100%;">
      <div id="divcabecera" class = "col s12 m12 l12" >
        <nav>
          <div class = "nav-wrapper">
            <a href = "#" class = "brand-logo">Login</a>
            <a href="#!" class="brand-logo center"><img src="https://www.logolynx.com/images/logolynx/15/1588b3eef9f1607d259c3f334b85ffd1.png"></a>
          </div>
        </nav>
      </div>

      <?php
        if (isset($_SESSION['error']) && $_SESSION['error']!='undefined' && $_SESSION['error']!=null && $_SESSION['error']!=""){

          if ($_SESSION['error']=="errorPsw") {
            echo '<script>var error = "password";</script>';
          }
          else if ($_SESSION['error']=="errorUser") {
            echo '<script> var error = "usuario" </script>';            
          }
        }
      ?>

      <div class="parallax"><img src="https://cdn.pixabay.com/photo/2016/06/02/02/38/mesh-1430108_960_720.png"></div>
      <div class="s12 m12 l12"><br> <br></div>    
      <div id="formulario" class="col m8 s8 l8 offset-m2 offset-s2 offset-l2 center z-depth-3">
        <form class = "col l12" method="post" action="validarLogin.php">
          <div align="center" class = "center input-field col l12">
            <i class = "material-icons prefix">account_circle</i>
            <input placeholder = "Username" name = "username" type = "text" class = "active validate" required />
            <label for = "username">Username</label>
          </div>

          <div align="center" class = " center input-field col l12"> 
            <i class = "material-icons prefix"></i>
            <label for = "password">Password</label>
            <input id = "password" type = "password" placeholder = "Password" name="password" class = "validate" required />  
          </div>

          <div class = "col l12">
            <button class="btn waves-effect waves-light grey darken-2" type="submit" name="action">Submit
            <i class="material-icons right">send</i>
            </button>

          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="window-message">
    <div class="error"></div>
  </div>
</body>
 
</html>