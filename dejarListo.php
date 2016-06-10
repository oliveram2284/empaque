<?php  
session_start();

include ("conexion.php");
$vari = new conexion();
$vari->conectarse();

$id = $_POST['id'];

$sql = "Update protocolos set estado = 'EN' where prtId = ".$id;
$resu = mysql_query($sql);

//echo $sql;
?>