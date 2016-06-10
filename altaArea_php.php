<!--
Documento: alta de areas, altaArea_php.php
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

$consulta = "insert into areas(descripcion) values('$nombre')";
mysql_query($consulta);

echo'<script>alert("Operación realizada con éxito.");location.href="principal.php";</script>';
?>