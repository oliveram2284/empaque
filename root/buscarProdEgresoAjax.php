	<?php
	$arre = explode('~',$_POST['variable']);
	
	$valor = $arre[0];
	
	$deposito = $arre[1];
	
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	//$consulta = "Select * from articulosdeposito where codProducto Like '%".$vari."%' or descProducto Like '%".$vari."%' limit 0,10";
	$consulta = "SELECT idProducto, codProducto, descProducto, stockLote FROM articulosdeposito
                 INNER JOIN productosdepositos ON articulosdeposito.idProducto = productosdepositos.id_articulo
				 WHERE productosdepositos.id_deposito=$deposito and 
				 (codProducto Like '%".$valor."%' or descProducto Like '%".$valor."%')
				 GROUP BY idProducto
				 ";
				 
	$resu = mysql_query($consulta);
	 
	echo '<table border="1"><tr><td>Código</td><td>Artículo</td></tr>';
 
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
		echo '</table>';
	
	?>