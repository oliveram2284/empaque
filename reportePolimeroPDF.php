<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$arre = explode('~',$_GET['consulta']);
$sql  = "";
$filtra_por_proveedor = false;

foreach($arre as $filtro)
	{
		$dato = explode(':',$filtro);
		$caso = $dato[0];
		$valor = $dato[1];
		switch($caso)
			{
			//filtro por proveedor
			case 2 :
				if($sql == "")
					{
						$sql = "pol.id_proveedor = ".$valor." ";	
					}
					else
						{
							$sql .= " and pol.id_proveedor = ".$valor." ";	
						}
				$filtra_por_proveedor = true;
				break;
			//filtro por cliente
			case 1 : 
				if($sql == "")
					{
						$sql = " ped.clientefact = '".$valor."' ";	
					}
					else
						{
							$sql .= " and ped.clientefact = '".$valor."' ";	
						}
				break;
			//filtro por estados
			case 4 : 
				if($sql == "")
					{
						$status = explode(',',$valor);
						$valores = "";
						foreach ($status as $valor)
							{
								switch($valor)
								{
									case "N":
										if($valores == "")
											$valores = "'N','DI','NA'";
											else
											$valores .= ",'N','DI','NA'";
										break;
									case "C":
										if($valores == "")
											$valores = "'C','CL'";
											else
											$valores .= ",'C','CL'";
										break;
									case "E":
										if($valores == "")
											$valores = "'E','AC'";
											else
											$valores .= ",'E','AC'";
										break;
									case "RV":
										if($valores == "")
											$valores = "'J','L','RV','TP'";
											else
											$valores .= ",'J','L','RV','TP'";
										break;
									case "AP":
										if($valores == "")
											$valores = "'CR','AP','MO'";
											else
											$valores .= ",'CR','AP','MO'";
										break;
									case "A":
										if($valores == "")
											$valores = "'A'";
											else
											$valores .= ",'A'";
										break;
									case "G":
										if($valores == "")
											$valores = "'G'";
											else
											$valores .= ",'G'";
										break;
									case "H":
										if($valores == "")
											$valores = "'H'";
											else
											$valores .= ",'H'";
										break;
									case "I":
										if($valores == "")
											$valores = "'I'";
											else
											$valores .= ",'I'";
										break;
									case "K":
										if($valores == "")
											$valores = "'K'";
											else
											$valores .= ",'K'";
										break;
									case "M":
										if($valores == "")
											$valores = "'M'";
											else
											$valores .= ",'M'";
										break;
								}
							}
						
						if($valores == "")
						{
							//todos los estados
							$sql = " (SELECT polimeroEstado FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero and polimeroEstado not in ('Q','X') ORDER BY logId DESC LIMIT 1) <> 'TODOS' ";
						}
						else
						{
							//solo los estados seleccionados
							$sql .= " (SELECT polimeroEstado FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero and polimeroEstado not in ('Q','X') ORDER BY logId DESC LIMIT 1) in (".$valores.") ";
						}
						//$sql = " pol.id_motivo = ".$valor." ";	
					}
					else
						{
							$status = explode(',',$valor);
							$valores = "";
							foreach ($status as $valor)
								{
									switch($valor)
									{
										case "N":
											if($valores == "")
												$valores = "'N','DI','NA'";
												else
												$valores .= ",'N','DI','NA'";
											break;
										case "C":
											if($valores == "")
												$valores = "'C','CL'";
												else
												$valores .= ",'C','CL'";
											break;
										case "E":
											if($valores == "")
												$valores = "'E','AC'";
												else
												$valores .= ",'E','AC'";
											break;
										case "RV":
											if($valores == "")
												$valores = "'J','L','RV','TP'";
												else
												$valores .= ",'J','L','RV','TP'";
											break;
										case "AP":
											if($valores == "")
												$valores = "'CR','AP','MO'";
												else
												$valores .= ",'CR','AP','MO'";
											break;
										case "A":
											if($valores == "")
												$valores = "'A'";
												else
												$valores .= ",'A'";
											break;
										case "G":
											if($valores == "")
												$valores = "'G'";
												else
												$valores .= ",'G'";
											break;
										case "H":
											if($valores == "")
												$valores = "'H'";
												else
												$valores .= ",'H'";
											break;
										case "I":
											if($valores == "")
												$valores = "'I'";
												else
												$valores .= ",'I'";
											break;
										case "K":
											if($valores == "")
												$valores = "'K'";
												else
												$valores .= ",'K'";
											break;
										case "M":
											if($valores == "")
												$valores = "'M'";
												else
												$valores .= ",'M'";
											break;
									}
								}
							
							if($valores == "")
							{
								//todos los estados
								$sql = " and (SELECT polimeroEstado FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero and polimeroEstado not in ('Q','X') ORDER BY logId DESC LIMIT 1) <> 'TODOS' ";
							}
							else
							{
								//solo los estados seleccionados
								$sql .= " and (SELECT polimeroEstado FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero and polimeroEstado not in ('Q','X')  ORDER BY logId DESC LIMIT 1) in (".$valores.") ";
							}
						}
				break;
			//filtro por fecha de entrega 
			case 5 : 
				$fechas = explode('/',$valor);
				$desde = invertirFecha($fechas[0]);
				$hasta = invertirFecha($fechas[1]);
				
				if($sql == "")
					{
						$sql = " (SELECT logFecha FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero ORDER BY logId ASC LIMIT 1) between '".$desde."' AND '".$hasta."' ";
					}
					else
						{
							$sql .= " and (SELECT logFecha FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero ORDER BY logId ASC LIMIT 1) between '".$desde."' AND '".$hasta."' ";	
						}
				break;
			}
	}

$html = "";
	
