<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$idPolimero = $_POST['id'];
$factura = $_POST['numero'];

$sql = "Update polimeros Set nro_factura='$factura', estado = '3' Where id_polimero=$idPolimero";
$resu = mysql_query($sql) or (die(mysql_error()));

echo '<script>opener.location.reload();window.close();</script>';

?>