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
	
	$consulta = "Select * from proveedores where razon_social Like '%".$vari."%' order by razon_social Limit $limiteMenor, $limiteMayor  ";
	$resu = mysql_query($consulta);
	
	echo '<div id="id="div_find"">'; 
	echo '<table border="1"><thead><tr class="title"><td><b>Código</b></td><td><b>Razón Social</b></td></tr></thead>';
 
	if(mysql_num_rows($resu)<= 0)
		{
		 echo '<tr><td colspan="10"></td></tr>';
		}else
			{
			 while($row = mysql_fetch_array($resu))
			 	{
				echo "<tr>
				 			<td>
							<a href=\"#\" 
							  onclick=\"window.opener.document.polimeros.idProveedor.value = '".$row['id_proveedor']."';
							  window.opener.document.polimeros.proveedor.value = '".$row['razon_social']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['id_proveedor']."</a>
							</td>
					   		<td>
							<a href=\"#\"onclick=\"window.opener.document.polimeros.idProveedor.value = '".$row['id_proveedor']."';
							  window.opener.document.polimeros.proveedor.value = '".$row['razon_social']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['razon_social']."</a>
							</td>
					   </tr>";
				}
			}
		echo '</table></div><br/>';
		echo '<dir>';
		echo '<input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProveedorPolimerosAjax.php\', '.(($limiteMenor == 0)? 0 : ($limiteMenor - $pagina)).','.$pagina.', 0)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProveedorPolimerosAjax.php\', '.$i * $pagina .','.$pagina.', 0)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProveedorPolimerosAjax.php\', '.($limiteMenor + $pagina).','.$pagina.', 0)">&nbsp;';
	
		echo '</dir>';
	
	?>
