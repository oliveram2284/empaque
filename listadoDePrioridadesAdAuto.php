<?php

include ("conexion.php");

$vari = new conexion();
$vari->conectarse();

$cant	= $_POST['cnt'];
$id = $_POST['ide'];
$viaje = $_POST['via'];

$sql = "Update prioridaddetalle d
		Join prioridad as p on p.prioId = d.prioId
		Set d.cantAut = ".$cant."
		Where d.pedId = ".$id." and p.viajeId = ".$viaje;

$resu = mysql_query($sql);

?>