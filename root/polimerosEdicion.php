<?php
session_start();

echo '<center>';

//--------------------------------------------

$idPolimero = $_POST['idPolimero'];
$operacion = $_POST['Operacion'];

//--------------------------------------------

if( !isset($_SESSION['id_usuario']))
	{
	 echo '<script>
	 			alert("Debes iniciar sesión para estar aca.");
				location.href = "principal.php";
	 	   </script>';	
	}
	
$idUsuario = $_SESSION['id_usuario'];

include "./layout/header2.php";
include "entrega_datos.php";

//---------------------------------------------

//---------------------------------------------


$var = new conexion();
$var->conectarse();
						                     
$sql = "select * from polimeros where id_polimero = ".$idPolimero."";
$resu = mysql_query($sql) or (die(mysql_error()));

$row= mysql_fetch_array($resu);
//---------------------------------------------

 ?>
<form id="polimeros" name="polimeros" method="post">
<div class="span-23 right">
        <div class="span-22  push-1"  id="titulo_main">
                <center>
                    <label >Polimeros</label>
                </center>
        </div>	
        <fieldset>
        <table>
        	<input type="hidden" name="Op" id="Op" value="<?php echo $operacion;?>" />
            <input type="hidden" name="idPolimero" id="idPolimero" value="<?php echo $idPolimero;?>"/>
            <tr>
            	<td>Fecha: </td>
                <td><input type="text" id="fecha" name="fecha" readonly value="<?php echo invertirFecha($row['fecha']); ?>" />
                <img src="./assest/plugins/buttons/icons/calendar.png" class="top" onClick="displayCalendar(fecha,'dd-mm-yyyy',this);return false;"></td>
            </tr>
            <tr>
            	<td>Proveedor:</td>
                <input type="hidden" id="idProveedor" name="idProveedor" value="<?php echo $row['id_proveedor'];?>"/>
                <td><input type="text" id="proveedor" name="proveedor" size="30" value="<?php echo obtenerDato($row['id_proveedor'],'proveedores','id_proveedor ','razon_social') ?>" readonly/> &nbsp;&nbsp;&nbsp;
                <input type="button" value="Buscar" class="button" onclick="BuscarProveedor()"/></td>
            </tr>
            <tr>
            	<td>Marca:</td>
                <td>
                	<select id="idMarca" name="idMarca" style="width:145px" >
                    	<option value="0">Selecc. Marca</option>
                        <?php
						//include("conexion.php");
						
						$consulta = "Select * from marca order by descripcion";
						$resul = mysql_query($consulta);
						
						while($uni=mysql_fetch_array($resul))
							{    if($row['id_etiqueta'] == $uni['idMarca'])
							     {
								    echo "<option value=".$uni['idMarca']." selected=\"selected\">".$uni['descripcion']."</option>";
                                 }else
                                 {
                                    echo "<option value=".$uni['idMarca'].">".$uni['descripcion']."</option>";
                                 }
							}
						?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>Cliente:</td>
                <td><input type="text" id="cliente" size="30" readonly value="<?php echo obtenerDatoCaracter($row['id_cliente'],'clientes','cod_client','razon_soci') ?>"/> &nbsp;&nbsp;&nbsp;
                <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $row['id_cliente'];?>" />
                <input type="button" value="Buscar" class="button" onclick="BuscarCliente()"/></td>
            </tr>
        </table>
        </fieldset>
        
        <fieldset>
        <table>
        	<tr>
            	<td>Trabajo:</td>
                <td>
                    <textarea id="trabajo" name="trabajo" rows="2" cols="50"><?php echo $row['trabajo'];?></textarea>
                <!--<input type="text" id="trabajo" name="trabajo" onkeyup="letras(trabajo)" />-->
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Motivo:</td>
                <td>
                	<select id="idMotivo" name="idMotivo" style="width:145px" onchange="habilitar(this.value)">
                    	<option value="0" >Selecc. Motivo</option>
                        <option value="1" <?php echo ($row['id_motivo'] == 1) ? "selected" : ""; ?>>Nuevo</option>
                        <option value="2" <?php echo ($row['id_motivo'] == 2) ? "selected" : ""; ?>>Pedido Reposición</option>
                    </select>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td>Remito de Documento: </td>
                <td><input type="text" name="remitoDocumento" id="remitoDocumento" <?php echo ($row['id_motivo'] == 2) ? "disabled=\"disabled\"" : ""; ?> onkeyup="alfanumerico(remitoDocumento)" value="<?php echo $row['remito_d']; ?>"/></td>
                <td>Pedido de Producción:</td>
                <td><input type="text" name="pedidoProduccion" id="pedidoProduccion" <?php echo ($row['id_motivo'] == 1) ? "disabled=\"disabled\"" : ""; ?> onkeyup="alfanumerico(pedidoProduccion)" value="<?php echo $row['pedido_P']; ?>"/></td>
            </tr>
            <tr>
            	<td>Fecha de Trabajo: </td>
                <td><input  type="text" readonly="readonly" id="fechaTrab" name="fechaTrab" value="<?php echo invertirFecha($row['fecha_recepcion']); ?>" />
                <img src="./assest/plugins/buttons/icons/calendar.png" class="top" onClick="displayCalendar(fechaTrab,'dd-mm-yyyy',this);return false;"></td>
                <td>Espesor:</td>
                <td><input type="text" id="espesor" name="espesor" onkeyup="numerico(espesor)" value="<?php echo $row['espesor'] ;?>"/></td>
            </tr>
            <tr>
            	<td>Color: </td>
                <td colspan="3"><input type="text" id="color" name="color" onkeyup="alfanumerico(color)" size="110" value="<?php echo $row['colores'] ;?>"/></td>
            </tr>
            <tr>
            	<td>Medidas:</td>
                <td><input type="text" id="medidas" name="medidas" onkeyup="alfanumerico(medidas)" value="<?php echo $row['medidas'] ;?>"/></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td>N° Remito: </td>
                <td colspan="3"><input type="text" id="remito" name="remito" onkeyup="numerico(remito)" value="<?php echo $row['nro_remito'] ;?>" /></td>
            </tr>
            <tr>
            	<td>Precio Proveedor:</td>
                <td><input type="text" id="precioProv" name="precioProv" onkeyup="decimal(precioProv)" value="<?php echo $row['precio_proveedor'] ;?>"/></td>
                <td>Precio Final:</td>
                <td><input type="text" id="precioFin" name="precioFin" onkeyup="decimal(precioFin)" value="<?php echo $row['precio_final'] ;?>"/></td>
             </tr>
             <tr>
             	<td>Estado</td>
                <td>
                	<select id="estado" name="estado" style="width:145px">
                    	<option value="0" >Selecc. Estado</option>
                        <option value="1" <?php echo ($row['estado'] == 1) ? "selected" : ""; ?>>Factura</option>
                        <option value="2" <?php echo ($row['estado'] == 2) ? "selected" : ""; ?>>No Factura</option>
                        <option value="4" <?php echo ($row['estado'] == 4) ? "selected" : ""; ?>>Revisión</option>
                    </select>
                </td>
                <td colspan="2">
                	<div id="facturado" style="display:none">
                    	N° De Factura: &nbsp;&nbsp;&nbsp;
                    	<input type="text" name="factura" id="factura" onkeyup="numerico(factura)" />
                    </div>
                </td>
             </tr>
             <tr>
             	<td valign="top">Observaciones:</td>
                <td><textarea id="observaciones" name="observaciones" ><?php echo $row['observacion'];?></textarea>
                
        </table>
        </fieldset>
        <input type="button" value="Aceptar" class="button" onclick="Validar()" />&nbsp;&nbsp;&nbsp;
        <input type="button" value="Cancelar" class="button" onclick="Inicio()"/>
