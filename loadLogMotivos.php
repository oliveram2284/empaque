<?php
$id = $_POST['variable'];

include("conexion.php");
	
$var = new conexion();
$var->conectarse();

$accion = " (pedidoEstado = 'R' or pedidoEstado = 'RR' or pedidoEstado = 'RN' or pedidoEstado = 'NO' or pedidoEstado = 'PX' or pedidoEstado = 'D' or pedidoEstado = 'NC')";

$consulta = "Select
                    nombre_real as nombre,
                    Date_format( logFecha, '%d-%m-%Y %H:%i' ) as logFecha,
		    observacion,
		    logCancel
            From
                    tbl_log_pedidos as p
            Join
                    usuarios as u
            On
                    p.usuarioId = u.id_usuario
            where
		    pedidoId = ".$id." and ".$accion."
	    Order by
		    logFecha desc
	    ";

$resu = mysql_query($consulta);


            if(mysql_num_rows($resu)<= 0)
		{
		 echo '<center><strong style="color: red;">El pedido nunca fue rechazado.</strong></center>';
		}else
			{
			 echo '<table class="table" style="width: 100%; margin-top: -50px;">';
			 echo '<thead>
				     <tr style="line-height: 10px;">
					   <th style="line-height: 10px; width: 40%;">Información</th>
					   <th style="width: 60%; line-height: 10px;">Motivo</th>
				     </tr>
			      </thead>';
			 
			 echo '<tbody>';
			 while($row = mysql_fetch_array($resu))
                         {
                            echo "<tr>
                                    <td>
					<strong>Usuario: </strong>".$row['nombre']."<br>
					<strong>Fecha: </strong>".$row['logFecha']."<br>
					<strong>Desde: </strong>".DeterminarEst($row['logCancel'])."</td>
                                    <td style=\"text-align: center\">".($row['observacion'] == null || $row['observacion'] == "" ? "<i>No especificado</i>" : ("<i>".$row['observacion']."</i>"))."</td>";
                         }
			 echo '</tbody>';
			 echo "</table><br>";
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
            return "Producci&oacuten";
        case "N":
            return "Diseño";
        case "B":
            return "Visado (Diseño)";
        case "D":
            return "Devuelto";
        case "C":
            return "Cancelado";
        case "U":
            return "Curso";
        case "NS":
            return "Nuevo Sin Impresi&oacuten";
        case "SI":
            return "Producto Aprobado";
        case "NO":
            return "Producto No Aprobado";
        case "AP":
            return "Aprobaci&oacuten de Producto";
        case "E":
            return "Editado";
	case "PO":
            return "Aprob. de Calidad de Polimero";
	case "NC":
	    return "Diseño no aprobado por cliente";
       default:
	    return "Diseño no aprobado por cliente";
        //return "Operación no definida (".$valor.")";
    }
}
?>