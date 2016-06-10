<?php
$deposito = $_GET['dep'];
?>
<html>
<head>
<title>Busqueda de Productos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<input type="hidden" name="deposito" value="<?php echo $deposito ;?>">
<input type="text" id="buscador" name="buscador" size="60" onKeyUp="ajaxxx(this.value,deposito.value,'div_find','buscarProdEgresoAjax.php')"/>
<!--comienzo div de grilla -->
<div id="div_find">
							
<table border="1">
	<tr>
		<td>Código</td><td>Artículo</td><td>Stock</td>
	</tr>
	<?php
	
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "SELECT idProducto, codProducto, descProducto, stockLote FROM articulosdeposito
                 INNER JOIN productosdepositos ON articulosdeposito.idProducto = productosdepositos.id_articulo
				 WHERE productosdepositos.id_deposito=$deposito
				 GROUP BY idProducto
				 LIMIT 0,10";
				 
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
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.idProducto.value = '".$row['idProducto']."';
							  window.opener.document.ingresoStock.nombre.value = '".$row['descProducto']."';
							  window.opener.document.ingresoStock.Stock.value = '".$row[3]."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['codProducto']."</a>
							</td>
					   		<td>
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.idProducto.value = '".$row['idProducto']."';
							  window.opener.document.ingresoStock.nombre.value = '".$row['descProducto']."';
							  window.opener.document.ingresoStock.Stock.value = '".$row[3]."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['descProducto']."</a>
							</td>
							<td>
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.idProducto.value = '".$row['idProducto']."';
							  window.opener.document.ingresoStock.nombre.value = '".$row['descProducto']."';
							  window.opener.document.ingresoStock.Stock.value = '".$row[3]."';
							  window.close();
							  parent.parent.GB_hide();\">".$row[3]."</a>
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
