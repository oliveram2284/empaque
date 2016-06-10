<?php
session_start();

$idUsuario = $_SESSION['id_usuario'];

include("conexion.php");
$var = new conexion();
$var->conectarse();
?>
<br>
<center>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Latin1" />
<title>Empaque</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>
<script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<script type="text/javascript" src="Js/ajax.js"></script>
</head>

<body id="fondo"  >
<div class="container  large"> <!-- Contenerdor margen de Pantalla standarizado -->

			<div class="span-24 " >
			<center>
</center>
</div>
<div class="span-23 right">
<form name="ingresoStock" method="post" >
<fieldset ><legend>Orden de Ingreso</legend>
	<table>
    	<tr>
			<td width="32%">Depósito: </td>
            <td width="68%">
                	<select name="nombreDeposito" id="nombreDeposito" onChange="Busque(this.value,'resultado','busquedaIngreso.php');">
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
			<td>Fecha de Ingreso:</td>
			<td><input type="text" readonly="true" name="fechaIng" value="<?php echo date("d-m-Y");?>">&nbsp;&nbsp;
            <img src="assest/plugins/buttons/icons/calendar.png" class="top" onClick="displayCalendar(fechaIng,'dd-mm-yyyy',this);return false;"><!---->
            </td>
		</tr>
        <tr>
        	<td colspan="2">
            <fieldset>
            <legend>Artículo</legend>
            	<table>
                	<tr>
                        <td>Articulo: </td>
                        <td><input type="text" name="codigoArticulo" id="codigoArticulo" readonly="true">&nbsp;&nbsp;&nbsp;<input type="button" value="Buscar" onClick="BuscarArticulo()" class="button"></td>
                        <input type="hidden" name="idArticulo">
					</tr>
                    <tr>
                        <td>Cantidad Ingreso: </td>
                        <td>
                        	<input type="text" name="cantidad" id="cantidad" onKeyUp="numerico(cantidad)">
                             &nbsp;&nbsp;&nbsp;&nbsp;Bultos:
                            <input type="text" name="bultos" id="bultos" onKeyUp="numerico(bultos)">
                            &nbsp;&nbsp;&nbsp;&nbsp;Kg: 
                            <input type="text" name="kg" id="kg" onKeyUp="numerico(kg)">
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                            <input type="button" value="Aceptar" onClick="GuardarStock();Agregar(agrega1.value, idArticulo.value, nombreDeposito.value, cantidad.value, bultos.value, kg.value, 'resultado', 'agregarAtabla.php')" class="button">
                            <input type="button" value="Cancelar" onClick="Principal()" class="button">
    					</td>
                    </tr>
            	</table>
            </fieldset>
            </td>
        </tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
		<input type="hidden" name="agrega1" value="">
	</table>
    <div id="resultado" align="left">
				Pendientes.......
			</div>
            <input type="hidden" name="numeroRemito">
	</fieldset>
</form>
</div>
</div>
</body>
</html>
</center>
<script>

function BuscarArticulo()
	{
	 window.open("buscarProductoStock.php", "PopUp", 'width=500,height=400,scrollbars=YES'); return false;
	}

function Principal()
	{
	 document.ingresoStock.action="principal.php";
	 document.ingresoStock.submit();
	}

function GuardarStock()
	{
	if(document.ingresoStock.codigoArticulo.value =="")
	 	{
		 alert("Debe asignar un artículo.");
		 document.ingresoStock.codigoArticulo.focus;
		 document.ingresoStock.agrega1.value = "invalido";
		 return false;
		}
	if(document.ingresoStock.cantidad.value <= 0)
	 	{
		 alert("La cantidad a ingresar debe ser mayor que 0.");
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
	 //document.ingresoStock.action ="IngresoStockPhp.php";
	 //document.ingresoStock.submit();
	}
	
function Confirmar()
	{
		/*var numRemito = prompt('Ingrese numero de orden: ','');
		
		if(numRemito != "" && numRemito != null)
			{*/
				//document.ingresoStock.numeroRemito.value = numRemito;
				
				document.ingresoStock.action ="IngresoStockPhp.php";
	 			document.ingresoStock.submit();
			/*}else
				{
					alert("Debe ingresar el numero de remito correspondiente a el ingreso.");
					return false;
				}*/
	}
function Limpiar()
	{
	 document.ingresoStock.codigoArticulo.value = "";
	 document.ingresoStock.cantidad.value = "";
	 document.ingresoStock.bultos.value = "";
	 document.ingresoStock.kg.value = "";
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

function alerta()
	{
		alert("hola");
	}
//_________________________________________________________//
</script>