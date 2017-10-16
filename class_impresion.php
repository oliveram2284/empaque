<?php

//incluimos la conexión de la base de datos
include("conexion.php");

//implementacion de la clase para imprimir reportes
class impresion 
	{
		//atributos propios de la clase
		
		
		//fin atributos de la clase 
		
		//metodos o funciones de la clase 
		function Encabezado($TipoDeDocumento, $numeroDocumento)
			{
				//abrir conexión
				$var = new conexion();
				$var->conectarse();
				
				//generara consulta para obtener los datos del encabezado 
				$consulta = "Select * From configuracionempresa";
				$row = mysql_query($consulta);
				
				$resu = mysql_fetch_array($row);
		
				//encabezado del formulario de impresión
				echo '<table width="100%" > 
						<tr>
							<td align="center"><img src="imag/LogoEmpresaEncabezado.jpg" width="65" height="65" /></td>
							<td>
								<b><div style="font-size: 24px">'.$resu['descripcion'].'</div>
								Departamento Ventas<br>
								'.$resu['cuit'].'<br>
								'.$resu['direccion'].'</b><br>
							</td>
							<td align="center" style="width: 200px; height=50px; border:1px solid black;">';
								switch($TipoDeDocumento)
								{
									//orden de ingreso
									case 1 : echo '<b><h2> Orden de Ingreso </h2></b>
													<br><h4> N° : '.str_pad($numeroDocumento, 8, "00000000", STR_PAD_LEFT).'</h4>';//</td>';
													
											 $idDepo = 	obtenerDato($numeroDocumento, 'remito', 'id_remito', 'idDeposito');
											 	
											 echo '<br><h4>Depósito Destino : '.obtenerDato($idDepo, 'depositos', 'id_deposito', 'nombre').'</h4></td>';	
											 break;
									//orden de egreso
									case 2 : echo '<b><h2> Orden de Egreso </h2></b>
													<br><h4> N° : '.str_pad($numeroDocumento, 8, "00000000", STR_PAD_LEFT).'</h4>';
											
											 $idDepo = 	obtenerDato($numeroDocumento, 'ordensalida', 'id', 'idDeposito');
											 	
											 echo '<br><h4>Depósito Origen : '.obtenerDato($idDepo, 'depositos', 'id_deposito', 'nombre').'</h4></td>';
											 break;
									//entrega
									case 3 : echo '<b><h2> Entrega de Productos </h2></b>
													<br><h4> N° : '.str_pad($numeroDocumento, 8, "00000000", STR_PAD_LEFT).'</h4>';
											
											 break;
									//pedidos
									case 4 : echo '<b>Pedido</b><br>
													<br><div style="font-size: 24px"><b>N° : '.obtenerDato($numeroDocumento, 'pedidos', 'npedido', 'codigo').'<b/></div>
													<br>Estado : ';
													switch(obtenerDato($numeroDocumento, 'pedidos', 'npedido', 'estado'))
													{
														case 'I':
															echo 'Ingresado';
															break;
														case 'A':
															echo 'Aprobado';
															break;
														case 'V':
															echo 'Recibido';
															break;
														case 'T':
															echo 'Terminado';
															break;
														case 'EP':
															echo 'Entregado Parcialmente';
															break;
														case 'ET':
															echo 'Entregado';
															break;
														case 'TP':
															echo 'Terminado Parcialmente';
															break;
													}
												echo '
												<br><br>
												<b></b>
												';
												
												
												//generara consulta para obtener los datos del encabezado 
												$consulta = "Select * From pedidos Where npedido = ".$numeroDocumento;
												$roww = mysql_query($consulta);
												
												$resuu = mysql_fetch_array($roww);
												echo 'Versión '.$resuu['version'];
											 break;
										//polimeros
										case 5 : 
											echo '<b><h2> Filtro </h2></b>';
											break;
										
										//Polímeros nuevos
										case 6:
											echo '<b><h2> Orden de Trabajo </h2></b>
											      <br><h4> N° : '.str_pad($numeroDocumento, 6, "000000", STR_PAD_LEFT).'</h4>';
													
											break;
                                        //entregas
                                        case 6 :
                                            echo '<b><h2> Filtro </h2></b>';
                                            break;
                                        //pedidos
                                        case 7 :
                                            echo '<b><h2>  </h2></b>';
                                            break;
										case 8 :
											echo '<b><h2>  </h2></b>';
											break;
								}
						
				echo 	'</tr></table>';
						/*
						<tr>
							<td><b>Localidad: </b>'.$resu['departamento'].' - '.$resu['provincia'].'</td>
						</tr>
						<tr>
							<td><b>Telefono/Fax: </b>'.$resu['telefonofax'].'</td>
						</tr>
						<tr>
							<td><b>Contacto: </b>'.$resu['contacto'].'</td>
						</tr>
						*/
			}
		
		function Cuerpo($TipoDeDocumento,$numeroDocumento)
			{
				echo '<table width="100%" style="border:1px solid black;">';
				
				switch($TipoDeDocumento)
					{
					//orden de ingreso
					case 1: 
						echo '<tr>
								<td style="border:1px solid black;background-color: #CCCCCC;" align="center" width="40%"> Artículo </td>
								<td style="border:1px solid black;background-color: #CCCCCC;" align="center" width="20%"> Cantidad </td>
								<td style="border:1px solid black;background-color: #CCCCCC;" align="center" width="20%"> Bultos </td>
								<td style="border:1px solid black;background-color: #CCCCCC;" align="center" width="20%"> Kilogramos </td>
							  </tr>';
							  
						$consulta = "Select * from detalle_remito Where idRemito = $numeroDocumento";
						$resu = mysql_query($consulta) or die (mysql_error());
						
						while ($row = mysql_fetch_array($resu))
							{
								echo '<tr>
										<td width="40%">'.obtenerDato($row['idDeposito'], 'depositos', 'id_deposito', 'nombre').'</td>
										<td width="20%" align="right">'.$row['Cantidad'].'</td>
										<td width="20%" align="right">'.$row['bultos'].'</td>
										<td width="20%" align="right">'.$row['kg'].'</td>
									  </tr>';
							}
						break;
					 //orden de egreso
					 case 2:
					 	echo '<tr>
								<td style="border:1px solid black;background-color: #CCCCCC;" align="center" width="30%"> Artículo </td>
								<td style="border:1px solid black;background-color: #CCCCCC;" align="center" width="40%"> Cantidad </td>
							  </tr>';
							  
						$consulta = "Select * from ordensalidadetalle Where idorden = $numeroDocumento";
						$resu = mysql_query($consulta) or die (mysql_error());
						
						while ($row = mysql_fetch_array($resu))
							{
								echo '<tr>
										<td width="30%">'.$row['desProducto'].'</td>
										<td width="30%" align="right">'.$row['cantidad'].'</td>
									  </tr>';
							}
						break;
					 //entrega de productos
					 case 3:
					 	$consu = "Select * from entregas Where id_entregas = $numeroDocumento";
						$resu = mysql_query($consu) or die(mysql_error());
						$row = mysql_fetch_array($resu);
					 	echo '<tr>
								<td style="background-color: #CCCCCC;" align="rigth" width="100%">
									Tipo de entrega: '.obtenerDato($row['id_tipodeentregas'], 'tipo_entrega', 'id_tipo', 'descripcion').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
									Destino: '.obtenerDato($row['id_destino'], 'destino', 'id_destino', 'descripcion').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Usuario de Expedición:  '.obtenerDato($row['id_usuarioexp'], 'usuarios', ' id_usuario', 'nombre_real').'
								</td>
							  </tr>
							  <tr>
								<td style="background-color: #CCCCCC;" align="rigth" width="100%">
								Chofer : '.$row['chofer'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								Télefono : '.$row['telefono'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								Fecha: '.$row['fecha'].'
								</td>
							  </tr>
							  <tr>
								<td style="background-color: #CCCCCC;" align="rigth" width="100%">
								Camion:'.$row['camion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								Domicilio : '.$row['domicilio'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								Transporte: '.obtenerDato($row['id_transporte'], 'transportes', ' id_transporte', 'razon_social').'
								</td>
							  </tr></table>';
							  
							  //cuerpo de la entrega 
							  $consu = "Select * from entregasdetalle Where identrega = $numeroDocumento order by tipoentrega, numero";
							  $resu = mysql_query($consu) or die(mysql_error());
							  
							  echo '<table width="100%" style="border:1px solid black;">';
									
							  $numero = 0;
							  
							  while($row = mysql_fetch_array($resu))
							  	{
									if($numero != $row['numero'])
										{
											echo '<tr><td colspan="9" height="10" ></td></tr>';
											echo '<tr><td colspan ="9" style="background-color: #CCCAAA;">'.obtenerDato($row['tipoentrega'], 'tipo_empaque', 'id_empaque', 'descripcion').' '.$row['numero'].'</td></tr>';										    
											echo '<tr style="background-color: #CCCAAA;">
														<td>Estampa</td>
														<td>Medidas</td>
														<td>Unidades</td>
														<td>Bultos</td>
														<td>Kilos</td>
														<td>Remito</td>
														<td>Factura</td>
														<td>Importe Aprox.</td>
														<td>Importe Neto</td>
													</tr>';
											$numero = $row['numero'];	
										}
									echo '<tr>
												<td>'.$row['estampa'].'</td>
												<td>'.$row['medida'].'</td>
												<td>'.$row['unidades'].'</td>
												<td>'.$row['bultos'].'</td>
												<td>'.$row['kg'].'</td>
												<td>'.$row['remito'].'</td>
												<td>'.$row['factura'].'</td>
												<td>'.$row['aprox'].'</td>
												<td>'.$row['neto'].'</td>
										 </tr>';
										 //<td>'.obtenerDato($row['tipoentrega'], 'tipo_empaque', ' id_empaque', 'descripcion').' '.$row['numero'].'</td>
								}
						break;
					//impresion del pedido
					case 4:
						//cuerpo del pedido
						$sql = "Select * from pedidos Where npedido = $numeroDocumento";
						$resu = mysql_query($sql) or(die(mysql_error()));
						$resu = mysql_fetch_array($resu);
						
						$det = "Select * from pedidosdetalle Where idPedido = $numeroDocumento";
						$resu2 = mysql_query($det) or (die(mysql_error()));
						$resu2 = mysql_fetch_array($resu2);
						
						//$cliente = "Select * from clientes Where cod_client = '".$resu['clientefact']."'";
						//$cli = mysql_query($cliente) or (die(mysql_error()));
						
						//$cli = mysql_fetch_array($cli);
						$cambio_entrega='';
						if($resu['entrega']!=$resu['entrega_original']){
							$cambio_entrega='Cambio Fecha Entrega Autorizado por Gerencia';
						}
										
						echo '<table width="100%">';//style="border:1px solid black;"
						echo '<tr>
							<td colspan="6">
								<br>
								<fieldset style="margin-right: 5px"><legend><b>Datos del Cliente<b></legend>
									<table width="100%">';
										$dato = explode('-',$resu['codigo']);
										$codigoVend = $dato[0];
										//if($resu['clientefact'] == $resu['facturarA'])
										//{
										echo '<tr>
											<td>Cliente:</td><td colspan="3"><b><div style="font-size: 20px">'.$resu['clienteNombre'].'</div></b></td>
											<td rowspan="3" style="text-align: center;"><b><div style="font-size: 25px;"> ';
											echo $codigoVend.' - '.$resu['destino'].'</div></b><br>
											Vendedor: <b>'.BuscaVendedor($codigoVend);
										echo'	</td>
										      </tr>
										      <tr>
											<td>Dirección: </td>
											<td colspan="3"><b>'.$resu['clienteDirecc'].' - </b></td> 
										      </tr>
										      <tr>
										         <td>CUIT:</td><td><b>'.$resu['clienteCUIT'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;
											 Código Tango: &nbsp;&nbsp;&nbsp;&nbsp;<b>'.$resu['facturarA'].'</b></td>
										      </tr>';
										
						echo 			'</table>
								</fieldset>
							</td>
						      </tr>';
							
						echo '<tr>
							<td width="70%">
								<br>
								<fieldset style="height: 170px;"><legend><b>Artículo</b></legend>
									<table width="100%">
										<tr>
											<td width="150px">Tipo de Producto:</td>
											<td><div style="font-size: 17px"><b>';
										        if($resu['descrip3'][0] == 'n' || $resu['descrip3'][0] == 'N')
											{
												echo "Nuevo";
											}
											else
											{
												echo "Habitual";
											}
									echo '</b></div></td>
										</tr>
										<tr>
											<td>Código:</td>
											<td><div style="font-size: 17px"><b>'.$resu['descrip3'].'</b></div></td>
										</tr>
										<tr>
											<td>Descripción:</td>
											<td><div style="font-size: 20px"><b>'.$resu['descripcion'].'</b></div></td>
										</tr>
										<tr>
											<td>Código Tango</td>
											<td><div style="font-size: 17px"><b>'.$resu['codigoTango'].'</b></div></td>
										</tr>
									</table>
								</fieldset>
							</td>
							<td >
								<br>
								<fieldset style="height: 170px;margin-right: 5px"><legend><b>Fechas</b></legend>
									<table width="100%">
										<tr style="height: 20px">
											<td>Emisión:</td>
											<td><b>'.invertirFecha($resu['femis']).'</b></td>
										</tr>
										<tr style="height: 20px">
											<td>Recepción:</td>
											<td><b>'.invertirFecha($resu['frecep']).'</b></td>
										</tr>
										<tr style="height: 20px">
											<td>Arpobación:</td>
											<td><b>'.invertirFecha($resu['faprob']).'</b></td>
										</tr>
										<tr>
											<td>
											<br>
											</td>
										</tr>
										<tr>
											<td>Entrega:</td>
											<td><div style="font-size: 20px"><b>'.invertirFecha($resu2['Fecha1']).'</b></div></td>
										</tr>
										<tr>
											<td colspan="2"><span style="color:#ff0000; font-size:13px;">'.$cambio_entrega.'</span>	</td>
										</tr>
										
									</table>
								</fieldset>
							</td>
						      </tr>'; 
						
						
						//detalle del pedido
						echo '<tr>
							<td colspan="6">
								<br>
								<fieldset style="margin-right: 5px"><legend><b>Descripción del Pedido</b></legend>
									<table width="100%">
										<tr>
											<td width="50%" valign="top">
												<fieldset style="margin-right: 5px; height: 90px;"><legend><b>Volúmen de Pedido</b></legend>
													<table width="100%">
														<tr>
															<td width="50%">Cantidad:</td>
															<td><b>'.$resu2['CantidadTotal'].'</b></td>
														</tr>
														<tr>
															<td>Unidades:</td>
															<td><b>'.obtenerDato($resu2['Unidad'],'unidades','idUnidad', 'descripcion').'</b></td>
														</tr>
														<tr>
															<td>Precio:</td>
															<td><b>'.obtenerDato($resu2['Moneda'],'monedas','idMoneda','descripcion').' '.$resu2['PrecioImporte'].' '.obtenerDato($resu2['IVA'],'condicioniva','idIVA','descripcion').'</b></td>
														</tr>
													</table>
												</fieldset>
											</td>
											<td valign="top">
												<fieldset style="margin-right: 5px; height: 90px;"><legend><b>Datos de Impresión</b></legend>
													<table width="100%">
														<tr>
															<td width="50%">Caras:</td>
															<td><b>';
																if($resu['caras'] == 0)
																echo "Sin Impresión";
																else
																if($resu['caras'] == 1) 
																	echo "1";
																	else 
																	echo "2";
														echo '  </b></td>
														<tr>
														<tr>
															<td>Tipos:</td>
															<td><b>';
															if($resu['centrada'] == "" || $resu['centrada'] == null || $resu['centrada'] == 2)
															echo "Ninguna";
															else
															if($resu['centrada'] == 1)
																echo "Centrada";
																else
																echo "Corrida";
														echo '  </b></td>
														<tr>
														<tr>
															<td>Horientación:</td>
															<td><b>';
															if($resu['apaisada'] == "" || $resu['apaisada'] == null || $resu['apaisada'] == 2)
															echo "Ninguna";
															else
															if($resu['apaisada'] == 1)
																echo "Apaisada";
																else
																echo "Normal";
														echo '  </b></td>
														<tr>
													</table>
												</fieldset>
											</td
										</tr>
										<tr>
											<td>
											<br>
												<fieldset style="margin-right: 5px;height: 280px;"><legend><b>Descripción de Producto</b></legend>
													<table width="100%">
														<tr>
															<td width="50%">Formato:</td>
															<td><b>'.obtenerDato($resu2['Formato'],'formatos','idFormato', 'descripcion').'</b></td>
														</tr>
														<tr>
															<td>Material:</td>
															<td><b>'.obtenerDato($resu2['Material'],'Materiales','idMaterial','descripcion').'</b></td>
														</tr>
														<tr>
															<td>Color Material:</b></td>
															<td><b>'.$resu2['ColorMaterial'].'</b></td>
														</tr>
														<tr>
															<td>Ancho (cm):</td>
															<td><b>'.$resu2['Ancho'].'</b></td>
														</tr>
														<tr>
															<td>Largo (cm):</td>
															<td><b>'.$resu2['Largo'].'</b></td>
														</tr>
														<tr>
															<td>Micronaje:</td>
															<td><b>'.$resu2['Micronaje'].'</b></td>
														</tr>
														<tr>
															<td>Fuelle:</td>
															<td><b>';
															if($resu2['Fuelle'] == "" || $resu2['Fuelle'] == null)
															echo "NO";
															else
															echo $resu2['Fuelle'];
															echo '</b></td>
														</tr>
														<tr>
															<td>Termo:</td>
															<td><b>';
															if($resu2['Termo'] == 1)
															echo "SI";
															else
															echo "NO";
															echo '</b></td>
														</tr>
														<tr>
															<td>Microp.:</td>
															<td><b>';
															if($resu2['Micro'] == 1)
															echo "SI";
															else
															echo "NO";
															echo '</b></td>
														</tr>
														<tr>
															<td>Origen:</td>
															<td><b>'.$resu2['PrecioPolimeros'].'</b></td>
														</tr>
														<tr>
															<td>Solapa:</td>
															<td><b>'.$resu2['PrecioPolimeros'].'</b></td>
														</tr>
														<tr>
															<td>Troquelado:</td>
															<td><b>'.($resu['tieneToquelado'] == null ? '--' : ($resu['tieneToquelado'] == '1' ? 'Si' : 'No')).'</b></td>
													</table>
												</fieldset>
											</td>
											<td valign="top">
											<br>
												<fieldset style="height: 180px;"><legend><b>Datos de Bobinado</b></legend>
													<table width="100%">
														<tr>
															<td width="50%">Sentido:</td>
															<td><b>';
															if($resu2['Bobinado'] == 1)
															echo "De Pie";
															else
																if($resu2['Bobinado'] == 2)
																echo "-";
																else
																echo "De Cabeza";
															
														echo'    </b></td>
														</tr>
														<tr>
															<td>Tratado:</td>
															<td><b>';
															if($resu2['BobinadoFuera'] == 1)
															echo "Por Fuera";
															else
																if($resu2['BobinadoFuera'] == 2)
																echo "-";
																else
																echo "Por Dentro";
														echo '  </b></td>
														</tr>
														<tr>
															<td>Dist. de Taco (cm):</td>
															<td><b>';
															if($resu2['DistanciaTaco'] != "" && $resu2['DistanciaTaco'] != null)
															echo $resu2['DistanciaTaco'];
														echo'   </b></td>
														</tr>
														<tr>
															<td>Diam. de Bobina (cm):</td>
															<td><b>';
															if($resu2['DiametroBobina'] != "" && $resu2['DiametroBobina'] != null)
															echo $resu['DiametroBobina'];
														echo'   </b></td>
														</tr>
														<tr>
															<td>Diam. de Canuto (cm):</td>
															<td><b>';
															if($resu2['DiametroCanuto'] != "" && $resu2['DiametroCanuto'] != null)
															echo $resu2['DiametroCanuto'];
														echo'   </b></td>
														</tr>
														<tr>
															<td>Kg. por Bobina:</td>
															<td><b>';
															if($resu2['KgBobina'] != "" && $resu2['KgBobina'] != null)
															echo $resu2['KgBobina'];
														echo'   </b></td>
														</tr>
														<tr>
															<td>Mts. por Bobina</td>
															<td><b>';
															if($resu2['MtsBobina'] != "" && $resu2['MtsBobina'] != null)
															echo $resu2['MtsBobina'];
														echo'   </b></td>
														</tr>
													</table>
												</fieldset>
												<fieldset style="height: 80px;"><legend><b>Datos de Vencimiento de Producto</b></legend>
													<table width="100%">
														<tr>
															<td>Envasado:</td>
															<td>'.$resu['envasado'].'</td>
														</tr>
														<tr>
															<td>Vencimiento:</td>
															<td>'.$resu['vencimiento'].'</td>
														</tr>
														<tr>
															<td>Lote:</td>
															<td>'.$resu['lote'].'</td>
														</tr>
													</table>
												</fieldset>
											</td>
										</tr>
										<tr>
											<td width="50%" valign="top">
												<br>
												<fieldset style="margin-right: 5px; height: 120px;"><legend><b>Composición de Laminado</b></legend>
													<table width="100%">
														<tr>
															<th width="25%"></th>
															<th width="25%">A</th>
															<th width="25%">B</th>
															<th width="25%">C</th>
														</tr>
														<tr>
															<td>Material:</td>
															<td style="text-align: center"><b>';
															if($resu2['Bilaminado1'] == 1)
															echo "";
															else
															{
																$consulta = 'Select descripcion From componenteslaminado Where idComponente = '.$resu2['Bilaminado1'];
																$resu = mysql_query($consulta);
																$row = mysql_fetch_array($resu);
																echo $row[0];
															}
														echo '  </b></td>
															<td style="text-align: center"><b>';
															if($resu2['Bilaminado1'] == 1)
															echo "";
															else
															{
																$consulta = 'Select descripcion From componenteslaminado Where idComponente = '.$resu2['Bilaminado2'];
																$resu = mysql_query($consulta);
																$row = mysql_fetch_array($resu);
																echo $row[0];
															}
														echo '  </b></td>
															<td style="text-align: center"><b>';
															if($resu2['Bilaminado2'] == 1)
															echo "";
															else
															{
																$consulta = 'Select descripcion From componenteslaminado Where idComponente = '.$resu2['Trilaminado'];
																$resu = mysql_query($consulta);
																$row = mysql_fetch_array($resu);
																echo $row[0];
															}
														echo '  </b></td>
														</tr>
														<tr>
															<td>Color:</td>
															<td style="text-align: center"><b>';
															if($resu2['Material1'] == 1)
															echo "";
															else
															{
																$consulta = 'Select descripcion From materialeslaminado Where idMaterialLam = '.$resu2['Material1'];
																$resu = mysql_query($consulta);
																$row = mysql_fetch_array($resu);
																echo $row[0];
															}
														echo '  </b></td>
															<td style="text-align: center"><b>';
															if($resu2['Material2'] == 1)
															echo "";
															else
															{
																$consulta = 'Select descripcion From materialeslaminado Where idMaterialLam = '.$resu2['Material2'];
																$resu = mysql_query($consulta);
																$row = mysql_fetch_array($resu);
																echo $row[0];
															}
														echo '  </b></td>
															<td style="text-align: center"><b>';
															if($resu2['Material3'] == 1)
															echo "";
															else
															{
																$consulta = 'Select descripcion From materialeslaminado Where idMaterialLam = '.$resu2['Material3'];
																$resu = mysql_query($consulta);
																$row = mysql_fetch_array($resu);
																echo $row[0];
															}
														echo '  </b></td>
														</tr>
														<tr>
															<td>Micronaje:</td>
															<td style="text-align: center"><b>'.$resu2['Micronaje1'].'</b></td>
															<td style="text-align: center"><b>'.$resu2['Micronaje2'].'</b></td>
															<td style="text-align: center"><b>'.$resu2['Micronaje3'].'</b></td>
														</tr>
													</table>
												</fieldset>
											</td>
											<td valign="top">
												<br>
												<fieldset style="margin-right: 5px; height: 120px;"><legend><b>Observaciones</b></legend>
												<b>'.$resu2['Obseervaciones'].'</b>
												</fieldset>
											</td>
										<tr>
									</table>
								</fieldset>
							</td>
						      </tr>';
						
						echo '</table>';
						break;
					//polimeros
					case 5 :
						echo '<table width="100%" style="border:1px solid black;">';
							echo '<tr>';
								echo '<td align="center" width="200" style="border:1px solid black;">Proveedor</td>';
								echo '<td align="center" width="80" style="border:1px solid black;">Etiqueta</td>';
								echo '<td align="center" width="120" style="border:1px solid black;">Trabajo</td>';
								echo '<td align="center" width="80" style="border:1px solid black;">Motivo</td>';
								echo '<td align="center" width="50" style="border:1px solid black;">Fecha</td>';
								echo '<td align="center" width="50" style="border:1px solid black;">Espesor</td>';
								echo '<td align="center" width="70" style="border:1px solid black;">Nº de Rem.</td>';
								echo '<td align="center" width="70" style="border:1px solid black;">Ped. Prod.</td>';
								echo '<td align="center" width="80" style="border:1px solid black;">Remito</td>';
								echo '<td align="center" width="70" style="border:1px solid black;">Color</td>';
								echo '<td align="center" width="80" style="border:1px solid black;">Medida</td>';
								echo '<td align="center" width="60" style="border:1px solid black;">P. Prov.</td>';
								echo '<td align="center" width="60" style="border:1px solid black;">P. Final</td>';
								echo '<td align="center" width="100" style="border:1px solid black;">Recibe</td>';
								echo '<td align="center" width="100" style="border:1px solid black;">Observaciones</td>';
							echo '</tr>';
							$condicion = $condicion = str_replace('~','\'',$numeroDocumento);
							$sql = "SELECT pr.razon_social, mr.descripcion, pol.trabajo, pol.id_motivo, pol.fecha, pol.espesor, pol.pedido_P, pol.remito_d, pol.nro_remito, pol.colores, pol.medidas, pol.precio_proveedor, pol.precio_final, pol.observacion, usu.nombre_real
							FROM polimeros pol
							INNER JOIN proveedores pr ON pr.id_proveedor = pol.id_proveedor
							INNER JOIN marca mr ON mr.idMarca = pol.id_etiqueta
							INNER JOIN usuarios usu ON usu.id_usuario = pol.id_usuario
							WHERE ".$condicion;		
							//INNER JOIN clientes cli ON cli.cod_client = pol.id_cliente
							//INNER JOIN usuarios us ON us.id_usuario = pol.id_usuario   --- 
							$resu = mysql_query($sql) or (die(mysql_error()));
							while($row = mysql_fetch_array($resu))
								{
									echo '<tr>';
										echo '<td>'.$row['razon_social'].'</td>';
										echo '<td>'.$row['descripcion'].'</td>';
										echo '<td>'.$row['trabajo'].'</td>';
										echo '<td>';
										if($row['id_motivo'] == 1)
											echo "Nuevo"; 
											else 
											echo"Pedido Reposición";
										echo '</td>';
										echo '<td>'.invertirFecha($row['fecha']).'</td>';
										echo '<td>'.$row['espesor'].'</td>';
										echo '<td>'.$row['remito_d'].'</td>';
										echo '<td>'.$row['pedido_P'].'</td>';
										echo '<td>'.$row['nro_remito'].'</td>';
										echo '<td>'.$row['colores'].'</td>';
										echo '<td>'.$row['medidas'].'</td>';
										echo '<td>'.$row['precio_proveedor'].'</td>';
										echo '<td>'.$row['precio_final'].'</td>';
										echo '<td>'.$row['nombre_real'].'</td>';
										echo '<td>'.substr($row['observacion'], 0, 20 ).'..</td>';
									echo '</tr>';
								}
								
						echo '</table>';
						break;
                    //entregas    
                    case 6 :
			
			//get data formulario
			$sql = "Select * From Polimeros where id_polimero = ".$numeroDocumento;
			$resu = mysql_query($sql) or (die(mysql_error()));
			while($row = mysql_fetch_array($resu))
			{
				//get np data
				$pedido = "Select * From Pedidos Where npedido = ".$row['idPedido'];
				$resu = mysql_query($pedido) or (die(mysql_error));
				while($ped = mysql_fetch_array($resu))
				{
					$pedido = $ped;
				}
				
				//get proveedor data
				$proveedor = "Select razon_social From Proveedores Where id_proveedor = ".$row['id_proveedor'];
				$resu = mysql_query($proveedor) or (die(mysql_error));
				while($prov = mysql_fetch_array($resu))
				{
					$proveedor = $prov;
				}
				
				if($row['idEspesor'] != "" && $row['idEspesor'] != null)
				{
					echo '<table width="100%">';//style="border:1px solid black;"
					echo '	<tr>
							<td colspan="2">
							<br>
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Cliente:</b>     '.$pedido['clienteNombre'].'</td>
									</tr>
									<tr>
										<td><b>Nota de Pedido:</b>     '.$pedido['codigo'].'</td>
									</tr>
									<tr>
										<td><b>Producto:</b>     '.$row['trabajo'].'</td>
									</tr>
								</table>
							</fieldset>
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
							<br>
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Proveedor:</b>     '.$proveedor['razon_social'].'</td>
									</tr>
									<tr>
										<td><b>Lineatura:</b>     '.$row['lineatura'].'</td>
									</tr>
									<tr>
										<td><b>Espesor:</b> ';
										$esp = "Select descEspesor from espesor Where idEspesor = ".$row['idEspesor'];
										$resu = mysql_query($esp) or (die(mysql_error));
										while($esp = mysql_fetch_array($resu))
										{
											echo $esp[0];
										}
									echo '   </td>
									</tr>
								</table>
							</fieldset>
							</td>
						</tr>
						
						<tr>
							<td width="50%">
							<br>
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Medidas:</b>     '.$row['medidas'].'</td>
									</tr>
									<tr>
										<td><b>Colores:</b>     '.$row['colores'].'</td>
									</tr>
									<tr>
										<td><b>Ptas. x Modulo:</b>     '.$row['pistas'].'</td>
									</tr>
									<tr>
										<td><b>Máquina:</b> ';
										$maq = "Select descMaquina from maquinas Where idMaquina = ".$row['idMaquina'];
										$resu = mysql_query($maq) or (die(mysql_error));
										while($maq = mysql_fetch_array($resu))
										{
											echo $maq[0];
										}
									echo   '</td>
									</tr>
									<tr>
										<td><b>Cilindro:</b>     '.$row['cilindro'].'</td>
									</tr>
									<tr>
										<td><b>Camisa de Lam.:</b>     '.$row['camisa'].'</td>
									</tr>
									<tr>
										<td><b>Ancho mat. Sugerido:</b>     '.$row['anchoSugerido'].'</td>
									</tr>
									<tr>
										<td>
											<b>AVT:</b> ';
											if (strpos($row['AVT'], '1') !== false)
												echo 'Si';
												else echo 'No';
												
											echo '<b>Banda de Refile:</b>';
											if (strpos($row['AVT'], '2') !== false)
												echo 'Si';
												else echo 'No';
											
											echo '<b>Hexag./Cuadros:</b>';
											if (strpos($row['AVT'], '3') !== false)
												echo 'Si';
												else echo 'No';
									echo '  </td>
									</tr>
									<tr>
										<td><b>Sentido de Impresión:</b>'.($row['sentido'] == 1 ? 'Frente':'Dorso').'</td>
									</tr>
									<tr>
										<td><b>Código de Barra:</b>     '.($row['barra'] == 0 || $row['barra'] == null ? 'No' : $row['barcode']).'</td>
									</tr>
								</table>
							</fieldset>
							</td>
							<td width="50%" style="vertical-align: top">
							<br>
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Calidad:</b>';
										$array = explode('/', $row['calidad']);
										foreach($array as $v)
											{
												if($v != "")
												{
													$tip = "Select descTipoPoli From tipo_polimero Where idTipoPoli = ".$v;
													$resu = mysql_query($tip) or (die(mysql_error));
													while($tip = mysql_fetch_array($resu))
													{
														echo $tip[0].' / ';
													}
												}
											}
							echo'		</tr>
								</table>
							</fieldset>
							<br>
							
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Diseño en base a:</b>';
										$str = '';
										if (strpos($row['disenioBase'], '1') !== false)
										 $str = 'Muestra';
										 
										if (strpos($row['disenioBase'], '2') !== false)
										 if($str == '')
											$str = 'Archivo/PDF';
											else
											$str = $str.' y Archivo/PDF';
										echo $str;
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Detalla Vendedor:</b>';
										$str = '';
										if (strpos($row['detallaVend'], '1') !== false)
										 $str = 'Por Mail / ';
										 
										if (strpos($row['detallaVend'], '2') !== false)
										 $str = 'Personalmente / ';
										 
										if (strpos($row['detallaVend'], '3') !== false)
										 $str = 'Teléfono';
										echo $str;
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Detalla Cliente:</b>';
										$str = '';
										if (strpos($row['detallaClien'], '1') !== false)
										 $str = 'Por Mail / ';
										 
										if (strpos($row['detallaClien'], '2') !== false)
										 $str = 'Personalmente / ';
										 
										if (strpos($row['detallaClien'], '3') !== false)
										 $str = 'Teléfono';
										echo $str;
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Gerencia:</b>';
										$str = '';
										if (strpos($row['detallaGeren'], '1') !== false)
										 $str = 'Por Mail / ';
										 
										if (strpos($row['detallaGeren'], '2') !== false)
										 $str = 'Personalmente / ';
										 
										if (strpos($row['detallaGeren'], '3') !== false)
										 $str = 'Teléfono';
										echo $str;
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Producción:</b> ';
										$str = '';
										if (strpos($row['detallaProd'], '1') !== false)
										 $str = 'Por Mail / ';
										 
										if (strpos($row['detallaProd'], '2') !== false)
										 $str = 'Personalmente / ';
										 
										if (strpos($row['detallaProd'], '3') !== false)
										 $str = 'Teléfono';
										echo $str;
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Impresión:</b> ';
										$str = '';
										if (strpos($row['detallaImp'], '1') !== false)
										 $str = 'Por Mail / ';
										 
										if (strpos($row['detallaImp'], '2') !== false)
										 $str = 'Personalmente / ';
										 
										if (strpos($row['detallaImp'], '3') !== false)
										 $str = 'Teléfono';
										echo $str;
									echo 	'</td>
									</tr>
								</table>
							</fieldset>
							</td>
						</tr>
						<tr>
							<td width="50%">
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Diseño:</b>';
										switch($row['disenio'])
										{
											case 1:
												echo 'Nuevo';
												break;
											case 2:
												echo 'C/Modificación';
												break;
											case 3:
												echo 'Variador';
												break;
										}
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Estado de Pol. en Planta:</b>';
										if($row['estadoPolPlanta'] != 0)
										{
											switch($row['estadoPolPlanta'])
											{
												case 1:
													echo 'Verificar';
													break;
												case 2:
													echo 'Reponer Todo';
													break;
												case 3:
													echo 'Buen Estado';
													break;
											}
											echo '  Reponer'.$row['reponer'];
										}
										else
										{echo '-';}
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Solicitar Muestra a:</b>';
										
										if($row['muestra'] != 0)
										{
											switch($row['muestra'])
											{
												case 1:
													echo 'Producción';
													break;
												case 2:
													echo 'Cliente';
													break;
												case 3:
													echo 'Ventas';
													break;
												case 4:
													echo 'Preprensa';
													break;
											}
										}
										else
										{echo '-';}
										
									echo 	'</td>
									</tr>
									<tr>
										<td><b>Fecha a Entregar Polímero:</b>    '.$row['fechaEnt'].'</td>
									</tr>
									<tr>
										<td><b>Presupuesto Aproximado:</b>     '.$row['presupuesto'].'</td>
									</tr>
								</table>
							</fieldset>
							</td>
							<td width="50%" style="vertical-align: top">
							<fieldset style="margin-right: 5px">
								<table width="100%">
									<tr>
										<td><b>Requiere reunón:</b>     '.($row['reunion'] == 1 ? 'Si' : 'No').'</td>
									</tr>
									<tr>
										<td><b>Detalles:</b>     '.$row['observacion'].'</td>
									</tr>
								</table>
							</fieldset>
							</td>
						</tr>
					      </table>';
				}
				else
				{
					echo '<b style="color: red; font-size: 95px;">Polímero sin datos</b>';
				}
			}
			break;
                    //pedidos
                    case 7 :
                        echo '<table>';										    
                        echo '<tr>
                    			<td>Nro Pedido</td>
                				<td>Cliente</td>				
                				<td>Articulo</td>
                				<td>Estado</td>
                				<td>Fecha</td>
                      		   </tr>';
                            
                            if(substr_count($numeroDocumento,"@@@") > 0)
                                {
                                    $sql = str_replace("@@@", "", $numeroDocumento);    
                                }
                                else
                                {
                                    $condicion = str_replace('~','\'',$numeroDocumento);
                                    
                                    $sql = "SELECT ped.npedido id, ped.codigo nro, cli.razon_soci clie, art.Articulo arti, fac.razon_soci fact, ped.femis fecha, ped.estado estado
                                    FROM pedidos ped 
                                    INNER JOIN pedidosdetalle det ON det.idPedido = ped.npedido
                                    INNER JOIN clientes cli ON cli.cod_client = ped.clientefact
                                    INNER JOIN articulos art ON art.Id = ped.descrip3
                                    INNER JOIN clientes fac ON fac.cod_client = ped.facturarA 	
                                    WHERE ".$condicion;
                                    
	
                                }
                                
					 
                            
                            $resu = mysql_query($sql) or (die(mysql_error()));
							while($row = mysql_fetch_array($resu))
								{
									echo '<tr>
                                            <td>'.$row['nro'].'</td>
            								<td>'.$row['clie'].'</td>
            								<td>'.$row['arti'].'</td>
            								<td>'.DeterminaEstado($row['estado']).'</td>
            								<td>'.invertirFecha($row['fecha']).'</td>';
									echo '</tr>';
								}
                        echo '</table>';
                        break;    
						
					}
					
				echo '</table>';
			}
		//fin de los metodos o funciones de la clase
	}

///funciones -------------

function obtenerDato($id,$tabla,$campo,$campoRetorno)
		{
		 if($id != 0)
			{
			 $consulta = 'Select '.$campoRetorno.' From '.$tabla.' Where '.$campo.' = '.$id;
			 $resu = mysql_query($consulta);
			 $row = mysql_fetch_array($resu);
			 return $row[0];
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
		if($date != "" && $date != null && $date != "Pendiente")
		{
		$dato = explode('-',$date);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
		}
		else
		return "-";
	}
    
function DeterminaEstado($estado)
    {
        switch($estado)
            {
                case "I":
                    return "Ingresado";
                    break;
                case "A":
                    return "Aceptado";
                    break;
                case "V":
                    return "Aprobado";
                    break;
                case "T":
                    return "Terminado";
                    break;
                case "EP":
                    return "Ter.Parcial";
                    break;
                default:
                    return "Sin Estado";
                    break;
            }
    }
    
function BuscaVendedor($id)
{
	if($id != '')
		{
			$consulta = "Select nombre From usuarios Where nombre like '".$id."%'";
			$resu = mysql_query($consulta);
			$row = mysql_fetch_array($resu);
			return $row[0];
		 }else
		 	{
				return '-';
			}
}
///fin funciones ---------
?>