<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?
		session_start();
		session_destroy();
		header("location:login.php");
		exit;
	?>
</body>
</html>