</div>
</form>

<?php include "./layout/footer.php"; ?>
</center>


<?php
///funciones -------------

function obtenerDato($id,$tabla,$campo,$campoRetorno)
		{
		 if($id != 0)
		{
		 $consulta = 'Select * From '.$tabla.' Where '.$campo.' ='.$id;
		 $resu = mysql_query($consulta);
		 $row = mysql_fetch_array($resu);
		 return $row[$campoRetorno];
		 }else
		 	{
			 return '-';
			}
		}
function obtenerDatoCaracter($id,$tabla,$campo,$campoRetorno)
		{
		 if($id != '')
		{
		 $consulta = "Select * From ".$tabla." Where ".$campo."='".$id."'";
		 $resu = mysql_query($consulta);
		 $row = mysql_fetch_array($resu);
		 return $row[$campoRetorno];
		 }else
		 	{
			 return '-';
			}
		}
		
function invertirFecha($date)
	{
		$dato = explode('-',$date);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
	}
    
//--------------------------------------------------------
?>
<script type="text/javascript">
function habilitar2()
	{
		if(document.getElementById('estado').value == 1)
			{
				document.getElementById('facturado').style.display = 'block';
				document.getElementById('factura').focus();
			}else
				{
					document.getElementById('facturado').style.display = 'none';
					document.getElementById('estado').focus();
				}
	}
