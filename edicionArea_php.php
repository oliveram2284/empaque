<!--
Documento: edicion de areas, edicionArea_php.php
Creado por: Sergio J. Moyano
Dia: 14/12/2010
Observaciones:
Modificaciones:
-->
<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$nombre = $_POST['Nombre'];
$id = $_POST['id_area'];

$consulta = "Update areas Set descripcion = '".$nombre."' Where id_area = '".$id."'";
mysql_query($consulta);

echo'<script>alert("Operaci�n realizada con �xito.");location.href="principal.php";</script>';
?>