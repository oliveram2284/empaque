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
                    <label>Reporte de Movimientos de Stock</label>
                </center>
        </div>	
        <fieldset>
        <table>
        	<tr>
            	<td><input type="checkbox" name="Tentr" id="Tentr" onClick="habilitar('Tentr','idEntr')"> T. de Entrega:</td>
                <td><select name="idEntr" id="idEntr" style="width:145px" disabled="disabled" >
                		<option value="0">T. de Entrega</option>
                        <?php
						$sql = "Select id_tipo, descripcion  from tipo_entrega order by descripcion";
						$resu = mysql_query($sql) or (die(mysql_error()));
						
						if(mysql_num_rows($resu) > 0)
							{
								while($row = mysql_fetch_array($resu))
									{
										echo '<option value="'.$row['id_tipo'].'">'.$row['descripcion'].'</option>';	
									}
							}
						?>
                </select>
                <td><input type="checkbox" name="Dest" id="Dest" onClick="habilitar('Dest','idDest')"> Destino:</td>
                <td><select name="idDest" id="idDest" style="width:145px" disabled="disabled"  >
                		<option value="0">Destino</option>
                        <?php
						$sql = "Select id_destino, descripcion from destino order by descripcion";
						$resu = mysql_query($sql) or (die(mysql_error()));
						
						if(mysql_num_rows($resu) > 0)
							{
								while($row = mysql_fetch_array($resu))
									{
										echo '<option value="'.$row['id_destino'].'">'.$row['descripcion'].'</option>';	
									}
							}
						?>
                    </select>
                </td>
                <td><input type="checkbox" name="Resp" id="Resp" onClick="habilitar('Resp','idResp')"> Responsable:</td>
                <td><select name="idResp" id="idResp" style="width:145px" disabled="disabled" >
                		<option value="0">Responsable</option>
                        <?php
						$sql = "Select id_usuario, nombre_real from usuarios order by nombre_real";
						$resu = mysql_query($sql) or (die(mysql_error()));
						
						if(mysql_num_rows($resu) > 0)
							{
								while($row = mysql_fetch_array($resu))
									{
										echo '<option value="'.$row['id_usuario'].'">'.$row['nombre_real'].'</option>';	
									}
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" name="Trans" id="Trans" onClick="habilitar('Trans','idTrans')"> Transporte:</td>
                <td><select name="idTrans" id="idTrans" style="width:145px" disabled="disabled" >
                		<option value="0">Transporte</option>
                        <?php
						$sql = "Select id_transporte, razon_social from transportes order by razon_social";
						$resu = mysql_query($sql) or (die(mysql_error()));
						
						if(mysql_num_rows($resu) > 0)
							{
								while($row = mysql_fetch_array($resu))
									{
										echo '<option value="'.$row['id_transporte'].'">'.$row['razon_social'].'</option>';	
									}
							}
						?>
                    </select>
                </td>
            	<td><input type="checkbox" name="Fech" id="Fech" onClick="habilitarFechas('Fech','fDes','fHas')"> Fecha:</td>
                <td colspan="3">
                <input type="text" name="FechDesde" id="FechDesde" readonly size="9" value="<?php echo date("d-m-Y");?>">
                <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechDesde,'dd-mm-yyyy',this);return false;" style="visibility:collapse" id="fDes">
                &nbsp;&nbsp;A&nbsp;&nbsp;
                <input type="text" name="FechHasta" id="FechHasta" readonly size="9" value="<?php echo date("d-m-Y");?>">
                <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechHasta,'dd-mm-yyyy',this);return false;" style="visibility:collapse" id="fHas">
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
		if(!(document.getElementById('Tentr').checked) && !(document.getElementById('Dest').checked) && !(document.getElementById('Resp').checked) &&
			!(document.getElementById('Fech').checked) && !(document.getElementById('Trans').checked))	
			{
				//ninguno chequeado
				alert("Seleccione algun campo para poder realizar la busqueda de entregas.");
				return false;
			}
			else
				{
					var filtros = "";
					//aplicar filtro para el/los chequeados
					//si esta chequeado el tipo de entrega -----------------------------
					if(document.getElementById('Tentr').checked)
						{
							if(document.getElementById('idEntr').value == 0)
								{
									alert("Seleccione un tipo de entrega válido");
									document.getElementById('idEntr').focus();
									return false;
								}
								else 
								{
									filtros = 1 + ":" + document.getElementById('idEntr').value;
								}
						}
					//si esta chequeado el destino-------------------------------
					if(document.getElementById('Dest').checked)
						{
							if(document.getElementById('idDest').value == 0)
								{
									alert("Seleccione un destino válido");
									document.getElementById('idDest').focus();
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idDest').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idDest').value;
								}
						}
					//si esta chequeado el responsable-----------------------------
					if(document.getElementById('Resp').checked)
						{
							if(document.getElementById('idResp').value == 0)
								{
									alert("Seleccione un responsable válido");
									document.getElementById('idResp').focus();
									return false;
								}else 
								{
									if(filtros == "")
										filtros = 3 + ":" + document.getElementById('idResp').value;
										else
										filtros = filtros + "~" + 3 + ":" + document.getElementById('idResp').value;
								}
						}
                    //si esta chequeado el transporte-----------------------------
					if(document.getElementById('Trans').checked)
						{
							if(document.getElementById('idTrans').value == 0)
								{
									alert("Seleccione un transporte válido");
									document.getElementById('idTrans').focus();
									return false;
								}else 
								{
									if(filtros == "")
										filtros = 4 + ":" + document.getElementById('idTrans').value;
										else
										filtros = filtros + "~" + 4 + ":" + document.getElementById('idTrans').value;
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
										filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
										else
										filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
								//}
						}
				
					reporteAjax('div_find','reporteEntregasphp.php',filtros);
					//ajax_pallet('result','entrega_ajax.php')
					//alert(filtros);
				}
	}

function ImprimirReporte(sql)
	{
	   if(isNaN(sql)== false)
        {
            //impresion individual
            window.open("impresionComprobantes.php?documento=3&id="+sql, "PopUp", "menubar=1,width=900,height=900");
        }else
        {
            //impresion de filtro 
            window.open("impresionComprobantes.php?documento=6&id="+sql, "PopUp", "menubar=1,width=900,height=900");
        }
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