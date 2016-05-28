<?php
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from clientes limit 0,10";
	$resu = mysql_query($consulta);
?>
<html>
<head>
<title>Busquedad de Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link rel="stylesheet" href="estilos.css" type="text/css" media="print" >

<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>



<body id="fondo">
<div class="container">
<form name="clientes">
<br><br>
<label>Buscar: &nbsp;&nbsp;</label>
<input type="text" id="buscador" name="buscador" size="60" onKeyUp="ajaxx(this.value,'div_find','buscarClientePolimerosAjax.php',LimiteMenor.value, LimiteMayor.value, 0)"/>
<!--comienzo div de grilla -->
<div id="div_find">


<input type="hidden" name="LimiteMenor" value="0">
<input type="hidden" name="LimiteMayor" value="10">
							
<table border="1">
  <thead>
	<tr>
		<td><strong>Código</strong></td><td><strong>Razón Social</strong></td>
	</tr>
	</thead>
	<tbody>
	<?php

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
							  onclick=\"window.opener.document.polimeros.idCliente.value = '".$row['cod_client']."';
							  window.opener.document.polimeros.cliente.value = '".$row['nom_com']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['cod_client']."</a>
							</td>
					   		<td>
							<a href=\"#\"onclick=\"window.opener.document.polimeros.idCliente.value = '".$row['cod_client']."';
							  window.opener.document.polimeros.cliente.value = '".$row['nom_com']."';
							  window.close();
							  parent.parent.GB_hide();\">".$row['nom_com']."</a>
							</td>
					   </tr>";
				}
			}
	
	?>
	</tbody>
</table>
<br />
<!-- inicio de botones para la paginacion -->
<?php
$pagina = 10;
		echo '<dir><input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarClientePolimerosAjax.php\', 0,10, 0)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarClientePolimerosAjax.php\', '.$i * $pagina .','.$pagina.', 0)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarClientePolimerosAjax.php\', '.$pagina.','.$pagina.', 0)">&nbsp;';
	
		echo '</dir>';
		
?>
<!-- fin de botones para la paginacion -->
</div>
<!--fin div de grilla -->
						 
</form>
</div>
</body>
</html>
