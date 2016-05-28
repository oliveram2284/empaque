<? // aca se determinan los permisos de acceso 
session_start();
if($_SESSION['id_usuario'])
	{
	 $permi=split("~",$_SESSION['permisos']); 
	 $equipo = 0;
	 for($i=0;$permi[$i];$i++)
		{
	 	 if(($permi[$i] == 2)||($permi[$i] == 1)) //tiene permiso para ver o tratar los equipos
	 		{
		 	 $equipo = 2;
			}
		}
	}
	else
		{
	 	 header("Location: index.php");
		}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Principal</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {  
        SCROLLBAR-FACE-COLOR:#FFFFFF;
        SCROLLBAR-HIGHLIGHT-COLOR:#CCCCCC;
        SCROLLBAR-SHADOW-COLOR:#000000;
        SCROLLBAR-3DLIGHT-COLOR:#CCCCCC;
        SCROLLBAR-ARROW-COLOR:#000000;
        SCROLLBAR-TRACK-COLOR:#CCCCCC;
        SCROLLBAR-DARKSHADOW-COLOR:white 
}

</style>
<script language="JavaScript">

function AbrirCentrado(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + ''); 
nuevaVentana.focus();
}

function alerta(valor)
	{
	 window.open("estado_componentes.php?id="+valor,"ventana1","width=800,height=800,scrollbars=YES")
	}
	
function datos_equipo(valor)
	{
	 window.open("datos_equipo.php?id="+valor,"ventana1","width=800,height=800,scrollbars=YES")
	}
	
function alerta_sr(valor)
	{
	 window.open("solicitudes_reparacion.php?id="+valor,"ventana1","width=800,height=800,scrollbars=YES")
	}
</script>

<SCRIPT language=JavaScript1.2 src="menu/stm31.js" type=text/javascript> </SCRIPT>
<script language="javascript" src="abm_iniciador_js.js" type="text/javascript">
</script>
<LINK href="egipcio.css" type=text/css rel=stylesheet>
<style type="text/css">
<!--

