<?php
$id = $_POST['variable'];

include("conexion.php");
	
$var = new conexion();
$var->conectarse();

$consulta = "Select
                    pedidoEstado,
                    nombre_real as nombre,
                    logFecha
            From
                    tbl_log_pedidos as p
            Join
                    usuarios as u
            On
                    p.usuarioId = u.id_usuario
            where
		    pedidoId = ".$id."
	    Order by logFecha desc";
	    //Date_format( logFecha, '%d-%m-%Y %H:%i' ) as logFecha
$resu = mysql_query($consulta);


            if(mysql_num_rows($resu)<= 0)
		{
		 echo '<center><strong style="color: red;">No hay movimientos para el pedido seleccionado.</strong></center>';
		}else
			{
			 echo '<table class="table" style="width: 100%; margin-top: -50px;">';
			 echo '<thead>
				     <tr style="line-height: 10px;">
					   <th style="width: 25%; line-height: 10px;">Operación</th>
					   <th style="line-height: 10px;">Usuario</th>
					   <th style="width: 25%; line-height: 10px;">Fecha</th>
				     </tr>
			      </thead>';
			 
			 echo '<tbody>';
			 while($row = mysql_fetch_array($resu))
                         {
                            echo "<tr>
                                    <td>".DeterminarEst($row['pedidoEstado'])."</td>
                                    <td>".$row['nombre']."</td>
                                    <td style=\"text-align: center\">".ConvertFecha($row['logFecha'])."</td>";
                         }
			 echo '</tbody>';
			 echo "</table><br>";
                        }
function ConvertFecha($fecha)
{
  $f = explode(' ', $fecha);
  
  $dia = explode('-',$f[0]);
  
  $hora = explode(':', $f[1]);
  
  return $dia[2].'-'.$dia[1].'-'.$dia[0].'  '.$hora[0].':'.$hora[1].':'.$hora[2];
}

function DeterminarEst($valor)
{
    switch($valor)
    {
        case "I":
            return "Emitido";
        case "A":
            return "Recibido";
        case "V":
            return "Aprobado";
        case "T":
            return "Terminado";
        case "EP":
            return "Entregado Parcial";
        case "R":
            return "Revisión";
        case "P":
            return "Producción";
        case "N":
	    return "Diseño";
	case "DI":
            return "Diseño de Polímero";
        case "B":
            return "Visado (Diseño)";
        case "D":
            return "Devuelto";
        case "C":
            return "Cancelado";
        case "U":
	case "UA":
            return "Curso";
        case "NS":
            return "Nuevo Sin Impresión";
        case "SI":
            return "Producto Aprobado";
        case "NO":
            return "Producto No Aprobado";
        case "AP":
            return "Aprobación de Producto";
        case "E":
            return "Editado";
	case "PR":
            return "Polimero Aprobado";
	case "CA":
            return "Calidad de Polimero";
	case "PO":
            return "Aprobación de Calidad de Polimero";
	case "PA":
            return "Recepción de Polimero";
	case "CL":
            return "Aprobación por Cliente";
	case "MO":
	    return "Mod. de Polímero Temporal";
	case "NC":
	    return "Producto no aprobado por el Cliente";
	case "CP":
	    return "Cancelado desde subsistema de polímeros";
	case "TP":
	    return "Terminado Parcial";
	case "CH":
	    return "Cancelación Impresión Hoja de Ruta";
	case "IH":
	    return "Impresión Hoja de Ruta en Trabajos Nuevo";
	case "PH":
	    return "Impresión Hoja de Ruta en Ad. Producción";
	case "EH":
	    return "Edición de Hoja de Ruta / Comunicación Interna";
	case "RA":
	    return "Nota de Pedido Reactivada";
	case "RN":
	    return "Rechazado desde Diseño";
	    break;
	case "RV":
	    return "Polímero con Revisión";
	    break;
       default:
        return "Operación no definida (".$valor.")";
    }
}
?>