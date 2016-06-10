<?php  
session_start();

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}

include ("conexion.php");
$var = new conexion();
$var->conectarse();

include ("class_menu.php") ;
$menu= new menu();

$accion = "I";
$id = 0;
if(isset($_GET['a']))
   {
	//Buscar los datos del grupo
	$accion = $_GET['a'];
	$id = $_GET['i'];
	$sql  = "SELECT * FROM  tbl_grupos WHERE id_grupo = ".$id."";
	$resu = mysql_query($sql)or die(mysql_error());
	$row = mysql_fetch_array($resu);
   }

require("header.php");
?>
<br>
    <form name="grupos" action="groupsphp.php" method="post">
    <div class="container">
    <center>
	<div id="menu" class="well">
	
	    <div class="row">
		<div class="span6 offset2">
			  <div class="page-header">
			  <h2>
			    Grupo
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atr&aacute;s&nbsp;" class="btn btn-danger" onClick="inicio()">
		</div>
	    </div>
	    
	    <div class="row">
		<div class="span10">
		    <strong>Nombre del Grupo: </strong>
		    <?php
			if($accion != "I")
			{
			    echo '<input type="text" id="gpoNombre" name="gpoNombre" value="'.$row['descripcion'].'">';
			}
			else
			{
			    echo '<input type="text" id="gpoNombre" name="gpoNombre">';
			    
			}
		    ?>
		     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		     <strong>Es Administrador</strong>
		     <?php
			if($accion != "I")
			{
			    if($row['administrador'] == 1)
			    {
				echo '<input type="checkbox" id="esAdmin" name="esAdmin" value="si" checked>';
			    }
			    else
			    {
				echo '<input type="checkbox" id="esAdmin" name="esAdmin" value="no">';
			    }
			}
			else
			{
			    echo '<input type="checkbox" id="esAdmin" name="esAdmin" value="no">';
			    
			}
		     ?>
		     <br><br>
		</div>
	    </div>
	    
	    <div class="row">
		<div class="span10">
			    <div class="navbar">
				<div class="navbar-inner">
				  <div class="container">
				    <div class="nav-collapse">
				      <ul class="nav">
					<?php
					    $menu->menu_permisos($id);
					?>
				      </ul>
				    </div>
				  </div>
				</div>
			      </div>
		</div>
	    </div>
	    
	    <div class="row">
		<div class="span10" style="text-align: right">
		    <input type="button" name="nuevo" value="Aceptar"  class="btn btn-success" onClick="Validar()">
			<input type="button" name="nuevo" value="Cancelar"  class="btn btn-danger" onClick="inicio()">
		</div>
	    </div>
	</div>    
    </center>
    </div>
    <input type="hidden" id="permisos" name="permisos" value="">
	<?php
	switch($accion)
	{
	    case "I":
		echo '<input type="hidden" id="accion" name="accion" value="I">';
		echo '<input type="hidden" id="idgpo" name="idgpo" value="'.$id.'">';
		break;
	    case "U":
		echo '<input type="hidden" id="accion" name="accion" value="U">';
		echo '<input type="hidden" id="idgpo" name="idgpo" value="'.$id.'">';
		break;
	    case "D":
		echo '<input type="hidden" id="accion" name="accion" value="D">';
		echo '<input type="hidden" id="idgpo" name="idgpo" value="'.$id.'">';
		break;
	}
	?>
    </form>
    
<?php

require("footer.php");

?>
<script>
    function inicio()
    {
	location.href="listado_grupos.php?tabla=tbl_grupos";
    }
    
    function grupos()
    {
        location.href="groups.php";
    }
    
    function Validar()
    {
	if(document.getElementById('accion').value != "D")
	{
	    if(document.getElementById('gpoNombre').value == "")
	    {
		alert("Ingrese un nombre válido para el grupo");
		return;
	    }
	    else
	    {
		$(document).ready(function() {     
		$("input[type=checkbox]:checked").each(function() { 
		    document.getElementById('permisos').value += $(this).attr("id")+"-";         
		    });     
		});
		
		if(document.getElementById('permisos').value == "")
		{
		    alert("Seleccione al menos un permiso del menu.");
		    return;
		}
		
		document.grupos.submit();
	    }
	}
	else
	{
	    document.grupos.submit();
	}
    }
    
    $('#esAdmin').change(function(){
    var checkeado = $(this).attr("checked");
    if(checkeado) {
        $(this).val('si');
    } else {
        $(this).val('no');
    }
});
</script>