	<meta http-equiv="Content-Type" content="text/html; charset=Latin1 ">
    <?php
	$vari = $_POST['variable'];
	
	
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from articulosdeposito where codProducto Like '%".$vari."%' or descProducto Like '%".$vari."%'";
	$resu = mysql_query($consulta);
	 
	echo '<table border="1"><tr><td>'.utf8_encode( "Código" ).'</td><td>'.utf8_encode( "Artículo" ).'</td></tr>';
 
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
		echo '</table>';
	
	?>
 </meta>