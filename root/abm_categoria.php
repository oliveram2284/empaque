<?php
//include("class_menu.php");
include("class.categoria.php");

 include ("./layout/header.php");
include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();

?>
<div class="span-22 push-1">
<form action="" method="" id="">

<fieldset><legend>Prueba</legend>
 <div  class="append-14 top" >
 <?php 
 $link=new conexion();
 $link=$link->conectarse();
 include "vistas.php";
	 
	 $sql="select id_categoria 'id', codigo 'CODIGO', nombre 'NOMBRE', factor 'FACTOR' from categorias ";
	 $res=mysql_query($sql);
	
	 echo  view_grilla($res);
	
 ?>

</div>

</fieldset>


</form>
</div>
<?php include ("./layout/footer.php");?>