-->
</style>
<style type="text/css">
<!--
.Estilo2 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo10 {color: #000000}
-->
</style>


<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body >
<center>
<p align="center"><img src="imag/logo.jpg" width="283" height="146" /></p><br>
<p align="center"><div align="center" class="tituloformulario" >
         			<script language="JavaScript1.2" src="menu/mr.js" type="text/javascript"></script>
     			  </div></p>

 <form name="inicio" method="post">
    <table width="70%" bgcolor="#0066FF" border="1">
      <?
	 if($equipo)
	 {
	 include("conexion.php");
	 $var = new conexion();
	 $var->conectarse();
	 
	 echo '<tr><td></td>';
	 $time2 = mktime(0,0,0,date("m"),date("d"),date("Y"));//fecha actual
	 for($i = 0; $i<10; $i++)
	 	{
		 echo '<td>'.date("d-m-Y",$time2).'</td>';
		 $time2 = $time2 + (60*60*24);
		}
	 echo '</tr><tr>';
	 
	 $consulta= "Select id_equipo, descripcion, marca, numero, hubicacion, fecha_ultimalectura, ultima_lectura, tipo_horas From equipos Where estado=0 Order By descripcion";
	 $resul = mysql_query($consulta);
	 
	 //cuerpo de la tabla 
	 while($row= mysql_fetch_array($resul))
	 	{
		  echo '<td bgcolor="#FFFFFF" onClick="datos_equipo('.$row["id_equipo"].')">'.$row["descripcion"].'</td>';
		  $calendario = array (0,0,0,0,0,0,0,0,0,0);
		  $calendario_sr = array (0,0,0,0,0,0,0,0,0,0);
		  
		  if($row["tipo_horas"]== 1) //equipo controlado por dias 
		  	{
			 obtener_fecha_proximo_control2($row["id_equipo"],&$calendario);
			 obtener_fecha_solicitud_reparacion($row["id_equipo"],&$calendario_sr);
			 for($i=0; $i<10;$i++)
			 	{echo '<td bgcolor="#FFFFFF">';
				 if(($calendario[$i]==0)&&($calendario_sr[$i]==0))
				 	{
					 //no hay tareas para ese equipo este dia 
					 echo '';
					}
					else
						{
						 if($calendario[$i]==1)//aviso de control
				 			{
							 echo '<img src="imag/tachuela verde.gif" onClick="alerta('.$row["id_equipo"].')">';
					 		}
						 if($calendario_sr[$i]==1)//aviso de control
				 			{
							 echo '<img src="imag/tachuela amarilla.gif" onClick="alerta_sr('.$row["id_equipo"].')">';
					 		}
						 }
				}	
			 }else
			 	{
				 obtener_hora_proximo_control($row["id_equipo"],&$calendario,$row["ultima_lectura"]);
				 obtener_fecha_solicitud_reparacion($row["id_equipo"],&$calendario_sr);
				 for($i=0; $i<10;$i++)
			 		{
					 echo '<td bgcolor="#FFFFFF">';
				 	 if(($calendario[$i]==0)&&($calendario_sr[$i]==0))
				 		{
					 	//no hay tareas para ese equipo este dia 
					 	echo '';
						}
						else
							{
						 	 if($calendario[$i]==1)//aviso de control
				 				{
							 	echo '<img src="imag/tachuela verde.gif" onClick="alerta('.$row["id_equipo"].')">';
					 			}
							if($calendario_sr[$i]==1)//aviso de control
				 				{
							 	echo '<img src="imag/tachuela amarilla.gif" onClick="alerta_sr('.$row["id_equipo"].')">';
					 			}
						 	}
					}
				 }
		
		
		 echo '</tr><tr>';
		 }
		
	  }
	
//para equipos con venciminto de componentes por fecha
function obtener_fecha_proximo_control2($id,$calendario)
	{
	 $consulta = 'Select * From carga_componentes Where id_equipo ='.$id.'';
	 $result = mysql_query($consulta);
	 while($row = mysql_fetch_array($result))
	 	{
		 //cantidad proximo control
		 $canti = cantidad($row["perido"],$row["cantidad"]);
		 
		 //ultima lectura
		 $arre = split("-",$row["ultimo"]);
		 $ulti = mktime(0,0,0,$arre[1],$arre[2],$arre[0]);
		 
		 //fecha actual
		 $ahora = mktime(0,0,0,date("m"),date("d"),date("Y"));
		 
		 //proximo control 
		 $proximo = date("Y-m-d",($ulti+$canti));
		 
		 //diferencia 
		 $dife = ($ahora - ($ulti + $canti )) / (60*60*24);
		 
		 //echo $dife;
		 //estamos a tiempo y ubicamos en el calendario la fecha del proximo control 
		 if(($dife > -10)&&($dife <=0))
		 	{
			 $dife = abs($dife);
			 $calendario[$dife] = 1;
			}
			else //la fecha del proximo control ya paso de la fecha actual y debe realizarce un control urgente
				{
				 if($dife > 0)
				 	{
				 	 $calendario[0] = 1;
					}
				}
		}
	}
	
function obtener_fecha_solicitud_reparacion($id,$calen)
	{
	 $consulta = 'Select * From solicitud_reparacion Where id_equipo = '.$id.'';
	 $resu = mysql_query($consulta);
	 while($row = mysql_fetch_array($resu))
	 	{
		 if($row['estado']== 'A')
		 {
		 //obtener fecha sugerido
		 $arre = split("-",$row["f_sugerido"]);
		 $ulti = mktime(0,0,0,$arre[1],$arre[2],$arre[0]);
		 
		 //fecha actual
		 $ahora = mktime(0,0,0,date("m"),date("d"),date("Y"));
		 
		 //diferencia 
		 $dife = (($ahora - $ulti) / (60*60*24));
		 
		 //estamos a tiempo y ubicamos en el calendario la fecha del proximo control 
		 if(($dife > -10)&&($dife <=0))
		 	{
			 $dife = abs($dife);
			 $calen[$dife] = 1;
			}
			else //la fecha del proximo control ya paso de la fecha actual y debe realizarce un control urgente
				{
				 $calen[0] = 1;
				}
		  }
		}
	}

//para equipos con venciminto de componentes por hora
function obtener_hora_proximo_control($id,&$calendario,$ul_lec)
	{
	 $consulta = 'Select * From carga_componentes Where id_equipo ='.$id.'';
	 $result = mysql_query($consulta);
	 while($row = mysql_fetch_array($result))
	 	{
		 //cantidad proximo control (cada cuantos horas)
		 $canti = cantidad($row["perido"],$row["cantidad"]);
		 
		 //proximo control 
		 $proximo = $canti + $row["ultimo"];
		 
		 //ultima lectura componente
		 $ultima = $row["ultimo"];
		 
		 //proximos controles
		 $critico_1 = ($proximo - $row["critico1"]);
		 $critico_2 = ($proximo - $row["critico2"]);
		 $critico_3 = ($proximo - $row["critico3"]);
		 
		 //poner pinche 
		 if(($ul_lec >= $critico_1)||($ul_lec >= $critico_2)||($ul_lec >= $critico_3)||($ul_lec >= $proximo))
		 	{
			 $calendario[0] = 1;
			}
		}

	}

function cantidad($tipo,$cant)
	{
	 switch($tipo)//periodo
		{
		 case "HORAS" :
		 				{
						 $dias = $cant; //a las cuantas horas
						 break;
						}
		 case "DIARIO":
		 				{
						 $dias = 1*$cant*60*60*24; //cada cuantos dias
						 break; 
						}
		 case "MENSUAL":
		 				{
						 $dias = 30*$cant*60*60*24;
						 break;
						}	
		 case "SEMANAL":
		 				{
						 $dias = 7*$cant*60*60*24;
						 break;
						}
		 case "ANUAL":
		 				{
						 $dias = 365*$cant*60*60*24;
						 break;
						}			
		}
		return $dias;
	}	
	?>
    </table>
 </form>

</center>

</body>
</html>
