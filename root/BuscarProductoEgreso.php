<html>
<head>
<title>Busqueda de Productos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>
</head>


<body>
<form name="clientes">

<label>Buscar: &nbsp;&nbsp;</label>
<input type="text" id="buscador" name="buscador" size="60" onKeyUp="ajaxx(this.value,'div_find','BuscarProductoEgresoAjax.php')"/>
<!--comienzo div de grilla -->
<div id="div_find">
							
<table border="1">
	<tr>
		<td>Código</td><td>Artículo</td><td>Código Producto</td><td>Stock</td>
	</tr>
	<?php
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from articulos limit 0,10";
	$resu = mysql_query($consulta);
	 
	if(mysql_num_rows($resu)<= 0)
		{
		 echo '<tr><td colspan="10"></td></tr>';
		}else
			{
			 while($row = mysql_fetch_array($resu))
			 	{
                                 //calcular stock total para el producto seleccionado
                                 $consu = "Select stockLote From productosdepositos  Where id_articulo = '".$row['Id']."' ";
                                 $res = mysql_query($consu);
                                    
                                    while($r = mysql_fetch_array($res))
                                    {
                                        $stock = ($r['stockLote'] == "") ? 0: $r['stockLote'];
                                    }
                                    
				 echo "<tr>
				 			<td>
							<a href=\"#\"onclick=\"window.opener.document.alta_pedido.idProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.producto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.Stock.value = '".$stock."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['Id']."</a>
							</td>
					   		<td>
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.idProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.producto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.Stock.value = '".$stock."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['Articulo']."</a>
							</td>
							<td>
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.idProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.producto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.Stock.value = '".$stock."';
							  window.close();
							  parent.parent.GB_hide()\";>".$row['Nombre_en_Facturacion']."</a>
							</td>
							<td>
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.idProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.producto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.Stock.value = '".$stock."';
							  window.close();
							  parent.parent.GB_hide()\";>".$stock."</a>
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
<script>
	function ejecutaEsto()
		{
		 alert("salio");
		}
</script>