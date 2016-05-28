<!--
Documento: alta de deposito, altaDeposito.php
Creado por: Sergio J. Moyano
Dia: 13/12/2010
Observaciones:
Modificaciones:
-->
<html>
<head>
<title>Alta de Dépositos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../Frame/estilos.css" rel="stylesheet" type="text/css">
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>

</head>

<body class="body">
<center>
<form name="depositos" action="altaDeposito_php.php" onSubmit="return deposito()" method="post">
<table class="borde_tabla" width="400">
	<tr>
		<td class="tituloformulario" align="center" colspan="2">Alta de Déposito</td>
	</tr>
	<tr>
		<td>Razón Social: </td>
		<td><input type="text" class="select" name="Razon" onKeyUp="alfanumerico(Nombre)"></td>
	</tr>
	<tr>
		<td>Dirección: </td>
		<td><input type="text" class="select" name="Dire" onKeyUp="alfanumerico(Dire)"></td>
	</tr>
	<tr>
		<td>Teléfono: </td>
		<td><input type="text" class="select" name="Telef" onKeyUp="numerico(Telef)"></td>
	</tr>
	<tr>
		<td>E-Mail: </td>
		<td><input type="text" class="select" name="Mail"></td>
	</tr>
	<tr>
		<td>Web: </td>
		<td><input type="text" class="select" name="Web" onKeyUp="alfanumerico(Web)"></td>
	</tr>
	<tr>
		<td>Observaciones: </td>
		<td><textarea name="Observ" cols="32" rows="5"></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><hr class="color"></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="button" value="<<Principal" class="botonmarron" onClick="principal()">&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Guardar" class="botonmarron">
		<td>
	</tr>
</table>
</form>
</center>
</body>
</html>
<script>
function deposito()
	{
	 if(document.depositos.Razon.value.length < 3)
	 	{
			alert("Razón Social demasiado corto.");
			return false;
		}else
			{
				return true;
			}
		
	}
</script>