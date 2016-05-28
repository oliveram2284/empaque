	<?php
	$vari = $_POST['variable'];
	
	
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from articulos where Articulo Like '%".$vari."%'";
	$resu = mysql_query($consulta);
	 
	echo '<table border="1"><tr><td>Código</td><td>Artículo</td><td>Código Producto</td></td>Stock</td></tr>';
 
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
		echo '</table>';
	
	?>
	<script>
	function ahoraEsto()
		{
		 alert("entro");
		}
	function ejecutaEsto()
		{
		 alert("salio");
		}
	</script>