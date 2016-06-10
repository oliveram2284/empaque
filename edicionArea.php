<!--
Documento: edición de areas, edicionArea.php
Creado por: Sergio J. Moyano
Dia: 14/12/2010
Observaciones:
Modificaciones:
-->
<html>
<head>
<title>Edición de Áreas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../Frame/estilos.css" rel="stylesheet" type="text/css">
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>

</head>
<?php
$id = $_GET['id'];

include("conexion.php");
$var = new conexion();
$var->conectarse();

$consulta = "Select * from areas Where id_area = '".$id."'";
$resu = mysql_query($consulta);
$row = mysql_fetch_array($resu);

?>
<body class="body">
<center>
<form name="areas" action="edicionArea_php.php" onSubmit="return area()" method="post">
<table class="borde_tabla" width="400">
	<tr>
		<td class="tituloformulario" align="center" colspan="2">Edición de Área</td>
	</tr>
	<tr>
		<td>Nombre: </td>
		<td><input type="text" class="select" name="Nombre" onKeyUp="alfanumerico(Nombre)" value="<?php echo $row['id_area']!= "" ? $row['descripcion']:"";?>"></td>
		<input type="hidden" name="id_area" value="<?php echo $row['id_area']!= "" ? $row['id_area']:"";?>">
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
function area()
	{
	 if(document.areas.Nombre.value.length < 3)
	 	{
			alert("Nombre de área demasiado corto.");
			return false;
		}else
			{
				return true;
			}
		
	}
</script>