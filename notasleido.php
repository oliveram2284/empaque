<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$id = $_POST['xid'];
$estado = $_POST['xestado'];

$consulta = "Update notas Set leido = ".$estado." Where idNota=".$id;
$resu = mysql_query($consulta);

echo json_encode(1);
?>