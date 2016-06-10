</br>
<center>
<html>
<head>
<title>Empaque</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>


<body id="fondo">

<div class="container">
<div class="span-4">&nbsp;&nbsp;</div>
<div class="span-15">
<center>
<form name="grupo" action="crear_grupo_php.php" method="post">
<table>
  <tr>
    <td colspan="2" id="titulo_main" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Crear Grupo</td>
  </tr>
  <tr>
    <td align="left"><label>Nombre :</label></td>
    <td align="left"><input type="text" name="nombre" class="select"></td>
  </tr>
  <tr>
  	<td> <label>Es Administrador: </label></td>
    <td> <input type="checkbox" name="administrador"></td>
  </tr>
  <tr>
    <td align="left"><label>Permisos:</label></td>
  </tr>
  <tr>
    <td width="40%"></td>
    <td width="60%" align="left">
<?php
include("conexion.php");
 
$var = new conexion();
$var->conectarse();

$consulta = "select * from tbl_menu where imagen != ''";
$resu = mysql_query($consulta);

while($row = mysql_fetch_array($resu))
  {
   ?><input type="checkbox" name="<?php echo $row['id_menu'];?>" onClick="seleccionar(<?php echo $row['id_menu'];?>)"><?php
   
   echo "<label>".htmlentities($row['descripcion'])."</label><br>";
   ?>
   <div id="<?php echo $row['id_menu'].'div';?>" style="display:none;">
		   <?php
           $item = $row['ubicacion'].'/';
           $consulta2 = "select * from tbl_menu where ubicacion like '$item%' Order By ubicacion";
           $resul = mysql_query($consulta2);
           
           while($row2 = mysql_fetch_array($resul))
            {
              echo "&nbsp;&nbsp;&nbsp;&nbsp;";
              ?>
              <input type="checkbox" name="<?php echo $row2['id_menu'];?>" ><!--onClick="alerta('<?php //echo $row['id_menu'];?>')"-->
              <?php
              echo htmlentities($row2['descripcion'])."<br>";
            }
          ?>
   </div>
  <?php
  }
?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><hr ></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    	&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        
      <input type="button" onClick="buscar()" value="Aceptar" class="button">           
      &nbsp;&nbsp;&nbsp;
      <input type="button" onClick="Principal()" value="Cancelar" class="button">
    </td>
  </tr>
</table>
<input type="hidden" name="indicesMenu" value="">

</form>
</center>
</div>
  

</div>


</body>
</html>
</center>
<script>
function Principal()
	{
	 document.grupo.action = "principal.php";
	 document.grupo.submit();
	}
	
function buscar()
	{
	document.grupo.indicesMenu.value = "";
	
	var elementos = document.grupo.elements.length;

	for(i=0; i<elementos; i++)
		{
	
		if(document.grupo.elements[i].type == 'checkbox' && document.grupo.elements[i].name != 'administrador')
			{
			 if(document.grupo.elements[i].checked == true)
			 	{
					if(document.grupo.indicesMenu.value == "")
					{
				 		document.grupo.indicesMenu.value = document.grupo.elements[i].name;
					}else
						{
							document.grupo.indicesMenu.value = document.grupo.indicesMenu.value +"-"+ document.grupo.elements[i].name;
						}
				}
			}

		}
	document.grupo.action = "crear_grupo_php.php";
	document.grupo.submit();
	}
	
function seleccionar(valor)
	{
	 div = document.getElementById(valor+'div');

	 if (div.style.display == '')
	 	{
		 div.style.display = 'none';
		}
		else
			{
			 div.style.display = '';
			}

	}
</script>