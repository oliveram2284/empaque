<?php
include "conexion.php";

$conecta = new conexion();
$conecta ->conectarse();

$dato=$_POST['variable'];

//$sql = "SELECT pol.id_polimero, pol.trabajo, pol.fecha_recepcion, pol.medidas, pol.precio_final, pr.razon_social, mr.descripcion, pol.id_motivo
//		FROM polimeros pol
//		INNER JOIN proveedores pr ON pr.id_proveedor = pol.id_proveedor
//		INNER JOIN marca mr ON mr.idMarca = pol.id_etiqueta
//		WHERE estado = 1 and (pol.trabajo Like '%".$dato."%' or pol.fecha_recepcion Like '%".$dato."%' or pol.medidas Like '%".$dato."%' or pol.precio_final Like '%".$dato."%' or pr.razon_social Like '%".$dato."%' or mr.descripcion Like '%".$dato."%')";

$sql = "SELECT pol.id_polimero, pol.trabajo, pol.fecha_recepcion, pol.medidas, pol.precio_final, pr.razon_social, mr.descripcion, pol.id_motivo
		FROM polimeros pol
		INNER JOIN proveedores pr ON pr.id_proveedor = pol.id_proveedor
		INNER JOIN marca mr ON mr.idMarca = pol.id_etiqueta
		WHERE estado = 4 and 1 and (pol.trabajo Like '%".$dato."%' or pol.fecha_recepcion Like '%".$dato."%' or pol.medidas Like '%".$dato."%' or pol.precio_final Like '%".$dato."%' or pr.razon_social Like '%".$dato."%' or mr.descripcion Like '%".$dato."%')";
        		
$resu = mysql_query($sql) or (die(mysql_error()));

echo '<table>
		<thead><tr>
        <td>Proveedor</td>
        <td>Marca</td>
        <td>Trabajo</td>
        <td>Motivo</td>
        <td>Fec. Recepcion</td>
        <td>Medidas</td>
        <td>Precio Final</td>
        <td>Editar</td>
        <td>Cancelar</td>
        </tr></thead>';
		
if(mysql_num_rows($resu) > 0)
	{
	while($row = mysql_fetch_array($resu))
		{	//reducir el campo trabajo 
			echo '
				<tr>
					<td>'.$row['razon_social'].'</td>
					<td>'.$row['descripcion'].'</td>
					<td>'.Recortar($row['trabajo']).'</td>
					<td>';
			echo ($row['id_motivo'] == 1) ? "Nuevo" : "Pedido Reposicion";
			echo 	'</td>
					<td>'.invertirFecha($row['fecha_recepcion']).'</td>
					<td>'.$row['medidas'].'</td>
					<td>'.$row['precio_final'].'</td>
					<td><img src="assest/plugins/buttons/icons/pencil.png" onClick="editarEliminar('.$row['id_polimero'].',\'E\')"></td>
                    <td><img src="assest/plugins/buttons/icons/cancel.png" onClick="editarEliminar('.$row['id_polimero'].',\'C\')"></td>
				 </tr>
		';
		}
	}else
	{
	echo '<tr><td colspan="8"><i>No hay polimeros en estado de revisión.</i></tr>';
	}
	
function Recortar ($texto)
    {
        $largo = strlen($texto);
        if($largo > 20)
            {
                return  substr($texto,0,16)."....";
            }else
            {
                return $texto;
            }
    }
    
function invertirFecha($fecha)
	{
	$var = explode('-',$fecha);
	return $var[2].'-'.$var[1].'-'.$var[0];	
	}
?>