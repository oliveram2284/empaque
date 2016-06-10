<!--
Documento: alta de empresas, altaEmpresa.php
Creado por: Sergio J. Moyano
Dia: 13/12/2010
Observaciones:
Modificaciones:
-->
<html>
<head>
<title>Alta de Empresas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../Frame/estilos.css" rel="stylesheet" type="text/css">
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>

</head>

<body class="body">
<center>
<form name="empresas" action="altaEmpresa_php.php" onSubmit="return empresa()" method="post">
<table class="borde_tabla" width="400">
	<tr>
		<td class="tituloformulario" align="center" colspan="2">Alta de Empresa</td>
	</tr>
	<tr>
		<td>Nombre: </td>
		<td><input type="text" class="select" name="Nombre" onKeyUp="alfanumerico(Nombre)"></td>
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
function empresa()
	{
	 if(document.empresas.Nombre.value.length < 3)
	 	{
			alert("Nombre de empresa demasiado corto.");
			return false;
		}else
			{
				return true;
			}
		
	}
</script>