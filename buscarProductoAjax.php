	<?php
	
	$pagina = 10;

	$arre = explode('~',$_POST['variable']);
	$vari = $arre[0];
	
	$limiteMenor = $arre[1];
	$limiteMayor = $arre[2];
	$opcion = $arre[3];
	
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	switch($opcion)
		{
			//buscar con signo +
			case "0":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND Articulo Like '+%' order by Articulo Limit $limiteMenor, $limiteMayor";
				break;
			//buscar con signo - 
			case "1":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND Articulo Like '-%' order by Articulo Limit $limiteMenor, $limiteMayor";
				break;
			//buscar con signo + y signo -
			case "2":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND ( Articulo Like '+%' OR Articulo Like '-%') order by ArticuloLimit $limiteMenor, $limiteMayor";
				break;
			//buscar sin signos
			case "3":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND Articulo NOT Like '+%' AND Articulo NOT Like '-%' order by Articulo Limit $limiteMenor, $limiteMayor";
				break;
		}
	//$consulta = "Select * from articulos where Articulo Like '%".$vari."%' Limit $limiteMenor, $limiteMayor";
	$resu = mysql_query($consulta);
	 
	echo '<table border="1">
    <thead>
    <tr>
		<td></td><td><b>Codigo</b></td><td><b>Articulo</b></td><td><b>Codigo Producto</b></td>
	</tr>
    </thead>';
 
	if(mysql_num_rows($resu)<= 0)
		{
		 echo '<tr><td colspan="10"></td></tr>';
		}else
			{
			 while($row = mysql_fetch_array($resu))
			 	{
				 echo "<tr>
				 			<td width=\"10px\">
				 			<td width=\"40px\">
							<a href=\"#\"onclick=\"window.opener.document.alta_pedido.codigoProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.nombreProducto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.descripcionProducto.value = '".$row['Nombre_en_Facturacion']."';
							  window.close();
							  parent.parent.GB_hide();\">".utf8_encode($row['Id'])."</a>
							</td>
					   		<td >
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.codigoProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.nombreProducto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.descripcionProducto.value = '".$row['Nombre_en_Facturacion']."';
							  window.close();
							  parent.parent.GB_hide();\">".utf8_encode($row['Articulo'])."</a>
							</td>
							<td>
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.codigoProducto.value = '".$row['Id']."';
							  window.opener.document.alta_pedido.nombreProducto.value = '".$row['Articulo']."';
							  window.opener.document.alta_pedido.descripcionProducto.value = '".$row['Nombre_en_Facturacion']."';
							  window.close();
							  parent.parent.GB_hide()\";>".utf8_encode($row['Nombre_en_Facturacion'])."</a>
							</td>
					   </tr>";
				}
			}
		echo '</table><br /><dir>';
		echo '<input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoAjax.php\', '.(($limiteMenor == 0)? 0 : ($limiteMenor - $pagina)).','.$pagina.', oculto.value)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoAjax.php\', '.$i * $pagina .','.$pagina.', oculto.value)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoAjax.php\', '.($limiteMenor + $pagina).','.$pagina.', oculto.value)">&nbsp;';
	
		echo '</dir>';
	?>
	<script>
	</script>