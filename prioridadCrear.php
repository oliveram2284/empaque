<?php
session_start();
include("conexion.php");

$var = new conexion();
$var->conectarse();

$viaje = $_POST['viaje'];
$pedidos = $_POST['pedidos'];

//Prioridad
$sql = "Insert into prioridad
		(viajeId, usrId) Values (".$viaje.",".$_SESSION['id_usuario'].")";
$resu = mysql_query($sql) or die(mysql_error());

//ultimo id insertado 
$consulta = "Select max(prioId) from prioridad";
$resu = mysql_query($consulta);
$row = mysql_fetch_array($resu);
$prioId = $row[0];

//detalle de prioridad
foreach ($pedidos as $p) {
	//Evaluar si ya fue agregada
	$sql = "Select Count(*) from prioridadDetalle as d 
			Join prioridad as p on p.prioId = d.prioId
			Where d.pedId = ".$p." and p.viajeId = ".$viaje;
	$resu = mysql_query($sql);
	$row = mysql_fetch_array($resu);
	$cant = $row[0];

	if($cant == 0)
	{
		$sql = "Insert prioridadDetalle (prioId, pedId) Values (".$prioId.",".$p.")";
		$resu = mysql_query($sql) or die(mysql_error());
	}
}

echo json_encode(1);

?>