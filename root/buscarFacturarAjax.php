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
	
	$consulta = "Select * from clientes where razon_soci Like '%".$vari."%' order by razon_soci Limit $limiteMenor, $limiteMayor";
	$resu = mysql_query($consulta);
	 
	echo '<table border="1"><tr  bgcolor="#B8EF8B"><td></td><td><b>Codigo</b></td><td><b>Razon Social</b></td></tr>';
 
	if(mysql_num_rows($resu)<= 0)
		{
		 echo '<tr><td colspan="10"></td></tr>';
		}else
			{
			 while($row = mysql_fetch_array($resu))
			 	{
				 echo "<tr>
				 			<td width=\"10px\"></td>
				 			<td width=\"20px\">
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.codigoTangoFacturar.value = '".$row['cod_client']."';
							  window..opener.document.alta_pedido.facturarA.value = '".$row['razon_soci']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['cod_client']."</a>
							</td>
					   		<td width=\"400px\">
							<a href=\"#\" onclick=\"window.opener.document.alta_pedido.codigoTangoFacturar.value = '".$row['cod_client']."';
							  window.opener.document.alta_pedido.facturarA.value = '".$row['razon_soci']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['razon_soci']."</a>
							</td>
					   </tr>";
				}
			}
		echo '</table><br/>';
		
		echo '<dir>';
		echo '<input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarFacturarAjax.php\', '.(($limiteMenor == 0)? 0 : ($limiteMenor - $pagina)).','.$pagina.', 0)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarFacturarAjax.php\', '.$i * $pagina .','.$pagina.', 0)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarFacturarAjax.php\', '.($limiteMenor + $pagina).','.$pagina.', 0)">&nbsp;';
	
		echo '</dir>';
	
	?>
