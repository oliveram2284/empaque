<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Empaque</title>
<link rel="shortcut icon" type="image/x-icon" href="logo.png">
<link rel="shortcut icon" type="image/x-icon" href="logo.png">

<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<script  src="ajax.js" type="application/javascript" language="javascript" ></script>
</head>

<body id="fondo" >
<div class="container  large"> <!-- Contenerdor margen de Pantalla standarizado -->
<form name="formulario" action="operacion.php" method="post">
<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$tabla = $_GET['tabla'];
$accion = $_GET['accion'];
$Id = $_GET['Id'];

echo '<input type="hidden" name="tablaNom" value="'.$tabla.'">';
echo '<input type="hidden" name="Pk" value="'.$Id.'">';
echo '<input type="hidden" name="accion" value="'.$accion.'">';

//preguntar si se debe buscar o no un registro
if($Id != 0)
	{
	 //buscar un registro 
	   //obtenemos el nombre del campo clave primaria de la tabla seleccionada
	   $cons = "SELECT COLUMN_NAME
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE table_name = '$tabla'
				AND table_schema = 'mi000652_empaque1'
				AND COLUMN_KEY = 'PRI'";
				
		$re = mysql_query($cons);
		$aux = mysql_fetch_array($re);
		$Pk = $aux[0];
		
	 $consulta = "Select * From ".$tabla." where ".$Pk." = ".$Id;
	 $registro = mysql_query($consulta);
	 $fila = mysql_fetch_array($registro);
	}

$consulta1 = "Select * from tbl_tablas where descripcion ='".$tabla."'";
$resu = mysql_query($consulta1);

if(mysql_num_rows($resu) != 1)
{
	echo'<script>alert("Error en lectura de tabla.");location.href="principal.php";</script>';
}else
	{
	 //comenzamos a armar la tabla 
	 $row = mysql_fetch_array($resu);
	 
	 //encabezado tabla
	 echo '<table border="1"><tr><td colspan="2" class="top"><h3>'.htmlentities($row['Titulo']).'</h3><hr></td></tr>';
	 
	 echo '<tr>';
	 $consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden";
	 $resu2 = mysql_query($consulta2);
	 
	 while($row2 = mysql_fetch_array($resu2))
			{
			 if($row2['seCarga']== 1)
			 	{
				 switch($row2['tipo'])
				 	{
					 case "entero":
					 	$funcJs = "numerico(this.value)";
						break;
					 case "cadena":
					 	$funcJs = "letras(this.value)";
						break;
					 case "alfanumerico":
					 	$funcJs = "alfanumerico(this.value)";
						break;	
					}
				 //switch para determinar que componente es el que se va a armar 
				 switch($row2['tipoHTML'])
				 	{
					 case 'text':
					        $valor = ($Id != 0) ? $fila[$row2['nombreCampo']]:"";
					 		echo '<tr><td>'.htmlentities($row2['nombreMuestra']).'</td>';
							echo '<td><input type="text" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="'.$valor.'" onKeyUp="'.$funcJs.'" class="top"></td></tr>';		
					 		break;
					 case 'button':
					 		echo '<tr><td><input type="button" class="button" name="'.$row2['nombreCampo'].'" value="'.htmlentities($row2['nombreMuestra']).'" class="top"></td></tr>';				
					 		break;
					 case 'textarea':
					 		$valor = ($Id != 0) ? $fila[$row2['nombreCampo']]:"";
					 		echo '<tr><td>'.htmlentities($row2['nombreMuestra']).'</td><td><textarea name="'.$row2['nombreCampo'].'" rows="20" cols="20">'.$valor.'</textarea></td></tr>';		
					 		break;
					case 'password':
							$valor = ($Id != 0) ? $fila[$row2['nombreCampo']]:"";
					 		echo '<tr><td>'.htmlentities($row2['nombreMuestra']).'</td>';
							echo '<td><input type="password" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="'.$valor.'" onKeyUp="'.$funcJs.'" class="top"></td></tr>';	
							break;
				    case 'select':
							$valor = ($Id != 0) ? $fila[$row2['nombreCampo']]:"";
					 		echo '<tr><td>'.htmlentities($row2['nombreMuestra']).'</td>';
							echo '<td><select name="'.$row2['nombreCampo'].'">';
							echo '<option value="0">Selecc. '.htmlentities($row2['nombreMuestra']).'</option>';
							$rec = mysql_query($row2['sql'])or die (mysql_error());
							
							if(mysql_num_rows($rec)> 0)
							{
								while($row4 = mysql_fetch_array($rec))	
									{
										if($valor == $row4[0])
											{
												echo '<option value="'.$row4[0].'" selected="selected">'.$row4[1].'</option>';
											}else
												{
													echo '<option value="'.$row4[0].'">'.$row4[1].'</option>';
												}
									}
							}
							echo '</select>';
							echo '</td></tr>';
							break;
					}
				}
			}
			
	//fin de la tabla 
	echo '</tr></table>';
	
	//botones
	// echo "<input type=\"button\" name=\"nuevo\" value=\"Nuevo\" onClick=\"AbrirVentana('$nombreTabla','I','0')\">";
	echo " <p> <input type=\"button\" value=\"Aceptar\" class=\"button\" onClick=\"Aceptar('$accion')\"> &nbsp;&nbsp;&nbsp;";
	echo '<input type="button" value="Cancelar" class="button" onClick="Cerrar()"> </p>';
	 }
?>
</form>
</div>
</body>
</html>

<script>
function Cerrar()
	{
	 window.close();
	}
	
function Aceptar(accion)
	{ 
	 switch(accion)
	 	{
		 case "I":
		 	document.formulario.submit();
			break;
		 case "D":
		    document.formulario.submit();
			break;
		 case "U":
		    document.formulario.submit();
			break;
		 default:
		 	alert("Operación no definida.");
			break;
		}
	}
	
</script>