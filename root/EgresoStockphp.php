<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$solicitante = $_POST['codigoTangoFacturar'];

$idProducto = $_POST['idProducto'];

$destino = $_POST['destino'];

$cantidad = $_POST['cantidad'];

$fecha = date("d-m-Y h:i:s A");

//echo $solicitante."--".$idProducto."--".$destino."--".$cantidad;
$consulta = "Insert Into ordenretiro(idSolicitante,idProducto,idDestino,Cantidad,Fecha) values (";
$consulta .= "'$solicitante','$idProducto',$destino,$cantidad,'".$fecha."')";
$resultado = mysql_query($consulta) or die(mysql_error());

echo '<script>alert("Extracción de productos exitosa.");location.href="principal.php";</script>';
?>