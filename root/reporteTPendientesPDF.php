<?php
session_start();

$esAdmin = $_SESSION['admin'];

include("conexion.php");
$var = new conexion();
$var->conectarse();

$arre = explode('~',$_GET['xfiltros']);
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
				//$condition .= " and (estado != 'T')";
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
$html = "";
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
		    ped.entrega as entrega,
		    DATEDIFF(CURDATE(), ped.entrega) as diferencia,
		    ped.cantidad_entregadas as entregado,
		    ped.esCI as CI,
		    ped.caras as caras,
		    det.CantidadTotal as total,
		    CASE WHEN (Select count(*) from pedidoshojasderuta Where idPedido = ped.npedido) > 0 THEN 1 ELSE 0 END as HR,
		    (Select pedidoEstado From tbl_log_pedidos Where pedidoId = ped.npedido and pedidoEstado not in ('PE','CH','IH','PH','EH') ORDER BY logId DESC LIMIT 1) estado,
		    ped.prodHabitual,
		    (Select descripcion From materiales Where idMaterial = det.material) as material
                    FROM pedidos ped 
                    INNER JOIN pedidosdetalle det ON det.idPedido = ped.npedido
                    WHERE ".$sql ." and (estado != 'T' and estado != 'C') order by ".$by;
		                              
		$resu = mysql_query($sql) or (die(mysql_error()));

		if(mysql_num_rows($resu) >  0)
			{				
				$condicion = str_replace('\'','~',$condicion);
				$html .= '<strong style="margin-left: 60%">Cantidad de Pedidos: <span style="color:red; font-size: 20px;">'.mysql_num_rows($resu).'</span></strong><br>';
				$html .= "<table style=\"width:100%; font-size: 11px;\">
				<thead>
				<tr>
				<th style=\"text-align: center;\"></th>
				<th style=\"text-align: center;\" width=\"65px;\">N° Pedido</th>
				<th style=\"text-align: center;\" width=\"250px;\">Cliente</th>				
				<th style=\"text-align: center;\" width=\"250px;\">Artículo</th>
				<th style=\"text-align: center;\" >F.Emisión</th>
				<th style=\"text-align: center;\" >F.Entrega</th>
				<th style=\"text-align: center;\" >Cantidad</th>
				<th style=\"text-align: center;\">Estado</th>
				<th></th>
				<th style=\"text-align: center;\">Material</th>
				</tr></thead>";
				$color = "#FFFFFF";
				while($row = mysql_fetch_array($resu))
					{
						$fuente = "black";
						if($row['estado'] == "C")
							$fuente = "red";
						$html .= '
							<tr style="height: 20px;background-color: '.$color.'; color:'.$fuente.'; cursor: pointer;">';
							if($row['prodHabitual'] == 1) //polId
							$html .= '<td style="text-align: center;">
								'.ArmarPolimeroLog($row['polId'],$row['nro'],$row['clie'],$row['caras']).'
							      </td>';
							else
							$html .= '<td></td>'; //onClick="ImprimirReporte(\''.$row['id'].'\')"
						$trabajoInfo = "-";
						$otInfo = "0000";
						if($row['polId'] != 0 && $row['polId'] != null){
							$respuesta = getOTyTrabajo($row['polId']);
							$respuesta = explode('~', $respuesta);
							
							$otInfo = $respuesta[0];
							$trabajoInfo = $respuesta[1];
						}
							
						$html .= '	<td><a style="color: '.$fuente.'" >'.$row['nro'].'</a></td>
								'.getRoww($row['clie']).'
								'.getRoww($row['arti']).'
								<td style="text-align: center;">'.invertirFecha($row['fecha']).'</td>
								<td style="text-align: center;">&nbsp;&nbsp;&nbsp;'.invertirFecha($row['entrega']).'</td>
								<td style="text-align: right;">'.$row['total'].'</td>
								<td style="text-align: center;">'.DeterminaEstado($row['estado'], $row['id']).'</td>
								<td style="text-align: center;">'.armarSemaforo($row['diferencia']).'</td>
								<td style="text-align: center;">'.$row['material'].'</td>
								';
						$html .= '	</tr>
						';
						
						if($color == "#FFFFFF")
							$color = "#A9F5A9";
							else
							$color = "#FFFFFF";
					}

			$html .= '</table>';
			}else
				{
				$html .= '<b><i>No se encontraron resultados.</i></b>';
				}
				
                
	}else
		{
		$html .= "<b><i>Filtro no v&aacute;lido.</i></b>";	
		}
//--------------- FUNCIONES -------------------
function armarSemaforo($diferencia)
{
	if($diferencia > 0)
		$color = "#FE2E64";
		else
		if($diferencia + 5 > 0)
			$color = "#FF8000";
			else
				$color = "#008040;";	
	return '<div
			style="color:'.$color.'"
			><b>'.(abs($diferencia) > 99 ? '+99' : abs($diferencia)).'</b>
		</div>';
}

function getOTyTrabajo($polId)
{
	$sql = "Select ordenDeTrabajo, trabajo from Polimeros Where id_polimero = ".$polId;
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
		}
		
	}
	
	return $code.'~'.$trabajo;
}

function getRoww($row)
{
  return '<td>'.$row.'</td>';
}
 
 function getRow($row)
 {
  $row = utf8_encode($row);
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
		    return "<a style=\"color: red;\">Rechazado</a>";
		    break;
		case "C":
		    return "<a style=\"color: red;\">Cancelado</a>";
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
		case "CA":
		    return getLogPolimero($id,'Preprensa');//log de polimero
		    break;
		case "P":
		    return "Of. Produc.";
		    break;
		case "U":
		case "UA":
		    return "<a>Curso</a>";
		    break;
		case "TP":
		    return "<a>Terminado Parcial</a>";
		    break;
		case "T":
		    return "<a>Terminado</a>";
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
		$texto .= '<div style="color:Blue">
				<b>N</b>
			   </div>';
	}
	else
	{
		if($polId == "" || $polId == null)
		{
			$texto .= '<div style="width: 20px; color:Red">
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
				$texto .= '<div	style="width: 20px; color: orange">
					<b>N</b>
				   </div>';
			}
			else
			{
				$texto .= '<div	style="width: 20px; color: green;">
					<b>N</b>
				   </div>';
			}
		}
	}
	return $texto;
}

function getLogPolimero($id,$name)
{
		return $name;		
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


//se incluye la libreria de dompdf
require_once("HTMLtoPDF/dompdf/dompdf_config.inc.php");

//se crea una nueva instancia al DOMPDF
$dompdf = new DOMPDF();
//se carga el codigo html
$dompdf->load_html(utf8_decode($html));
//aumentamos memoria del servidor si es necesario
ini_set("memory_limit","300M"); 
//Tamaño de la página y orientación 
$dompdf->set_paper('a4', 'landscape');
//lanzamos a render
$dompdf->render();
//guardamos a PDF
$dompdf->stream("TrabajosPedndientes.pdf");

?>