function Validar()
	{
		//validar proveedor
		if(document.getElementById('idProveedor').value == 0)
			{
			 alert("Seleccione el proveedor.");
			 document.getElementById('proveedor').focus();
			 return false;
			}
		//validar marca
		if(document.getElementById('idMarca').value == 0)
			{
				alert("Seleccione una marca.");
				document.getElementById('idMarca').focus();
				return false;
			}
		//validar el cliente 
		if(document.getElementById('idCliente').value == 0)
			{
				alert("Seleccione el cliente.");
				document.getElementById('cliente').focus();
				return false;
			}
		//validar trabajo 
		if(document.getElementById('trabajo').value == "")
			{
				alert("Indique el tipo de trabajo.");
				document.getElementById('trabajo').focus();
				return false;	
			}
		//validar motivo 
		if(document.getElementById('idMotivo').value == 0)
			{
				alert("Seleccione el motivo.");
				document.getElementById('idMotivo').focus();
				return false;
			}else
				{
					if(document.getElementById('idMotivo').value == 1)
						{
							//validar remito de documento
							if(document.getElementById('remitoDocumento').value == "")
								{
									alert("Ingrese el número de remito del documento.");
									document.getElementById('remitoDocumento').focus();
									return false;
								}
						}else
							{
							//validar pedido de producción
							if(document.getElementById('pedidoProduccion').value == "")
								{
									alert("Ingrese el número de pedido de producción.");
									document.getElementById('pedidoProduccion').focus();
									return false;
								}	
							}
				}
		//validar espesor 
		if(document.getElementById('espesor').value == "")
			{
				alert("Indique el espesor.");
				document.getElementById('espesor').focus();
				return false;
			}
		//validar color
		if(document.getElementById('color').value == "")
			{
				alert("Indique el color.");
				document.getElementById('color').focus();
				return false;
			}
		//validar medidas
		if(document.getElementById('medidas').value == "")
			{
				alert("Indique las medidas.");
				document.getElementById('medidas').focus();
				return false;
			}
		//validar n° de remito
		if(document.getElementById('remito').value == "")
			{
				alert("Indique el número de remito.");
				document.getElementById('remito').focus();
				return false;
			}
		//validar precio proveedor
		if(document.getElementById('precioProv').value == "")
			{
				alert("Indique el precio del Proveedor.");
				document.getElementById('precioProv').focus();
				return false;
			}
		//validar precio final
		if(document.getElementById('precioFin').value == "")
			{
				alert("Indique el precio final.");
				document.getElementById('precioFin').focus();
				return false;
			}
		//validar estado
		if(document.getElementById('estado').value == 0)
			{
				alert("Indique el estado.");
				document.getElementById('estado').focus();
				return false;
			}
				
		document.polimeros.action = "polimerosEdicionphp.php";
		document.polimeros.submit();
	}
function Inicio()
	{
		document.polimeros.action="principal.php";
	 	document.polimeros.submit();
	}
function habilitar(id)
	{
		if(id == 1)
			{
				document.getElementById('remitoDocumento').disabled=false;
				document.getElementById('pedidoProduccion').disabled=true;
				document.getElementById('remitoDocumento').focus();
			}
			else
				{ 
					if(id == 2)
						{
							document.getElementById('pedidoProduccion').disabled=false;
							document.getElementById('remitoDocumento').disabled=true;
							document.getElementById('pedidoProduccion').focus();
						}
						else
							{
								document.getElementById('pedidoProduccion').disabled=true;
								document.getElementById('remitoDocumento').disabled=true;
							}
				}
	}

function BuscarCliente()
	{
	 window.open("buscarClientePolimeros.php", "PopUp", 'width=500,height=400,scrollbars=YES'); return false;
	}
	
function BuscarProveedor()
	{
	 window.open("buscarProveedorPolimeros.php", "PopUp", 'width=500,height=400,scrollbars=YES'); return false;
	}
//________________________________________________________	
//solo letras en el campo	
function letras (campo) 
	{
	var charpos = campo.value.search("[^A-Za-z´. ]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value= campo.value.slice(0, -1);
		campo.focus();
		return false; 
		}
		 else 
		 	{
			return true;
			}
}
//_________________________________________________________// 
//Solo numeros en el campo
function numerico(campo) 
	{
	var charpos = campo.value.search("[^0-9,]"); 
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
//_________________________________________________________//
//Solo se permiten numero y letras (no simbolos)
function alfanumerico(campo)
	{ 
	var charpos = campo.value.search("[^A-Za-z0-9. ]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value =  campo.value.slice(0, -1)
		campo.focus();
		return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//	
//Solo se permiten flotantes
function decimal(campo)
	{ 
	var charpos = campo.value.search("[^0-9.]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value =  campo.value.slice(0, -1)
		campo.focus();
		return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//

</script>

