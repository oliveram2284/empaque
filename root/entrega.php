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
include "entrega_datos.php";

// borrar contenido tabla temporal de entregas 
$odb= new db(); 
$sql="delete from entregatemporal";
                
$res= $odb->query($sql);
//---------------------------------------------


 ?>
 <form name="entrega" action="" method="post">
<div class="span-23 right"><!-- Cuerpo de Formulario -->
	<div class="span-23">
    
	<fieldset> <legend>Entrega</legend>
		<table>
			<tr>
				
				<td>
				    <label class="span-3">Tipo de Entrega: </label><?php _select_tipo_entrega();?>
				</td>	
			</tr>
			<tr>
				<td ><label class="span-3">Destino: </label><?php  _select_destino(); ?>
						<!--<button class="button" id="bt_destino" name="bt_destino" onClick="AbrirVentana('destino','I','0') ">Nuevo</button>-->
						
				</td>
				<td>
					<label class="span-3">Resp. Exp: </label><?php  _select_respo_exp(); ?>
				</td>
			</tr>
			<tr>
				<td><label class="span-3">Transporte: </label><?php  _select_transporte(); ?>
						<!--<button class="button" id="bt_entrega" name="bt_entrega" onClick="AbrirVentana('transportes','I','0')"  >Nuevo</button>-->
				</td>	
				<td><!--<label class="span-3">Vendedor: </label><?php  /* _select_vendedor();*/ ?>
						<button class="button" id="bt_entrega" name="bt_entrega" >Nuevo</button>-->
				</td>  
				
			</tr>
						<tr>
				<td ><label class="span-3">Chofer: </label> 
																					<input type="text" id="chofer" name="chofer" onkeyup="letras(chofer)" />
							
				</td>
				<td><label class="span-3">Teléfono: </label>
																					<input type="text" id="telefono" name="telefono" onkeyup="numerico(telefono)" />
						
				</td>	
			</tr>
			</tr>
			<tr>
				<td ><label class="span-3">Camión: </label> 
																					<input type="text" id="camion" name="camion"  class="top" onkeyup="alfanumerico(camion)"/>
							
				</td>
				<td><label class="span-3">Domicílio: </label>
																					<input type="text" id="domicilio" name="domicilio" size="40" class="top"  onkeyup="alfanumerico(domicilio)"  />
						
				</td>	
			</tr>
			<tr>
				<td ><label class="span-3">Fecha: </label> 
																					<input type="text" id="fecha" name="fecha" class="top" readonly="readonly" value="<?php echo date("d-m-Y");?>" />
																					<img src="./assest/plugins/buttons/icons/calendar.png" class="top" onClick="displayCalendar(fecha,'dd-mm-yyyy',this);return false;">
																					
				</td>
				<td>
						
				</td>	
			</tr>
	</table>
	</fieldset>
	<!--<hr>-->
	 <fieldset ><legend>Carga</legend>
	  
	<div class="span-18" id="div_pallet">
	<table>
    	<tr>
        	<td><label>Tipo de Empaque:</label></td>
            <td>
            	<select name="idTipoEmp" id="idTipoEmp" >
           		<option value="0">Tipo de Empaque</option>
			   <?php
                $odb= new db(); 
				$sql="select id_empaque,descripcion from tipo_empaque order by descripcion";
                
                $res= $odb->query($sql);
                    
                while($row = mysql_fetch_array($res))
                    {  
                    echo"<option value=' ".$row['id_empaque']."'>".$row['descripcion']."</option> ";
                    }
               ?>
           		</select>
            </td>
            <td><label>Número</label></td>
            <td><input type="text" name="numero" id="numero" size="5" onkeyup="numerico(numero)"/></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
        	<td colspan="6">
        <fieldset>
        <table>
        <tr>
        	<td><label>Pedido</label></td><input type="hidden" id="codigoH" />
            <td>
               <select name="nroPedido" id="nroPedido" onchange="document.getElementById('estampa').value=this.options[this.selectedIndex].getAttribute('estampa'),document.getElementById('medidas').value=this.options[this.selectedIndex].getAttribute('medidas'),document.getElementById('codigoH').value=this.options[this.selectedIndex].getAttribute('codigo'), document.getElementById('cant').value=this.options[this.selectedIndex].getAttribute('cantidad'), document.getElementById('bult').value=this.options[this.selectedIndex].getAttribute('bultos'), document.getElementById('kil').value=this.options[this.selectedIndex].getAttribute('kilos')">
           		<option value="0">Pedidos..</option>
			   <?php
                $odb= new db(); 
				$sql = "SELECT id, npedido, ar.Articulo, d.Ancho, d.Largo, d.Micronaje, pd.codigo, pd.cantidad_entregadas, pd.kg_entregados, pd.bultos_entregados
						FROM pedidos pd
						INNER JOIN articulos ar ON pd.descrip3 = ar.Id
						INNER JOIN pedidosdetalle d ON pd.npedido = d.idPedido
						WHERE estado = 'T' OR estado = 'EP' OR estado = 'TP' ORDER BY npedido";
				//$sql="select npedido from pedidos Where estado = 'T' or estado = 'EP' or estado = 'TP' order by npedido";
                
                $res= $odb->query($sql);
                    
                while($row = mysql_fetch_array($res))
                    {  
					//$valor = str_pad($row['npedido'], 8, "00000000", STR_PAD_LEFT);
                    echo"<option estampa='".$row[2]."' medidas='".$row[3]." X ".$row[4]." X ".$row[5]."' value='".$row['npedido']."' codigo='".$row[6]."' cantidad='".$row[7]."' bultos='".$row[8]."' kilos='".$row[9]."'>".$row[6]."</option> ";
                    }
               ?>
           		</select>
            </td>
            <td><label>Estampa</label></td>
            <td><input type="text" size="15" id="estampa" readonly="readonly"/></td>
            <td><label>Medidas</label></td>
            <td><input type="text" size="25" id="medidas" readonly="readonly"/></td>
        </tr>
        <tr>
        	<td><label>Unidades:</label></td>
            <td><input type="text" size="15" id="cant" readonly="readonly"/></td>
         	<td><label>Bultos:</label></td>
            <td><input type="text" size="15" id="bult" readonly="readonly" /></td>
            <td><label>Kilos:</label></td>
            <td><input type="text" size="15" id="kil" readonly="readonly" /></td>
        </tr>
        </table>
        </fieldset>
        	</td>
        </tr>
        <tr>
        	<td><label>Unidades</label></td>
            <td><input type="text" size="15" id="unidades" onkeyup="numerico(unidades)"/></td>
            <td><label>Bultos</label></td>
            <td><input type="text"  size="15" id="bultos" onkeyup="numerico(bultos)" /></td>
            <td><label>Kg:</label></td>
            <td><input type="text" size="15" id="kilos" onkeyup="decimal(kilos)"/></td>
        </tr>
        <tr>
        	<td><label>Remito</label></td>
            <td><input type="text" size="15" id="remito" onkeyup="numerico(remito)"/></td>
            <td><label>Factura</label></td>
            <td><input type="text" size="15" id="factura" onkeyup="numerico(factura)"/></td>
            <td><label>$/u Aprox</label></td>
            <td><input type="text" size="15" id="valor" onkeyup="decimal(valor)"/></td>
        </tr>
        <tr>
        	<td><label>Imp. Neto</label></td>
            <td><input type="text"  size="15" id="importeNeto" onkeyup="decimal(importeNeto)" /></td>
        </tr>
        <tr>
        	<td>
            <input type="button" id="newpallet" name="newpallet" onclick="ajax_pallet('result','entrega_ajax.php');" value="Agregar" class="button"/>
            </td>
         </tr>
    </table>
	</div>
     </fieldset>
	
	
	<fieldset><legend>Salida</legend>
	 <div id="result" class="span-16 " > 
     
	</div>
    </fieldset>
