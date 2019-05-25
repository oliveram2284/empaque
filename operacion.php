<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

//nombre de la tabla 
$tabla = $_POST['tablaNom'];

//id del registro
$Id = $_POST['Pk'];

//accion que se va a ejecutar
//U : modificacion
//I : insercion
//D : eliminacion
$accion = $_POST['accion'];

$cons = "SELECT COLUMN_NAME
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = '$tabla'
			AND table_schema = 'mi000652_empaque1'
			AND COLUMN_KEY = 'PRI'";
			
	$re = mysql_query($cons);
	$aux = mysql_fetch_array($re);
	$Pk = $aux[0];

switch($accion)
	{
	case "D":
		{	
		 $consulta = "Delete From ".$tabla." where ".$Pk." = ".$Id;
		 $registro = mysql_query($consulta);
		 echo"<script>alert('Los datos se guardaron correctamente');  window.opener.location.href = window.opener.location.href; window.opener.document.location.reload();self.close()
			 if (window.opener.progressWindow) { window.opener.progressWindow.close() }
			window.close();
			</script>";
		 break;
		}
	case "I":{

		if($_REQUEST['tablaNom']=='usuarios'){
			$consulta = " Insert Into usuarios 
			(nombre,nombre_real,creado_por,
			id_tipo,id_sector,id_puesto,
			contrasenia,id_grupo,catId)
			Values ('".$_REQUEST['nombre']."','".$_REQUEST['nombre_real']."',0,0,0,0,'".$_REQUEST['contrasenia']."','".$_REQUEST['id_grupo']."','".$_REQUEST['catId']."')
			";
			
			$resu = mysql_query($consulta);
		}else{

			$consulta = "Select * From tbl_tablas where descripcion = '".$tabla."'";
			$resu = mysql_query($consulta);
			$row = mysql_fetch_array($resu);
			$idTabla = $row['id_tabla'];
		
			//buscamos los campos de la tabla
			$consulta = "Select * from tbl_campostablas where id_tabla ='".$idTabla."'";
			$resu = mysql_query($consulta);
			
			$campos = "";
			$tipos = "";
			while($row = mysql_fetch_array($resu))
				{
				 if($row['seCarga'] != 0)
				 	{
					 //este campo se debe cargar desde el formulario
					 if($campos == "")
					 	{
						 $campos = $row['nombreCampo'];
						 $tipos = $row['tipo'];
						}else
							{
							 $campos .= ",".$row['nombreCampo'];
							 $tipos .= ",".$row['tipo'];
							}
					}
				}
				
			 $arreCamp = explode(",",$campos);
			 $arreTipo = explode(",",$tipos);
			 
			 //print_r($arreCamp);
 			 //print_r($arreTipo);
			 $values = "";
			 
			 for($i=0 ; $i< count($arreCamp) ; $i++)
			 	{
				 //echo $arreCamp[$i];
				 //echo $arreTipo[$i]."<br>";
				 if($i == (count($arreCamp)-1))
				 	{
					 //es el ultimo 
					 if($arreTipo[$i] == "entero")
					 	{
						 $values .= "".$_POST[$arreCamp[$i]]."";
						}else
							{
							 $values .= "'".$_POST[$arreCamp[$i]]."'";
							}
					}else
						{
						 //no es el ultimo 
						 if($arreTipo[$i]== "entero")
						 	{
							 $values .= "".$_POST[$arreCamp[$i]].",";
							}else
								{
								$values .= "'".$_POST[$arreCamp[$i]]."',";
								}
						}
				}
			 
				$consulta = "Insert Into ".$tabla." (".$campos.") Values (".$values.")";
				die($consulta);
				mysql_query($consulta);
			}
			 echo"<script>alert('Los datos se guardaron correctamente');  window.opener.location.href = window.opener.location.href; window.opener.document.location.reload();self.close()
			 if (window.opener.progressWindow) { window.opener.progressWindow.close() }
			window.close();
			</script>";
		 break;
		}
	case "U":
		{
		 $consulta = "Select * From tbl_tablas where descripcion = '".$tabla."'";
		 $resu = mysql_query($consulta);
		 $row = mysql_fetch_array($resu);
		 $idTabla = $row['id_tabla'];
		
			//buscamos los campos de la tabla
			$consulta = "Select * from tbl_campostablas where id_tabla ='".$idTabla."'";
			$resu = mysql_query($consulta)or die(mysql_error());
			
			$campos = "";
			$tipos = "";
			
			while($row = mysql_fetch_array($resu))
				{
					//print_r($row);
				 if($row['seCarga'] != 0)
				 	{
					 //este campo se debe cargar desde el formulario
					 if($campos == "")
					 	{
						 $campos = $row['nombreCampo'];
						 $tipos = $row['tipo'];
						}else
							{
							 $campos .= ",".$row['nombreCampo'];
							 $tipos .= ",".$row['tipo'];
							}
					}
				}
				
			 $arreCamp = explode(",",$campos);
			 $arreTipo = explode(",",$tipos);
			 
			 $values = "";
			 
			 for($i=0 ; $i< count($arreCamp) ; $i++)
			 	{
				 //echo $arreCamp[$i];
				 //echo $arreTipo[$i]."<br>";
				 if($i == (count($arreCamp)-1))
				 	{
					 //es el ultimo 
					 if($arreTipo[$i] == "entero")
					 	{
						 $values .= "".$arreCamp[$i]." = ".$_POST[$arreCamp[$i]]."";
						}else
							{
							 $values .= "".$arreCamp[$i]." = '".$_POST[$arreCamp[$i]]."'";
							}
					}else
						{
						 //no es el ultimo 
						 if($arreTipo[$i]== "entero")
						 	{
							 $values .= "".$arreCamp[$i]." = ".$_POST[$arreCamp[$i]].",";
							}else
								{
								$values .= "".htmlentities($arreCamp[$i])." = '".htmlentities($_POST[$arreCamp[$i]])."',";
								}
						}
				}
			 
			 $consulta = "Update ".$tabla." Set ".$values."where ".$Pk." = ".$Id;
			 mysql_query($consulta);
			 echo"<script>alert('Los datos se guardaron correctamente');  window.opener.location.href = window.opener.location.href; window.opener.document.location.reload();self.close()
			 if (window.opener.progressWindow) { window.opener.progressWindow.close() }
			window.close();
			</script>";
		 break;	
		}	
	}

//luego de la operacion cerrar la ventana 	
echo '<script>window.close();</script>';

?>