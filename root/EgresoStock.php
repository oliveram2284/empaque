<?php
session_start();

$nombre = $_SESSION['NombreReal'];
$idUsuario = $_SESSION['id_usuario'];

include("conexion.php");

$var = new conexion();
$var->conectarse();

?>
<br>
<center>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Egreso de Stock</title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>
</head>
<script   type="text/javascript" src="Js/Botones.js"></script>
<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>
<script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

<body id="fondo">
<div class="container  large"> <!-- Contenerdor margen de Pantalla standarizado -->
<div class="span-24 " >
                <center>
                </center>
			</div>
<div class="span-23 right">
<fieldset><legend>Orden de Retiro</legend>
	<form name="ingresoStock" method="post">
    	<table>
            <tr>
            	<td>Solicitante: </td>
                <td>
                	<select name="soli">
                    	<option value="0" selected="selected">Seleccione solicitante.</option>
                	<?php 
					$consulta = "select idSolicitante, descripcion from solicitante";
					$resu = mysql_query($consulta) or die(mysql_error());
					
					while($row = mysql_fetch_array($resu))
						{
							$id = $row['idSolicitante'];
							$no = $row['descripcion'];
							
							 echo"<option value=' ".$row['idSolicitante']."'>".$row['descripcion']."</option> ";
						}
					?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Depósito: </td>
            	<td>
                	<select name="deposito" onChange="Busque(this.value,'resultado','busquedaEgreso.php');">
                    	<option value="0" selected="selected">Seleccione depósito.</option>
                	<?php 
					$consulta = "select id_deposito, nombre from depositos";
					$resu = mysql_query($consulta) or die(mysql_error());
					
					while($row = mysql_fetch_array($resu))
						{
							$id = $row['id_deposito'];
							$no = $row['nombre'];
							
							 echo"<option value=' ".$row[0]."'>".$row[1]."</option> ";
						}
					?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>Fecha: </td>
                <td><input type="text" name="fechaIng" value="<?php echo date("d-m-Y");?>" readonly>&nbsp;&nbsp;
                <img src="assest/plugins/buttons/icons/calendar.png" class="top" onClick="displayCalendar(fechaIng,'dd-mm-yyyy',this);return false;"><!---->
                </td>
            </tr>
            <tr>
            	<td colspan="2">
                	<fieldset>
                    	<legend>Artículo</legend>
                        <table>
                        	<tr>
                            	<td>Descripción:</td>
                                <td>
                                	<input type="text" name="nombre" readonly>&nbsp;&nbsp;&nbsp;
                                    <input type="button" class="button" value="Buscar" name="busca" 
                                    	   onClick="BuscarArticulo();">
                                    <input type="hidden" name="idProducto">
                                </td>
                            </tr>
                            <tr>
                            	<td>Stock Actual:</td><td><input type="text" name="Stock" readonly></td>
                            </tr>
                            <tr>
                            	<td>Cantidad Solicitada:</td>
                                <td>
                                	<input type="text" name="cantidad" onKeyUp="numerico(cantidad)">
                                    &nbsp;&nbsp;&nbsp;&nbsp;Bultos:
                                    <input type="text" name="bultos" onKeyUp="numerico(bultos)">
                                    &nbsp;&nbsp;&nbsp;&nbsp;Kg: 
                                    <input type="text" name="kg" onKeyUp="numerico(kg)">
                                </td>
                            </tr>
                            	<input type="hidden" name="agrega1" value="invalido">
                            <tr>
                            	<td colspan="2" align="center">
                                	<input type="button" class="button" value="Aceptar" onClick="Guardar();AgregaraEgreso(agrega1.value, idProducto.value, deposito.value, cantidad.value, bultos.value, kg.value, 'resultado', 'agregarAtablaEgreso.php');">
                                    <input type="button" class="button" value="Cancelar" onClick="Principal()">
                                </td>
                            </tr>
                        </table>
                    </fieldset>
               </td>
            </tr>
        </table>
        <div id="resultado">
        	Pendientes.....
        </div>
    </form>
</fieldset>
</div>
</div>
</body>
</center> 
</html>
</center>
<script>
function Confirmar(idDeposito)
	{
		if(document.ingresoStock.soli.value <= 0)
			{
				alert("Debe seleccionar quien es el solicitante.");
			}
			else
			{
				var fecha = document.ingresoStock.fechaIng.value;
				var solicitante = document.ingresoStock.soli.value;
				
				location.href="RegistrarEgresoDepositos.php?idDepo="+idDeposito+"&fecha="+fecha+"&soli="+solicitante;	
			}
	}
function Guardar()
	{
		if(document.ingresoStock.idProducto.value == null || document.ingresoStock.idProducto.value == "")
			{
				alert("Debe seleccionar un artículo para guardar.");
				document.ingresoStock.busca.focus;
			 	document.ingresoStock.agrega1.value = "invalido";
			 	return false;
			}
		if(document.ingresoStock.cantidad.value <= 0)
			{
			 alert("La cantidad a retirar debe ser mayor que 0.");
			 document.ingresoStock.agrega1.value = "invalido";
			 return false;
			}
	if(document.ingresoStock.bultos.value < 0)
	 	{
		 alert("La cantidad de bultos a ingresar debe ser mayor que 0.");
		 document.ingresoStock.agrega1.value = "invalido";
		 return false;
		}else
			{
				if(document.ingresoStock.bultos.value == "")
					document.ingresoStock.bultos.value = 0;
			}
	if(document.ingresoStock.kg.value < 0)
	 	{
		 alert("La cantidad de kilos a ingresar debe ser mayor que 0.");
		 document.ingresoStock.agrega1.value = "invalido";
		 return false;
		}else
			{
				if(document.ingresoStock.kg.value == "")
					document.ingresoStock.kg.value = 0;
			}
		document.ingresoStock.agrega1.value = "valido";
	}
	
function BuscarArticulo()
	{
		var deposito = document.ingresoStock.deposito.value;
		if(deposito != 0)
			{
			window.open("buscarProdEgreso.php?dep="+deposito, "PopUp", 'width=500,height=400,scrollbars=YES'); return false;	
			}else
				{
				 alert("Primero debe seleccionar un deposito.");
				 return false;	
				}
	}

function Principal()
	{
	 document.ingresoStock.action="principal.php";
	 document.ingresoStock.submit();
	}
	
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

function Limpiar()
	{
	 document.ingresoStock.idProducto.value = "";
	 document.ingresoStock.nombre.value = "";
	 document.ingresoStock.cantidad.value = "";
	 document.ingresoStock.Stock.value = "";
	 document.ingresoStock.bultos.value = "";
	 document.ingresoStock.kg.value = "";
	}

</script>