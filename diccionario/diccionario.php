<?php

function _listadoTitle($action=false){
    $output='';
    switch($action){
        case "I":
                $output="Pedidos Emitidos";
                break;
        case "A":
                $output="Pedidos Recibidos";
                break;
        case "P":
                $output="Pedidos en Adm. de Producción";
                break;
        case "V":
                $output="Pedidos Aprobados";
                break;
        case "T":
                $output="Pedidos Terminados";
                break;
        case "N":
                $output="Pedidos para Diseño";
                break;
        case "EP":
            $output="Pedidos Terminados Parcialmente";
            break;
        case "U":
            $output="Pedidos en Curso";
            break;
        case "AP":
            $output="Aprobación de Productos para diseño";
            break;
        case "PO":
            $output="Aprobación de Calidad de Polímero";
            break;
        case "PA":
            $output="Asociar Pedido con Polímero";
            break;
        case "E":
            $output="Editar Precio";
            break;
        case "CL":
            $output="Aprobación por Cliente";
            break;
        case "TN":
            $output="Trabajos Nuevos";
            break;
        case "TO":
            $output="Todos los Pedidos";
            break;
        case "EH":
            $output="Editar HR / CI";
            break;
        case "DE":
            $output="Devoluciones";
            break;
            default :
                    $output="Operacion No Registrada";
    }
    return $output;
}