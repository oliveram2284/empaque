<!--
Documento: listado de empresas, listadoEmpresa.php
Creado por: Sergio J. Moyano
Dia: 13/12/2010
Observaciones:
Modificaciones:
-->
<?php
include("conexion.php");
include("pantalla_libreria.php");

$var = new conexion();
$var->conectarse();

$res =mysql_query("Select descripcion, id_empresa From empresas order by descripcion") or die (mysql_error());
//$res=mysql_query("SELECT id_cond 'Nro' , nombre 'Nombre', dni_conductor 'DNI', telefono 'Teléfono' from tbl_conductor where estado='0' ; ")or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Listado de Empresas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../Frame/estilos.css" rel="stylesheet" type="text/css">
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/validacion.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>

</head>

<body class="body">
<center>
<form name="empresas" action="listadoEmpresa_php.php" onSubmit="return empresa()" method="post">
<table width="800" class="borde_tabla">
	<tr>
		<td class="tituloformulario" align="center">Empresas</td>
	</tr>
	<tr>
		<td align="left">
			<input type="button" name="nuevo" id="nuevo" onclick="" class="botonmarron" value="Nuevo">
			<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="buscar" id="buscar" onclick="ShowDiv('flotante');" class="botonmarron" value="Buscar">
			
			  <button type="button" name="addclientebt" id="addclientebt" onclick=" PopWindows('addconductor.php','Nuevo_Cliente','180','750');" class="botonmarron" ></button>
			  <button type="button" name="buscarbt" id="buscarbt" onclick="" ><img src="assets/css/plugins/buttons/icons/magnifier.png" align="middle" alt="" />Buscar Conductor</button>
			-->
		</td>
	</tr>
	<tr>
		<td>
        	<table width="100%" >
            	<!--<tr>-->
                    <!--<td align="left"><input type="radio" name="filtro" id="filtro" value="2" checked="checked" />Nombre</td>-->
                    <!-- <td width="58%" align="left" ><input type="radio" name="filtro" id="filtro" value="4" disabled="disabled" />Nombre</td> -->
                <!--</tr>-->
                <tr>
					<td colspan="3" align="left">Buscar :
      	  			<input type="text" name="buscartext" id="buscartext" size="50"   onkeyup="ajaxx(this.value,'listEmpresa','buscarEmpresa.php');"  />      	  
          			</td>
				</tr>
            </table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%">
				<tr class="sub_titulo">
					<td align="center">Nombre</td>
					<td align="center">Editar</td>
					<td align="center">Eliminar</td>
				</tr>
				<?php
				/*
				$consulta = "Select * From empresas order by descripcion";
				$resu = mysql_query($consulta);
				
				if(mysql_num_rows($resu)<= 0)
					{
						echo '<tr><td colspan="3" align="center">No se encontraron empresas.</td></tr>';
					}else
						{
						 while($row = mysql_fetch_array($resu))
						 	{
							 echo "<tr>";
							 echo "<td>".$row['descripcion']."</td>";
							 echo '<td align="center"><img src="iconos/editar.png" onClick="editar('.$row['id_empresa'].')"></td>';
							 echo '<td align="center"><img src="iconos/borrar.png" onClick="borrar('.$row['id_empresa'].')"></td>';
							 echo "</tr>";
							}
						}*/
				?>
			</table>
		</td>
	</tr>
	 <tr>
        <td align="left">
        <div id="listEmpresa" >
        <?php
		listaTabla($res,'editconductor.php','supconductor.php','Modificar_Conductor');
		?>
        </div>
        </td>
      </tr>
	<tr>
		<td><hr class="color"></td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			<input type="button" class="botonmarron" value="<< Principal" onClick="principal()">
		</td>
	</tr>
</table>
</form>
</center>
</body>
</html>
<script>
function editar(id)
	{
	 document.empresas.action = "edicionEmpresa.php?id="+id;
	 document.empresas.submit();
	}

function borrar(id)
	{
	  if (confirm('¿Estas seguro de eliminar esta empresa?'))
	  	{
       	 document.empresas.action = "eliminarEmpresa.php?id="+id;
		 document.empresas.submit();
    	} 
	}
</script>