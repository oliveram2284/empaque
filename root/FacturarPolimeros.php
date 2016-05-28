<?php
$idPolimero = $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ASCII" />
<title>Empaque</title>

<link rel="shortcut icon" type="image/x-icon" href="logo.png">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
	<script   type="text/javascript" src="../Empaque1.0/Js/Botones.js"></script>
	
<script language="javascript" src="../Empaque1.0/abm_iniciador_js.js" type="text/javascript"></script>

<script   type="text/javascript" src="../Empaque1.0/Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="../Empaque1.0/Js/ajax.js"></script>
</head>

<body id="fondo"  >
	<div class="container  large"> <!-- Contenerdor margen de Pantalla standarizado -->

			<div class="span-24 " >
			<center>
				<div class="span-22  push-1"  id="titulo_main">
                    <center>
                        <label >
                        Ingrese Número de Factura
                        </label>
                    </center>
				</div>			
				<div class="span-24">
                        <div id="menu_top" class="span-24">
                        </div>
                        
                        <div class="span-22 push-1"> <!-- Cuerpo de Formulario -->
                        <form name="facturarPoli" method="post">
                        	<label>N° Factura: </label>&nbsp;&nbsp;
                            <input type="text" name="numero" id="numero" onkeyup="numerico(numero)" />&nbsp;&nbsp;&nbsp;
                            <input type="button" class="button" value="Aceptar" onclick="ValidarPop()"/>&nbsp;&nbsp;&nbsp;
                            <input type="button" class="button" value="Cancelar" onclick="CerrarPop()" />
                            <input type="hidden" name="id" value="<?php echo $idPolimero; ?>" />
                        </form>
                        </div>
                </div>
           </center>
           </div>
    </div>
</body>
</html>
<script>
//_________________________________________________________// 
function ValidarPop()
	{
		if(document.getElementById('numero').value == "" || document.getElementById('numero').value == 0)
			{
				alert("Ingrese un número de factura valido.");
				document.getElementById('numero').focus();
				return false;	
			}
		document.facturarPoli.action = "FacturarPolimerosphp.php";
		document.facturarPoli.submit();
	}
//_________________________________________________________// 
function CerrarPop()
	{
		window.close();
	}

//_________________________________________________________// 
//Solo numeros en el campo
function numerico(campo) 
	{
	var charpos = campo.value.search("[^0-9]"); 
    if (campo.value.length > 0 &&  charpos >= 0)  
		{ 
		campo.value = campo.value.slice(0, -1);
		campo.focus();
	    return false; 
		} 
			else 
				{
				return true;
				}
	}
</script>