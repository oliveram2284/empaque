<?php

session_start();

include ("../config.php");


if(!isset($_REQUEST['action'])){
  return false;
}


switch ($_REQUEST['action']) {
    case 1:{
        $date= (isset($_REQUEST['date'])) ? $_REQUEST['date'] :  date('Y-m-d');
        $viajes=R::getAll("SELECT 
                v.*, 
                d.descripcion 'destino_description', 
                d.color 'destino_color',
                t.codigo 'transporte_codigo',
                t.razon_social 'transporte_razon_sosial',
                t.direccion 'transporte_direccion',
                t.direccion 'transporte_direccion',
                ( Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = v.idViaje and d.cantAut is not null ) 'aprobados',
                ( Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = v.idViaje and d.cantAut is not null) 'todos'
            FROM 
                        viajes as v 
            INNER JOIN 
                        destino as d 
            ON 
                        v.idDestino=d.id_destino
            INNER JOIN  
                        transportes as t
            ON 		
                        v.idTransporte=t.id_transporte
            WHERE MONTH(v.fecha) = MONTH('".$date."') and v.status=1 order by v.fecha asc ");

        echo json_encode(array('result'=>$viajes));
        break;
        
        break;

    }
    default:{
        break;
    }
}