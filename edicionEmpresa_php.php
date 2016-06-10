<!--
Documento: edicion de empresas, edicionEmpresa_php.php
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
$id = $_POST['id_empresa'];

$consulta = "Update empresas Set descripcion = '".$nombre."' Where id_empresa = '".$id."'";
mysql_query($consulta);

echo'<script>alert("Operación realizada con éxito.");location.href="principal.php";</script>';
?>