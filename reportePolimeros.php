<?php
session_start();
?>
<center>
<?php
if( !isset($_SESSION['id_usuario']))
	{
	 echo '<script>
	 			alert("Debes iniciar sesión para estar aca.");
				location.href = "principal.php";
	 	   </script>';	
	}
	
$idUsuario = $_SESSION['id_usuario'];

include "./layout/header2.php";

//---------------------------------------------

$var = new conexion();
$var->conectarse();
 ?>
 <form id="reportePolimeros" name="reportePolimeros" method="post">
 <div class="span-23 right">
        <div class="span-22  push-1"  id="titulo_main">
                <center>
                    <label >Reporte Polímeros</label>
                </center>
        </div>	
        <fieldset>
        <table>
        	<tr>
            	<td><input type="checkbox" name="Prov" id="Prov" onClick="habilitar('Prov','idProv')"> Proveedor:</td>
                <td><select name="idProv" id="idProv" style="width:145px" disabled="disabled" >
                		<option value="0">Proveedor</option>
                        <?php
						$sql = "Select id_proveedor, razon_social  from proveedores order by razon_social";
						$resu = mysql_query($sql) or (die(mysql_error()));
						
						if(mysql_num_rows($resu) > 0)
							{
								while($row = mysql_fetch_array($resu))
									{
										echo '<option value="'.$row['id_proveedor'].'">'.$row['razon_social'].'</option>';	
									}
							}
						?>
                </select>
                <td><input type="checkbox" name="Clie" id="Clie" onClick="habilitar('Clie','idClie')"> Cliente:</td>
                <td><select name="idClie" id="idClie" style="width:145px" disabled="disabled"  >
                		<option value="0">Cliente</option>
                        <?php
						$sql = "Select cod_client, razon_soci from clientes order by razon_soci";
						$resu = mysql_query($sql) or (die(mysql_error()));
						
						if(mysql_num_rows($resu) > 0)
							{
								while($row = mysql_fetch_array($resu))
									{
										echo '<option value="'.$row['cod_client'].'">'.$row['razon_soci'].'</option>';	
									}
							}
						?>
                    </select>
                </td>
                <td><input type="checkbox" name="Moti" id="Moti" onClick="habilitar('Moti','idMoti')"> Motivo:</td>
                <td><select name="idMoti" id="idMoti" style="width:145px" disabled="disabled" >
                		<option value="0">Motivo</option>
                        <option value="1">Nuevo</option>
                        <option value="2">Pedido Reposición</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td><input type="checkbox" name="Fech" id="Fech" onClick="habilitarFechas('Fech','fDes','fHas')"> Fecha:</td>
                <td colspan="2">
                <input type="text" name="FechDesde" id="FechDesde" readonly size="9" value="<?php echo date("d-m-Y");?>">
                <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechDesde,'dd-mm-yyyy',this);return false;" style="visibility:collapse" id="fDes">
                &nbsp;&nbsp;A&nbsp;&nbsp;
                <input type="text" name="FechHasta" id="FechHasta" readonly size="9" value="<?php echo date("d-m-Y");?>">
                <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechHasta,'dd-mm-yyyy',this);return false;" style="visibility:collapse" id="fHas">
                </td>
                <td><input type="checkbox" name="Recep" id="Recep" onClick="habilitarFechas('Recep','rDes','rHas')">Fecha de Recepción:</td>
                <td colspan="2">
                <input type="text" name="RecepDesde" id="RecepDesde" readonly size="9" value="<?php echo date("d-m-Y");?>">
                <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(RecepDesde,'dd-mm-yyyy',this);return false;" style="visibility:collapse" id="rDes">
                &nbsp;&nbsp;A&nbsp;&nbsp;
                <input type="text" name="RecepHasta" id="RecepHasta" readonly size="9" value="<?php echo date("d-m-Y");?>">
                <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(RecepHasta,'dd-mm-yyyy',this);return false;" style="visibility:collapse" id="rHas">
                </td>
            </tr>
            <tr>
            	<td colspan="6">
                <br>
                	<input type="button" class="button" value="Aceptar" onClick="Validar()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" class="button" value="Cancelar" onClick="Principal()">
        </table>
        </fieldset>
        <fieldset><legend>Resultado</legend>
        	<div id="div_find">
            	<b><i>No se encontraron resultados.</i></b>
            </div>
        </fieldset>
 </div>
 </form>
 <?php include "./layout/footer.php"; ?>
 
 <script>
 function Principal()
 	{
		document.reportePolimeros.action = "principal.php";
		document.reportePolimeros.submit();
	}
 function habilitar(id,camp)
	{
		if(document.getElementById(id).checked)
		{
			document.getElementById(camp).disabled=false;
		}
			else
			{
				document.getElementById(camp).disabled=true;
			}
	}
