	<?php
	
	$pagina = 5;

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
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND Articulo Like '+%' And id not like 'n0%' order by Articulo Limit $limiteMenor, $limiteMayor";
				break;
			//buscar con signo - 
			case "1":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND Articulo Like '-%' And id not like 'n0%' order by Articulo Limit $limiteMenor, $limiteMayor";
				break;
			//buscar con signo + y signo -
			case "2":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND ( Articulo Like '+%' OR Articulo Like '-%') And id not like 'n0%' order by ArticuloLimit $limiteMenor, $limiteMayor";
				break;
			//buscar sin signos
			case "3":
				$consulta = "Select * from articulos where Articulo Like '%".$vari."%' AND Articulo NOT Like '+%' AND Articulo NOT Like '-%' And id not like 'n0%' order by Articulo Limit $limiteMenor, $limiteMayor";
				break;
		}
	//$consulta = "Select * from articulos where Articulo Like '%".$vari."%' Limit $limiteMenor, $limiteMayor";
	$resu = mysql_query($consulta);
	 
	echo '<table border="1">
    <table class="table table-hover">
	<thead>
		<tr style="text-align: center">
			<th>'.utf8_encode('Código').'</td><th>'.utf8_encode('Artículo').'</th><th>'.utf8_encode('Código Producto').'</th>
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
				 			<td width=\"40px\">
							<a href=\"#\"onclick=\"retorno('".utf8_encode($row['Id'])."', '".utf8_encode($row['Articulo'])."')\">".utf8_encode($row['Id'])."</a>
							</td>
					   		<td >
							<a href=\"#\" onclick=\"retorno('".utf8_encode($row['Id'])."', '".utf8_encode($row['Articulo'])."')\">".utf8_encode($row['Articulo'])."</a>
							</td>
							<td>
							<a href=\"#\" onclick=\"retorno('".utf8_encode($row['Id'])."', '".utf8_encode($row['Articulo'])."')\";>".utf8_encode($row['Nombre_en_Facturacion'])."</a>
							</td>
					   </tr>";
				}
			}
		echo '</table><br /><dir>';
		echo '<input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoPopAjax.php\', '.(($limiteMenor == 0)? 0 : ($limiteMenor - $pagina)).','.$pagina.', oculto.value)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoPopAjax.php\', '.$i * $pagina .','.$pagina.', oculto.value)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoPopAjax.php\', '.($limiteMenor + $pagina).','.$pagina.', oculto.value)">&nbsp;';
	
		echo '</dir>';
	?>
	<script>
	</script>