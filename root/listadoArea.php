<!--
Documento: listado de áreas, listadoArea.php
Creado por: Sergio J. Moyano
Dia: 14/12/2010
Observaciones:
Modificaciones:
-->
<html>
<head>
<title>Listado de áreas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../Frame/estilos.css" rel="stylesheet" type="text/css">
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>

</head>

<body class="body">
<center>
<form name="areas" action="listadoArea_php.php" onSubmit="return area()" method="post">
<table width="800" class="borde_tabla">
	<tr>
		<td class="tituloformulario" align="center">Áreas</td>
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
				include("conexion.php");

				$var = new conexion();
				$var->conectarse();
				
				$consulta = "Select * From areas order by descripcion";
				$resu = mysql_query($consulta);
				
				if(mysql_num_rows($resu)<= 0)
					{
						echo '<tr><td colspan="3" align="center">No se encontraron áreas.</td></tr>';
					}else
						{
						 while($row = mysql_fetch_array($resu))
						 	{
							 echo "<tr>";
							 echo "<td>".$row['descripcion']."</td>";
							 echo '<td align="center"><img src="iconos/editar.png" onClick="editar('.$row['id_area'].')"></td>';
							 echo '<td align="center"><img src="iconos/borrar.png" onClick="borrar('.$row['id_area'].')"></td>';
							 echo "</tr>";
							}
						}
				?>
			</table>
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
	 document.areas.action = "edicionArea.php?id="+id;
	 document.areas.submit();
	}

function borrar(id)
	{
	  if (confirm('¿Estas seguro de eliminar esta área?'))
	  	{
       	 document.areas.action = "eliminarArea.php?id="+id;
		 document.areas.submit();
    	} 
	}
</script>