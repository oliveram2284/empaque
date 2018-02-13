<?php

include ("conexion.php");

$vari = new conexion();
$vari->conectarse();

# definimos los valores iniciales para nuestro calendario
//$month=date("n");
$month	= $_POST['mes'];
//$year=date("Y");
$year = $_POST['anio'];
//$diaActual=date("j");
 $diaActual = $_POST['dia'];

# Obtenemos el dia de la semana del primer dia
# Devuelve 0 para domingo, 6 para sabado
$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
# Obtenemos el ultimo dia del mes
$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
 
$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
?>



LOAD CALENDAR

<div id='calendar'></div>