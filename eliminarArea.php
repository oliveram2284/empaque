<!--
Documento: eliminar un area, eliminarArea.php
Creado por: Sergio J. Moyano
Dia: 14/12/2010
Observaciones:
Modificaciones:
-->
<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_GET['id'];

$consulta = "Delete From areas Where id_area ='".$id."'";
mysql_query($consulta);

echo'<script>alert("Operación realizada con éxito.");location.href="listadoArea.php";</script>';
?>