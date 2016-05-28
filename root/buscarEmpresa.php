<?php
 include("conexion.php");
 include("pantalla_libreria.php");
$conecta = new conexion();
$conecta ->conectarse();

$dato=$_POST['variable'];


$res=mysql_query("SELECT id_empresa , descripcion from empresas where descripcion like '".$dato."%'; ")or die(mysql_error());;


 listaTabla($res,'editconductor.php','supconductor.php','Modificar_Conductor');

?>