<?php
session_start();

$nombre = substr($_SESSION['Nombre'], 0, 2);

include("conexion.php");

$var = new conexion();
$var->conectarse();

//$consulta = "SELECT Max( substr( codigo, 4, 4 ) ) from pedidos Where codigo like'%".$nombre."%'";
$consulta = "SELECT Max( substr( codigo, 4, 4 ) ) from pedidos Where codigo REGEXP '^".$nombre."'";

//$consulta = "select count(*) from pedidos Where codigo like'%".$nombre."%'";
$resu = mysql_query($consulta);
$canti = mysql_fetch_array($resu);

$cantidad = str_pad($canti[0] + 1, 4, "0000", STR_PAD_LEFT);
$codigo = $nombre."-".$cantidad."-".date("y");

//$_GET['valor2'] => Accion
$accionPedido = $_GET['valor2'];

//$_GET['valor1'] => 0  : Pedido nuevo
//$_GET['valor1'] => >0 : Identificador del pedido
$idPedido = $_GET['valor1'];

	switch($accionPedido)
	{
		case "I":
				//ingreso nuevo
				$num = $codigo;
				break;

		case "A"://cargar los datos del pedido seleccionado
		case "V":
		case "P":
		case "T":
		case "C":
		case "E":
		case "TP":
		case "ET":
		case "EP":
		case "R":
		case "D":
		case "B":
		case "AP":
		case "SI":
		case "NO":
		case "DI":
		case "N":
				$consulta = "Select * From pedidos Where npedido=".$idPedido;
				$resu = mysql_query($consulta);
				$row = mysql_fetch_array($resu);

				//detalle del pedido
				$detalle = "Select * From pedidosdetalle where idPedido = $idPedido";
				$deta = mysql_query($detalle);
				$rDeta = mysql_fetch_array($deta);

				break;
		default :
				//cargar pedido seleccionado
				//$consulta = "Select * from ";
				break;
	}

function Readonly($accion)
{
    if($accion != "I" && $accion != "A" && $accion != "E" && $accion != "P")
    {
        return "readonly";
    }
}

function IsEnabled($accion)
{
    if($accion != "I" && $accion != "A" && $accion != "E" && $accion != "P")
    {
        echo " disabled=\"disabled\"";
    }
}

require("header.php");


?>
<style type="text/css">
 .span6 {
    width: 45%;
  }
</style>


<!-- VENTANAS EMERGENTES -->
<!-- Vencimientos -->
<div class="modal hide fade" id="VencPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Datos de Elaboración</h3>
  </div>
  <div class="modal-body">

	<table>
		<tr>
			<td>Envasado: </td>
			<td><input type="text" id="envasado" value="<?php echo isset($row['envasado']) ? $row['envasado']: "";?>" <?php echo Readonly($accionPedido);?>/></td>
		</tr>
		<tr>
			<td>Vencimiento: </td>
			<td><input type="text" id="vencimiento" value="<?php echo isset($row['vencimiento']) ? $row['vencimiento']: "";?>" <?php echo Readonly($accionPedido);?>/></td>
		</tr>
		<tr>
			<td>Lote: </td>
			<td><input type="text" id="lote" value="<?php echo isset($row['lote']) ? $row['lote']: "";?>" <?php echo Readonly($accionPedido);?>/></td>
		</tr>
	</table>

  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseClientesPop" onclick="ClosePop('VencPop')">Cerrar</a>
  </div>
</div>

<!-- Clientes -->
<div class="modal hide fade" id="ClientesPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Búsqueda de Clientes</h3>
  </div>
  <div class="modal-body">
    <strong>Buscar :   </strong>  <input type="text" id="buscador" onkeyup="BuscadorDeClientes(this.value)"><br><br>
    <div id="resultado_Cliente" style="width: 90%; min-height: 250px; max-height: 250px;">

    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseClientesPop" onclick="ClosePop('ClientesPop')">Cerrar</a>
  </div>
</div>

<!-- Productos -->
<center>
<div class="modal hide fade" id="ProductosPop" style="width: 900px; margin-left: -450px;">
  <div class="modal-header">
    <input type="hidden" id="busc" value="1">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Búsqueda de Productos</h3>
  </div>
  <div class="modal-body">
	<table>
		<tr>
			<td><strong>Buscar :   </strong>  <input type="text" id="buscadorP" onkeyup="BuscadorDeProductos(this.value, 1)"></td>
			<td>
				<div class="btn-group" data-toggle="buttons-radio" style="margin-top: -8px;">
					<button type="button" class="btn btn-primary active" onclick="setear(1)">  </button>
					<button type="button" class="btn btn-primary" onclick="setear(2)">+</button>
					<button type="button" class="btn btn-primary" onclick="setear(3)">-</button>
					<button type="button" class="btn btn-primary" onclick="setear(4)">+ -</button>
	    		        </div>
			</td>
		</tr>
	</table>
    <div id="resultado_Productos" style="width: 90%; min-height: 250px; max-height: 250px;">

    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseProductosPop" onclick="ClosePop('ProductosPop')">Cerrar</a>
  </div>
</div>
</center>

<!-- Mensajes de Alertas y/o error -->
<div class="modal hide fade" id="MensajesPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 style="color: red;">Error!!</h3>
  </div>
  <div class="modal-body">
    <br>
    <div id="msj_error_pop" class="alert alert-error">

    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseMensajePop" onclick="closeMensaje()">Cerrar</a>
  </div>