</div>
</form>
<!-- indica si hay detalle cargado -->
<input type="hidden" id="haydetalle" name="haydetalle" value="si" />
<!-- -->
<div class="span-23"  >
      <input type="button" name="submitBot" id="submitBot" value="Aceptar" class="button" onclick="validarEntrega()" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="button" onclick="Principal()" />
                        
</div>
<?php include "./layout/footer.php"; ?>
</center>

<script type="text/javascript">

function Principal()
	{
	 document.entrega.action="principal.php";
	 document.entrega.submit();
	}

function validarEntrega()
	{
		if(document.getElementById('selecEntrega').value <= 0)
			{
				alert("Seleccione el tipo de entrega.");
				return false;
			}
		if(document.getElementById('selecrespexp').value <= 0)
			{
				alert("Seleccione el responsable de expedición.");
				return false;
			}
		if(document.getElementById('selecDestino').value <= 0)
			{
				alert("Seleccione el destino.");
				return false;
			}
		if(document.getElementById('selectransporte').value <= 0)
			{
				alert("Seleccione el transporte.");
				return false;
			}
		if(document.getElementById('chofer').value == "")
			{
				alert("Ingrese el nombre del chofer.");
				document.getElementById('chofer').focus();
				return false;
			}
		if(document.getElementById('camion').value == "")
			{
				alert("Ingrese la patente del camión.");
				document.getElementById('camion').focus();
				return false;
			}
		if(document.getElementById('telefono').value == "")
			{
				alert("Ingrese un número de telefono.");
				document.getElementById('telefono').focus();
				return false;
			}
		if(document.getElementById('domicilio').value == "")
			{
				alert("Ingrese un domicilio para la entrega.");
				document.getElementById('domicilio').focus();
				return false;
			}
		if(document.getElementById('haydetalle').value != "si")
			{
				alert("Ingrese un domicilio para la entrega.");
				return false;
			}
			
		document.entrega.action = "entregaphp.php";
		document.entrega.submit();
	}

