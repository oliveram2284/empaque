<?php
include "conexion.php";

$conecta = new conexion();
$conecta ->conectarse();

$dato=$_POST['variable'];

$arre = explode('~',$dato);

$dato = $arre[0];

$tabla = $arre[1];

$consulta1 = "Select * from tbl_tablas where descripcion ='".$tabla."'";
$resu = mysql_query($consulta1);
$row = mysql_fetch_array($resu);

$consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden";
$resu2 = mysql_query($consulta2);

$campos = "";
//--

//campo id de la tabla 
$cons = "SELECT COLUMN_NAME
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = '$tabla'
		AND table_schema = 'mi000652_empaque1'
		AND COLUMN_KEY = 'PRI'";
		
$re = mysql_query($cons);
$aux = mysql_fetch_array($re);
$campos .= $aux[0];

//--
					//area encabezado

						echo '<table border="1"><thead><tr>';					
						 while($row = mysql_fetch_array($resu2))
							{
							 if($row['visible'] == 1)
								{
								 echo '<td>'.utf8_encode($row['nombreMuestra']).'</td>';

								 $campos .= ",".$row['nombreCampo'];

								}else
									{
									 echo '';
									}

							}
							echo '<td>Editar</td><td>Eliminar</td> </thead></tr>';
														
							$camposAbuscar = explode(',',$campos);
							
							$cantidad = count($camposAbuscar);
							$condicion = "";

							for($i=1 ; $i<$cantidad ; $i++)
								{
								 if($i!= ($cantidad -1))
								 	{
								 	$condicion .= $camposAbuscar[$i]." Like '%".$dato."%' or  ";
									}else
										{
										 $condicion .= $camposAbuscar[$i]." Like '%".$dato."%' ";
										}
								}
							
							//area cuerpo
							$consulta3 = "Select $campos from ".$tabla." where ".$condicion."";
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
											echo "<td onClick=\"AbrirVentana('$tabla','U','$row_1[0]')\"><img src=\"./assest/plugins/buttons/icons/pencil.png \" aling='center' /></td>";


											//--
											
											//eliminar
											echo "<td /*onClick=\"AbrirVentana('$tabla','D','$row_1[0]')\"/><img src='./assest/plugins/buttons/icons/cancel.png ' aling='center' /> </td>";

											//--
											 echo '</tr>';
											}
									}
							 echo "</tbody></table>";
							 //echo "<img src=\"./assest/plugins/buttons/icons/pencil.png \" aling='center' />";
?>