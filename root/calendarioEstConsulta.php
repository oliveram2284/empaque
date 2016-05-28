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
 

	<style>
		#calendar {
			font-family:Arial;
			font-size:12px;
		}
		#calendar caption {
			text-align:left;
			padding:5px 10px;
			background-color:#003366;
			color:#fff;
			font-weight:bold;
		}
		#calendar th {
			background-color:#006699;
			color:#fff;
			width:40px;
		}
		#calendar td {
			text-align:right;
			padding:2px 5px;
			width: 75px;
			background-color:#E6F8E0;
		}
		#calendar .hoy {
			background-color:#D0F5A9;
		}
	</style>

<?php $html = '';

$html = '<table id="calendar" style="width: 100%; height: 600px; border: 1px solid #04B431;">
	<caption>'. $meses[$month]." ".$year.'</caption>
	<tr>
		<th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>
		<th>Vie</th><th>Sab</th><th>Dom</th>
	</tr>
	<tr bgcolor="silver">
		';
		$last_cell=$diaSemana+$ultimoDiaMes;
		// hacemos un bucle hasta 42, que es el máximo de valores que puede
		// haber... 6 columnas de 7 dias
		$semanaVacia = true;
		$semana = "";
		for($i=1;$i<=42;$i++)
		{
			if($i==$diaSemana)
			{
				// determinamos en que dia empieza
				$day=1;
			}
			if($i<$diaSemana || $i>=$last_cell)
			{
				// celca vacia
				$semana .= '<td style="background-color: #E6E6E6">&nbsp;</td>';
			}else{
				// mostramos el dia
				$semanaVacia = false;
				if($day==$diaActual && $month == date("n"))
					$semana .= BuscarViajes($day,$month,$year, 'hoy');
				else
					$semana .= BuscarViajes($day,$month,$year, '');
				$day++;
			}
			// cuando llega al final de la semana, iniciamos una columna nueva
			if($i%7==0)
			{
				if($semanaVacia == false)
				{
					$html .= $semana."</tr><tr>\n";
					$semana = '';
					$semanaVacia = true;
				}
				else
				{
					$semana = '';
				}
			}
		}
	
	//$html .= '</tr>';
$html .= '</table>';

		$html .= '<button class="btn btn-mini btn btn-info" type="button" onclick="AbrirCalendario('.($month - 1).','.$year.')" style="margin-top: 5px">
					 <i class="icon-chevron-left icon-white"></i>
				  </button>
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <button class="btn btn-mini btn btn-info" type="button" onclick="AbrirCalendario('.($month + 1).','.$year.')" style="margin-top: 5px">
					 <i class="icon-chevron-right icon-white"></i>
				  </button>';

echo $html;

function BuscarViajes($dia, $mes, $anio, $clase){
	
	$band = false;
	$fecha_actual = strtotime(date("d-m-Y H:i:s",time()));
	$fecha_entrada = strtotime($dia."-".$mes."-".$anio." 01:00:00");
	if($fecha_actual > $fecha_entrada){
	        $band = true;
	}

	//es feriado 
	$sql = "Select Count(*) From Feriados where ferDay = '".$anio.'-'.$mes.'-'.$dia."'";
	$resu = mysql_query($sql);
	$color = "black";
	$background_color = "";
	while($row = mysql_fetch_array($resu))
	   {
	   		if($row[0] > 0)
	   		{
	   			//hay un feriado
	   			$color = 'white';
	   			$background_color = 'red';
	   		}
	   }

	$esDomingo = false;
	switch (date('w', $fecha_entrada)){ 
	    case 0: 
	    	$esDomingo = true; 
	    	$color = "black";
			$background_color = "#A4A4A4";
	    	break; 
	}

	$html = "";
	$sql = "SELECT 
					V.idViaje, V.Fecha, V.horaSalida, V.minutoSalida, V.dias, V.horas, T.razon_social, D.descripcion, D.color 
			FROM Viajes  as V 
			Join Transportes as T 
					on T.id_transporte = V.idTransporte
			Join Destino as D 
					on D.id_destino = V.idDestino WHERE V.Fecha = '".$anio.'-'.$mes.'-'.$dia."'";

	$resu = mysql_query($sql);

    if(mysql_num_rows($resu) > 0){    	
    	$html = "<td class='clase' style='border: black 1px solid; background-color: ".$background_color."; color: ".$color."; width: 139px;'><strong>$dia</strong>";
    	while($row = mysql_fetch_array($resu))
           {
           	$horas = $row['dias'] * 24;
           	$horas += $row['horas'];
           	$fechaViaje = date($row['Fecha']." ".str_pad($row['horaSalida'], 2, "0", STR_PAD_LEFT).":".str_pad($row['minutoSalida'], 2, "0", STR_PAD_LEFT).":00");
           	$fechaLimite = strtotime ( '-'.$horas.' hour' , strtotime ( $fechaViaje ) ) ;

           	if($band == false){
	           	if($fecha_actual > $fechaLimite){
	           		$band = true;
	           	}
           	}

           	$via = "Select Count(*) As Cant From prioridad Where viajeId = ".$row['idViaje'];
           	//Aca se arma el semaforo 
	    	$resu_ = mysql_query($via);
	    	$cantidad = 0; $hay_listados = false;
	    	if(mysql_num_rows($resu_) > 0){    	
	    		while($row_ = mysql_fetch_array($resu_))
           			{
	    				$cantidad = $row_['Cant'];
	    				if($cantidad > 0)
	    		 		$hay_listados = true;
	    		 	}
	    	}
	    		$title = 'Empresa: '.$row['razon_social'].'    /    Destino:'.$row['descripcion'].'    /    Salida: '.str_pad($row['horaSalida'], 2, "0", STR_PAD_LEFT).':'.str_pad($row['minutoSalida'], 2, "0", STR_PAD_LEFT);

           			if($hay_listados == false)
						$html .= '<div style="width: 110px; font-size: 15px; color: white; background:'.$row['color'].'; box-shadow: 2px 2px 5px #999; margin-bottom: 5px; padding: 5px; cursor: pointer;" onclick="AbrirPorViaje('.$row['idViaje'].')" title="'.$title.'">'.$row['descripcion'].'</div>';
					else
						$html .= '<div style="width: 110px; font-size: 15px; color: white; background:'.$row['color'].'; box-shadow: 2px 2px 5px #999; margin-bottom: 5px; padding: 5px; cursor: pointer;" onclick="AbrirPorViaje('.$row['idViaje'].')" title="'.$title.'">
									'.armarSemaforo($row['idViaje']).' '.$row['descripcion'].' <img src="./assest/plugins/buttons/icons/abajo.png" width="20" heigth="20" >
								  </div>';
			$hay_listados = false;
           	$band = false;
           }
         $html .= "</td>";
    }
    else
    {
    	$html = "<td style='background-color: ".$background_color."; color: ".$color."; width: 139px;'>$dia</td>";
    }

	return $html;
}

function armarSemaforo($idViaje)
{
	//Contar todos
	$todos = 0;
	$sql = 'Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = '.$idViaje;
	$resu_ = mysql_query($sql);
	if(mysql_num_rows($resu_) > 0){    	
		while($row_ = mysql_fetch_array($resu_))
   			{
				$todos = $row_['Cant'];
		 	}
	}

	//Contar los aprobados
	$aprobados = 0;
	$sql = 'Select Count(DISTINCT d.pedId) As Cant From prioridad As p Join prioridaddetalle As d On p.prioId = d.prioId Where p.viajeId = '.$idViaje.' and d.cantAut is not null';
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