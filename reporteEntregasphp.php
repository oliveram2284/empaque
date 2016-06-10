<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$arre = explode('~',$_POST['variable']);
$sql  = "";

foreach($arre as $filtro)
	{
		$dato = explode(':',$filtro);
		$caso = $dato[0];
		$valor = $dato[1];
		switch($caso)
			{
			//filtro por tipo de entrega
			case 1 :
				if($sql == "")
					{
						$sql = "tent.id_tipo = ".$valor." ";	
					}
					else
						{
							$sql .= " and tent.id_tipo = ".$valor." ";	
						}
				break;
			//filtro por destino
			case 2 : 
				if($sql == "")
					{
						$sql = " des.id_destino = '".$valor."' ";	
					}
					else
						{
							$sql .= " and des.id_destino = '".$valor."' ";	
						}
				break;
			//filtro por responsable
			case 3 : 
				if($sql == "")
					{
						$sql = " usu.id_usuario = ".$valor." ";	
					}
					else
						{
							$sql .= " and usu.id_usuario = ".$valor." ";	
						}
				break;
            //filtro por transporte
			case 4 : 
				if($sql == "")
					{
						$sql = " tra.id_transporte = ".$valor." ";	
					}
					else
						{
							$sql .= " and tra.id_transporte = ".$valor." ";	
						}
				break;
			//filtro por fecha 
			case 5 : 
				$fechas = explode('/',$valor);
				$desde = invertirFecha($fechas[0]);
				$hasta = invertirFecha($fechas[1]);
				
				if($sql == "")
					{
						$sql = " ent.fecha between '".$desde."' AND '".$hasta."' ";
					}
					else
						{
							$sql .= " and ent.fecha between '".$desde."' AND '".$hasta."' ";	
						}
				break;
			}
	}
if($sql != "")
	{
		$condicion = $sql;
        
        $sql = "SELECT ent.id_entregas, tent.descripcion, des.descripcion, usu.nombre_real, tra.razon_social, ent.fecha 
                    FROM entregas ent
                    INNER JOIN tipo_entrega tent ON tent.id_tipo = ent.id_tipodeentregas
                    INNER JOIN destino des ON des.id_destino = ent.id_destino
                    INNER JOIN usuarios usu ON usu.id_usuario = ent.id_usuarioexp
                    INNER JOIN transportes tra ON tra.id_transporte = ent.id_transporte
                    WHERE ".$sql;
         
		$resu = mysql_query($sql) or (die(mysql_error()));
		
		if(mysql_num_rows($resu) >  0)
			{
				$condicion = str_replace('\'','~',$condicion);
				echo '<img src="assest/plugins/buttons/icons/printer.png" title="Imprimir Filtro" onClick="ImprimirReporte(\''.$condicion.'\')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '<img src="assest/plugins/buttons/icons/icono_excel.gif" title="Exportar a Exel">';
			echo "<table>
				<thead><tr>
				<td>Numero Ent.</td>
				<td>Tipo Ent.</td>				
				<td>Destino</td>
				<td>Responsable</td>
				<td>Transporte</td>
				<td>Fecha</td>
                <td>Imprimir</td>
				</tr></thead>";
				while($row = mysql_fetch_array($resu))
					{	
						echo '
							<tr>
                                <td>'.$row[0].'</td>
								<td>'.$row[1].'</td>
								<td>'.$row[2].'</td>
								<td>'.$row[3].'</td>
								<td>'.$row[4].'</td>
								<td>'.invertirFecha($row['fecha']).'</td>
                                <td><img src="assest/plugins/buttons/icons/printer.png" title="Imprimir Entrega" onClick="ImprimirReporte(\''.$row[0].'\')"></td>
							 </tr>
						';
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
function invertirFecha($date)
	{
		$dato = explode('-',$date);
		$dato = $dato[2] ."-". $dato[1] ."-". $dato[0];
		return $dato;
	}
//---------------------------------------------
?>