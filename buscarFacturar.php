<?php include("conexion.php"); ?> 
<head>
<title>Empaque</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>
</head>

<body id="fondo">
<div class="container">

<form name="clientes">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label>Buscar: &nbsp;&nbsp;</label>
<input type="text" id="buscador" name="buscador" size="60" onKeyUp="ajaxx(this.value,'div_find','buscarFacturarAjax.php',LimiteMenor.value, LimiteMayor.value, 0)"/>
<!--comienzo div de grilla -->
<div id="div_find">
			

<input type="hidden" name="LimiteMenor" value="0">
<input type="hidden" name="LimiteMayor" value="10">
							            				
<table border="1">
<thead>
    <tr>
      <td></td><td><strong> Codigo </strong></td><td><strong> Razon Social </strong> </td>
    </tr> 

</thead>
	<tbody>
	<?php
  
  
  $var = new conexion();
  $var->conectarse();
  
  $consulta = "Select * from clientes order by razon_soci limit 0,10";
  $resu = mysql_query($consulta);
   
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
  
  ?>

	
	</tbody>
	</table><br />
    
<!-- inicio de botones para la paginacion -->
<?php
$pagina = 10;
		echo '<dir><input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarFacturarAjax.php\', 0,10, 0)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarFacturarAjax.php\', '.$i * $pagina .','.$pagina.', 0)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarFacturarAjax.php\', '.$pagina.','.$pagina.', 0)">&nbsp;';
	
		echo '</dir>';
		
?>
<!-- fin de botones para la paginacion -->    
    
</div>
<!--fin div de grilla -->
						 
</form>
</div>
</body>
</html>
