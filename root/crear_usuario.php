<?php
$accion = $_GET['accion'];

include("conexion.php");
$var=new conexion;
$var->conectarse();


?>
<html>
<head>
<title>Usuario</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 

<link href="estilos.css" rel="stylesheet" type="text/css">


</head>
<center>
<body id="fondo">
<div class="container large">
<center>
<form name="usuario" action="crea_user.php" method="post" onSubmit="return validar()">
<div class="span-4 left">&nbsp;&nbsp;</div>
<div class="span-15 ">

<table >
  <tr>
    <td colspan="2" align="center" id="titulo_main">
    <?php
	echo ($accion == "C") ? "Crear Usuario": ( $accion == "M" ? "Modificar Usuario": "Eliminar Usuario");
	?>
    </td>
  </tr>
  <?php
   if($accion != "C")
   	{
		?>
        <tr>
  			<td align="right" colspan="2">Seleccionar Usuario:  &nbsp;&nbsp;&nbsp;
            	<select name="usuarios">
                <option value="0">Selecc. Usuario</option>
            	<?php
				$sql = "Select * from usuarios";
				$resu = mysql_query($sql,$var->links) or die (mysql_error());
				while($row=mysql_fetch_array($resu))
					{ 
					 echo "<option value='".$row['id_usuario']."'>".htmlentities($row['nombre'])."</option>";
				  	}
				?>
                </select>
            </td>
  		</tr>	
        <?php
	}
  ?>
  <tr>
    <td align="center"> Nombre de Usuario </td>
    <td align="center"><input type="text" name="nombre" size="28" maxlength="20" value="" /></td>
  </tr>
  <tr>
    <td align="center">Nombre Real: </td>
    <td align="center"><input type="text" name="nombre_real" size="28" maxlength="20" value=""/></td>
  </tr>
  <tr>
        <td align="center">Contraseña: </td>
      <td align="center"><input type="password" name="pass" size="28" maxlength="20" value=""/></td>
    </tr>
  <tr>
        <td align="center">Confirmar Contraseña: </td>
        <td align="center"><input type="password" name="pass2" size="28" maxlength="20" value=""/></td>
    </tr>
  
  <tr>
    <td colspan="2"><hr color="#62C05B"></td>
  </tr>
  <tr>
  <td colspan="2" align="center" id="titulo_main">Grupos Disponibles</td>
  </tr>
  <tr>
  <td colspan="2" align="center">
  <select name="usu[]" size="10" style="width:250px;" multiple="multiple">
  <?php

     $consulta2="SELECT id_grupo,descripcion FROM tbl_grupos order by descripcion";
     $result2=mysql_query($consulta2,$var->links);
     while($row=mysql_fetch_array($result2))
        { 
         echo "<option value='".$row['id_grupo']."'>".htmlentities($row['descripcion'])."</option>";
      }
    ?>
  </select>
  </td>
  </tr>
  <tr><td align="center" colspan="2">
  <table width="100%" align="center">
  <tr>
      <td colspan="2" align="center">
      <!-- <input type="button" name="volver" value="Volver" onClick="window.hist`??�?????<htmory.back();"> -->
      <input type="button" name="menus" value="Cancelar" onClick="inicio_menu(usuario)" class="button"/>&nbsp;&nbsp;
      <input type="submit" value="Aceptar" class="button"/>&nbsp;&nbsp;
      <input type="reset" value="Limpiar" class="button" />
      <!--<input type="button" name="cerrar" value="Cerrar Sesion" onClick="cerrarses(usuario)" class="botonmarron"/>-->
      </td>
  </tr>
</table>
  </td></tr>
</table>


</div>

 <input type="hidden" name="oper" />	
</form>
</center>

</div>
</body>
</center>
</html>
<script>
function validar()
	{
	if((document.usuario.nombre.value.length==0)||(document.usuario.nombre.value.length<4))//valido el nombre 
	   {
       alert("Tiene Que Escribir Un Nombre O Su Nombre Es Demasiado Corto!!!")
       document.usuario.nombre.focus();
	   return false;
       }
	 
	 if((document.usuario.nombre_real.value.length==0)||(document.usuario.nombre_real.value.length<10))//valido el nombre 
	   {
       alert("Tiene Que Escribir Un Nombre O Su Nombre Es Demasiado Corto!!!")
       document.usuario.nombre_real.focus();
	   return false;
       }
	   
	 if((document.usuario.pass.value.length==0)||(document.usuario.pass.value.length<4))
	   {
       alert("Tiene Que Escribir Su Contrase�a O Su Contrase�a No Tiene La Cantidad De Caracteres Requeridos!!!")
       document.usuario.pass.focus();
       return false;
       }  
	   
	 if (document.usuario.pass.value != document.usuario.pass2.value)
	   {
       alert("Las Contrase�as No Son Iguales!!!")
       document.usuario.pass2.focus();
       return false;
       }
     document.usuario.submit();
	 }

function inicio_menu(ob) /* AL MENU PRINCIPAL */
	{
	 ob.action="principal.php";
	 ob.submit();
	}
	
function cerrarses(obj) /* CERRAR SESION  */
	{
	 obj.oper.value="C";
	 obj.action="func_php.php";
	 obj.submit();
	}

function limpiar()
	{
	 document.usuario.pass.value="";
	 document.usuario.nombre_real.value="";
	}
</script>