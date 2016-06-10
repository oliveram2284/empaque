<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$nombre = $_POST['nombre'];
$permisos = $_POST['indicesMenu'];
$administrador = isset($_POST['administrador']) ? 1 : 0;

$consulta = "insert into tbl_grupos(descripcion,permisos,administrador) values('$nombre','$permisos', $administrador)";
mysql_query($consulta);

echo'<script>alert("Operación realizada con éxito.");location.href="principal.php";</script>';
?>