function ajax_pallet(id_div,controller)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	if(validar() == false)
		{
			return false;
		}
		else
		{
			var capa=document.getElementById(id_div);
			
			var tipoEmp=  document.getElementById('idTipoEmp').value;
			var npedido=  document.getElementById('nroPedido').value;
			var unidades= document.getElementById('unidades').value;
			var bultos=   document.getElementById('bultos').value;
			var kilos=    document.getElementById('kilos').value;
			var remito=   document.getElementById('remito').value;
			var factura=  document.getElementById('factura').value;
			var valor=    document.getElementById('valor').value;
			var neto=     document.getElementById('importeNeto').value;
			var medidas=  document.getElementById('medidas').value;
			var estampa=  document.getElementById('estampa').value;
			var numero=   document.getElementById('numero').value;
			var codigo=   document.getElementById('codigoH').value;
			
			// Creo el objeto AJAX
			var ajax=nuevoAjax();
			// Coloco el mensaje "Cargando..." en la capa
			capa.innerHTML="Cargando...";
			// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
			ajax.open("POST", controller, true);
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			
			var variable=tipoEmp+"~"+npedido+"~"+unidades+"~"+bultos+"~"+kilos+"~"+remito+"~"+factura+"~"+valor+"~"+neto+"~"+medidas+"~"+estampa+"~"+numero+"~"+codigo;
			//alert(variable);
			ajax.send("variable="+variable);
		
		ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4)
				{
					// Respuesta recibida. Coloco el texto plano en la capa correspondiente
					capa.innerHTML=ajax.responseText;
				}
			}
		Limpiar();	
		}
}

function Limpiar()
	{
		document.getElementById('idTipoEmp').value = 0;
		//document.getElementById('nroPedido').value = 0;
		document.getElementById('unidades').value = "";
		document.getElementById('bultos').value = "";
		document.getElementById('kilos').value = "";
		document.getElementById('remito').value = "";
		document.getElementById('factura').value = "";
		document.getElementById('valor').value = "";
		document.getElementById('importeNeto').value = "";
		document.getElementById('medidas').value = "";
		document.getElementById('estampa').value = "";
		document.getElementById('numero').value = "";
	}

function validar()
	{
		if(document.getElementById('idTipoEmp').value == 0)
			{
				alert("Indique el tipo de empaque.");	
				document.getElementById('idTipoEmp').focus();
				return false;
			}
		if(document.getElementById('numero').value <= 0)
			{
				alert("Indique el número de empaque.");	
				document.getElementById('numero').focus();
				return false;
			}
		if(document.getElementById('nroPedido').value == 0)
			{
				alert("Indique el número de pedido.");	
				document.getElementById('nroPedido').focus();
				return false;
			}
		if(document.getElementById('unidades').value <= 0)
			{
				alert("La cantidad de unidades debe ser un valor mayor que cero.");	
				document.getElementById('unidades').focus();
				return false;
			}
		if(document.getElementById('bultos').value <= 0)
			{
				alert("La cantidad de bultos debe ser un valor mayor que cero.");	
				document.getElementById('bultos').focus();
				return false;
			}
		if(document.getElementById('kilos').value <= 0)
			{
				alert("La cantidad de kilos debe ser un valor mayor que cero.");	
				document.getElementById('kilos').focus();
				return false;
			}
		if(document.getElementById('remito').value <= 0)
			{
				alert("Debe ingresar un valor positivo para el número de remito.");	
				document.getElementById('remito').focus();
				return false;
			}
		if(document.getElementById('factura').value <= 0)
			{
				alert("Debe ingresar un valor positivo para el número de factura.");	
				document.getElementById('factura').focus();
				return false;
			}
		if(document.getElementById('valor').value <= 0)
			{
				alert("Debe ingresar un valor para el importe aproximado.");	
				document.getElementById('valor').focus();
				return false;
			}
		if(document.getElementById('importeNeto').value <= 0)
			{
				alert("Debe ingresar un valor para el importe neto.");	
				document.getElementById('importeNeto').focus();
				return false;
			}		
		return true;
	}
	
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