if($sql != "")
	{
		$condicion = $sql;
		//echo $sql;
		if($filtra_por_proveedor == false)
		{
			//Unir con los que no tienen proveedor aun 
			$sql = "SELECT
					pol.id_polimero as id,
					pol.ordenDeTrabajo as orden,
					prov.razon_social as proveedor,
					ped.clienteNombre as cliente,
					pol.trabajo as trabajo,
					(SELECT logFecha FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero ORDER BY logId ASC LIMIT 1) as fecha,
					(SELECT polimeroEstado FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero and polimeroEstado not in ('Q','X') ORDER BY logId DESC LIMIT 1) as estado
				FROM
					polimeros AS pol
				LEFT JOIN
					proveedores AS prov ON prov.id_proveedor = pol.id_proveedor
				JOIN
					pedidos as ped ON pol.idPedido = ped.npedido
				WHERE
					".$sql;		
		}
		else
		{
			$sql = "SELECT
					pol.id_polimero as id,
					pol.ordenDeTrabajo as orden,
					prov.razon_social as proveedor,
					ped.clienteNombre as cliente,
					pol.trabajo as trabajo,
					(SELECT logFecha FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero ORDER BY logId ASC LIMIT 1) as fecha,
					(SELECT polimeroEstado FROM tbl_log_polimeros WHERE polimeroId = pol.id_polimero and polimeroEstado not in ('Q','X') ORDER BY logId DESC LIMIT 1) as estado
				FROM
					polimeros AS pol
				inner JOIN
					proveedores AS prov ON prov.id_proveedor = pol.id_proveedor
				JOIN
					pedidos as ped ON pol.idPedido = ped.npedido
				WHERE
					".$sql;
		}
		//echo $sql;
		$resu = mysql_query($sql) or (die(mysql_error()));
		
		if(mysql_num_rows($resu) >  0)
			{
				$condicion = str_replace('\'','~',$condicion);
				$html .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
				$html .=  '<strong style="margin-left: 60%">Cantidad de Polímeros: <span style="color:red; font-size: 20px;">'.mysql_num_rows($resu).'</span></strong>';
				$html .= "<table style=\"width:100%; font-size: 10px; font-family:Helvetica;\">
				<thead><tr>
				<th>Id</th>
				<th>N° de Orden</th>
				<th>Proveedor</th>
				<th>Cliente</th>
				<th>Trabajo</th>
				<th>Creado</th>
				<th>Estado</th>
				</tr></thead>";
				$color = "#FFFFFF";
				while($row = mysql_fetch_array($resu))
					{	
						$html .= '
							<tr style="height: 20px;background-color: '.$color.';cursor: pointer;">
								<td>'.$row['id'].'</td>
								<td style="text-align: center;">'.$row['orden'].'</td>
								'.getRoww($row['proveedor']).'
								'.getRoww($row['cliente']).'
								'.getRoww($row['trabajo']).'
								<td style="text-align: center;">'.invertirFecha($row['fecha']).'</td>
								<td style="text-align: center;">'.getEstatus($row['estado']).'</td>
							 </tr>';
							 
					if($color == "#FFFFFF")
						$color = "#A9F5A9";
						else
						$color = "#FFFFFF";
					}

			$html .= '</table>';
			}else
				{
				$html .= '<b><i>No se encontraron resultados!!.</i></b>';
				}
	}else
		{
			$html .= '--->'.$sql ;
			$html .= "<b><i>Filtro no válido.</i></b>";	
		}
//--------------- FUNCIONES -------------------
function invertirFecha($date)
	{
		$date = explode(' ',$date);
		$dato = explode('-',$date[0]);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
	}
	
function getRoww($row)
{
  return '<td>'.$row.'</td>';
}

function getEstatus($code) {
    switch ($code) {
	case "TP":
	    return "Enviado a Aprob. de Borradores";
	    break;
	case "AP":
	    return "Borrador Aprobado";
	    break;
	case "A":
	    return "Preprensa empaque";
	    break;
	case "C":
	    return "Borradores en producción";
	    break;
	case "E":
	    return "Borradores ap. a preprensa";
	    break;
	case "G":
	    return "Preprensa en proveedor";
	    break;
	case "H":
	    return "Confección de polímero";
	    break;
	case "I":
	    return "Polímero en calidad";
	    break;
	case "K":
	    return "Producción / impresión";
	    break;
	case "N":
	    return "Corrección (Prod./Imp.)";
	    break;
	case "F":
	    return "Corrección (Borr. en Prod.)";
	    break;
	case "J":
	    return "Corrección (Conf. de Pol.)";
	    break;
	case "L":
	    return "Rehacer (Pol. en Calidad)";
	    break;
	case "Z":
	    return "Polímero en StandBy";
	    break;
	case "X":
	    return "Polímero Reactivado (" + $code + ")";
	    break;
	case "M":
	    return "Polímero Archivado";
	    break;
	case "Q":
	    return "Autorización Fact. Polímeros";
	    break;
	case "XX":
	    return "Facturación Autorizada";
	    break;
	case "MO":
	case "RV":
	    return "Borrador Correjido";
	    break;
	//--------------------------
	case "DI":
	    return "Ingreso en Preprensa";
	    break;
	case "CL":
	    return "Enviado aprob. de Cliente";
	    break;
	case "AC":
	    return "Aprobado por el Cliente";
	    break;
	case "NA":
	    return "NO Aprobado por el Cliente";
	    break;
	case "CR":
	    return "Generar Polímero";
	    break;
	case "RN":
	    return "Rehacer Pedido";
	    break;
	case "NO":
	    return "Borrador Rechazado";
	    break;
	//---------------------------
	default:
	    return "Op. no definida. ("+$code+")";
    }
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
$dompdf->stream("ListadoDePolimeros.pdf");

?>