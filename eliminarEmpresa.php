<!--
Documento: eliminar una empresas, eliminarEmpresa.php
Creado por: Sergio J. Moyano
Dia: 13/12/2010
Observaciones:
Modificaciones:
-->
<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_GET['id'];

$consulta = "Delete From empresas Where id_empresa ='".$id."'";
mysql_query($consulta);

echo'<script>alert("Operaci�n realizada con �xito.");location.href="listadoEmpresa.php";</script>';
?>