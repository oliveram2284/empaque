<html>
<head>
<title>Busqueda de Productos</title>
<meta http-equiv="Content-Type" content="text/html; charset=Latin1">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
</head>
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>

<body>
<form name="clientes">
<br>
<label>Buscar: &nbsp;&nbsp;</label>
<input type="text" id="buscador" name="buscador" size="60" onKeyUp="ajaxx(this.value,'div_find','buscarProductoAjaxStock.php')"/>
<!--comienzo div de grilla -->
<div id="div_find">
							
<table border="1">
	<tr>
		<td>Código</td><td>Artículo</td>
	</tr>
	<?php
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from articulosdeposito limit 0,10";
	$resu = mysql_query($consulta);
	
		if(mysql_num_rows($resu)<= 0)
		{
		 echo '<tr><td colspan="10"></td></tr>';
		}else
			{
			 while($row = mysql_fetch_array($resu))
			 	{
				 echo "<tr>
				 			<td>
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.codigoArticulo.value = '".$row['descProducto']."';
							  window.opener.document.ingresoStock.idArticulo.value = '".$row['idProducto']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['codProducto']."</a>
							</td>
					   		<td>
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.codigoArticulo.value = '".$row['descProducto']."';
							  window.opener.document.ingresoStock.idArticulo.value = '".$row['idProducto']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['descProducto']."</a>
							</td>
					   </tr>";
				}
			}
	
	?>
</table>
</div>
<!--fin div de grilla -->
						 
</form>
</body>
</html>