</div>

<!-- ---------------------->

<!-- Carga de comprobantes de CI -->
<div class="modal hide fade" id="CIpop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Carga de comprobantes de CI</h3>
  </div>
  <div class="modal-body">
    <div>
	<table>
		<tr>
			<td colspan="3" align="center">
				<div class="alert alert-error" id="error_div_CI" style="display: none">
					<label id="error_msj_CI" style="margin-top: 9px"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td><label>N° de Comprobante: </label></td>
			<td><input type="text" id="numberCI" style="margin-top: -5px;"></td>
			<td><button type="button" class="btn btn-primary" onclick="AddCI()" style="margin-top: -15px;">+</button></td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td colspan="3">
				<div style="max-height: 100px; height: 100px; min-height: 100px; overflow-y: auto; overflow-y: auto; background-color: #FAFAFA; margin-bottom: 10px; border: 1px solid; border-color: #cccccc;">
				    <table style="width: 100%;" id="table_hoja_CI">
					<tbody></tbody>
				    </table>
				</div>
			</td>
		</tr>
	</table>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseMensajePop" onclick="ClosePop('CIpop')">Cerrar</a>
    <a href="#" class="btn btn-primary" id="btnAceptarCI" onclick="ValidarConCI()">Aceptar</a>
  </div>
</div>

<!-- ---------------------->

