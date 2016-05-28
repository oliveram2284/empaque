<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['xid'];

//Modificar
$sql = "Update viajes ";
$sql.= "set status = 0 ";
$sql.= "Where idViaje = ".$id;
$resu = mysql_query($sql) or die(mysql_error());

echo json_encode(0);
?>