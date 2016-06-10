<?php
session_start();
$nombre = substr($_SESSION['Nombre'], 0, 2);

$esAdmin = $_SESSION['admin'];

include "conexion.php";

$conecta = new conexion();
$conecta ->conectarse();

$dato=$_POST['variable'];

$arre = explode('~',$dato);

$dato = $arre[0];

$tabla = $arre[1];

$accion = $arre[2];

$consulta1 = "Select * from tbl_tablas where descripcion ='".$tabla."'";
$resu = mysql_query($consulta1);
$row = mysql_fetch_array($resu);

$consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden";
$resu2 = mysql_query($consulta2);

//$campos = "";
$ca = "";
//--

//campo id de la tabla 
$cons = "SELECT COLUMN_NAME
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = '$tabla'
		AND table_schema = 'mi000652_empaque1'
		AND COLUMN_KEY = 'PRI'";
		
$re = mysql_query($cons);
$aux = mysql_fetch_array($re);
$campos[] = $aux[0];
$ca .= $aux[0];
//--
					//area encabezado

						echo '<table border="1"><thead><tr>';					
						 while($row = mysql_fetch_array($resu2))
							{
							 if($row['visible'] == 1)
								{
								 echo '<td>'.utf8_encode($row['nombreMuestra']).'</td>';
								 
                                 if($row['tipo'] == "date")
                                    { 
                                        $campos[] = "Date_format( ".$row['nombreCampo'].", '%d-%m-%Y' ) AS ".$row['nombreCampo'];
                                        $ca .= ",".$row['nombreCampo'];
								    }
                                    else
                                    {
                                        $campos[] = "".$row['nombreCampo'];
                                        $ca .= ",".$row['nombreCampo'];    
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
								 		echo "<td>Aceptar</td><td>Cancelar</td></tr></thead>";
										else
										echo "<td>Cancelar</td></tr></thead>";
										break;	
								 case "A": //aceptados
								 		echo "<td>Aprobar</td><td>Cancelar</td></tr></thead>";
										break;
								 case "V": //aprobados
								 		echo "<td>Terminar</td><td>Cancelar</td></tr></thead>";
										break;
								 case "T": //terminados
								 		echo "<td>Editar</td><td>Cancelar</td></tr></thead>";
										break;
								}
														
							$camposAbuscar = explode(',',$ca);
							
							$cantidad = count($campos);
							$condicion = "";

							for($i = 0 ; $i < $cantidad ; $i++)
								{
								 if($i!= ($cantidad -1))
								 	{
								 	$condicion .= $camposAbuscar[$i]." Like '%".$dato."%' or  ";
									}else
										{
										 $condicion .= $camposAbuscar[$i]." Like '%".$dato."%' ";
										}
								}
								
							$campos[] = "razon_soci";
                            
                            
							$condicion .= " or razon_soci Like '%".$dato."%'";// or Articulo Like '%".$dato."%' "; 
                            
                            $union = "";
                            for($i = 0 ; $i < $cantidad ; $i++)
								{
								 if($i!= ($cantidad -1))
								 	{
								 	$union .= $campos[$i].",";
									}else
										{
										 $union .= $campos[$i];
										}
								}

                            //area cuerpo
							if($esAdmin == 1)
								{
									$consulta3 = "Select $union, razon_soci, Articulo from ".$tabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												  INNER JOIN articulos ON pedidos.descrip3 = articulos.Id
												  where (".$condicion.") and estado='$accion' order by codigo";//and pedidos.codigo Like '%".$nombre."%'";
												  
									if($accion == 'V')
									{
									$consulta3 = "Select $union, razon_soci, Articulo from ".$tabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												  INNER JOIN articulos ON pedidos.descrip3 = articulos.Id
												  where (".$condicion.") and (estado='$accion' or estado='TP') order by codigo";//and pedidos.codigo Like '%".$nombre."%' ";//".$usuario."
									}
								}else
								{
									$consulta3 = "Select $union, razon_soci, Articulo from ".$tabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												  INNER JOIN articulos ON pedidos.descrip3 = articulos.Id
												  where (".$condicion.") and estado='$accion' and pedidos.codigo REGEXP '^".$nombre."' order by codigo";
												  
									if($accion == 'V')
									{
									$consulta3 = "Select $union, razon_soci, Articulo from ".$tabla." 
												  INNER JOIN clientes ON pedidos.clientefact = clientes.cod_client 
												  INNER JOIN articulos ON pedidos.descrip3 = articulos.Id
												  where (".$condicion.") and (estado='$accion' or estado='TP') and pedidos.codigo REGEXP '^".$nombre."' order by codigo";//".$usuario."
									}		
								}
                            
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
															 if($i==5)//cliente
																	{
																		echo '<td>';
																		echo $row_1['razon_soci'];
																		echo '</td>';
																	}
																	else
																	{
																		if($i == 7)//producto
																			{
																				echo '<td>';
																				echo $row_1['Articulo'];
																				echo '</td>';	
																			}
																			else
																			if($i == 15)
																				{
																					break;
																				}else
																					{
																						echo '<td>'.$value.'</td>';
																					}
																	}
															}
														}
													$i++;
												}
											switch($accion)
												{
												case "I": //ingresados
														if($esAdmin == 1)
														{
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','A')\" ><img src=\"./assest/plugins/buttons/icons/add.png\" width=\"15\" heigth=\"15\" /></td>";	 		
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														}else
														{
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														}
														break;
												  case "A": //aceptados
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','V')\" ><img src=\"./assest/plugins/buttons/icons/tick.png\" width=\"15\" heigth=\"15\" /></td>";
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														break;
												  case "V": //aprobados
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','T')\" ><img src=\"./assest/plugins/buttons/icons/package_go.png\" width=\"15\" heigth=\"15\" /></td>";
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														break;
												  case "T": //terminados
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','E')\" ><img src=\"./assest/plugins/buttons/icons/pencil.png\" width=\"15\" heigth=\"15\" /></td>";
														echo "<td onClick=\"AbrirVentanaPedido('$row_1[0]','C')\" ><img src=\"./assest/plugins/buttons/icons/cross.png\" width=\"15\" heigth=\"15\" /></td>";
														break;
												}
											 echo '</tr>';
											}
									}
							 echo "</tbody></table>";
?>