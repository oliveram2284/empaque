<?php
session_start();

$esAdmin = $_SESSION['admin'];

include("conexion.php");
$var = new conexion();
$var->conectarse();

$sql= stripslashes ($_POST['variable']);

if($sql != "")
	{
	 //................................................................................
         //.. Copio la consulta para tenerla y poder ordenar por algun campo el resultado .
         //................................................................................
//         $consulta = str_replace($order,"",$sql);
//         echo '<input type="hidden" name="consul" id="consul" value="'.$consulta.'"/>';
//	 //echo $sql;
         //................................................................................
	 
	 $resu = mysql_query($sql) or (die(mysql_error()));
		
		if(mysql_num_rows($resu) >  0)
			{
				//ver si aplica filtro de estado
				$condicion = str_replace('\'','~',$sql);
				echo '<img src="assest/plugins/buttons/icons/printer.png" title="Imprimir Filtro" onClick="ImprimirReporte(\''.$condicion.'\')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '<img src="assest/plugins/buttons/icons/icono_excel.gif" title="Exportar a Exel" onclick="ExportarExcel1(\''.$condicion.'\');">';
				echo "<table style=\"width:100%; font-size: 11px;\">
				<thead>
				<tr>
				<th style=\"text-align: center;\" width=\"65px;\"><a onClick=\"orderBy('ped.codigo')\" style=\"cursor: pointer; text-decoration: none; color: black;\">N° Pedido</a></th>
				<th style=\"text-align: center;\" width=\"270px;\"><a onClick=\"orderBy('ped.clienteNombre')\" style=\"cursor: pointer; text-decoration: none; color: black;\">Cliente</a></th>				
				<th style=\"text-align: center;\" width=\"270px;\"><a onClick=\"orderBy('ped.descripcion')\" style=\"cursor: pointer; text-decoration: none; color: black;\">Artículo</a></th>
				<th style=\"text-align: center;\" width=\"80px;\"><a onClick=\"orderBy('ped.femis')\" style=\"cursor: pointer; text-decoration: none; color: black;\">Fecha Emisión</a></th>
				<th style=\"text-align: center;\" width=\"130px;\">Fecha <br>Estado Actual</th>
				<th style=\"text-align: center;\">Estado Actual</th>
				<th style=\"text-align: center;\"></th>
				</tr></thead>";
				$color = "#FFFFFF";
				while($row = mysql_fetch_array($resu))
					{
						echo '
							<tr style="height: 10px;background-color: '.$color.'; cursor: pointer;">
								<td><a onclick="Seguimiento(\''.$row['id'].'\',\''.$row['nro'].'\')">'.$row['nro'].'</a></td>
								'.getRow($row['clie']).'
								'.getRow($row['arti']).'
								<td style="text-align: center;">'.invertirFecha($row['fecha']).'</td>
								<td style="text-align: center;">'.FormatDate($row['logFecha']).'</td>
								<td style="text-align: center;">'.DeterminaEstado($row['estado']).'</td>
								';
						echo '		<td style="text-align: center;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''.$row['id'].'\')" style="cursor: pointer;"></td>
							 </tr>
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
	    echo "<b><i>Filtro no válido.</i></b>";	
	}
//--------------- FUNCIONES -------------------
function getRow($row)
 {
  $tooltip = $row;
  $row = utf8_encode(substr($row, 0, 40));
  if(strlen($tooltip)> 40)
    $row .= '...';
  return '<td title="'.$tooltip.'">'.$row.'</td>';
 }
 
function invertirFecha($date)
	{
		$dato = explode('-',$date);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
	}
    
function DeterminaEstado($estado)
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
		    return "Rechazado";
		    break;
		case "C":
		    return "Cancelado";
		    break;
		case "A":
		    return "Recibido";
		    break;
		case "N":
		case "NO":
		case "SI":
		    return "Diseño";
		    break;
		case "AP":
		    return "Aprobación de Producción";
		    break;
		case "CA":
		    return "Generando Polímero";
		    break;
		case "P":
		    return "Producción";
		    break;
		case "U":
		    return "Curso";
		    break;
		case "TP":
		    return "Terminado Parcial";
		    break;
		case "T":
		    return "Terminado";
		    break;
                default:
                    return "";
                    break;
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