function habilitarFechas(id,desde,hasta)
	{
		if(document.getElementById(id).checked)
			{
				document.getElementById(desde).style.visibility = "visible";
				document.getElementById(hasta).style.visibility = "visible";
			}else
			{
				document.getElementById(desde).style.visibility = "collapse";
				document.getElementById(hasta).style.visibility = "collapse";
			}
	}
function Validar()
	{
		if(!(document.getElementById('Prov').checked) && !(document.getElementById('Clie').checked) && !(document.getElementById('Moti').checked) &&
			!(document.getElementById('Fech').checked) && !(document.getElementById('Recep').checked))	
			{
				//ninguno chequeado
				alert("Seleccione algun campo para poder realizar la busqueda de polimeros.");
				return false;
			}
			else
				{
					var filtros = "";
					//aplicar filtro para el/los chequeados
					//si esta chequeado proveedor-----------------------------
					if(document.getElementById('Prov').checked)
						{
							if(document.getElementById('idProv').value == 0)
								{
									alert("Seleccione un proveedor válido");
									document.getElementById('idProv').focus();
									return false;
								}
								else 
								{
									filtros = 1 + ":" + document.getElementById('idProv').value;
								}
						}
					//si esta chequeado cliente-------------------------------
					if(document.getElementById('Clie').checked)
						{
							if(document.getElementById('idClie').value == 0)
								{
									alert("Seleccione un cliente válido");
									document.getElementById('idClie').focus();
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idClie').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idClie').value;
								}
						}
					//si esta chequeado el motivo-----------------------------
					if(document.getElementById('Moti').checked)
						{
							if(document.getElementById('idMoti').value == 0)
								{
									alert("Seleccione un motivo válido");
									document.getElementById('idMoti').focus();
									return false;
								}else 
								{
									if(filtros == "")
										filtros = 3 + ":" + document.getElementById('idMoti').value;
										else
										filtros = filtros + "~" + 3 + ":" + document.getElementById('idMoti').value;
								}
						}
					//si esta chequeda la fecha-------------------------------
					if(document.getElementById('Fech').checked)
						{
							/*if(document.getElementById('FechDesde').value == 0)
								{
									alert("Seleccione una fecha válida.");
									document.getElementById('FechDesde').focus();
									return false;
								}else 
								{*/
									if(filtros == "")
										filtros = 4  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
										else
										filtros = filtros + "~" + 4 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
								//}
						}
					//si esta chequeda la fecha-------------------------------
					if(document.getElementById('Recep').checked)
						{
							/*if(document.getElementById('RecepDesde').value == 0)
								{
									alert("Seleccione una fecha válida.");
									document.getElementById('RecepDesde').focus();
									return false;
								}else 
								{*/
									if(filtros == "")
										filtros = 5  + ":" + document.getElementById('RecepDesde').value + "/" + document.getElementById('RecepHasta').value;
										else
										filtros = filtros + "~" + 5 + ":" + document.getElementById('RecepDesde').value + "/" + document.getElementById('RecepHasta').value;
								//}
						}
					reporteAjax('div_find','reportePolimerosphp.php',filtros);
					//ajax_pallet('result','entrega_ajax.php')
					//alert(filtros);
				}
	}

function ImprimirReporte(sql)
	{
		window.open("impresionComprobantes.php?documento=5&id="+sql, "PopUp", "menubar=1,width=1500,height=900");
	}	
//----------------- AJAX --------------------------------
function nuevoAjax1()
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

function reporteAjax(div, archivo, filtros)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax1();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+filtros);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
	
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}
//----------------------------------------------------------
 </script>