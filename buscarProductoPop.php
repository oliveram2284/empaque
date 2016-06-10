<html>
<head>
<title>Busqueda de Productos</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<!--
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print">
-->
<link href="assest/style_style/css/bootstrap.css" rel="stylesheet">
<link href="assest/style_style/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assest/style_style/css/datepicker.css" rel="stylesheet">

<script src="assest/style_style/js/jquery.js"></script>
<script src="assest/style_style/js/bootstrap.js"></script>
<script src="assest/style_style/js/bootstrap.min.js"></script>

<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>
</head>


<body onload="FocoEn()">
<form name="clientes">
<div class="well">
	
	<div class="form-inline">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label>Buscar: &nbsp;&nbsp;</label>
		<input type="text" id="buscador" name="buscador" size="60" onKeyUp="alfanumerico(buscador);ajaxx(this.value,'div_find','buscarProductoPopAjax.php', LimiteMenor.value, LimiteMayor.value, oculto.value)"/>
		
			<label>&nbsp;&nbsp;&nbsp;+</label>			<input type="radio" name="opcion1" value="0" onClick="cambiaValor(0)"> &nbsp;
			<label>&nbsp&nbsp;&nbsp;-</label>			<input type="radio" name="opcion1" value="1" onClick="cambiaValor(1)"> &nbsp;
			<label>&nbsp;&nbsp;&nbsp;+ y -</label>		<input type="radio" name="opcion1" value="2" onClick="cambiaValor(2)"> &nbsp;
			<label>&nbsp;&nbsp;&nbsp;Ninguno</label>	<input type="radio" name="opcion1" value="3" onClick="cambiaValor(3)" checked><br />
			
			<input type="hidden" name="oculto" value="3">
	</div>
<input type="hidden" id="idArt" name="idArt">
<input type="hidden" id="nameArt" name="nameArt">
	
<!--comienzo div de grilla -->
<div id="div_find">

<input type="hidden" name="LimiteMenor" value="0">
<input type="hidden" name="LimiteMayor" value="5">
						
<table class="table table-hover">
	<thead>
		<tr style="text-align: center">
			<th>Código</td><th>Artículo</th><th>Código Producto</th>
		</tr>
	</thead>
	<?php
	include("conexion.php");
	
	$var = new conexion();
	$var->conectarse();
	
	$consulta = "Select * from articulos where id not like 'n0%' order by Articulo limit 0,5";
	$resu = mysql_query($consulta);
	 
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
						<td>
						<a href=\"#\" onclick=\"retorno('".utf8_encode($row['Id'])."', '".utf8_encode($row['Articulo'])."')\">".utf8_encode($row['Articulo'])."</a>
						</td>
						<td>
						<a href=\"#\" onclick=\"retorno('".utf8_encode($row['Id'])."', '".utf8_encode($row['Articulo'])."')\";>".utf8_encode($row['Nombre_en_Facturacion'])."</a>
						</td>
					   </tr>";
				}
			}
	
	?>
</table><br />
<?php
$pagina = 5;
		echo '<dir><input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoPopAjax.php\', 0,10, oculto.value)">&nbsp;';
		
		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoPopAjax.php\', '.$i * $pagina .','.$pagina.', oculto.value)">&nbsp;';
			}
		
		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarProductoPopAjax.php\', '.$pagina.','.$pagina.', oculto.value)">&nbsp;';
	
		echo '</dir>';
		
?>
</div>
<!--fin div de grilla -->

</div>						 
</form>
</body>
</html>
<script>
function cambiaValor(valor)
	{
		document.clientes.oculto.value = valor;
	}

	function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}
    
function ajaxx(valor1,id_div,controller, lmtMenor, lmtMayor, opcion)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+lmtMenor+"~"+lmtMayor+"~"+opcion);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function retorno(id, description)
{
	document.getElementById('idArt').value = id;
	document.getElementById('nameArt').value = description;
	window.opener.document.getElementById('codigoProducto').value = document.getElementById('idArt').value;
	window.opener.document.getElementById('descriptionProd').value = document.getElementById('nameArt').value;
	window.close();
}

function FocoEn ()
{
	document.getElementById('buscador').focus();
}
</script>