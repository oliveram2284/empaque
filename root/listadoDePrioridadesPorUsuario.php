<?php

include ("conexion.php");

$vari = new conexion();
$vari->conectarse();
session_start();

$id	= $_POST['id'];



$sql = "Select * From prioridad as p where p.viajeId = ".$id." and p.usrId = ".$_SESSION['id_usuario'];
$resu = mysql_query($sql);

$html = '<div class="accordion" id="accordion2">';
if(mysql_num_rows($resu) > 0){    	
	while($row = mysql_fetch_array($resu)){

				//Agregar header para este usuario
				//Y buscar todos las prioridades para este
				$html .= '<div class="accordion-group">
						    <div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#'.$row['prioId'].'">
						        '.Invertir_Fecha($row['prioFecha']).'
						      </a>
						    </div>
						    <div id="'.$row['prioId'].'" class="accordion-body collapse">
      							<div class="accordion-inner">
      								<table style="font-size: 10px; width: 100%;">';

				$prio_ = "Select 
								pedId, cantAut, cantEnt
						  From 	
						  		prioridad As p 
						  Join prioridaddetalle As d On p.prioId = d.prioId
						  Where p.viajeId = ".$row['viajeId']." and p.prioId = ".$row['prioId'];

				$resu_ = mysql_query($prio_);
				while($row_ = mysql_fetch_array($resu_)){
						$html .= getFila($row_['pedId'], $row_['cantAut'], $row['viajeId'], $row_['cantEnt']);
				}

				$html .= '			</table>
								</div>
    						</div>
						  </div>';
	}
}
else
{
	$html .= '<span class="label label-important" style="font-size:15px;">No hay prioridades pendientes</span>';
}

 $html .= '</div>';

echo $html;

function getFila($id, $cant, $viaje, $ent){
	
	// if($ent != null && $ent != ""){
	// 	$rowRet = '<tr>';
	// }
	// else
	// {
		$rowRet = '<tr style="height: 40px;">';
	//}

	$sql = 'Select p.codigo, p.descripcion, d.CantidadTotal From Pedidos as p Join pedidosdetalle as d on d.idPedido = p.npedido Where p.npedido = '.$id;
	$resu = mysql_query($sql);
	if(mysql_num_rows($resu) > 0){    	
	while($row = mysql_fetch_array($resu)){
			$rowRet .= '<td>'.$row['codigo'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>'.$row['descripcion'].'</td>
					 	<td>'.$row['CantidadTotal'].'</td>';
			if($cant != null)
			{
				if($cant == -1) {
					$rowRet .= '<td><span class="label label-important">No Autorizado</span></td>';
				} else {
					if($ent != null) {
						$rowRet .= '<td><span class="label label-warning">Completado</span></td>';
					} else {
						$rowRet .= '<td><span class="label label-success">Autorizado</span></td>';
					}
				}
			}
			else
			{
				$rowRet .= '<td><span class="label label-info">Pendiente</span></td>';
			}
		}
		//<strike>
	}
	$rowRet .= '</tr>';
	
	
	return $rowRet;
}

// function Armar_semaforo($idViaje,$usrId) {
// 	//Contar todos
// 	$todos = 0;
// 	$sql = 'Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = '.$idViaje.' and cantAut is not null and cantAut > -1 and p.usrId = '.$usrId;
// 	$resu_ = mysql_query($sql);
// 	if(mysql_num_rows($resu_) > 0){    	
// 		while($row_ = mysql_fetch_array($resu_))
//    			{
// 				$todos = $row_['Cant'];
// 		 	}
// 	}

// 	//Contar los aprobados
// 	$aprobados = 0;
// 	$sql = 'Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = '.$idViaje.' and cantAut is not null and cantAut > -1 and p.usrId = '.$usrId.' and d.cantEnt is not null';
// 	$resu_ = mysql_query($sql);
// 	if(mysql_num_rows($resu_) > 0){    	
// 		while($row_ = mysql_fetch_array($resu_))
//    			{
// 				$aprobados = $row_['Cant'];
// 		 	}
// 	}

// 	if($todos > 0)
// 	{
// 		if($todos == $aprobados)
// 		{
// 			return '<div title="'.$aprobados.' de '.$todos.'"
// 					style="width: 20px; height: 15px; background:green; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
// 					>
// 				   </div>';
// 		}
// 		else
// 		{
// 			if($aprobados == 0)
// 			{
// 				return '<div title="'.$aprobados.' de '.$todos.'"
// 						style="width: 20px; height: 15px; background:red; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
// 						>
// 					   </div>';
// 			}
// 			else
// 			{
// 				return '<div title="'.$aprobados.' de '.$todos.'"
// 						style="width: 20px; height: 15px; background:yellow; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;"
// 						>
// 					   </div>';;
// 			}
// 		}
// 	}
// 	else
// 	{
// 		return "";
// 	}
// 	return $todos.'/'.$aprobados;
// }

function Invertir_Fecha($fecha) {
	$fecha = explode(' ', $fecha);
	$date = explode('-', $fecha[0]);
	$hour = explode(':', $fecha[1]);

	return $date[2].'-'.$date[1].'-'.$date[0].' '.$hour[0].':'.$hour[1];
}

?>