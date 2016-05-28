	<?php
	$vari = $_POST['variable'];
	
	
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from depositos where nombre Like '%".$vari."%' limit 0,10";
	$resu = mysql_query($consulta);
	 
	echo '<table border="1"><tr><td>Código</td><td>Artículo</td><td>Código Producto</td></tr>';
 
	if(mysql_num_rows($resu)<= 0)
		{
		 echo '<tr><td colspan="10"></td></tr>';
		}else
			{
			 while($row = mysql_fetch_array($resu))
			 	{
				 echo "<tr>
				 			<td>
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.nombreDeposito.value = '".$row['nombre']."';
							  window.opener.document.ingresoStock.idDeposito.value = '".$row['id_deposito']."';
							  parent.parent.GB_hide();\">".$row['codigo']."</a>
							</td>
					   		<td>
							 <a href=\"#\"onclick=\"window.opener.document.ingresoStock.nombreDeposito.value = '".$row['nombre']."';
							  window.opener.document.ingresoStock.idDeposito.value = '".$row['id_deposito']."';
							  parent.parent.GB_hide();\">".$row['nombre']."</a>
							</td>
							<td>
							  <a href=\"#\"onclick=\"window.opener.document.ingresoStock.nombreDeposito.value = '".$row['nombre']."';
							  window.opener.document.ingresoStock.idDeposito.value = '".$row['id_deposito']."';
							  parent.parent.GB_hide()\";>".$row['localidad']."</a>
							</td>
					   </tr>";
				}
			}
		echo '</table>';
	
	?>