<div class="well"> <!-- Contenerdor margen de Pantalla standarizado -->
	<div class="row">
		<div class="span6 offset2">
			<div class="page-header">
				<?php
				switch($accionPedido)
					{
						case "I":
							echo "<h2>Ingreso de Pedido</h2>";
							break;

						case "A":
							echo "<h2>Recepción de Pedido</h2>";
							break;

						case "R":
							echo "<h2>Rehacer Pedido</h2>";
							break;

						case "C":
							echo "<h2>Cancelar Pedido</h2>";
							break;

						case "E":
							echo "<h2>Editar Pedido</h2>";
							break;

						case "P":
							echo "<h2>Pedidos en Adm. de Producción</h2>";
							break;

						case "AP":
							echo "<h2>Pedido para Aprobar</h2>";
							break;

						case "SI":
							echo "<h2>Aprobar Pedido para diseño</h2>";
							break;

						case "B":
							echo "<h2>Pedido Diseñado</h2>";
							break;

						case "NO":
							echo "<h2><font style=\"color: red;\">NO</font> Aprobar Pedido para diseño</h2>";
							break;

						case "D":
							echo "<h2>Devolución de Pedido</h2>";
							break;
						case "N":
							echo "<h2>Aprobar Diseño</h2>";
							break;
					}

				?>
			</div>
		</div>
	</div>

	<!-- Datos del pedido -->
	<input type="hidden" id="idPedido" name="idPedido" value="<?php echo $idPedido; ?>"/>

	<div class="row">
		<div class="span10">
			<div class="bs-docs-example">
				<table style="width: 90%">
					<tr>
						<td>
							<?php
							if ($accionPedido != "I")
							{
							?>
							<img src="assest/plugins/buttons/icons/printer.png" title="Imprimir Pedido" onClick="Imprimir(<?php echo $idPedido;?>)">
							<?php
							}
							?>
						</td>
						<td></td>
						<td><label>N° de Pedido:</label></td>
						<td colspan="2">
							<input type="text" name="numeroPedido" maxlength="8" value="<?php echo isset($row['codigo'])? $row['codigo']:$num;?>" readonly>
						</td>

					</tr>
					<tr>
						<td><label>Cliente:</label> </td>
						<td>
							<?php
								if(Readonly($accionPedido) == "readonly")
								{
									?>
									<div>
										<input type="text" id="tbCliente" name="nombreCliente" readonly="true" value="<?php echo $row['clienteNombre'];?>">
									</div>
									<?php
								}
								else
								{
									?>
									<div class="control-group error">
										<input type="text" id="tbCliente" onclick="BuscarClientes()" name="nombreCliente" readonly="true" value="<?php echo isset($row['clienteNombre']) ? $row['clienteNombre']:"";?>">
									</div>
									<?php
								}
							?>
						</td>
						<!--<td><input type="button" id="btnCli" value="Buscar" onClick="BuscarCliente()" class="button"></td>-->
						<td><label>Código en Tango:</label></td>
						<td><input type="text" name="codigoTango" id="codigoTango" maxlength="8" value="<?php echo isset($row['clientefact']) ? $row['clientefact']:"";?>" readonly="true"></td>
					</tr>
					<tr>
						<td><label>Dirección:</label></td>
						<td><input type="text" name="direccionCliente" id="direccionCliente" readonly="true" value="<?php echo isset($row['clienteDirecc']) ? $row['clienteDirecc']:"";?>"></td>
						<td><label>Télefono:</label></td>
						<td><input type="text" name="telefonoCliente" id="telefonoCliente" readonly="true" value="<?php echo isset($row['clienteTelef']) ? $row['clienteTelef']:"";?>"></td>
					</tr>
					<tr>
						<td><label>Lugar de Entrega:</label></td>
						<td><input type="text" id="lugId" name="lugarEntrega" value="<?php echo isset($row['destino']) ? $row['destino']:"";?>" <?php echo Readonly($accionPedido);?>></td>
						<td><label>CUIT:</label></td>
						<td><input type="text" name="cuit" id="cuit" readonly="true" value="<?php echo isset($row['clienteCUIT']) ? $row['clienteCUIT']:"";?>" class="top"></td>
					</tr>
					<tr>
						<td><label>Facturar a:</label> </td>
						<td>
							<?php
								if(Readonly($accionPedido) == "readonly")
								{
									?>
									<div>
										<input type="text" name="facturarA" id="facturarA" value="<?php echo $row['facturarANombre'];?>" readonly="true">
									</div>
									<?php
								}
								else
								{
									?>
									<div class="control-group error">
										<input type="text" name="facturarA" id="facturarA" onclick="BuscarFacturars()" value="<?php echo isset($row['facturarANombre']) ? $row['facturarANombre']:"";?>" readonly="true">
									</div>
									<?php
								}
							?>

						</td>
						<!--<td><input type="button" value="Buscar" onClick="BuscarFacturar()" class="button"></td>-->
						<td><label>Código en Tango:</label></td>
						<td><input type="text" name="codigoTangoFacturar" id="codigoTangoFacturar" value="<?php echo isset($row['facturarA']) ? $row['facturarA']:"";?>" readonly="true"></td>
					</tr>
				</table>
			 </div>
		</div>
	</div>
	<input type="hidden" id="mail_protocolo" value="">
	<input type="hidden" id="envia_protocolo" value="">

	<!-- detalle del producto -->
	<div class="row">
		<div class="span6">
			<div class="bs-docs-article">
				<table style="width: 90%">
					<tr>
						<td>
							<input type="hidden" id="versionNP" name="versionNP" value="<?php echo isset($row['version']) ? $row['version'] : "1";?>">
							<input type="hidden" id="esNuevoNP" name="esNuevoNP" value="<?php echo isset($row['prodHabitual']) ? ($row['prodHabitual'] == 0 ? 0 : 1) : 0; ?>">
							<input type="hidden" id="arti" name="arti" value="<?php echo isset($row['prodHabitual']) ? ($row['prodHabitual'] == 0 ? "no" : "si") : "no"; ?>">
							<input type="radio" name="nuevoP" id="chkH" value="si" onClick="chequeadoN('no')" <?php echo isset($row['prodHabitual']) ? ($row['prodHabitual'] == 0 ? "checked" : "") : "checked"; ?> <?php IsEnabled($accionPedido);?>>Habitual
						</td>
						<td>
							<input type="radio" name="nuevoP" id="chkN" value="no" onClick="chequeadoN('si')" <?php echo isset($row['prodHabitual']) ? ($row['prodHabitual'] == 1 ? "checked" : "") : ""; ?> <?php IsEnabled($accionPedido);?>>Nuevo
						</td>
					</tr>
					<tr>
						<td><label>Código: </label></td>
						<td>
							<?php
							if(isset($row['prodHabitual']))
							{
								if($row['prodHabitual'] == 0 && ($accionPedido == "I" || $accionPedido == "A" || $accionPedido == "E"))
								{
									echo "
										<div class=\"control-group error\" id=\"div_busqueda_prod\">
											<input type=\"text\" id=\"codigoProductop\" name=\"codigoProductop\" class=\"input-xlarge\" onclick=\"BuscarProductoN()\" value=\"". (isset($row['descrip3']) ? $row['descrip3']: "")."\" style=\"width: 390px;\" readonly>
										</div>
									";
								}
								else
								{
									echo "
										<div id=\"div_busqueda_prod\">
											<input type=\"text\" id=\"codigoProductop\" name=\"codigoProductop\" class=\"input-xlarge\" onclick=\"BuscarProductoN()\" value=\"". (isset($row['descrip3']) ? $row['descrip3']: "")."\" style=\"width: 390px;\" readonly>
										</div>
									";
								}
							}
							else
							{
								if($accionPedido == "I" || $accionPedido == "A" || $accionPedido == "E")
								{
									echo "
										<div class=\"control-group error\" id=\"div_busqueda_prod\">
											<input type=\"text\" id=\"codigoProductop\" name=\"codigoProductop\" class=\"input-xlarge\" onclick=\"BuscarProductoN()\" value=\"". (isset($row['descrip3']) ? $row['descrip3']: "")."\" style=\"width: 390px;\" readonly>
										</div>
									";
								}
								else
								{
									echo "
										<div id=\"div_busqueda_prod\">
											<input type=\"text\" id=\"codigoProductop\" name=\"codigoProductop\" class=\"input-xlarge\" onclick=\"BuscarProductoN()\" value=\"". (isset($row['descrip3']) ? $row['descrip3']: "")."\" style=\"width: 390px;\" readonly>
										</div>
									";
								}
							}
							?>

						</td>
					</tr>
					<tr>
						<td><label>Artículo: </label></td>
						<td colspan="2">
							<?php
								if(isset($row['prodHabitual']))
								{
									if($row['prodHabitual'] == 0)
									{
										?>
											<input type="text" id="nombreProducto" class="input" name="nombreProducto" value="<?php echo isset($row['descripcion']) ? $row['descripcion']: "";?>" size="45" style="width: 390px;" readonly>
										<?php
									}
									else
									{
										?>
											<input type="text" id="nombreProducto" class="input" name="nombreProducto" value="<?php echo isset($row['descripcion']) ? $row['descripcion']: "";?>" size="45" style="width: 390px;" <?php echo Readonly($accionPedido);?>>
										<?php
									}
								}
								else
								{
									?>
										<input type="text" id="nombreProducto" class="input" name="nombreProducto" value="<?php echo isset($row['descripcion']) ? $row['descripcion']: "";?>" size="45" style="width: 390px;" readonly>
									<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td><label>Código Tango: </label></td>
						<td><input type="text" id="descripcionProducto" class="input-xlarge" name="descripcionProducto" value="<?php echo isset($row['codigoTango']) ? $row['codigoTango']: "";?>" style="width: 390px;" readonly></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="span6" style="">
			<div class="bs-docs-date">
				<table>
					<tr>
						<td>
							Emisión:
						</td>
						<td>
							<input type="text" name="fechaEmision" id="fechaEmision"  value="<?php echo ($accionPedido == 'I') ? date("d-m-Y"): invertirFecha($row['femis']);?>" readonly="true" class="input-small">
						</td>
					</tr>
					<tr>
						<td>
							Recepción:
						</td>
						<td>
							<input type="text" name="fechaRecp" id="fechaRecp" value="<?php echo ($accionPedido == 'I') ? "Pendiente": $row['frecep'];?>" readonly="true" class="input-small">
						</td>
					</tr>
					<tr>
						<td>
							Aprobación:
						</td>
						<td>
							<input type="text" name="fechaAprob" id="fechaAprob" value="<?php echo ($accionPedido == 'I') ? "Pendiente": $row['faprob'];?>" readonly="true" class="input-small">
						</td>
					</tr>
					<tr>
						<td>
							Entrega:
						</td>
						<td>
							<?php
								$fechin = "";
								if($accionPedido != 'I')
								{
									$fechin = explode('-',$row['entrega']);
									$fechin = $fechin[2].'-'.$fechin[1].'-'.$fechin[0];
								}

								if (Readonly($accionPedido) == "readonly")
								{
									?>
									<div>
										<input type="text" id="fecha1" name="fecha1" class="input-small" value="<?php echo $fechin; ?>" readonly>
									</div>
									<?php
								}
								else
								{
									echo "
									<script>
									$(function() {
										var d=new Date();
										$('#fecha1').datepicker({ minDate: new Date(d.getFullYear(), d.getMonth(), d.getDate()) });
										$('#fecha1').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
										$('#fecha1').datepicker( 'setDate', '".$fechin."' );
									      });
									</script>

									<div class=\"control-group error\">
										<input type=\"text\" id=\"fecha1\" name=\"fecha1\" class=\"input-small\" readonly>
									</div>

									";
								}
							?>
						</td>
					</tr>
				</table>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="span10">
			<div class="bs-docs-detail">
				<div class="row">
					<div class="span6">
						<div class="bs-docs-product">
							<table style="width: 100%">
								<tr>
									<td>Formato:</td>
									<td>
										<select name="formato" id="formato" <?php IsEnabled($accionPedido);?>>
											<option value="0" selected="selected">Seleccionar</option>
											<?php
													$consulta = "Select * from formatos order by descripcion";
													$resu = mysql_query($consulta);
													if($accionPedido == "I")
													{
														while($uni = mysql_fetch_array($resu))
														{
															echo "<option value=".$uni['idFormato'].">".htmlentities($uni['descripcion'])."</option>";
														}
													}else
														{
															while($uni = mysql_fetch_array($resu))
															{
																if($rDeta['Formato'] == $uni['idFormato'])
																{
																	echo "<option value=".$uni['idFormato']." selected>".htmlentities($uni['descripcion'])."</option>";
																}else
																	{
																		echo "<option value=".$uni['idFormato'].">".htmlentities($uni['descripcion'])."</option>";
																	}
															}
														}
													?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Material:</td>
									<td>
										<select name="material" id="material" onChange="habilitarComponentes(this.value)" <?php IsEnabled($accionPedido);?>>
											<option value="0" selected="selected">Seleccionar</option>
											<?php
													$consulta = "Select * from materiales order by descripcion";
													$resu = mysql_query($consulta);
													if($accionPedido == "I")
													{
														while($uni = mysql_fetch_array($resu))
														{
															echo "<option value=".$uni['idMaterial']." >".$uni['descripcion']."</option>";//onClick=\"habilitarComponentes(".$uni['idMaterial'].")\"
														}
													}else
														{
															while($uni = mysql_fetch_array($resu))
															{
																if($rDeta['Material'] == $uni['idMaterial'])
																{
																	echo "<option value=".$uni['idMaterial']." selected >".$uni['descripcion']."</option>";//onClick=\"habilitarComponentes(".$uni['idMaterial'].")\"
																}else
																	{
																		echo "<option value=".$uni['idMaterial']." >".$uni['descripcion']."</option>"; //onClick=\"habilitarComponentes(".$uni['idMaterial'].")\"
																	}
															}
														}




											?>
										</select>
										<?php
											$ancho = "readonly";
											$largo = "readonly";
											$micron = "readonly";
											$fuell = "readonly";
											$orige = "readonly";
											$solap = "readonly";
											$termo = "disabled=\"false\"";
											$micro = "disabled=\"false\"";
											$troqu = "disabled=\"false\"";

											if($accionPedido == "E" || $accionPedido == "A" || $accionPedido == "P")
											{
												//get dinamic data format
												$getDD  = "Select cmpId from tbl_formato_campos Where fId = ".$rDeta['Formato']."";
												$values = mysql_query($getDD);

												while($frm= mysql_fetch_array($values))
												{
													switch($frm[0])
													{
														case "ancho":
															$ancho = "";
															break;
														case "largo":
															$largo = "";
															break;
														case "micronaje":
															$micron = "";
															break;
														case "fuelle":
															$fuell = "";
															break;
														case "termo":
															$termo = "";
															break;
														case "micro":
															$micro = "";
															break;
														case "origen":
															$orige = "";
															break;
														case "solapa":
															$solap = "";
															break;
														case "troquelado":
															$troqu = "";
															break;
													}

													//echo '<script>
													//	var id_cmp = "#"+'.$frm[0].';
													//	campos_para_validar.push(id_cmp);
													//      </script>';
												}

											}

										?>
									    </td>
								</tr>
								<tr>
									<td>
										Color Material:
									</td>
									<td>
										<input type="text" id="color" name="color" onKeyUp="alfanumerico(color)" value="<?php echo ($accionPedido == 'I')? "": $rDeta['ColorMaterial'];?>" <?php IsEnabled($accionPedido);?>>
									</td>
								</tr>
                <tr>
									<td>
										Origen:
									</td>
									<td>
										<input type="text" id="origen" name="origen" <?php echo $orige; ?> value="<?php echo ($accionPedido == 'I')? "": $rDeta['PrecioPolimeros'];?>"><!-- "-->
									</td>
								</tr>
								<tr>
									<td>
										Ancho (cm):
									</td>
									<td>
										<input type="text" id="ancho" name="ancho" onKeyUp="decimal(ancho)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['Ancho'];?>" <?php echo $ancho; ?> >
									</td>
								</tr>
								<tr>
									<td>
										Largo (cm):
									</td>
									<td>
										<input type="text" id="largo" name="largo" onKeyUp="decimal(largo)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['Largo'];?>" <?php echo $largo; ?>>
									</td>
								</tr>
								<tr>
									<td>
										Micronaje:
									</td>
									<td>
										<input type="text" id="micronaje" name="micronaje" onKeyUp="alfanumerico(micronaje)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['Micronaje'];?>" <?php echo $micron;?> >
									</td>
								</tr>
								<tr>
									<td>
										Fuelle:
									</td>
									<td>
										<input type="text" id="fuelle" name="fuelle" onKeyUp="alfanumerico(fuelle)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['Fuelle'];?>" <?php echo $fuell;?> >
									</td>
								</tr>
								<tr>
									<td>
										Termo:
									</td>
									<td>
										<input type="checkbox" name="termo" id="termo" <?php echo ($accionPedido == 'I')? "": ($rDeta['Termo'] == 1) ? "checked": "";?> <?php echo $termo;?> >
									</td>
								</tr>
								<tr>
									<td>
										Microp:
									</td>
									<td>
										<input type="checkbox" name="micro" id="micro" <?php echo ($accionPedido == 'I')? "": ($rDeta['Micro'] == 1) ? "checked": "";?> <?php echo $micro; ?> >
									</td>
								</tr>

								<tr>
									<td>
										Env/Ven/Lote:
									</td>
									<td>
										<button class="btn btn-mini btn btn-info" type="button" onclick="abrir_venc()">
											...
										</button>
									</td>
								</tr>
								<tr>
									<td style="padding-top: 10px;">
										Solapa:
									</td>
									<td style="padding-top: 10px;">
										<input type="text" id="solapa" name="solapa" <?php echo $solap; ?> value="<?php echo ($accionPedido == 'I')? "": $rDeta['solapa'];?>"><!-- "-->
									</td>
								</tr>
								<tr>
									<td style="padding-top: 10px;">
										Troquelado:
									</td>
									<td style="padding-top: 10px;">
										<select id="troquelado" <?php echo $troqu; ?>>
											<?php
											if(isset($row['tieneToquelado']))
											{
												if($row['tieneToquelado'] == null)
													echo '<option value="-1" "Selected">--</option>';
													else
														echo '<option value="-1">--</option>';

												if($row['tieneToquelado'] == '1')
													echo '<option value="1" Selected>Si</option>';
													else
														echo '<option value="1">Si</option>';

												if($row['tieneToquelado'] == '0')
													echo '<option value="0" Selected>No</option>';
													else
														echo '<option value="0">No</option>';
											}else{
												?>
												<option value="-1" "Selected">--</option>
												<option value="1">Si</option>
												<option value="0">No</option>
												<?php
											}
											?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="span6">
						<div class="bs-docs-bobinado">
							<table style="width: 100%">
								<tr>
									<td>
										Sentido:
									</td>
									<td>
										<select name="bobinado" id="bobinado" <?php IsEnabled($accionPedido);?>>
											<option value="2" <?php echo ($accionPedido == 'I')? "selected": ($rDeta['Bobinado'] == 2) ? "selected": "";?>>Ninguno</option>
											<option value="1" <?php echo ($accionPedido == 'I')? "": ($rDeta['Bobinado'] == 1) ? "selected": "";?>>De Pie</option>
											<option value="0" <?php echo ($accionPedido == 'I')? "": ($rDeta['Bobinado'] == 0) ? "selected": "";?>>De Cabeza</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Tratado:
									</td>
									<td>
										<select name="fuera" id="fuera" <?php IsEnabled($accionPedido);?>>
											<option value="2" <?php echo ($accionPedido == 'I')? "selected": ($rDeta['BobinadoFuera'] == 2) ? "selected": "";?>>Ninguno</option>
											<option value="1" <?php echo ($accionPedido == 'I')? "": ($rDeta['BobinadoFuera'] == 1) ? "selected": "";?>>Por Fuera</option>
											<option value="0" <?php echo ($accionPedido == 'I')? "": ($rDeta['BobinadoFuera'] == 0) ? "selected": "";?>>Por Dentro</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Dist. de Taco:
									</td>
									<td>
										<input type="text" name="distancia" id="distancia" onKeyUp="decimal(distancia)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['DistanciaTaco'];?>" <?php IsEnabled($accionPedido);?>>
									</td>
								</tr>
								<tr>
									<td>
										Diam. de Bobina:
									</td>
									<td>
										<input type="text" name="bobina" id="bobina" onKeyUp="decimal(bobina)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['DiametroBobina'];?>" <?php IsEnabled($accionPedido);?>>
									</td>
								</tr>
								<tr>
									<td>
										Diam. de Canuto:
									</td>
									<td>
										<input type="text" name="canuto" id="canuto" onKeyUp="decimal(canuto)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['DiametroCanuto'];?>" <?php IsEnabled($accionPedido);?>>
									</td>
								</tr>
								<tr>
									<td>
										Kg. x Bobina:
									</td>
									<td>
										<input type="text" name="kgBobina" id="kgBobina" onKeyUp="decimal(kgBobina)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['KgBobina'];?>" <?php IsEnabled($accionPedido);?>>
									</td>
								</tr>
								<tr>
									<td>
										Mts. x Bobina:
									</td>
									<td>
										<input type="text" name="mtsBobina" id="mtsBobina" onKeyUp="decimal(mtsBobina)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['MtsBobina'];?>" <?php IsEnabled($accionPedido);?>>
									</td>
								</tr>
							</table>
						</div>

						<div class="bs-docs-observacio">
							<?php
							$readonly = " readonly ";

							if($accionPedido != "I")
							{
								$readonly = "  ";
							}

							if(Readonly($accionPedido) == "readonly")
							   {
								?><textarea name="observaciones" id="observaciones" rows="3" style="width: 300px" readonly="readonly"><?php echo ($accionPedido == 'I')? "" : $rDeta['Obseervaciones'];?></textarea> <?php
							   }
							   else
							   {
								?><textarea name="observaciones" id="observaciones" rows="3" style="width: 300px"><?php echo ($accionPedido == 'I')? "" : $rDeta['Obseervaciones'];?></textarea><?php
							   }

							?>

						</div>
					</div>
				</div>



				<div class="row" style="text-align: center">
					<div class="span4">
						<div class="bs-docs-volumen">
							<table style="width: 100%">
								<tr>
									<td>
										Cantidad:
									</td>
									<td>
										<input type="text" id="cantidad"  readonly name="cantidad" onKeyUp="numerico(cantidad);" value="<?php echo ($accionPedido == 'I')? "": $rDeta['CantidadTotal'];?>" <?php echo Readonly($accionPedido);?>>
									</td>
								</tr>
								<tr>
									<td>
										Unidades:
									</td>
									<td>
										<select id="unidades" name="unidades" style="width: 150px;" <?php IsEnabled($accionPedido);?>>
											<option value="0" selected="selected">Selecc.</option>
											<?php
											$b = 0;
												$consulta = "Select * from unidades order by descripcion";
												$resu = mysql_query($consulta);
												if($accionPedido == "I")
												{
													while($uni = mysql_fetch_array($resu))
													{
														echo "<option value=".$uni['idUnidad'].">".$uni['descripcion']."</option>";
													}
												}else
													{
				   									    while($uni = mysql_fetch_array($resu))
														{
														if($rDeta['Unidad'] == $uni['idUnidad'])
															{
																 echo "<option value=".$uni['idUnidad']." selected>".$uni['descripcion']."</option>";
															}else
																{
																	echo "<option value=".$uni['idUnidad'].">".$uni['descripcion']."</option>";
																}
														}
													}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Precio:</td>
									<td>
										<select id="moneda" name="moneda" style="width: 70px;" <?php IsEnabled($accionPedido);?>>
											<option value="0" selected="selected">-</option>
											<?php
											$consulta = "Select * from monedas order by descripcion";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idMoneda'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
													  if($rDeta['Moneda'] == $uni['idMoneda'])
														{
															echo "<option value=".$uni['idMoneda']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idMoneda'].">".$uni['descripcion']."</option>";
															}
													}
												}
											?>
										</select>
										<input type="text" id="precio" name="precio" onKeyUp="decimal(precio)" value="<?php echo ($accionPedido == 'I')? "" : $rDeta['PrecioImporte'];?>" style="width: 85px;" <?php echo Readonly($accionPedido);?>>
										<select id="condicionPago" name="condicionPago" style="width: 85px;" <?php IsEnabled($accionPedido);?>>
											<option value="0" selected="selected">-</option>
											<?php
											$consulta = "Select * from condicioniva order by descripcion";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idIVA'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
													   if($rDeta['IVA'] == $uni['idIVA'])
														{
															echo "<option value=".$uni['idIVA']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idIVA'].">".$uni['descripcion']."</option>";
															}
													}
												}
											?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="span4 offset1">
						<div class="bs-docs-print">
							<table style="width: 100%">
								<tr>
									<td>Caras:</td>
									<td>
										<select name="caras" id="caras" onchange="HabilitarDatosImpresion()" <?php IsEnabled($accionPedido);?>>
											<option value="3" <?php echo ($accionPedido == 'I')? "selected": ($row['caras'] == 3) ? "selected": "";?>>Seleccionar</option>
											<option value="0" <?php echo ($accionPedido == 'I')? "": ($row['caras'] == 0) ? "selected": "";?>>Sin Impresi&oacute;n</option>
											<option value="1" <?php echo ($accionPedido == 'I')? "": ($row['caras'] == 1) ? "selected": "";?>>1 Cara</option>
											<option value="2" <?php echo ($accionPedido == 'I')? "": ($row['caras'] == 2) ? "selected": "";?>>2 Caras</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Tipo Imp:</td>
									<td>
										<select name="centrada" id="centrada" <?php IsEnabled($accionPedido);?>>
											<option value="3" <?php echo ($accionPedido == 'I')? "selected": ($row['centrada'] == 3) ? "selected": "";?>>Seleccionar</option>
											<option value="2" <?php echo ($accionPedido == 'I')? "": ($row['centrada'] == 2) ? "selected": "";?>>Ning&uacute;na</option>
											<option value="1" <?php echo ($accionPedido == 'I')? "": ($row['centrada'] == 1) ? "selected": "";?>>Centrada</option>
											<option value="0" <?php echo ($accionPedido == 'I')? "": ($row['centrada'] == 0) ? "selected": "";?>>Corrida</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Horientación:</td>
									<td>
										<select name="tipo" id="tipo" <?php IsEnabled($accionPedido);?>>
											<option value="3" <?php echo ($accionPedido == 'I')? "selected": ($row['apaisada'] == 3) ? "selected": "";?>>Seleccionar</option>
											<option value="2" <?php echo ($accionPedido == 'I')? "": ($row['apaisada'] == 2) ? "selected": "";?>>Ninguna</option>
											<option value="1" <?php echo ($accionPedido == 'I')? "": ($row['apaisada'] == 1) ? "selected": "";?>>Apaisada</option>
											<option value="0" <?php echo ($accionPedido == 'I')? "": ($row['apaisada'] == 0) ? "selected": "";?>>Com&uacute;n</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="span9">
						<div class="bs-docs-laminado">
							<table style="width: 100%">
								<tr>
									<td>Materiales :</td>
									<td>
										<select id="Bilaminado1" name="Bilaminado1" disabled>
										<?php
											$consulta = "Select * from componenteslaminado";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idComponente'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
														if($rDeta['Bilaminado1'] == $uni['idComponente'])
														{
															 echo "<option value=".$uni['idComponente']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idComponente'].">".$uni['descripcion']."</option>";
															}
													}
												}
										?>
										</select>
									</td>
									<td>
										<select id="Bilaminado2" name="Bilaminado2" disabled>
										<?php
											$consulta = "Select * from componenteslaminado";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idComponente'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
														if($rDeta['Bilaminado2'] == $uni['idComponente'])
														{
															 echo "<option value=".$uni['idComponente']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idComponente'].">".$uni['descripcion']."</option>";
															}
													}
												}
										?>
										</select>
									</td>
									<td>
										<select id="Trilaminado" name="Trilaminado" disabled>
										<?php
											$consulta = "Select * from componenteslaminado";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idComponente'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
														if($rDeta['Trilaminado'] == $uni['idComponente'])
														{
															 echo "<option value=".$uni['idComponente']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idComponente'].">".$uni['descripcion']."</option>";
															}
													}
												}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Colores :</td>
									<td>
										<select id="Material1" name="Material1" disabled>
										<?php
											$consulta = "Select * from materialeslaminado";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idMaterialLam'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
														if($rDeta['Material1'] == $uni['idMaterialLam'])
														{
															 echo "<option value=".$uni['idMaterialLam']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idMaterialLam'].">".$uni['descripcion']."</option>";
															}
													}
												}
										?>
										</select>
									</td>
									<td>
										<select id="Material2" name="Material2" disabled>
										<?php
											$consulta = "Select * from materialeslaminado";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idMaterialLam'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
														if($rDeta['Material2'] == $uni['idMaterialLam'])
														{
															 echo "<option value=".$uni['idMaterialLam']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idMaterialLam'].">".$uni['descripcion']."</option>";
															}
													}
												}
										?>
										</select>
									</td>
									<td>
										<select id="Material3" name="Material3" disabled>
										<?php
											$consulta = "Select * from materialeslaminado";
											$resu = mysql_query($consulta);
											if($accionPedido == "I")
											{
												while($uni = mysql_fetch_array($resu))
												{
													echo "<option value=".$uni['idMaterialLam'].">".$uni['descripcion']."</option>";
												}
											}else
												{
													while($uni = mysql_fetch_array($resu))
													{
														if($rDeta['Material3'] == $uni['idMaterialLam'])
														{
															 echo "<option value=".$uni['idMaterialLam']." selected>".$uni['descripcion']."</option>";
														}else
															{
																echo "<option value=".$uni['idMaterialLam'].">".$uni['descripcion']."</option>";
															}
													}
												}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td><label>Micronaje : </label></td>
									<td><input type="text" id="Micronaje1" name="Micronaje1" style="width:220px" disabled value="<?php echo ($accionPedido == 'I') ? "": $rDeta['Micronaje1']; ?>"></td>
									<td><input type="text" id="Micronaje2" name="Micronaje2" style="width:220px" disabled value="<?php echo ($accionPedido == 'I') ? "": $rDeta['Micronaje2']; ?>"></td>
									<td><input type="text" id="Micronaje3" name="Micronaje3" style="width:220px" disabled value="<?php echo ($accionPedido == 'I') ? "": $rDeta['Micronaje3']; ?>"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<?php
				if($accionPedido == "A")
				{
				?>
					<div class="row">
						<div class="span4">
						<table>
							<tr>
								<td style="padding-right: 20px;">
									Estadística:
								</td>
								<td>
									<select id="estadistica" name="estadistica">
										<?php
											$consulta = "Select idEsta, estNombre from tbl_estadisticas order by estNombre";
											$resu = mysql_query($consulta);
											if(mysql_num_rows($resu) > 0)
											{
												while($est = mysql_fetch_array($resu))
												{
													echo "<option value=".$est['idEsta']." >".$est['estNombre']." </option>";//onClick=\"habilitarComponentes(".$uni['idMaterial'].")\"
												}
											}
										?>
									</select>
								</td>
							</tr>
						</table>
						</div>
					</div>
				<?php
				}
				else
				{
					#determinar si es o no una comunicacion interna
					if($accionPedido == "P")
					{
						?>

						<div class="row">
							<div class="span4">
							<table>
								<tr>
									<td style="padding-right: 20px;">
										Es Comunicación Interna:
									</td>
									<td>
										<input type="checkbox" id="esCI" onclick="EnabledButtonCI()">
									</td>
								</tr>
							</table>
							</div>
						</div>

						<?php
					}
				}
				?>
				<input type="hidden" id="CI_values" value="">
			</div>
		</div>

	</div>

	<div class="row">
		<div class="span9" style="text-align: right">
			<table style="margin-left: 700px">
				<tr>
					<td><input type="button" value="Cancelar" onClick="history.back(-1);">&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input type="button" id="btn_save" value="Aceptar" onClick="guardar_1()" class="btn btn-primary">
						<input type="button" id="btn_CI" value="CI" onClick="guardar_CI()" class="btn btn-warning" style="display: none">
					</td>
				</tr>
			</table>
		</div>
	</div>

	<!--<form name="alta_pedido" action="IngresoPedidosphp.php" method="post" >-->


