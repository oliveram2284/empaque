<?php
session_start();

$esAdmin = $_SESSION['admin'];

include("conexion.php");
$var = new conexion();
$var->conectarse();

$arre = explode('~',$_POST['variable']);
$sql  = "";
$order = $_GET['order'];
$by = $_GET['By'];

switch($by)
{
	case 1: $by = "ped.codigo ";break;
	case 2: $by = "ped.ClienteNombre ";break;
	case 3: $by = "ped.descripcion ";break;
	case 4: $by = "ped.femis ";break;
	default: $by = "ped.codigo ";break;
}

$by .= $order;

foreach($arre as $filtro)
	{
		$dato = explode(':',$filtro);
		$caso = $dato[0];
		$valor = $dato[1];
		switch($caso)
			{
			//filtro por cliente
			case 1 :
				if($sql == "")
					{
						$sql = "clientefact = '".$valor."' ";	
					}
					else
						{
							$sql .= " and clientefact = '".$valor."' ";	
						}
				break;
			//filtro por articulo
			case 2 : 
				if($sql == "")
					{
						$sql = " descrip3 = '".$valor."' ";	
					}
					else
						{
							$sql .= " and descrip3 = '".$valor."' ";	
						}
				break;
			//filtro por estado
			case 3 :
				$condition  = "";
				
				if($valor != "0")
				{
					$status = explode(',',$valor);
					foreach($status as $st)
					{
						$estados = "";
						switch($st)
						{
							//Ingresados
							case "A":
								$estados = "(estado ='I' or estado = 'E')";
								//$condition = $estados;
								break;
							//Recibidos
							case "B":
								$estados = "(estado ='A' or estado = 'D')";
								//$condition = $estados;
								break;
							//Preprensa
							case "C":
								$estados = "(estado ='N' or estado = 'NS' or estado = 'AP' or estado = 'SI' or estado = 'NO' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PX' or estado = 'U' or estado = 'MO' or estado = 'RV' or estado = 'DI' or estado = 'CL' or estado = 'NC' or estado = 'CP' or (estado = 'CA' and calidad = 'CA')) and (calidad != 'PR' and calidad != 'PA') and (estado != 'U' and calidad !='X')";
								//$condition = $estados;
								break;
							//Producción
							case "D":
								$estados = " ((estado ='P' or estado = 'NS' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PR') ) and (polimeroEnFacturacion = '1') or
									     ((estado ='P' or estado = 'NS' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PR') ) and (polimeroEnFacturacion = '') or
									     ((estado ='P' or estado = 'NS' or estado = 'B' or estado = 'PO' or estado = 'PA' or estado = 'PR') ) and (polimeroEnFacturacion = '2') ";
								//$condition = $estados;
								break;
							//Curso
							case "E":
								$estados = " (estado ='U' or estado = 'RA') and (polimeroEnFacturacion = '2' or polimeroEnFacturacion = '' or polimeroEnFacturacion = '1')";
								//$condition = $estados;
								break;
							//Terminados
							case "F":
								$estados = " (estado ='T')";
								//$condition = $estados;
								break;
							//Terminados Parcial
							case "G":
								$estados = " (estado ='TP')";
								//$condition = $estados;
								break;
							//Cancelados
							case "H":
								$estados = " (estado ='C')";
								//$condition = $estados;
								break;
							//Rechazados
							case "I":
								$estados = " (estado ='R' or estado = 'RR' or estado = 'RN' )";
								//$condition = $estados;
								break;
						}
						
						if($estados != "")
						{
							if($condition == "")
								$condition = $estados;
								else
								$condition .= " or ".$estados;
						}
					}
				}
				
				if($sql == "")
					{
						if($condition != "" && $condition != " ")
						{
							$sql = " ( ". $condition. " ) ";
						}
					}
					else
						{
							//echo "1".$sql."2".;
							if($condition != "")
							{
								$sql .= "and ( ". $condition. " ) ";
							}
						}
				break;
			    
			case 4 :
			    if($sql == "")
				{
				    $sql = " det.Vendedor = ".$valor." ";
				}
				else
				    {
					$sql .= " and det.Vendedor = ".$valor." ";
				    }
			    break;
			
			//filtro por fecha 
			case 5 : 
				$fechas = explode('/',$valor);
				$desde = invertirFecha($fechas[0]);
				$hasta = invertirFecha($fechas[1]);
				
				if($sql == "")
					{
						$sql = " ped.femis between '".$desde."' AND '".$hasta."' ";
					}
					else
						{
							$sql .= " and ped.femis between '".$desde."' AND '".$hasta."' ";	
						}
				break;
			
			}
	}
	
//.........................................................
//.. En el caso de que el usuario no sea el administrador .
//.. vamos a filtrar solo los pedidos que pertenezcan .....
//.. al usuario logueado ..................................
//.........................................................
if($esAdmin == 0)
    {
        if($sql == "")
            {
                $sql = " det.Vendedor = ".$_SESSION['id_usuario']." ";
            }
            else
            {
                $sql .= " and det.Vendedor = ".$_SESSION['id_usuario']." ";
            }
    }
//.........................................................

if($sql != "")
	{
		$condicion = $sql;
    
        $sql = "SELECT
		    ped.npedido id,
		    ped.codigo nro,
		    ped.clienteNombre clie,
		    ped.descripcion arti,
		    ped.clienteNombre fact,
		    ped.femis fecha,
		    ped.poliNumero as polId,
		    ped.esCI as CI,
		    ped.caras as caras,
		    CASE WHEN (Select count(*) from pedidoshojasderuta Where idPedido = ped.npedido) > 0 THEN 1 ELSE 0 END as HR,
		    (Select pedidoEstado From tbl_log_pedidos Where pedidoId = ped.npedido and pedidoEstado not in ('PE','CH','IH','PH','EH') ORDER BY logId DESC LIMIT 1) estado,
		    (Select logFecha From tbl_log_pedidos Where pedidoId = ped.npedido and pedidoEstado not in ('PE','CH','IH','PH','EH') ORDER BY logId DESC LIMIT 1) logFecha,
		    ped.prodHabitual
                    FROM pedidos ped 
                    INNER JOIN pedidosdetalle det ON det.idPedido = ped.npedido
                    WHERE ".$sql ." order by ".$by;
		                        
         //................................................................................
         //.. Copio la consulta para tenerla y poder ordenar por algun campo el resultado .
         //................................................................................
         $consulta = str_replace($order,"",$sql);
         echo '<input type="hidden" name="consul" id="consul" value="'.$consulta.'"/>';
	 //echo $sql;
         //................................................................................
        
		$resu = mysql_query($sql) or (die(mysql_error()));

		if(mysql_num_rows($resu) >  0)
			{				
				$condicion = str_replace('\'','~',$condicion);
				echo '<img src="assest/plugins/buttons/icons/page_white_acrobat.png" title="Exportar a PDF" onClick="ValidarExportacion()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '<img src="assest/plugins/buttons/icons/icono_excel.gif" title="Exportar a Exel" onclick="ValidarExportacionAPdf();">';
				echo '<strong style="margin-left: 60%">Cantidad de Pedidos: <span style="color:red; font-size: 20px;">'.mysql_num_rows($resu).'</span></strong>';
				echo "<table style=\"width:100%; font-size: 11px;\">
				<thead>
				<tr>
				<th style=\"text-align: center;\"></th>
				<th style=\"text-align: center;\"></th>
				<th style=\"text-align: center;\"></th>
				<th style=\"text-align: center;\" width=\"65px;\"><a onClick=\"Validar(1)\" style=\"cursor: pointer; text-decoration: none; color: black;\">N° Pedido</a></th>
				<th style=\"text-align: center;\" width=\"270px;\"><a onClick=\"Validar(2)\" style=\"cursor: pointer; text-decoration: none; color: black;\">Cliente</a></th>				
				<th style=\"text-align: center;\" width=\"270px;\"><a onClick=\"Validar(3)\" style=\"cursor: pointer; text-decoration: none; color: black;\">Artículo</a></th>
				<th style=\"text-align: center;\" width=\"80px;\"><a onClick=\"Validar(4)\" style=\"cursor: pointer; text-decoration: none; color: black;\">Fecha Emisión</a></th>
				<th style=\"text-align: center;\" width=\"130px;\">Fecha <br>Estado Actual</th>
				<th style=\"text-align: center;\">Estado Actual</th>
				</tr></thead>";
				$color = "#FFFFFF";
				while($row = mysql_fetch_array($resu))
					{
						$fuente = "black";
						if($row['estado'] == "C")
							$fuente = "red";
						echo '
							<tr style="height: 10px;background-color: '.$color.'; color:'.$fuente.'; cursor: pointer;">';
							if($row['prodHabitual'] == 1) //polId
							echo '<td style="text-align: center;">
								'.ArmarPolimeroLog($row['polId'],$row['nro'],$row['clie'],$row['caras']).'
							      </td>';
							else
							echo '<td></td>';
						echo'
								<td style="text-align: center;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row['id'].'\')" style="cursor: pointer;"></td>';
						if($row['CI'] == null || $row['CI'] == '')
							{
								if($row['HR'] == 1)
									echo'<td><a onclick="getHojaRuta('.$row['id'].')">HR</a></td>';
									else
									echo'<td></td>';
							}
							else
							echo'<td><a onclick="getHojaRuta('.$row['id'].')">CI</a></td>';
						echo'	<td><a style="color: '.$fuente.'" onclick="Seguimiento(\''.$row['id'].'\',\''.$row['nro'].'\')">'.$row['nro'].'</a></td>
								'.getRoww($row['clie']).'
								'.getRoww($row['arti']).'
								<td style="text-align: center;">'.invertirFecha($row['fecha']).'</td>
								<td style="text-align: center;">'.FormatDate($row['logFecha']).'</td>
								<td style="text-align: center;">'.DeterminaEstado($row['estado'], $row['id']).'</td>
								';
						echo '	</tr>
						';
						
						if($color == "#FFFFFF")
							$color = "#A9F5A9";
							else
							$color = "#FFFFFF";
					}

			echo '</table>';
			}else
				{
				echo '<b><i>No se encontraron resultados.</i></b>';
				}
				
                
	}else
		{
		echo "<b><i>Filtro no v&aacute;lido.</i></b>";	
		}
//--------------- FUNCIONES -------------------
function getRoww($row)
{
  $tooltip = $row;
  $row = utf8_encode(substr($row, 0, 40));
  if(strlen($tooltip)> 40)
    $row .= '...';
  return '<td title="'.$tooltip.'">'.$row.'</td>';
}
 
 function getRow($row)
 {
  $tooltip = $row;
  $row = utf8_encode(substr($row, 0, 40));
  if(strlen($tooltip)> 40)
    $row .= '...';
  return '<td>'.$row.'</td>';
 }
 
function invertirFecha($date)
	{
		$dato = explode('-',$date);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
	}
    
function DeterminaEstado($estado, $id)
    {
        switch($estado)
            {
                case "I":
		case "E":
                    return "Ingresado";
                    break;
		case "R":
		case "RR":
		case "RN":
		    return "<a style=\"color: red;\" onClick=\"AbrirMotivosRechazados(".$id.")\">Rechazado</a>";
		    break;
		case "C":
		    return "<a style=\"color: red;\" onClick=\"AbrirMotivosCancelados(".$id.")\">Cancelado</a>";
		    break;
		case "A":
		case "D":
		    return "Recibido";
		    break;
		case "N":
		     return getLogPolimero($id,'Preprensa(Nuevo)');
		     break;
		case "NO":
		      return getLogPolimero($id,'No Aprobado');
		      break;
		case "SI":
		case "NC":
		case "RV":
		      return getLogPolimero($id,'Preprensa');
		      break;
		case "DI":
			return getLogPolimero($id,'Preprensa');
			break;
		case "CL":
		case "CP":
		    return getLogPolimero($id,'Preprensa');
		    break;
		case "AP":
		case "MO":
		    return getLogPolimero($id,'Preprensa');
		    break;
		    //return "Aprobación de Producción";
		    //break;
		case "CA":
		    return getLogPolimero($id,'Preprensa');//log de polimero
		    break;
		case "P":
		    return "Of. Produc.";
		    break;
		case "U":
		case "UA":
		    return "<a onClick=\"getHojaRuta(".$id.")\">Curso</a>";
		    break;
		case "TP":
		    return "<a onClick=\"openET(".$id.")\">Terminado Parcial</a>";
		    break;
		case "T":
		    return "<a onClick=\"openET(".$id.")\">Terminado</a>";
		    break;
		case "PE":
		    return "Edición de Precio";
			break;
                default:
                    return "";
                    break;
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

function getLogPolimero($id,$name)
{
	$sql = "Select * from Polimeros Where idPedido = ".$id;
	$resu = mysql_query($sql) or (die(mysql_error()));
		
	if(mysql_num_rows($resu) >  0)
	{
		while($row = mysql_fetch_array($resu))
		{
			$sql = "Select * from pedidos where npedido =".$id;
			$ped = mysql_query($sql) or (die(mysql_error()));
			$np = "";
			$cli = "";
			
			while($row2 = mysql_fetch_array($ped))
			{
				$np = $row2['codigo'];
				$cli = $row2['clienteNombre'];
			}
			
			return "<a onClick=\"openLog(".$row['id_polimero'].",'".$row['ordenDeTrabajo']."','".$row['trabajo']."','".$np."','".$cli."')\">".$name."</a>";
		}
		//return "<a href=\"#\" onClick=\"getLogPolimero(".$id.")\">".$name."</a>";		
	}
	else
	{
		return $name;		
	}
	
}

function getLastDateAndStatus($idPedido)
{
    $sql = "Select pedidoEstado, logFecha From tbl_log_pedidos Where pedidoId = ".$idPedido." ORDER BY logId DESC LIMIT 1";
    
    $resu = mysql_query($sql) or (die(mysql_error()));
		
    if(mysql_num_rows($resu) >  0)
    {
	while($row = mysql_fetch_array($resu))
	{
	    echo '<td style="text-align: center;">'.FormatDate($row['logFecha']).'</td>';
	    echo '<td style="text-align: center;">'.DeterminaEstado($row['pedidoEstado']).'</td>';
	}
    }
    else
    {
	echo '<td style="text-align: center;"></td>';
	echo '<td style="text-align: center;"></td>';
    }
}

function FormatDate($fecha)
{
    $array = explode(' ', $fecha);
    $date = explode('-',$array[0]);
    
    $hour = explode(':',$array[1]);
    return $date[2]."-".$date[1]."-".$date[0]." ".$hour[0].":".$hour[1];
}
//---------------------------------------------
?>