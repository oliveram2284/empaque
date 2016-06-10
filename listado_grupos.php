<?php  
session_start();

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}

include ("conexion.php");


require("header.php");
?>
<br>
    <div class="container">
    <center>
	<div id="menu" class="well">
	
	    <div class="row">
		<div class="span6 offset2">
			  <div class="page-header">
			  <h2>
			    <?php
				$vari = new conexion();
				$vari->conectarse();
				
				$sql = "Select Titulo from tbl_tablas Where descripcion = '".$_GET['tabla']."'";
				$resultado = mysql_query($sql) or (die(mysql_error()));
				$row = mysql_fetch_array($resultado);
				
				echo $row['Titulo'];
			    ?>
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" name="nuevo" value="Nuevo"  class="btn btn-success" onClick="grupos()">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
			    <?php
				include("class_abm.php");
				
				$tabla = new abm();
				$tabla->listado_grupo($_GET['tabla']);
			    ?>
		</div>
	    </div>
	</div>    
    </center>
    </div>

<?php

require("footer.php");

?>
<script>
    function inicio()
    {
	location.href="principal.php";
    }
    
    function grupos()
    {
        location.href="groups.php";
    }
    
</script>