<!-- accion que se ejecuta -->
	<?php
	switch($accionPedido)
	{
		case "I":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="I">';
				break;
		case "A":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="A">';
				break;
		case "P":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="P">';
				break;
		case "V":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="V">';
				break;
		case "T":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="T">';
				break;
		case "TP":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="TP">';
				break;
		case "C":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="C">';
				break;
		case "E":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="E">';
				break;
		case "ET":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="ET">';
				break;
		case "EP":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="EP">';
				break;
		case "R":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="R">';
				break;
		case "D":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="D">';
				break;
		case "B":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="B">';
				break;
		case "AP":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="AP">';
				break;
		case "SI":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="SI">';
				break;
		case "NO":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="NO">';
				break;
		case "DI":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="CL">';
				break;
		case "N":
				echo '<input type="hidden" id="accionPedido" name="accionPedido" value="N">';
				break;
	}
	?>


<div class="modal hide fade" id="cantidad_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Cantidades Permitidas</h3>
  </div>
  <div class="modal-body">
		<table class="table table-bordered" id="table_cant">
			<thead>
				<tr>
					<th>#</th>
					<th>Descripción</th>
					<th>Largo Desarrollo(Corte)</th>
					<th>Ancho</th>
					<th>Multiplo de Bolsas</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
  	<div class="control-group">
	    <div class="controls">
	    	<input type="text" id="input_cant_pop" class="" placeholder="Ingrese Cantidad">
	    	<input type="hidden" id="multiplo_cant" >
	    </div>
	  </div>
    <ul class="cant_allowed unstyled " data-multi=""></ul>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="pop_close">Cerrar</a>
    <a href="#" class="btn btn-primary">Seleccionar</a>
  </div>
</div>


</div>

<?php
require("footer.php");



//--------------- FUNCIONES -------------------
function invertirFecha($date)
	{
		$dato = explode('-',$date);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
	}
//---------------------------------------------

?>
<script type="text/javascript">
/*
	$(function(){
		swal({
  title: "Error!",
  text: "Here's my error message!",
  type: "error",
  confirmButtonText: "Cool"
});
	});*/
</script>
<script type="text/javascript" src="Js/IngresoPedidos.js"></script>
