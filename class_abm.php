<?php

class abm
	{
		function listado($nombreTabla)
			{
			 $var = new conexion();
			 $var->conectarse();
			 
			 $consulta1 = "Select * from tbl_tablas where descripcion ='".$nombreTabla."'";
			 $resu = mysql_query($consulta1);
			 
			 if(mysql_num_rows($resu) != 1)
			 	{
					echo'<script>alert("Error en lectura de tabla.");location.href="principal.php";</script>';
				}else
					{
					 $row = mysql_fetch_array($resu); 
					 $consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden ";
					 $resu2 = mysql_query($consulta2) or die(mysql_error());
					 
					 if(mysql_num_rows($resu2)== 0)
					 	{
							
							echo'<script>alert("Campos de tabla no asignados.");location.href="principal.php";</script>';
						}else
							{//echo "<p><br>";
							 echo '<p><label>Buscar: &nbsp;&nbsp;</label>';
							 echo "<input type=\"text\" id=\"buscador\" name=\"buscador\" size=\"60\" onkeyup=\"ajax2(this.value,'div_find','buscar.php','".$nombreTabla."');\"/>";
							 //echo "<input type=\"text\" id=\"buscador\" name=\"buscador\" size=\"60\" onkeyup=\"ajax2(this.value,\'div_find\',\'buscar.php\','cadena')\"/></br>";
							 
							 
							 echo "&nbsp;&nbsp;&nbsp;<input type=\"button\" name=\"nuevo\" value=\"Nuevo\"  class=\"button\" onClick=\"AbrirVentana('$nombreTabla','I','0')\"> <input type=\"button\" value=\"Principal\" class=\"button\" onClick=\"principalL()\"></p></p>";
							
							//comienzo div de grilla 
							echo '<div id="div_find">';
							
							echo '<table border="1"> <thead><tr>';
							//campos que se muestran
							$campos = "";
							//--
							
							//campo id de la tabla 
							$cons = "SELECT COLUMN_NAME
									FROM INFORMATION_SCHEMA.COLUMNS
									WHERE table_name = '$nombreTabla'
									AND table_schema = 'mi000652_empaque1'
									AND COLUMN_KEY = 'PRI'";
									
							$re = mysql_query($cons);
							$aux = mysql_fetch_array($re);
							$campos .= $aux[0];
							
							//--
 							//area encabezado
												
							 while($row = mysql_fetch_array($resu2))
							 	{
								 if($row['visible'] == 1)
								 	{
									 echo '<td><label>'.htmlentities($row['nombreMuestra']).'</label></td>';
									 $campos .= ",".$row['nombreCampo'];
									}else
										{
										 echo '';
										}
								}
							echo '<td><label>Editar</label></td><td><label>Eliminar</label></td></tr></thead>';
							
							//area cuerpo
							$consulta3 = "Select $campos from ".$nombreTabla;
							$resu3 = mysql_query($consulta3);
							echo"<tbody>";
							if(mysql_num_rows($resu3) <= 0)
								{
								 echo '<tr><td colspan="10"></td></tr>';
								}else
									{
										while($row_1 = mysql_fetch_array($resu3))
											{
											echo '<tr>';
											 $i = 0;
											 foreach($row_1 as $value)
    											{
													if($i>1)
														{
														if($i%2)
															{
															 echo '<td>'.htmlentities($value).'</td>';
															}
														}
													$i++;
												}
											//editar 
											echo "<td onClick=\"AbrirVentana('$nombreTabla','U','$row_1[0]')\" ><img src=\"./assest/plugins/buttons/icons/pencil.png\" width='15' heigth='15' /></td>";
											//--
											
											//eliminar
											echo "<td onClick=\"AbrirVentana('$nombreTabla','D','$row_1[0]')\"><img src=\"./assest/plugins/buttons/icons/cancel.png\"   width='15' heigth='15' /></td>";
											//--
											 echo '</tr>';
											}
									}
							 echo '</tbody></table>';
							 
							 //fin div de grilla 
							 echo '</div>';
							 
							}
					}
			}
			
		function listado_grupo($nombreTabla)
			{
			 $var = new conexion();
			 $var->conectarse();
			 
			 $consulta1 = "Select * from tbl_tablas where descripcion ='".$nombreTabla."'";
			 $resu = mysql_query($consulta1);
			 
			 if(mysql_num_rows($resu) != 1)
			 	{
					echo'<script>alert("Error en lectura de tabla.");location.href="principal.php";</script>';
				}else
					{
					 $row = mysql_fetch_array($resu); 
					 $consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden ";
					 $resu2 = mysql_query($consulta2) or die(mysql_error());
					 
					 if(mysql_num_rows($resu2)== 0)
					 	{
							
							echo'<script>alert("Campos de tabla no asignados.");location.href="principal.php";</script>';
						}else
							{
							
							//comienzo div de grilla 
							echo '<div id="div_find">';
							
							echo '<table class="table table-hover"> <thead><tr>';
							//campos que se muestran
							$campos = "";
							//--
							
							//campo id de la tabla 
							$cons = "SELECT COLUMN_NAME
									FROM INFORMATION_SCHEMA.COLUMNS
									WHERE table_name = '$nombreTabla'
									AND table_schema = 'mi000652_empaque1'
									AND COLUMN_KEY = 'PRI'";
									
							$re = mysql_query($cons);
							$aux = mysql_fetch_array($re);
							$campos .= $aux[0];
							
							//--
 							//area encabezado
												
							 while($row = mysql_fetch_array($resu2))
							 	{
								 if($row['visible'] == 1)
								 	{
									 echo '<th>'.htmlentities($row['nombreMuestra']).'</th>';
									 $campos .= ",".$row['nombreCampo'];
									}else
										{
										 echo '';
										}
								}
							echo '<th>Editar</th><th>Eliminar</th></tr></thead>';
							
							//area cuerpo
							$consulta3 = "Select $campos from ".$nombreTabla;
							
							$resu3 = mysql_query($consulta3);
							echo"<tbody>";
							if(mysql_num_rows($resu3) <= 0)
								{
								 echo '<tr><td></td></tr>';
								}else
									{
										while($row_1 = mysql_fetch_array($resu3))
											{
											echo '<tr>';
											 $i = 0;
											 foreach($row_1 as $value)
    											{
													if($i>1)
														{
														if($i%2)
															{
															 if($value == "0")
															 echo '<td style="text-align: center;">No</td>';
															 else
															 if($value == "1")
															 echo '<td style="text-align: center;">Si</td>';
															 else
															 echo '<td>'.htmlentities($value).'</td>';
															}
														}
													$i++;
												}
											//editar 
											echo "<td onClick=\"AccionGrupo('U','$row_1[0]')\" style=\"text-align: center;\">
												<img src=\"./assest/plugins/buttons/icons/pencil.png\" width='15' heigth='15' title=\"Editar\" style=\"cursor:pointer\"/>
											      </td>";
											//--
											
											//eliminar
											echo "<td onClick=\"AccionGrupo('D','$row_1[0]')\" style=\"text-align: center;\">
												<img src=\"./assest/plugins/buttons/icons/cancel.png\"   width='15' heigth='15' title=\"ELiminar\" style=\"cursor:pointer\"/>
											      </td>";
											//--
											 echo '</tr>';
											}
									}
							 echo '</tbody></table>';
							 
							 //fin div de grilla 
							 echo '</div>';
							 
							}
					}
			}
			
		function listadoPedido($accion,$nombre, $pagina, $query)
			{
			 $esAdmin = $_SESSION['admin'];
			 $var = new conexion();
			 $var->conectarse();
			 
			 $nombreTabla = "pedidos";
			 $consulta1 = "Select * from tbl_tablas where descripcion ='".$nombreTabla."'";
			 $resu = mysql_query($consulta1);
			 
			 if(mysql_num_rows($resu) != 1)
			 	{
					echo'<script>alert("Error en lectura de tabla.");location.href="principal.php";</script>';
				}else
					{
					 $row = mysql_fetch_array($resu); 
					 $consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden ";
					 $resu2 = mysql_query($consulta2) or die(mysql_error());
					 
					 if(mysql_num_rows($resu2)== 0)
					 	{
							echo'<script>alert("Campos de tabla no asignados.");location.href="principal.php";</script>';
						}else
							{
							//comienzo div de grilla
							echo '<div id="div_find">';
							
							echo '<div style="min-height: 430px;">';
							echo '<table class="table table-hover"> <thead><tr>';
							//campos que se muestran
							$campos = "";
							//--
							
							//campo id de la tabla 
							$cons = "SELECT COLUMN_NAME
									FROM INFORMATION_SCHEMA.COLUMNS
									WHERE table_name = '$nombreTabla'
									AND table_schema = 'mi000652_empaque1'
									AND COLUMN_KEY = 'PRI'";
									
							$re = mysql_query($cons);
							$aux = mysql_fetch_array($re);
							$campos .= $aux[0];
							
							//--
 							//area encabezado
							
							echo '<th></th>';												
							 while($row = mysql_fetch_array($resu2))
							 	{
								 if($row['visible'] == 1)
								 	{
									 echo '<th>'.htmlentities($row['nombreMuestra']).'</th>';
									 if($row['tipo'] == "date")
										{ 
										    $campos .= ",Date_format( ".$row['nombreCampo'].", '%d-%m-%Y' ) AS ".$row['nombreCampo'];
										}
										else
										{
										    $campos .= ",".$row['nombreCampo'];    
										}
									}else
										{
										 echo '';
										}
								}
							switch($accion)
								{
								 case "I": //ingresados o generados
								 		if($esAdmin == 1)
								 		echo "<th style=\"width: 20px;\">Emisión<th>Recibir</th><th>Rehacer</th><th>Cancelar</th><th>Motivos</th></tr></thead>";
										else
										echo "<th style=\"width: 60px;\">Emisión<th>Editar</th><th>Motivos</th></tr></thead>";
										break;	
								 case "A": //Recibidos
								 		echo "<th style=\"width: 60px;\">Recepción</th><th>Producción</th><th>Rehacer</th><th>Cancelar</th><th>Motivos</th></tr></thead>";
										break;
								 case "P": //produccion 
										echo "<th style=\"width: 60px;\">Producción</th>
										      <th style=\"width: 60px;\">Hora</th>
										      <th>Poner en Curso</th>
										      <th>Devolver</th>
										      <th></th><th></th><th></th></tr></thead>";
										break;
								 case "V": //aprobados
								 case "U": //curso
								 		echo "<th style=\"width: 60px;\">Curso</th><th style=\"text-align: center\" width=\"50px;\">Terminar</th><th style=\"text-align: center\" width=\"50px;\">Cancelar</th><th></th></tr></thead>";
										break;
								 case "EH"://Editar hoja de ruta
										echo "<th style=\"width: 60px;\">Curso</th><th style=\"text-align: center\" width=\"50px;\">Editar</th><th></th></tr></thead>";
										break;
								 case "T": //terminados
								 		echo "<th style=\"width: 60px;\">Reactivar</th><th>Cont.Entrega</th></tr></thead>";
										break;
								 case "EP": //terminados Parcialmente
								 		echo "<th style=\"width: 60px;\">Entregado</th><th style=\"width: 60px;\">Cancelar</th></tr></thead>";
										break;
								 case "N": //productos nuevos (diseño)
										echo "
										      <th style=\"width: 8;\">Diseño</th>
										      <th style=\"width: 8;\">Cliente</th>
										      <th style=\"text-align: center\" >Aprobación</th>
										      <th style=\"text-align: center\" >Generar Polimero</th>
										      
										      <th style=\"text-align: center\" >Rehacer</th>
										      <th style=\"text-align: center\" >Motivos</th>
										      <th></th>
										      <th></th>
										      </tr></thead>";
										      //<th style=\"text-align: center\" >Polimero</th>
										break;
								 case "AP": //productos pendientes de aprobación
										echo "<th style=\"text-align: center\" width=\"60px;\" >Aprobación</th>
										      <th style=\"text-align: center\" width=\"50px;\">Aprobado</th>
										      <th style=\"text-align: center\" width=\"50px;\">No Aprobado</th>
										      <th style=\"text-align: center\" width=\"50px;\">Motivos</th>
										      <th></th>
										      <th></th>
										      </tr></thead>";
										break;
									
								case "PO": //polimeros para aprobar su calidad
										echo "<th style=\"text-align: center\" width=\"50px;\">Aprobado</th>
										      <th style=\"text-align: center\" width=\"50px;\">No Aprobado</th>
										      <th style=\"text-align: center\" width=\"50px;\">Motivos</th></tr></thead>";
										break;
									
								case "PA": //asociar pedido con polímero
										echo "<th style=\"text-align: center\" width=\"70px;\">Asoc. Polimero</th></tr></thead>";
										break;
									
								case "E": //editar precio de pedido
										echo "<th style=\"text-align: center\" width=\"70px;\">Editar Precio</th></tr></thead>";
										break;
								case "CL": //Aprobación del cliente
										echo "<th style=\"text-align: center\" width=\"70px;\">Aprobado</th>
										      <th style=\"text-align: center\" width=\"70px;\">Rechazado</th>
										      <th style=\"text-align: center\" width=\"50px;\"></th></tr></thead>";
										break;
								case "TN": //Trabajos Nuevos
										echo "<th style=\"text-align: center\">Estado</th><th></th><th></th></tr></thead>";
										break;
								case "DE": //devoluciones
									echo "<th></th><th></th><th style=\"text-align: center\">Motivo</th><th></th></tr></thead>";
								}
							//area  cuerpo
							$search_by_txt = "";
							if($query != "")
							{
								$search_by_txt = " and (codigo like '%".$query."%' ";
								$search_by_txt .= " or clienteNombre like '%".$query."%' ";
								$search_by_txt .= " or descripcion like '%".$query."%') ";
							}
							
							$cantidad = 0;
							$accionConsulta = "";
								switch($accion)
								{
									case "I":
										$accionConsulta = " (estado ='".$accion."' or estado = 'R' or estado = 'E' or estado = 'RR') ";
										break;
									
									case "A":
										$accionConsulta = " (estado ='A' or estado = 'D' or estado = 'RN') ";
										break;
									
									case "P":
										$accionConsulta = " ((estado ='".$accion."' or estado = 'NS' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PR') ) and (polimeroEnFacturacion = '1') or
												    ((estado ='".$accion."' or estado = 'NS' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PR') ) and (polimeroEnFacturacion = '') or
												    ((estado ='".$accion."' or estado = 'NS' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PR') ) and (polimeroEnFacturacion = '2') ";
										break;
									
									case "U":
										$accionConsulta = " (estado ='".$accion."' or estado = 'TP' or estado = 'RA') and (polimeroEnFacturacion = '2' or polimeroEnFacturacion = '' or polimeroEnFacturacion = '1')";
										break;
									
									case "EH":
										$accionConsulta = " estado ='U' and (polimeroEnFacturacion = '2' or polimeroEnFacturacion = '' or polimeroEnFacturacion = '1')";
										break;
									
									case "N":
										$accionConsulta = " (estado ='".$accion."' or estado = 'NS' or estado = 'AP' or estado = 'SI' or estado = 'NO' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PX' or estado = 'U' or estado = 'MO' or estado = 'RV' or estado = 'DI' or estado = 'CL' or estado = 'NC' or estado = 'CP' or (estado = 'CA' and calidad = 'CA')) and (calidad != 'PR' and calidad != 'PA') and (estado != 'U' and calidad !='X')";
										break;
									case "TN":
										$accionConsulta = " (estado ='N' or estado = 'NS' or estado = 'AP' or estado = 'SI' or estado = 'NO' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PX' or estado = 'U' or estado = 'MO' or estado = 'RV' or estado = 'DI' or estado = 'CL' or estado = 'NC' or estado = 'CP' or (estado = 'CA' and calidad = 'CA')) and (calidad != 'PR' and calidad != 'PA') and (estado != 'U' and calidad !='X')";
										break;
									
									case "PA":
										$accionConsulta = " (estado = 'T') ";
										break;
									
									case "E":
										$accionConsulta = "(estado != 'T' and estado != 'C')";
										break;
									
									case "AP":
										$accionConsulta = "(estado = 'AP' or estado = 'RV')";
										break;
									
									case "CL":
										$accionConsulta = "estado = '".$accion."'";
										break;
									
									case "TO":
										$accionConsulta = "estado != '1'";
										break;
									
									case "DE":
										$accionConsulta = "estado = 'D'";
										break;
									
									default:
										$accionConsulta = "estado ='".$accion."'";
										break;
								}
							
							if($esAdmin == 1)
								{												  
									if($accion == 'V')
									{
									$consulta3 = "Select $campos, razon_soci, descripcion as Articulo,estado, caras from ".$nombreTabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												   
												  where (estado='$accion' or estado='TP') order by codigo Limit ".($pagina * 10).",10";
												  
									$consultaCantidad = "Select count(*) from ".$nombreTabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												   
												  where (estado='$accion' or estado='TP')";
									}
									else
									{
										switch($accion)
										{
											case 'I':
											case 'R':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( femis, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras,
															hojaruta,

															(Select Count(*) From tbl_log_pedidos Where (pedidoEstado = 'R' or pedidoEstado = 'RR' or pedidoEstado = 'RN' or pedidoEstado = 'NO' or pedidoEstado = 'PX' or pedidoEstado = 'D' or pedidoEstado = 'NC') and pedidoId = npedido) as devolucion
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";	
												break;
											
											case 'A':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( frecep, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras,
															(Select Count(*) From tbl_log_pedidos Where (pedidoEstado = 'R' or pedidoEstado = 'RR' or pedidoEstado = 'RN' or pedidoEstado = 'NO' or pedidoEstado = 'PX' or pedidoEstado = 'D' or pedidoEstado = 'NC') and pedidoId = npedido) as devolucion
														From
															".$nombreTabla." 
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";
												break;
											
											case 'P':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															descrip3 as code,
															estado,
															calidad,
															Date_format( faprob, '%d-%m-%Y' ) as fecha,
															Date_format( fecdisenio, '%d-%m-%Y' ) as fecha1,
															polimeroEnFacturacion,
															prodHabitual,
															poliNumero,
															version,
															estaImpreso,
															poliNumero as polId,
															caras,
															marcarComoDevuelta,
															hojaruta

														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and version >=2) ".$search_by_txt."
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and version >=2) ".$search_by_txt."";
												break;
											
											case 'DE':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															descrip3 as code,
															estado,
															calidad,
															Date_format( faprob, '%d-%m-%Y' ) as fecha,
															Date_format( fecdisenio, '%d-%m-%Y' ) as fecha1,
															polimeroEnFacturacion,
															prodHabitual,
															poliNumero,
															version,
															estaImpreso,
															poliNumero as polId,
															caras,
															seDevolvio
														From
															".$nombreTabla."
														Where
															(seDevolvio is not null and estado != 'C' )".$search_by_txt."
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (seDevolvio is not null) ".$search_by_txt."";
												break;
											
											case 'N':
											case 'TN':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( fecdisenio, '%d-%m-%Y' ) as fecha,
															calidad,
															prodHabitual,
															poliNumero,
															version,
															estaImpreso,
															seCargoHRCI,
															poliNumero as polId,
															caras,
															marcarComoDevuelta
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and version <= 1) ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and version <= 1) ".$search_by_txt."";
													  
												break;
											
											case 'U':
											case 'EH':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( feccurso, '%d-%m-%Y' ) as fecha,
															calidad,
															polimeroEnFacturacion,
															esCI,
															cantidad_entregadas,
															kg_entregados,
															bultos_entregados,
															prodHabitual,
															ImporteFactPolimero,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
 														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";
												break;
											
											case 'AP':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( fecestadoap, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";
												break;
											
											case 'PO':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															calidad = 'PO' ".$search_by_txt."
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";
												break;
											
											case 'E':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( fecestadoap, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";
												break;
											
											case 'CL':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( fecestadoap, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";
												break;
											
											case 'TO':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( femis, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";	
												break;
											
											case 'T':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(".$accionConsulta.") ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta.") ".$search_by_txt."";	
												break;
											
											default:
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															prodHabitual,
															poliNumero as polId,
															caras
														From
															".$nombreTabla."
														Where
															(calidad = 'PA' and (poliNumero = '' or poliNumero = null)) ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (calidad = 'PA' and (poliNumero = '' or poliNumero = null)) ".$search_by_txt."";
												break;
										}
									}
								}
								else
								{											  
									if($accion == 'V')
									{
									$consulta3 = "Select $campos, razon_soci, descripcion as Articulo,estado ,
															poliNumero as polId, caras from ".$nombreTabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												   
												  where (estado='$accion' or estado='TP') and pedidos.codigo REGEXP '^".$nombre."' order by codigo Limit ".($pagina * 10).",10";
												  
									$consultaCantidad = "Select count(*) from ".$nombreTabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												   
												  where (estado='$accion' or estado='TP') and pedidos.codigo REGEXP '^".$nombre."'";
									}
									else
									{	switch($accion)
										{
											case 'I':
											case 'R':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( femis, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras,
															hojaruta,
															(Select Count(*) From tbl_log_pedidos Where (pedidoEstado = 'R' or pedidoEstado = 'RR' or pedidoEstado = 'RN' or pedidoEstado = 'NO' or pedidoEstado = 'PX' or pedidoEstado = 'D' or pedidoEstado = 'NC') and pedidoId = npedido) as devolucion
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
														     
												break;
											
											case 'A':
												$consulta3 = "Select $campos, razon_soci, descripcion as Articulo,estado, Date_format( frecep, '%d-%m-%Y' ) as fecha,
															poliNumero as polId, caras from ".$nombreTabla." 
													  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
													   
													  where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." order by codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select count(*) from ".$nombreTabla." 
															INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
															 
															where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												break;
											
											case 'P':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															descrip3 as code,
															estado,
															calidad,
															Date_format( faprob, '%d-%m-%Y' ) as fecha,
															Date_format( fecdisenio, '%d-%m-%Y' ) as fecha1,
															polimeroEnFacturacion,
															prodHabitual,
															version,
															estaImpreso,
															poliNumero as polId,
															caras,
															marcarComoDevuelta,
															hojaruta 
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and version >= 2 and
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 													
														Order By
															codigo Limit ".($pagina * 10).",10";
													
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and version >= 2 and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												break;
											
											case 'DE':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															descrip3 as code,
															estado,
															calidad,
															Date_format( faprob, '%d-%m-%Y' ) as fecha,
															Date_format( fecdisenio, '%d-%m-%Y' ) as fecha1,
															polimeroEnFacturacion,
															prodHabitual,
															version,
															estaImpreso,
															poliNumero as polId,
															caras,
															seDevolvio,
															hojaruta 
														From
															".$nombreTabla."
														Where
															(seDevolvio is not null and estado != 'C' and 
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 													
														Order By
															codigo Limit ".($pagina * 10).",10";
															
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (seDevolvio is not null and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												break;
											
											case 'N':
											case 'TN':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( fecdisenio, '%d-%m-%Y' ) as fecha,
															calidad,
															prodHabitual,
															poliNumero,
															version,
															estaImpreso,
															seCargoHRCI,
															poliNumero as polId,
															caras,
															marcarComoDevuelta,
															hojaruta  
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and version <= 1 and
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and version <= 1 and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
													  
												break;
											
											case 'U':
											case 'EH':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( feccurso, '%d-%m-%Y' ) as fecha,
															calidad,
															polimeroEnFacturacion,
															esCI,
															cantidad_entregadas,
															kg_entregados,
															bultos_entregados,
															prodHabitual,
															ImporteFactPolimero,
															prodHabitual,
															poliNumero as polId,
															caras, 
															hojaruta  
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												
												break;
											
											case "AP":
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( fecestadoap, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero,
															poliNumero as polId,
															caras,
															hojaruta  
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												break;
											
											case "PO":
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															prodHabitual,
															poliNumero as polId,
															caras,
															hojaruta  
														From
															".$nombreTabla."
														Where
															(".$accionConsulta." and
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												break;
											
											case 'TO':
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															Date_format( femis, '%d-%m-%Y' ) as fecha,
															prodHabitual,
															poliNumero as polId,
															caras,
															hojaruta  
														From 
															".$nombreTabla."
														Where
															(".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
													  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (".$accionConsulta." and pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
														     
												break;
											
											default:
												$consulta3 = "Select
															npedido, 
															codigo,
															clienteNombre,
															descripcion as Articulo,
															estado,
															prodHabitual,
															poliNumero as polId,
															caras,
															hojaruta  
														From
															".$nombreTabla."
														Where
															(calidad = 'PA' and (poliNumero = '' or poliNumero = null) and
															pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt." 
														Order By
															codigo Limit ".($pagina * 10).",10";
																  
												$consultaCantidad = "Select
															Count(*)
														     From ".$nombreTabla." 
														     Where (calidad = 'PA' and (poliNumero = '' or poliNumero = null) and
														     pedidos.codigo REGEXP '^".$nombre."') ".$search_by_txt."";
												
												break;
											
										}
									}
								}
							//echo $consulta3."<br>";
							$resu3 = mysql_query($consulta3);
							echo"<tbody>";
							if(mysql_num_rows($resu3) <= 0)
								{
								 echo '<tr><td colspan="10"></td></tr>';
								}else
									{
										$cant = mysql_query($consultaCantidad);
										$fila = mysql_fetch_array($cant);
										$cantidad = $fila[0];
										
										while($row_1 = mysql_fetch_array($resu3))
											{
											 
											 switch($row_1['estado'])
											 {
												case "R":
													echo '<tr class="error">';
													break;
												
												case "RR":
												case "RN":
												case "PX":
													echo '<tr style="background-color : #B40431">';
													break;
												
												case "D":
													echo '<tr class="warning">';
													break;
												
												case "NS":
												case "SI":
													echo '<tr class="info">';
													break;
												
												case "B":
													if(isset($row_1['calidad']))
													   {
														if($row_1['calidad'] == 'PX')
														{
															echo '<tr style="background-color : #B40431">';
														}
														else
														{
															echo '<tr class="nuevo">';	
														}
													   }
													   else
													   {
														echo '<tr class="nuevo">';
													   }
													break;
												
												case "TP":
												case "RA":
													echo '<tr class="tp">';
													break;
												
												case "NO":
													echo '<tr style="color: red;">';
													break;
												
												case "MO":
												case "RV":
													echo '<tr class="warning">';
													break;
												default:
													echo '<tr>';
													break;
											 }
											 
											 if($row_1['prodHabitual'] == 1)
											  echo '<td width="15px;">'.ArmarPolimeroLog($row_1['polId'], $row_1['codigo'], $row_1['clienteNombre'], $row_1['caras']).'</td>';
											  else
											 echo '<td width="15px;"></td>';
											 
											 echo '<td width="90px;">
												<a onClick="Seguimiento(\''.$row_1[0].'\', \''.$row_1['codigo'].'\')" style="cursor: pointer;">'.$row_1['codigo'].'</a>
											       </td>';
											 echo '<td>'.$row_1['clienteNombre'].'</td>';
											 echo '<td>'.$row_1['Articulo'].'</td>';

												if($accion == 'P')
												{
													echo '<td style="text-align: center">'.$row_1['fecha'].'</td>';
													echo '<td style="text-align: center">'.BuscarHora($row_1[0]).'</td>';
												}
												else
												{
													if($accion != 'PO' && $accion != 'PA' && $accion != 'E' && $accion != 'CL' && $accion != "TN" && $accion != 'TO' && $accion != 'T' && $accion != 'DE')
													echo '<td width="60px;" style="text-align: center;">'.$row_1['fecha'].'</td>';
												}
											 
											switch($accion)
												{
												  case "I": //ingresados
												  		if($esAdmin == 1)
														{
															if($row_1['estado'] == 'R')
															{
																echo '<td width=\"50px;\"></td><td width=\"50px;\"></td>';
															}
															else
															{
																echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','A')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/add.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																echo "<td onClick=\"AbrirPopPedidos('$row_1[0]','".$accion."')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
															}
															
															echo "<td onClick=\"AbrirPopPedidosCancel('$row_1[0]','C')\" style=\"text-align: center\" width=\"50px;\">
																<img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
															
														}
														else
															{
																echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','E')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/pencil.png\" style=\"cursor: pointer;\" width=\"15\" heigth=\"15\" /></td>";
																
															}
														if($row_1['devolucion'] > 0)
															echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
															else
																echo "<td width=\"50px;\"></td>";
														break;
												
												  case "P": //produccion
														if($row_1['estado'] != 'NS' && $row_1['estado'] != 'SI' && $row_1['estado'] != 'NO' && $row_1['estado'] != 'U')
															{
																if($row_1['estaImpreso'] != 0)
																{
																	if(substr($row_1['code'], 0,1) == 'n')
																	{
																		echo "<td onClick=\"AbrirPop('$row_1[0]','UA')\" style=\"text-align: center\" width=\"50px;\">
																		<img src=\"./assest/plugins/buttons/icons/tick.png\" width=\"15\" heigth=\"15\" /></td>"; 
																	}
																	else
																	{
																		echo "<td onClick=\"AbrirPop('$row_1[0]','U')\" style=\"text-align: center\" width=\"50px;\">
																		<img src=\"./assest/plugins/buttons/icons/tick.png\" width=\"15\" heigth=\"15\" /></td>";	
																	}
																	//echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','D')\" style=\"text-align: center\" width=\"50px;\">
																	//	<img src=\"./assest/plugins/buttons/icons/page_red.png\" width=\"15\" heigth=\"15\" /></td>";
																}
																else
																{
																	echo '<td></td>';
																}
																echo "<td class='td_dev' data-id='".$row_1['npedido']."' data-action='D' data-rh='".(($row_1['hojaruta']!='')?$row_1['hojaruta']:'')."' style='text-align: center' width='50px'>
																		<img src='./assest/plugins/buttons/icons/page_red.png' width='15' heigth='15' /></td>";
																/*
																echo "<td onClick=\"AbrirPopPedidos('$row_1[0]','D')\" style=\"text-align: center\" width=\"50px;\">
																		<img src=\"./assest/plugins/buttons/icons/page_red.png\" width=\"15\" heigth=\"15\" /></td>"; */
															}
															else
															{
																if($row_1['estado'] == 'U')
																{
																	echo '<td colspan="2" style="text-align: center; color:red;">Esperando Polimero</td>';
																}
																else
																{
																	echo '<td></td>';
																	//echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','D')\" style=\"text-align: center\" width=\"50px;\">
																	//	<img src=\"./assest/plugins/buttons/icons/page_red.png\" width=\"15\" heigth=\"15\" /></td>";
																	echo "<td onClick=\"AbrirPopPedidos('$row_1[0]','D')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/page_red.png\" width=\"15\" heigth=\"15\" /></td>"; 
																}
															}
															
															echo '<td style="text-align: center;" width="50px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
															if($row_1['poliNumero'] != '' && $row_1['poliNumero'] != 0)
																echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/printer.png" onClick="ImprimirPolimero(\''.$row_1['poliNumero'].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																else
																echo '<td></td>';
															if($row_1['estaImpreso'] == 0)
																echo '<td><button class="btn btn-mini btn-danger" type="button" style="width: 30px;" onClick="SetImpresion(\''.$row_1[0].'\',\'P\')"></button></td>';
															if($row_1['estaImpreso'] == 1)
																echo '<td><button class="btn btn-mini btn-warning" type="button" style="width: 30px;" onClick="SetImpresion(\''.$row_1[0].'\',\'N\')"></button></td>';
															if($row_1['estaImpreso'] == 2)
																echo '<td><button class="btn btn-mini btn-success" type="button" style="width: 30px;" onClick="SetImpresion(\''.$row_1[0].'\',\'N\')"></button></td>';
															if($row_1['marcarComoDevuelta'] == '1')
																echo '<td>
																	<div onClick="AbrirMotivos(\''.$row_1[0].'\')" 
																		style="width: 20px; height: 15px; background:White; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: red; cursor: pointer;" title="Devuelto"
																		>
																		<b>D</b>
																	</div>
																</td>';
																else echo '<td></td>';
														break;	
												
												  case "A": //aceptados
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','P')\" style=\"text-align: center\">
															<img src=\"./assest/plugins/buttons/icons/tick.png\" width=\"15\" heigth=\"15\" /></td>";
														echo "<td onClick=\"AbrirPopPedidos('$row_1[0]','".$accion."')\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
														echo "<td onClick=\"AbrirPopPedidosCancel('$row_1[0]','C')\" style=\"text-align: center\">
															<img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														if($row_1['devolucion'] > 0)
														echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
															else echo "<td></td>";
														break;
												  case "V": //aprobados
														echo "<td onClick=\"AbrirPopTerminado('$row_1[0]','".$row_1['Articulo']."','".$row_1['codigo']."')\" style=\"text-align: center\" title=\"Terminar\">
														          <img src=\"./assest/plugins/buttons/icons/box.png\" width=\"20\" heigth=\"20\" />
														      </td>"; 
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" style=\"text-align: center\" title=\"Cancelar\">
															<img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"20\" heigth=\"20\" />
														      </td>";
														break;
												  case "U": //curso //quitar calidad y evaluar por campo facturacion
														if($row_1['esCI'] != null && $row_1['esCI'] != "")
														{
															echo "<td onClick=\"AbrirPopTerminado('$row_1[0]','".htmlspecialchars($row_1['Articulo'])."','Terminar Nota De Pedido N° ".$row_1['codigo']."')\" style=\"text-align: center\" title=\"Terminar\">
																<img src=\"./assest/plugins/buttons/icons/box.png\" width=\"20\" heigth=\"20\" />
															    </td>";
															if($row_1['cantidad_entregadas'] > 0 ||
															   $row_1['kg_entregados'] > 0 ||
															   $row_1['bultos_entregados'] > 0
															   )
															{
																echo "<td></td>";
																echo "<td style=\"text-align: center\" onClick=\"ContraEntrega('$row_1[0]')\" title=\"Contra Entrega\"><img src=\"./assest/plugins/buttons/icons/note_delete.png\" width=\"15\" heigth=\"15\" style=\"cursor:pointer\"/></td>";
															}
															else
															{
																echo "<td onClick=\"AbrirPopPedidosCancel('$row_1[0]','C')\" style=\"text-align: center\" title=\"Cancelar\">
																<img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"20\" heigth=\"20\" />
																</td>";
																echo "<td></td>";
															}
															
														}
														else
														{
															if($row_1['polimeroEnFacturacion'] == 2 || $row_1['polimeroEnFacturacion'] == '' || $row_1['polimeroEnFacturacion'] == 1)
															{
																echo "<td onClick=\"AbrirPopTerminado('$row_1[0]','".htmlspecialchars($row_1['Articulo'])."','Terminar Nota De Pedido N° ".$row_1['codigo']."')\" style=\"text-align: center\" title=\"Terminar\">
																	<img src=\"./assest/plugins/buttons/icons/box.png\" width=\"20\" heigth=\"20\" />
																    </td>"; 
																if($row_1['cantidad_entregadas'] > 0 ||
																	$row_1['kg_entregados'] > 0 ||
																	$row_1['bultos_entregados'] > 0
																	)
																{
																	echo "<td></td>";
																	echo "<td style=\"text-align: center\" onClick=\"ContraEntrega('$row_1[0]')\" title=\"Contra Entrega\"><img src=\"./assest/plugins/buttons/icons/note_delete.png\" width=\"15\" heigth=\"15\" style=\"cursor:pointer\"/></td>";
																}
																     else
																     {
																	echo "<td onClick=\"AbrirPopPedidosCancel('$row_1[0]','C')\" style=\"text-align: center\" title=\"Cancelar\">
																	<img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"20\" heigth=\"20\" />
																	</td>";
																	echo "<td></td>";
																     }
															}
															else
															{
																echo '<td colspan="2" style="color:red; text-align: center;">Esperando Polimero</td>';
															}
														}
														echo '<td style="text-align: center;">
															<img src="assest/plugins/buttons/icons/zoom.png" width="20" heigth="20" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;">
														      </td>';
														break;
												  case "EH"://Editar hoja de rutas
														echo '<td style="text-align: center"><img src="./assest/plugins/buttons/icons/pencil.png" onClick="AbrirPop('.$row_1[0].',\'EH\')" style="cursor: pointer;" width="15" heigth="15" title="Editar HR/CI"/></td>';
														echo '<td style="text-align: center;" width="50px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
														break;
												  case "T": //terminados
														echo "<td style=\"text-align: center\" onClick=\"ReactivarPedido('$row_1[0]')\" ><img src=\"./assest/plugins/buttons/icons/pencil.png\" width=\"15\" heigth=\"15\" style=\"cursor:pointer\"/></td>";
														echo "<td style=\"text-align: center\" onClick=\"ContraEntrega('$row_1[0]')\" ><img src=\"./assest/plugins/buttons/icons/note_delete.png\" width=\"15\" heigth=\"15\" style=\"cursor:pointer\"/></td>";
														//echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														break;
												  case "EP": //terminados parcialmente
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','ET')\" ><img src=\"./assest/plugins/buttons/icons/pencil.png\" width=\"15\" heigth=\"15\" /></td>";
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														break;
												  case "N": //pedidos ccn productos nuevos (diseño)
												  case "TN":
														if($accion == "N")
														{
															if($row_1['estado'] == 'NS' || $row_1['estado'] == 'SI' || $row_1['estado'] == 'MO')
															{
																echo "<td></td>
																      <td></td>
																      <td onClick=\"AbrirDisenioById('$row_1[0]','$row_1[codigo]','$row_1[clienteNombre]','".htmlspecialchars($row_1['Articulo'])."','CR')\" title=\"Generar Polímero\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/application_edit.png\" width=\"15\" heigth=\"15\" />
																      </td>";
																//echo "<td></td>";
																if($row_1['estado'] == "SI" || $row_1['estado'] == 'MO')
																{
																	echo "<td onClick=\"AbrirPopPedidos('$row_1[0]', '".$accion."')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
															
																	echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																}
																
																echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
															}
															else
															{
																if($row_1['estado'] == 'AP' || $row_1['estado'] == 'RV')
																{
																	echo '<td colspan="5" style="text-align: center; color: blue;">Esperando aprobación de producción</td>';
																	echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																}
																else
																{
																	if($row_1['estado'] == 'NO' || $row_1['estado'] == "NC" || $row_1['estado'] == "CP")
																	{
																		echo '<td colspan="3" style="text-align: center; color: red;">';
																		if($row_1['estado'] == 'NO')
																			echo "Pedido rechazado";
																			else
																			if($row_1['estado'] == 'NC')
																				echo "Pedido rechazado por el cliente";
																				else
																				echo "Pedido cancelado en subsistema Polímeros";
																		echo '</td>';
																		echo "<td onClick=\"AbrirPopPedidos('$row_1[0]', '".$accion."')\" style=\"text-align: center\" width=\"50px;\">
																		<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																		echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																		echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		
																	}
																	else
																	{
																		if($row_1['calidad'] == 'CA' || $row_1['calidad'] == 'PX')
																		{
																			if($row_1['estado'] == 'CA')
																			{
																				echo "<td colspan=\"4\" style=\"text-align: center; color: blue;\">Generación de Polímero</td>";
																			}
																			else
																			{
																				echo "<td></td>";
																				echo "<td></td>";
																				echo "<td></td>";
																				echo "<td></td>";	
																			}
																			echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		}
																		
																		if($row_1['estado'] == 'CA' && $row_1['calidad'] != 'CA')
																		{
																			echo '<td colspan="4" style="text-align: center; color: orange;">Esperando aprobación de calidad</td>';
																			echo "<td onClick=\"AbrirPopPedidos('$row_1[0]', '".$accion."')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		}
																		
																		if($row_1['calidad'] == "PO")
																		{
																			echo '<td colspan="5" style="text-align: center; color: brown;">Esperando aprobación de calidad.</td>';
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		}
																		
																		if($row_1['calidad'] == "PA")
																		{
																			echo "<td></td>";
																			echo "<td></td>";
																			echo "<td></td>";
																			echo "<td></td>";
																			echo "<td></td>";
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		}
																		
																		if($row_1['estado'] == "DI" && $row_1['calidad'] != 'CA' )
																		{
																			echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','DI')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/eye.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			echo "<td></td>";
																			echo "<td></td>";
																			echo "<td onClick=\"AbrirPopPedidos('$row_1[0]', 'N')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																				<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																			
																		}
																		
																		if($row_1['estado'] == 'CL')
																		{
																			echo '<td colspan="5" style="text-align: center; color: green;">Esperando aprobación de cliente</td>';
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		}
																		
																		if($row_1['estado'] != 'B' && $row_1['estado'] != 'CA' && $row_1['estado'] != 'PO' && $row_1['estado'] != 'PX' && $row_1['estado'] != 'PA' && $row_1['estado'] != 'U' && $row_1['estado'] != 'DI' && $row_1['estado'] != 'CL')
																		{
																			echo "<td></td>";
																			echo "<td onClick=\"AbrirDisenio('$row_1[0]','$row_1[codigo]','$row_1[clienteNombre]','".htmlspecialchars($row_1['Articulo'])."','TP')\" title=\"Generar Polímero\" style=\"text-align: center\">
																				<img src=\"./assest/plugins/buttons/icons/chart_bar_edit.png\" width=\"15\" heigth=\"15\" />
																			      </td>
																			      <td></td>";
																			
																			echo "<td onClick=\"AbrirPopPedidos('$row_1[0]', '".$accion."')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			
																			echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																			<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
																			echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																		}
																	}
																	
																}
															}
															if($row_1['poliNumero'] != '' && $row_1['poliNumero'] != 0)
																echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/printer.png" onClick="ImprimirPolimero(\''.$row_1['poliNumero'].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
																else
																echo '<td></td>';
														}
														else{
															if($row_1['estado'] == 'NS' || $row_1['estado'] == 'SI' || $row_1['estado'] == 'MO')
															{																
																echo "<td style=\"text-align: center; color: blue;\">Polímero Aprobado por producción</td>";
															}
															else
															{
																if($row_1['estado'] == 'AP' || $row_1['estado'] == 'RV')
																{
																	echo '<td style="text-align: center; color: blue;">Esperando aprobación de producción</td>';
																}
																else
																{
																	if($row_1['estado'] == 'NO' || $row_1['estado'] == "NC")
																	{
																		echo '<td style="text-align: center; color: red;">';
																		if($row_1['estado'] == 'NO')
																			echo "Pedido rechazado";
																			else
																			echo "Pedido rechazado por el cliente";
																		echo '</td>';
																	}
																	else
																	{
																		if($row_1['calidad'] == 'CA' || $row_1['calidad'] == 'PX')
																		{
																			if($row_1['estado'] == 'CA')
																			{
																				echo "<td style=\"text-align: center; color: blue;\">Generación de Polímero</td>";
																			}
																			else
																			{
																				if($row_1['estado'] != 'CL' && $row_1['estado'] != 'CP')
																					echo '<td style="text-align: center;">Trabajo Nuevo</td>';
																			}
																			
																		}
																		
																		if($row_1['estado'] == 'CA' && $row_1['calidad'] != 'CA')
																		{
																			echo '<td style="text-align: center; color: orange;">Esperando aprobación de calidad</td>';
																		}
																		
																		if($row_1['calidad'] == "PO")
																		{
																			echo '<td style="text-align: center; color: brown;">Esperando aprobación de calidad.</td>';
																		}
																		
																		if($row_1['calidad'] == "PA")
																		{
																			echo "<td>falta..</td>";
																		}
																		
																		if($row_1['estado'] == "DI" && $row_1['calidad'] != 'CA' )
																		{
																			echo '<td style="text-align: center;"> Trabajo Nuevo</td>';
																			
																		}
																		
																		
																		if($row_1['estado'] == 'CL')
																		{
																			echo '<td style="text-align: center; color: green;">Esperando aprobación de cliente</td>';
																		}
																		
																		if($row_1['estado'] != 'B' && $row_1['estado'] != 'CA' && $row_1['estado'] != 'PO' && $row_1['estado'] != 'PX' && $row_1['estado'] != 'PA' && $row_1['estado'] != 'U' && $row_1['estado'] != 'DI' && $row_1['estado'] != 'CL')
																		{
																			if($row_1['estado'] != 'CP')
																			echo '<td style="text-align: center;">Aprobado por el Cliente</td>';
																			else
																			echo '<td style="text-align: center; color: red;">Cancelado en Subsitema Polímeros</td>';
																		}
																	}
																	
																}
															}
															
															echo '<td style="text-align: center;">
															<img src="assest/plugins/buttons/icons/zoom.png" width="20" heigth="20" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;">
														      </td>';
														      if($row_1['poliNumero'] != '' && $row_1['poliNumero'] != 0)
															echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/printer.png" onClick="ImprimirPolimero(\''.$row_1['poliNumero'].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
															else
															echo '<td></td>';
														      if($row_1['estaImpreso'] == 0)
														      {
															echo '<td></td>';
															echo '<td><button class="btn btn-mini btn-danger" type="button" style="width: 30px;" onClick="SetImpresion(\''.$row_1[0].'\',\'S\')"></button></td>';
														      }
														      if($row_1['estaImpreso'] == 1)
														      {
															if($row_1['seCargoHRCI'] == 1)
																{
																	echo '<td style="text-align: center"><img src="./assest/plugins/buttons/icons/pencil.png" onClick="AbrirPop('.$row_1[0].',\'EH\')" style="cursor: pointer;" width="20" heigth="20" title="Editar HR/CI"/></td>';
																}
																else
																{
																	echo '<td style="text-align: center"><img src="./assest/plugins/buttons/icons/tick.png" onClick="AbrirPop('.$row_1[0].',\'EH\')" style="cursor: pointer;" width="20" heigth="20" title="Editar HR/CI"/></td>';
																}
															echo '<td><button class="btn btn-mini btn-warning" type="button" style="width: 30px;" onClick="SetImpresion(\''.$row_1[0].'\',\'N\')"></button></td>';
														      }
														      if($row_1['marcarComoDevuelta'] == '1')
																/*echo '<td>
																	<div
																		style="width: 20px; height: 15px; background:White; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: red;" title="Devuelto"
																		>
																		<b>D</b>
																	</div>
																</td>';*/
																echo '<td>
																<div onClick="AbrirMotivos(\''.$row_1[0].'\')" 
																		style="width: 20px; height: 15px; background:White; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: red; cursor: pointer;" title="Devuelto"
																		>
																		<b>D</b>
																	</div> </td>';
																else echo '<td></td>';
														}
														
														
														break;
												  case "AP":
														echo "<td onClick=\"AbrirDisenioById('$row_1[0]','$row_1[codigo]','$row_1[clienteNombre]','".htmlspecialchars($row_1['Articulo'])."','AP')\" title=\"Polímero Aprobado\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/star.png\" width=\"15\" heigth=\"15\" /></td>";
														echo "<td onClick=\"AbrirPopPedidos('$row_1[0]','".$accion."')\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
														echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
														echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
														if($row_1['poliNumero'] != '' && $row_1['poliNumero'] != 0)
															echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/printer.png" onClick="ImprimirPolimero(\''.$row_1['poliNumero'].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
															else
															echo '<td></td>';
														break;
													
												  case "PO":
														echo "<td onClick=\"AprobarCalidad('$row_1[0]','SI')\" title=\"Aprobado\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/star.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\"/></td>";
														echo "<td onClick=\"AprobarCalidad('$row_1[0]','NO')\" title=\"No Aprobado\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/stop.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
														echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
																	<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
													        break;
												  case "PA":
														echo "<td onClick=\"AsociarPolimeroOpen('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/color_wheel.png\" width=\"20\" heigth=\"20\" style=\"cursor: pointer;\" title=\"Asociar Polimero\"/>
														      </td></tr>";
													
													        break;
												  case "E":
														echo "<td style=\"text-align: center\" onClick=\"AbrirPopEditarPrecio('$row_1[0]','".htmlspecialchars($row_1['Articulo'])."','Editar Precio Nota De Pedido N° ".$row_1['codigo']."')\">
															<img src=\"./assest/plugins/buttons/icons/pencil.png\" style=\"cursor: pointer;\" width=\"15\" heigth=\"15\" title=\"Editar Precio\"/>
														      </td>";
														break;
												  case "CL":
														echo "<td style=\"text-align: center\" onClick=\"AbrirVentanaPedido('$row_1[0]','N')\">
															<img src=\"./assest/plugins/buttons/icons/tick.png\" style=\"cursor: pointer;\" width=\"15\" heigth=\"15\" title=\"Aprobar diseño\"/>
														      </td>";
														echo "<td style=\"text-align: center\" onClick=\"AbrirPopPedidos('$row_1[0]', 'NC')\">
															<img src=\"./assest/plugins/buttons/icons/stop.png\" style=\"cursor: pointer;\" width=\"15\" heigth=\"15\" title=\"Editar Precio\"/>
														      </td>";
														echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
														break;
												  case "TO":
														echo '<td style="text-align: center;" width="50px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
														break;
												//  case "T":
												//		echo '<td style="text-align: center;" width="50px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
												//		break;
												
												  case "DE": //devoluciones
														echo '<td style="text-align: center;" width="50px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row_1[0].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
														if($row_1['poliNumero'] != '' && $row_1['poliNumero'] != 0)
															echo '<td style="text-align: center;" width="30px;"><img src="assest/plugins/buttons/icons/printer.png" onClick="ImprimirPolimero(\''.$row_1['poliNumero'].'\')" style="cursor: pointer;" width="15px" heigth="15px"></td>';
															else
															echo '<td></td>';
														echo "<td onClick=\"AbrirMotivos('$row_1[0]')\" style=\"text-align: center\" width=\"50px;\">
															<img src=\"./assest/plugins/buttons/icons/note.png\" width=\"15\" heigth=\"15\" style=\"cursor: pointer;\" /></td>";
														$color = "#D7DF01";
														$texto = "P";
														$title = "Producción";
														if($row_1['seDevolvio'] == 'D')
														{
															$color = "#58D3F7";
															$texto = "D";
															$title = "Diseño";
														}
														echo '<td><div title="'.$title.'"
															style="width: 20px; height: 15px; background:'.$color.'; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
															>
															<b>'.$texto.'</b>
														   </div></td>';
														break;	
												}
											 echo '</tr>';
											}
									}
							 echo '</tbody></table>';
							 echo '</div>';
							 echo '<input type="hidden" name="idPedido"><input type="hidden" name="accionPedido">';
							 
							 //------Paginación----
							 if($pagina == 0)
							 {
								echo '<button class="btn btn-info" type="button" disabled title="Anterior"><i class="icon-chevron-left icon-white"></i></button>   Página ';
							 }
							 else
							 {
								echo '<a href="listadoPedidos.php?accion='.$accion.'&page='.($pagina - 1).'&query='.$query.'">
									<button class="btn btn-info" type="button" title="Anterior">
									   <i class="icon-chevron-left icon-white"></i>
								        </button>
								      </a>    Página ';	
							 }
							 if($pagina == 0)
							 {
								echo 1;
							 }
							 else
							 {
								echo $pagina +1;
							 }
							 
							 echo " de ".ceil($cantidad / 10);
							 //echo " de ".round(($cantidad / 10), 0, PHP_ROUND_HALF_UP)."  ";
							 
							 if(($pagina + 1) == ceil($cantidad / 10) || ceil($cantidad / 10) == 0)
							 {
								echo '<button class="btn btn-info" type="button" disabled title="Siguiente"><i class="icon-chevron-right icon-white"></i></button>';
							 }
							 else
							 {
								echo '<a href="listadoPedidos.php?accion='.$accion.'&page='.($pagina + 1).'&query='.$query.'">
									<button class="btn btn-info" type="button" title="Siguiente">
										<i class="icon-chevron-right icon-white"></i>
								        </button>
								      </a>';
							 }
							 
							 echo '</div>';
							 
							}
					}
			}
		
		function listadoPolimero($accion, $pagina, $query)
			{
			$var = new conexion();
			$var->conectarse();
			 
			$estado = "";
			switch($accion)
			{
				case "A":
					//Diseño Preprensa
					$estado = " po.estado = 'A' or po.estado = 'D' or po.estado = 'F' or po.estado = 'N'";
					break;
				
				case "B":
					//Aprobacion Cliente
					$estado = " po.estado = 'B' ";
					break;
				
				case "C":
					//Control Prod. /Borradores
					$estado = " po.estado = 'C' ";
					break;
				
				case "E":
					//Diseño de Polimero Aprobado
					$estado = " po.estado = 'E' ";
					break;
				
				case "G":
					//Polimero en Proveedor
					$estado = " po.estado = 'G' or po.estado = 'J' or po.estado = 'L' ";
					break;
				
				case "H":
					//Aprobación Preprensa
					$estado = " po.estado = 'H' ";
					break;
				
				case "I":
					//Polímero en Calidad
					$estado = " po.estado = 'I' ";
					break;
				
				case "K":
					//Polímero en Producción/Impresión
					$estado = " po.estado = 'K' ";
					break;
				
				case "P":
					//Facturación de Polímeros
					$estado = " (po.estado in ('I', 'K', 'M', 'O', 'A', 'G', 'H')) and po.EnFacturacion = 'F' ";
					break;
				
				case "Q":
					//Administración Polímero en Facturación
					$estado = " po.EnFacturacion = 'A' ";
					break;
			}
			
			$search_by_txt = "";
			if($query != "")
			{
				$search_by_txt = " and (pe.codigo like '%".$query."%' ";
				$search_by_txt .= " or pe.descripcion like '%".$query."%' ";
				$search_by_txt .= " or pe.clienteNombre like '%".$query."%') ";
			}
							
			$_cant = "SELECT
					po.*,
					pe.codigo,
					pe.descripcion,
					pe.clienteNombre
					
				  FROM
					polimeros AS po
			          JOIN
					pedidos AS pe ON po.idPedido = pe.npedido
				  WHERE
					(".$estado.") ".$search_by_txt;
			
			$_rows = mysql_query($_cant);	  
			$cantidad = mysql_num_rows($_rows);
			
			$_list = "SELECT po.*, pe.codigo, pe.descripcion, pe.clienteNombre FROM polimeros AS po
			          JOIN pedidos AS pe ON po.idPedido = pe.npedido WHERE (".$estado.") ".$search_by_txt."
				  order by pe.codigo Limit ".($pagina * 10).",10";
			
			$_rows = mysql_query($_list);
			 
			echo '<div style="min-height: 430px;">';
			echo '<table class="table table-hover">';
			
			if(mysql_num_rows($_rows) <= 0)
				{
					echo '<thead><tr><td colspan="10">No hay polimeros</td></tr></thead>';
				}
				else
				{
					echo '	<thead>
							<tr>
								<th>Código</th>
								<th>Trabajo</th>
								<th width="75px">N° Pedido</th>';
							
					//Titulo de botones o acciones
					switch($accion)
					{
						case "A":
							echo '<th>Preprensa en Prov.</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "B":
							echo '<th>Aprobado</th>';
							echo '<th>Corregir</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "C":
							echo '<th>Borrad. aprob. a preprensa</th>';
							echo '<th>Corregir</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "E":
							echo '<th>Preprensa en prov.</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "G":
							echo '<th>Conf. polímero</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "H":
							echo '<th>Polím. en calidad</th>';
							echo '<th>Corregir</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "I":
							echo '<th>Produc./impr.</th>';
							echo '<th>Rehacer</th>';
							echo '<th>STD BY</th>';
							echo '<th>Cancelar</th>';
							break;
						
						case "K":
							echo '<th>Archivar</th>';
							echo '<th>Corregir</th>';
							break;
						
						case "P":
							echo '<th>Facturar</th>';
							break;
						
						case "Q":
							echo '<th>Autorizar</th>';
							break;
					}
					
					echo 			'<th></th>';
					echo 			'<th></th>';
					echo 		'</tr>';
					echo 	'</thead>';
						
					while($row = mysql_fetch_array($_rows))
					{
						echo '<tbody>
							<tr>';
						
						if($row['ordenDeTrabajo'] != null)
							echo '<td><a href="#" onClick="openLog('.$row['id_polimero'].',\''.$row['ordenDeTrabajo'].'\',\''.$row['descripcion'].'\',\''.$row['codigo'].'\',\''.$row['clienteNombre'].'\')">'.$row['ordenDeTrabajo'].'</a></td>';
							else
							echo '<td><a href="#" onClick="openLog(('.$row['id_polimero'].',\''.$row['ordenDeTrabajo'].'\',\''.$row['descripcion'].'\',\''.$row['codigo'].'\',\''.$row['clienteNombre'].'\')">'.$row['id_polimero'].'</a></td>';
						echo '<td>'.$row['descripcion'].'</td>';
						echo '<td style="text-align: center">'.$row['codigo'].'</td>';
						
						//Acciones o botones
						switch($accion)
						{
							case "A":
								if($row['standBy'] != 1)
								{
									//Aprobar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'G\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "B":
								if($row['standBy'] != 1)
								{
									//Aprobar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'C\')"/>
										</td>';
									//Corregir
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/exclamation.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'D\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "C":
								if($row['standBy'] != 1)
								{
									//Enviar a proveedor
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'E\')"/>
										</td>';
									//Corregir
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/exclamation.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'F\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "E":
								if($row['standBy'] != 1)
								{
									//Enviar a proveedor
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'G\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "G":
								if($row['standBy'] != 1)
								{
									//Aprobar Preprensa
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'H\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "H":
								if($row['standBy'] != 1)
								{
									//Enviar a Calidad
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'I\')"/>
										</td>';
									//Corregir
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/exclamation.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'J\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "I":
								if($row['standBy'] != 1)
								{
									//Enviar a Producción
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'K\')"/>
										</td>';
									//Rehacer
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/exclamation.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'L\')"/>
										</td>';
									//Stand By
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_in.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'Z\')"/>
										</td>';
									//Cancelar
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/stop.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'Y\')"/>
										</td>';
								}
								else
								{
									//En standBy
									echo '<td></td>';
									echo '<td></td>';
									echo '	<td style="text-align: center">
											<img src="./assest/plugins/buttons/icons/door_out.png" width="15" heigth="15" style="cursor: pointer;" onClick="OpenStandBy(\''.$row['id_polimero'].'\', \'X\')"/>
										</td>';
									echo '<td></td>';
								}
								break;
							
							case "K":
								//Guardar
								echo '	<td style="text-align: center">
										<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="ChangeStatus(\''.$row['id_polimero'].'\', \'M\')"/>
									</td>';
								//Corregir
								echo '	<td style="text-align: center">
										<img src="./assest/plugins/buttons/icons/exclamation.png" width="15" heigth="15" style="cursor: pointer;" onClick="CancelOrReturn(\''.$row['id_polimero'].'\', \'N\')"/>
									</td>';
								break;
							
							case "P":
								//Facturar
								echo '	<td style="text-align: center">
										<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="FacturarPolimero(\''.$row['id_polimero'].'\', \'Q\')"/>
									</td>';
								break;
							
							case "Q":
								//Autorizar
								echo '	<td style="text-align: center">
										<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" onClick="FacturarPolimeroSiNo(\''.$row['id_polimero'].'\')"/>
									</td>';
								break;
						}
						
						echo 		'<td style="text-align: center">
									<img src="./assest/plugins/buttons/icons/printer.png" width="15" heigth="15" style="cursor: pointer;" onClick="ImprimirPolimero(\''.$row['id_polimero'].'\')"/>
								</td>';
						echo 		'<td style="text-align: center">
									<img src="./assest/plugins/buttons/icons/zoom.png" width="15" heigth="15" style="cursor: pointer;" onclick="ImprimirReporte(\''.$row['idPedido'].'\')"/>
								</td>';
						echo '	</tr>
						      </tbody>';
					}
				}
			
			echo '</table>';
			echo '</div>';
			
			//------Paginación----
			if($pagina == 0)
			{
			       echo '<button class="btn btn-info" type="button" disabled title="Anterior"><i class="icon-chevron-left icon-white"></i></button>   Página ';
			}
			else
			{
			       echo '<a href="listadoPolimero.php?accion='.$accion.'&page='.($pagina - 1).'">
				       <button class="btn btn-info" type="button" title="Anterior">
					  <i class="icon-chevron-left icon-white"></i>
				       </button>
				     </a>    Página ';	
			}
			if($pagina == 0) 
			{
			       echo 1;
			}
			else
			{
			       echo $pagina +1;
			}
			
			echo " de ".ceil($cantidad / 10);
			//echo " de ".round(($cantidad / 10), 0, PHP_ROUND_HALF_UP)."  ";
			
			if(($pagina + 1) == ceil($cantidad / 10) || ceil($cantidad / 10) == 0)
			{
			       echo '<button class="btn btn-info" type="button" disabled title="Siguiente"><i class="icon-chevron-right icon-white"></i></button>';
			}
			else
			{
			       echo '<a href="listadoPolimero.php?accion='.$accion.'&page='.($pagina + 1).'">
				       <button class="btn btn-info" type="button" title="Siguiente">
					       <i class="icon-chevron-right icon-white"></i>
				       </button>
				     </a>';
			}
			
			}
	}
	
	function BuscarHora($id)
		{
			$var = new conexion();
			$var->conectarse();
			
			$sql = "SELECT DATE_FORMAT( logFecha,  '%k:%i' ) AS DATE
				FROM tbl_log_pedidos
				WHERE pedidoId = ".$id." and pedidoEstado = 'P'
				ORDER BY logId DESC 
				LIMIT 1";
				
			$_rows = mysql_query($sql);
			
			if(mysql_num_rows($_rows) <= 0)
			{
				return "-";
			}
			else
			{
				while($row = mysql_fetch_array($_rows))
					return $row[0];
			}
		}

function ArmarPolimeroLog($polId,$nro,$cliente, $caras)
{
	$texto = "";
	if($caras == 0)
	{
		//$texto .= '<img src="assest/plugins/buttons/icons/new_.png">';
		$texto .= '<div
				style="width: 20px; height: 15px; background:Blue; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
				>
				<b>N</b>
			   </div>';
	}
	else
	{
		if($polId == "" || $polId == null)
		{
			//$texto .= '<img src="assest/plugins/buttons/icons/new_.png">';
			$texto .= '<div
					style="width: 20px; height: 15px; background:Red; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
					>
					<b>N</b>
				   </div>';
		}
		else
		{
			$sql = "Select * from Polimeros Where id_polimero = ".$polId;
			$resu = mysql_query($sql) or (die(mysql_error()));
				
			$code = '0000';
			$trabajo = '-';
			$enProduccion = 0;
			if(mysql_num_rows($resu) >  0)
			{
				while($row = mysql_fetch_array($resu))
				{
					$code = $row['ordenDeTrabajo'];
					$trabajo = $row['trabajo'];
					$enProduccion = $row['enProduccion'];
				}
				
			}
			
			if($enProduccion == 0)
			{
				//$texto .= '<img src="assest/plugins/buttons/icons/newGreen.png" onclick="openLog('.$polId.',\''.$code.'\', \''.$trabajo.'\',\''.$nro.'\',\''.$cliente.'\')">';
				$texto .= '<div
						onclick="openLog('.$polId.',\''.$code.'\', \''.$trabajo.'\',\''.$nro.'\',\''.$cliente.'\')"
						style="width: 20px; height: 15px; background: orange; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white; cursor: pointer;"
					>
					<b>N</b>
				   </div>';
			}
			else
			{
				//$texto .= '<img src="assest/plugins/buttons/icons/newOK.png" onclick="openLog('.$polId.',\''.$code.'\', \''.$trabajo.'\',\''.$nro.'\',\''.$cliente.'\')">';
				$texto .= '<div
						onclick="openLog('.$polId.',\''.$code.'\', \''.$trabajo.'\',\''.$nro.'\',\''.$cliente.'\')"
						style="width: 20px; height: 15px; background: green; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white; cursor: pointer;"
					>
					<b>N</b>
				   </div>';
			}
		}
	}
	return $texto;
}
?>
<script>
	function principalL()
		{
		document.listado.action = "principal.php";
		document.listado.submit();
		}
		
	function AbrirVentanaPedido(id,accion)
		{
		//alert(accion+"  "+id);
		document.listado.idPedido.value = id;
		document.listado.accionPedido.value = accion;
		document.listado.action = "IngresoPedidos.php?valor1="+id+"&valor2="+accion;
		document.listado.submit();
		}
		
	function AbrirVentana(tabla,accion,id)
		{
		 //alert(tabla);
		 window.open("class_formulario.php?tabla="+tabla+"&accion="+accion+"&Id="+id, "PopUp", 'width=500,height=400'); return false;
		}
	
	function AccionGrupo(accion, id)
		{
			
			location.href = "groups.php?a="+accion+"&i="+id;
		}
		
</script>