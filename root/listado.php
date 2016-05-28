<?php  
session_start();

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}

include ("conexion.php");

 ?>
 <br />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Empaque</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>
  <script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
  <script   type="text/javascript" src="assest/Js/Botones.js"></script>
  
<script language="javascript" src="abm_iniciador_js.js" type="text/javascript"></script>

<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>

</head>

<body id="fondo"  >
<div class="container  large"> <!-- Contenerdor margen de Pantalla standarizado -->

			<div class="span-24 " >
			<center>
			  <p align="center"></p>
</center>
			
</div>
<div class="span-22  push-1"  id="titulo_main">
<center>
	<label>
        <?php
            $vari = new conexion();
            $vari->conectarse();
            
            $sql = "Select Titulo from tbl_tablas Where descripcion = '".$_GET['tabla']."'";
            $resultado = mysql_query($sql) or (die(mysql_error()));
            $row = mysql_fetch_array($resultado);
            
            echo $row['Titulo'];         
        ?>
    </label>
</center>
</div>			

<div class="span-24">
<div id="menu_top" class="span-24 ">
<p>
      
</p>  

<div class="span-22 push-1"> <!-- Cuerpo de Formulario -->

<form name="listado">
<?php
include("class_abm.php");

$tabla = new abm();
$tabla->listado($_GET['tabla']);

?>
</form>
</div>
</div>
</div>
</body>
</html>
