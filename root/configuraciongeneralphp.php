<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Empaque</title>
</head>
</html>
<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$cuit = $_POST['cuit'];
$desc = $_POST['razon'];
$dire = $_POST['direccion'];
$depa = $_POST['departamento'];
$prov = $_POST['Provincia'];
$tele = $_POST['telefono'];
$mail = $_POST['mail'];
$cont = $_POST['contacto'];

$consulta = "Update configuracionempresa set cuit='$cuit', descripcion='$desc',";
$consulta.= "direccion='$dire', departamento='$depa', provincia='$prov', telefonofax='$tele',";
$consulta.= "mail='$mail', contacto='$cont' Where id_cliente=1";

$resu = mysql_query($consulta) or ('<script>alert("A ocurrido un problema, verifique los datos e intente nuevamente la operación.");window.history.back();</script>');

if ($resu==1)
	{
		echo '<script>alert("Datos editados correctamente.");location.href="principal.php";</script>';
	}
	else
	{
		echo '<script>alert("A ocurrido un problema, verifique los datos e intente nuevamente la operación.");window.history.back();</script>';
	}
?>