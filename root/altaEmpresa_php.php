<!--
Documento: alta de empresas, altaEmpresa_php.php
Creado por: Sergio J. Moyano
Dia: 13/12/2010
Observaciones:
Modificaciones:
-->
<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$nombre = $_POST['Nombre'];

$consulta = "insert into empresas(descripcion) values('$nombre')";
mysql_query($consulta);

echo'<script>alert("Operaci�n realizada con �xito.");location.href="principal.php";</script>';
?>