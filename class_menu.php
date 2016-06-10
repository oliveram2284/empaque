<?php

class menu
{
	function menu_ppal($idGpo)
	{
	$count = 1;
	//en la variable $idGpo viene todos los indices del menu que 
	$var = new conexion();
	$var->conectarse();
	 
	$sql = "
		(SELECT
			menu. * 
		FROM
			tbl_grupos_permisos AS gpo
		JOIN
			tbl_menu_emp AS menu ON menu.id_menu = gpo.id_menu
		WHERE
			gpo.id_grupo = ".$idGpo.")
		Union
			(Select menu.*
			From tbl_menu_emp as menu
			Where menu.link = \"\")
		Order by ubicacion";
			
	 $res = mysql_query($sql);
	 
	 $encabezado_a_usar = "";
	 $sub_encabezado_a_usar = "";
	 $armando_Nivel1 = false;
	 $armando_Nivel2 = false;
	 $anterior_fue_subMenu = false;
	 
	if(mysql_num_rows($res)>0)
	{
		while($r =  mysql_fetch_array($res))
		{
			if($r['imagen'] != "")
			{
				//Menu Principal
				$encabezado_a_usar = $r['descripcion'];
				if($armando_Nivel1 == true && $armando_Nivel2 == false)
				{
					echo '</ul>';
					$armando_Nivel1 = false;
				}
				
				if($armando_Nivel2 == true)
				{
					if(substr_count($r['ubicacion'], '/') == 1 || substr_count($r['ubicacion'], '/') == 2)
					{
						if($idGpo != 46 && $idGpo != 45 && $idGpo != 48 && $idGpo != 52 && $idGpo != 53 && $idGpo != 54 && $idGpo != 55)
							echo '</ul>';
					}
					else
					{
						echo '</ul></li>';
					}
					$armando_Nivel2 = false;
					$anterior_fue_subMenu = false;
				}
				
			}
			else
			{
				if($encabezado_a_usar != "")
				{
					if($r['link'] == "")
					{
						$armando_Nivel2 = true;
						$encabezado_a_usar_Level2 = $r['descripcion'];
					}
					else
					{
						echo'<li class="dropdown">';
						echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.htmlentities($encabezado_a_usar).'<b class="caret"></b></a>';
						//ahora armar cuerpo
						
						echo '<ul class="dropdown-menu">';
						echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
							
						$encabezado_a_usar = "";
						$armando_Nivel1 = true;
					}
				}
				else
				{
					if($r['link'] == "")
					{
						$encabezado_a_usar_Level2 = $r['descripcion'];
						$armando_Nivel2 = true;
					}
					else
					{
						if(isset($encabezado_a_usar_Level2))
						{
							if($armando_Nivel2 == true || $encabezado_a_usar_Level2 != "")
							{
								if($encabezado_a_usar_Level2 != "" && substr_count($r['ubicacion'], '/') >= 3)
								{
									$anterior_fue_subMenu = true;
									if($encabezado_a_usar_Level2 != "")
									{
										echo'<li class="dropdown-submenu" style="text-align: left;">';
										echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.htmlentities($encabezado_a_usar_Level2).'</a>';
										//ahora armar cuerpo
										echo '<ul class="dropdown-menu">';
										echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
										
										$encabezado_a_usar_Level2 = "";
									}
									else
									{
										echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
									}
								}
								else
								{
									if(substr_count($r['ubicacion'], '/') >= 3)
									{
										echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';	
									}
									else
									{
										if($anterior_fue_subMenu == true)										
											{
												echo '</ul><li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
												$armando_Nivel2 = false;
											}
											else
											echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
									}
								}
							}
							else
							{
								echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';	
							}
						}
						else
						{
							if(substr_count($r['ubicacion'], '/') >= 3)
							{
								$anterior_fue_subMenu = true;
								echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';	
							}
							
							if($anterior_fue_subMenu == true)
							{
								echo '</ul><li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';	
							}
							else
							{
								echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
							}
						}
					}
				}
			}
			
			
		}
	}
	else
	{
		echo "Error en la asignacion de permisos";
	}
	 if(mysql_num_rows($res)>0)
	    {
		$encabezado = "";
		$entroXprimeraVez = true;
		
		$encabezadoNivel2 = "";
		$entroEnNivel2 = false;
		
		$cerrar = false;
		
		$menu = "";
		while($r = mysql_fetch_array($res))
			{
				$nivel = substr_count($r['ubicacion'], '/');
				//1 = header menu principal
				//2 = Opción de menu principal o header de submenu
				//3 = Opción de submenu
				switch($nivel)
				{							
					case "1":
						//Encabezado
						echo "Tienes problemas!!!!";
						break;
					
					case "2":
						//Normal
						$posicion = strrpos($r['ubicacion'], '/', 0);
						if($posicion != false)
						{
							$inicioCadena = substr($r['ubicacion'], 0, $posicion);
							echo $inicioCadena;
							if($inicioCadena != $encabezado)
							{
								if($entroXprimeraVez == true)
								{
									$entroXprimeraVez = false;
								}
								else
								{
									//preguntamos si ya entro en el nivel 2
									if($entroEnNivel2 == true)
									{
										echo '</ul></li>';
										$entroEnNivel2 = false;

										
									}
									else
									{
										//Cerramos el item del menu
										echo '</ul></li>';
									}
									
								}
								
								//agregar encabezado al menu
								$sqlCabeza = "SELECT * FROM tbl_menu_emp WHERE ubicacion = '".$inicioCadena."'";
								$resCabeza = mysql_query($sqlCabeza);
								if(mysql_num_rows($resCabeza)>0)
								{
									$row = mysql_fetch_array($resCabeza);
									$encabezado = $inicioCadena;
									
									echo'<li class="dropdown">';
									echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.htmlentities($row['descripcion']).'<b class="caret"></b></a>';
									//ahora armar cuerpo
									echo '<ul class="dropdown-menu">';
									echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
								}
								else
								{
									echo "Error de lectura en busqueda de la cabecera";
								}
							}
							else
							{
								//agregar item al menu
								echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
							}
						}
						break;
					
					case "3":
						//2° Nivel
						//obtener nivel 2
						$posicion = strrpos($r['ubicacion'], '/', 0);
							$entroEnNivel2 = true;					
						if($posicion != false)
						{
							$inicioCadena = substr($r['ubicacion'], 0, $posicion);
							
							if($inicioCadena != $encabezadoNivel2)
							{																
								//agregar encabezado al menu
								$sqlCabeza = "SELECT * FROM tbl_menu_emp WHERE ubicacion = '".$inicioCadena."'";
								$resCabeza = mysql_query($sqlCabeza);
								if(mysql_num_rows($resCabeza)>0)
								{
									$row = mysql_fetch_array($resCabeza);
									$encabezadoNivel2 = $inicioCadena;
									
									echo'<li class="dropdown-submenu" style="text-align: left;">';
									echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.htmlentities($row['descripcion']).'</a>';
									//ahora armar cuerpo
									echo '<ul class="dropdown-menu">';
									echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
								}
								else
								{
									echo "Error de lectura en busqueda de la cabecera";
								}
							}
							else
							{
								//agregar item al menu
								echo '<li style="text-align: left;"><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
								if($count == 2)
									echo '</ul></li>';
								$count++;
							}
						}
						break;
					
					case "4":
						//3° Nivel
						break;
					
					default:
						echo "Error => Hoooo!!!";
						break;
				}
			}
			//cerramos el ultimo item del menu
			echo '</ul></li>';
	       }
	       else
	       {
			echo "Error en la asignacion de permisos";
	       }

	}
	
	function menu_permisos($id)
	{
	
		$var = new conexion();
		$var->conectarse();
		 


		$consulta = "Select * From tbl_menu_emp Where imagen != '' ORDER BY ubicacion";		
		$resu = mysql_query($consulta);
		if(mysql_num_rows($resu)>0)
		       {
			       while($row = mysql_fetch_array($resu))
				       {
					       echo'<li class="dropdown">';
					       echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.htmlentities($row['descripcion']).'<b class="caret"></b></a>';
					       
					       //ahora armar cuerpo
					       echo '<ul class="dropdown-menu">';
					       $inicio = $row['ubicacion']."/";
					       
					       $cons = "Select * From tbl_menu_emp Where ubicacion Like '$inicio%' ORDER BY descripcion" ;
						$res = mysql_query($cons);
						if(mysql_num_rows($res)> 0)
							{
								while($r = mysql_fetch_array($res))
								{
									//Preguntar por si es sub-menu
									$ubicacion = $r['ubicacion']."/";
									$subM    = "Select * From tbl_menu_emp Where ubicacion Like '$ubicacion%' ORDER BY descripcion";
									$subMres = mysql_query($subM);
									
									if(mysql_num_rows($subMres)> 0)
									{
										echo '<li class="dropdown-submenu" style="text-align: left;">
											<a tabindex="-1" href="#">'.htmlentities($r['descripcion']).'</a>
												<ul class="dropdown-menu">';
												while($sb = mysql_fetch_array($subMres))
												{
													//preguntar si esta chequeado
													if($id > 0)
													{
														$sqlCant    = "Select * from tbl_grupos_permisos Where id_grupo = ".$id." and id_menu = ".$sb['id_menu']."";
														$sqlCantRes = mysql_query($sqlCant);
														if(mysql_num_rows($sqlCantRes)> 0)
														{
															echo '<li><a><input type="checkbox" id="'.$sb['id_menu'].'" checked> '.htmlentities($sb['descripcion']).'</a></li>';
														}
														else
														{
															echo '<li><a><input type="checkbox" id="'.$sb['id_menu'].'"> '.htmlentities($sb['descripcion']).'</a></li>';
														}
													}
													else
													{
														echo '<li><a><input type="checkbox" id="'.$sb['id_menu'].'"> '.htmlentities($sb['descripcion']).'</a></li>';
													}
												}
										echo '		</ul>
										      </li>';
									}
									else
									{
										//Preguntar si esta chequeado
										if($id > 0)
										{
											$sqlCant    = "Select * from tbl_grupos_permisos Where id_grupo = ".$id." and id_menu = ".$r['id_menu']."";
											$sqlCantRes = mysql_query($sqlCant);
											if(mysql_num_rows($sqlCantRes)> 0)
											{
												echo '<li style="text-align: left;"><a><input type="checkbox" id="'.$r['id_menu'].'" checked> '.htmlentities($r['descripcion']).'</a></li>';
											}
											else
											{
												echo '<li style="text-align: left;"><a><input type="checkbox" id="'.$r['id_menu'].'"> '.htmlentities($r['descripcion']).'</a></li>';	
											}
										}
										else
										{
											echo '<li style="text-align: left;"><a><input type="checkbox" id="'.$r['id_menu'].'"> '.htmlentities($r['descripcion']).'</a></li>';	
										}
										
									}
									
								}
							}
					       
					       echo '</ul></li>';
				       }
			       }
	}
	
	function getNotes($date){
		/*
		$sql = 'Select 
					TIMESTAMPADD( DAY , ( 0 - WEEKDAY( \''.$date.'\' ) ) , CURDATE( ) ) AS PrimerDiaSemana, 
					TIMESTAMPADD( DAY , ( 6 - WEEKDAY( \''.$date.'\' ) ) , CURDATE( ) ) AS UltimoDiaSemana,
					TIMESTAMPADD( DAY , ( -1 - WEEKDAY( \''.$date.'\' ) ) , CURDATE( ) ) AS SemanaAnterior,
					TIMESTAMPADD( DAY , ( 7 - WEEKDAY( \''.$date.'\' ) ) , CURDATE( ) ) AS SemanaPosterior';
		*/
		$sql = 'SELECT  
					DATE_SUB(  \''.$date.'\', INTERVAL WEEKDAY(  \''.$date.'\' ) DAY ) AS PrimerDiaSemana, 
					DATE_ADD( DATE_SUB(  \''.$date.'\', INTERVAL WEEKDAY(  \''.$date.'\' ) DAY ) , INTERVAL 6 DAY ) AS UltimoDiaSemana,
					DATE_ADD( DATE_SUB(  \''.$date.'\', INTERVAL WEEKDAY(  \''.$date.'\' ) DAY ) , INTERVAL -1 DAY ) AS SemanaAnterior,
					DATE_ADD( DATE_SUB(  \''.$date.'\', INTERVAL WEEKDAY(  \''.$date.'\' ) DAY ) , INTERVAL 7 DAY ) AS SemanaPosterior';
		
		$res = mysql_query($sql);

	if(mysql_num_rows($res)>0) {
		while($r =  mysql_fetch_array($res))
		{
			echo '<br><div class="row">
					<div class="span12" style="text-align: left;">';
					
			echo 		'<a href="principal.php?day='.$r['SemanaAnterior'].'">';
			echo 		'<button class="btn btn-info" type="button" title="Anterior"><i class="icon-chevron-left icon-white"></i></button></a>';
			echo 			'  <b>'.$this->Invert_Fecha($r['PrimerDiaSemana']).'</b>   al   <b>'.$this->Invert_Fecha($r['UltimoDiaSemana']).'</b>  '; 
			echo 		'<a href="principal.php?day='.$r['SemanaPosterior'].'">';
			echo 		'<button class="btn btn-info" type="button" title="Siguiente"><i class="icon-chevron-right icon-white"></i></button></a>';
			
			echo '	</div>
				  </div><br>';
			
			$fecha = date($r['PrimerDiaSemana']);	
			$band = false;
			for ($i = 0 ; $i < 7 ; $i++)
			{
				$nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) ) ;
				$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
					  
				$sql = 'Select * From Notas Where DATE( fecha ) =  \''.$nuevafecha.'\' and usrId = '.$_SESSION['id_usuario'].' order by fecha desc';
				$notes = mysql_query($sql);
				if(mysql_num_rows($notes)>0)
				{
					$band = true;
					echo '<div class="row">
							<div class="span12" style="text-align: left;">
								<b>'.$this->Invert_Fecha($nuevafecha).'</b>
							</div>
						  </div>';
					while($n =  mysql_fetch_array($notes))
					{
						$tipo = '';
						$icon = '';
						$text = '';
						switch($n['tipo'])
						{
							case '1':
								$icon = '<img src="./assest/plugins/buttons/icons/information.png" width="15" heigth="15" style="cursor: pointer;" />';
								$tipo = '58, 135, 173, 0.1';
								break;
							case '2':
								$icon = '<img src="./assest/plugins/buttons/icons/bullet_error.png" width="15" heigth="15" style="cursor: pointer;" />';
								$tipo = '252, 248, 227, 0.9';
								break;
							case '3':
								$icon = '<img src="./assest/plugins/buttons/icons/exclamation.png" width="15" heigth="15" style="cursor: pointer;" />';
								$tipo = '185, 74, 72, 0.2';
								break;
						}
						if($n['leido'] == 0){
							$text = '<a href="#" style="text-decoration:none; color:black;" onClick="LeerPop('.$n['idNota'].','.$n['leido'].',\''.$n['titulo'].'\',\''.$n['descripcion'].'\',\''.$n['fecha'].'\','.$n['tipo'].')">
										<b>'.$n['titulo'].': </b> '.substr($n['descripcion'], 0, 20).'...</a>';
						}
						else{
							$text = '<a href="#" style="text-decoration:none; color:black;" onClick="LeerPop('.$n['idNota'].','.$n['leido'].',\''.$n['titulo'].'\',\''.$n['descripcion'].'\',\''.$n['fecha'].'\','.$n['tipo'].')">
										<strike>'.$n['titulo'].': '.substr($n['descripcion'], 0, 20).'...</strike></a>';
						}
						$checked = $n['leido'] == 1 ? "checked" : "";
						echo '<div class="row">
							<div class="span12" style="text-align: left;">
								<div class="span4 alert" style="background: rgba('.$tipo.'); color: black;">
									<input type="checkbox" onClick="Leer('.$n['idNota'].','.$n['leido'].')" '.$checked.'> 
									'.$icon.' '.$text.'
								</div>
							</div>
						  </div>';
					}
				}else{
					/*
					echo '<div class="row">
							<div class="span12" style="text-align: left;">
								<div class="span4 alert alert-success" style="filter:alpha(opacity=50); opacity:0.5;"><i>No hay notas</i></div>
							</div>
						  </div>';
					*/
				}
			}
			
			if($band == false)
			{
				echo '<div class="row">
						<div class="span12" style="text-align: left;">
							<div class="span4 alert" style="background: rgba(189,189,189,0.3); color: black;">
								No hay notas para la semana seleccionada.
							</div>
						</div>
					  </div>';
			}
		}
	}
	else {
		echo "problemas";
	}
		//var_dump($_SESSION['id_usuario']);
	}
	
	function Invert_Fecha($date){
		$da = explode('-',$date);
		
		return $da[2].'-'.$da[1].'-'.$da[0];
	}
}
?>
