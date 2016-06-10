<?php

include ("conexion.php");

$vari = new conexion();
$vari->conectarse();

$id	= $_POST['id'];



$sql = "Select * From prioridad  as p join usuarios as u on p.usrId = u.id_usuario where p.viajeId = ".$id." order by p.usrId";
$resu = mysql_query($sql);

$html = '<div class="accordion" id="accordion2">';
if(mysql_num_rows($resu) > 0){    	
	$user = "";
	while($row = mysql_fetch_array($resu)){
			if($user != $row['usrId'])
			{
				//Agregar header para este usuario
				//Y buscar todos las prioridades para este
				$html .= '<div class="accordion-group">
						    <div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#'.$row['usrId'].'" >
						      	<table width="100%">
						      		<tr>
						        		<td style="width: 60%; text-align: right;">'.$row['nombre'].', '.$row['nombre_real'].' </td>
						        		<td style="text-align: left; padding-left: 25px;">'.Armar_semaforo($row['viajeId'],$row['usrId']).'</td>
						        	</tr>
						        </table>
						      </a>
						    </div>
						    <div id="'.$row['usrId'].'" class="accordion-body collapse">
      							<div class="accordion-inner">
      								<table style="font-size: 10px; width: 100%;">';

				$prio_ = "Select 
								DISTINCT pedId, cantAut, cantEnt
						  From 	
						  		prioridad As p 
						  Join prioridaddetalle As d On p.prioId = d.prioId
						  Where p.viajeId = ".$row['viajeId']." and p.usrId = ".$row['usrId'];

				$resu_ = mysql_query($prio_);
				while($row_ = mysql_fetch_array($resu_)){
						$html .= getFila($row_['pedId'], $row_['cantAut'], $row['viajeId'], $row_['cantEnt']);
				}

				$html .= '			</table>
								</div>
    						</div>
						  </div>';

				$user = $row['usrId'];
			}
			else
			{
				//----
			}
	}
}
else
{
	$html .= '<span class="label label-important" style="font-size:15px;">No hay prioridades pendientes</span>';
}

 $html .= '</div>';


echo $html;

function getFila($id, $cant, $viaje, $ent){
	
	$sql = 'Select p.codigo, p.descripcion, d.CantidadTotal From Pedidos as p Join pedidosdetalle as d on d.idPedido = p.npedido Where p.npedido = '.$id;
	$resu = mysql_query($sql);
	if(mysql_num_rows($resu) > 0){    	
	while($row = mysql_fetch_array($resu)){
		$rowRet = '<tr style="height: 40px;">';
		
			$rowRet .= '<td>'.$row['codigo'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					 	<td>'.$row['descripcion'].'</td>
					 	<td>(cant:'.$row['CantidadTotal'].')</td>';
			if($cant != null && $cant != "")
			{
				if($cant == -1)
				{
					$rowRet .= '<td colspan="2" style="text-align:center;"><span class="label label-important">No Autorizado</span></td>';
				}
				else
				{
					if($ent != null)
					{
						$rowRet .= '<td colspan="2" style="text-align:center;"><span class="label label-success">Aut.</span>
									&nbsp;&nbsp;<span class="label label-warning">Completado</span></td>';
					}
					else
					{
						$rowRet .= '<td colspan="2" style="text-align:center;"><span class="label label-success">Autorizado</span></td>';
					}
				}
			}
			else
			{
				$rowRet .= '<td colspan="2" style="text-align:center;"><span class="label label-info">Pendiente</span></td>';
			}
		}
		//<strike>
	}
	$rowRet .= '</tr>';
	
	
	return $rowRet;
}

function Armar_semaforo($idViaje,$usrId) {
	//Contar todos
	$todos = 0;
	$sql = 'Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = '.$idViaje.' and p.usrId = '.$usrId;
	$resu_ = mysql_query($sql);
	if(mysql_num_rows($resu_) > 0){    	
		while($row_ = mysql_fetch_array($resu_))
   			{
				$todos = $row_['Cant'];
		 	}
	}

	//Contar los aprobados
	$aprobados = 0;
	$sql = 'Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = '.$idViaje.' and p.usrId = '.$usrId.' and d.cantAut is not null';
	$resu_ = mysql_query($sql);
	if(mysql_num_rows($resu_) > 0){    	
		while($row_ = mysql_fetch_array($resu_))
   			{
				$aprobados = $row_['Cant'];
		 	}
	}

	if($todos > 0)
	{
		if($todos == $aprobados)
		{
			return '<div title="'.$aprobados.' de '.$todos.'"
					style="width: 20px; height: 15px; background:green; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
					>
				   </div>';
		}
		else
		{
			if($aprobados == 0)
			{
				return '<div title="'.$aprobados.' de '.$todos.'"
						style="width: 20px; height: 15px; background:red; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
						>
					   </div>';
			}
			else
			{
				return '<div title="'.$aprobados.' de '.$todos.'"
						style="width: 20px; height: 15px; background:yellow; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
						>
					   </div>';;
			}
		}
	}
	else
	{
		return "";
	}
	return $todos.'/'.$aprobados;
}

?>