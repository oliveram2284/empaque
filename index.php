
<!doctype html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Jekyll v3.8.5">
		<title>Empaque Sa</title>

		<link rel="canonical" href="">
		<!-- Bootstrap core CSS -->
		<link href="assest/bootstrap/dist/css/bootstrap.css" rel="stylesheet" >
		<link href="assest/login.css" rel="stylesheet" >

	</head>
  	<body >
		<form class="form-signin" action="login.php" method="POST">		
			<img class="mb-4 img-fluid" src="logo-V2.png" alt="" >
			<h1 class="h3 mb-3 font-weight-normal text-center">Sistema Ventas</h1>
			<div class="form-group">
				<label for="username text-right">Usuario</label>
				<input type="text" id="username"  name="username" class="form-control" placeholder="Usuario" required autofocus>
			</div>

			<div class="form-group">
				<label for="inputPassword text-right">Password</label>
				<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			</div>


			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
			
		</form>
	</body>
</html>



<?php
session_start();
session_destroy();
require("header.php");
/*
?>


<body id="fondo">

<br />
<div class="container">
  <div class="well" style="min-height: 90%">
  <form name="index" action="func_php.php" method="post" onSubmit="return valida()">
    <br><br><br><br>
    <div style=" width: 320px; background: #F0F0F0; border-radius: 10px 10px 10px 10px; -moz-border-radius: 10px 10px 10px 10px; -webkit-border-radius: 10px 10px 10px 10px; border: 1px solid #04B431; box-shadow: 20px 20px 45px rgba(0, 0, 0, 0.99); -moz-box-shadow: 20px 20px 45px rgba(0, 0, 0, 0.99); -webkit-box-shadow: 20px 20px 45px rgba(0, 0, 0, 0.99);">
      <br>
      <table>
	<tr>
	  <td><img src="logo-V2.png" width="200" height="150" /><br><br><br></td>
	</tr>
	<tr>
	  <td><input type="text" name="user" id="user" placeholder="Nombre de Usuario" /></td>
	</tr>
	<tr>
	  <td><input type="password" name="pass" id="pass" placeholder="Constraseña" /></td>
	</tr>
	<tr>
	  <td style="text-align: center"><input type="submit" value="Ingresar" class="btn btn-success" /></td>
	</tr>
      </table>
      <br>
      <br>
	<input type="hidden" name="oper" value="V"/>

    </div>


  </form>
  </div>
</div>
<br>
<br>
<br>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>

</body>
<?php
require("header.php"); */
?>