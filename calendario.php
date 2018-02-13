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
 

	<style>/*
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
		}*/
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
				$semana .= "<td>&nbsp;</td>";
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
	
	$html .= '</tr>';
$html .= '</table>';

if($month > date("n") && $year == date("Y"))
{
	$html .= '<button class="btn btn-mini btn btn-info" type="button" onclick="AbrirCalendario('.($month - 1).','.$year.')" style="margin-top: -9px">
				 <i class="icon-chevron-left icon-white"></i>
			  </button>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <button class="btn btn-mini btn btn-info" type="button" onclick="AbrirCalendario('.($month + 1).','.$year.')" style="margin-top: -9px">
				 <i class="icon-chevron-right icon-white"></i>
			  </button>';
}
else
{
	$html .= '<button class="btn btn-mini btn btn-info" type="button" onclick="AbrirCalendario()" style="margin-top: -9px" disabled="disabled">
				 <i class="icon-chevron-left icon-white"></i>
			  </button>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <button class="btn btn-mini btn btn-info" type="button" onclick="AbrirCalendario('.($month + 1).','.$year.')" style="margin-top: -9px">
				 <i class="icon-chevron-right icon-white"></i>
			  </button>';
}

echo $html;

function BuscarViajes($dia, $mes, $anio, $clase){
	
	$band = false;
	$fecha_actual = strtotime(date("d-m-Y 01:00:00",time()));
	$fecha_entrada = strtotime($dia."-".$mes."-".$anio." 01:00:00");
	if($fecha_actual > $fecha_entrada){
	        $band = true;
	}

	$html = "";
	$sql = "SELECT 
					V.idViaje, V.Fecha, T.razon_social, D.descripcion, D.color 
			FROM Viajes  as V 
			Join Transportes as T 
					on T.id_transporte = V.idTransporte
			Join Destino as D 
					on D.id_destino = V.idDestino WHERE V.Fecha = '".$anio.'-'.$mes.'-'.$dia."'";

	$resu = mysql_query($sql);

    if(mysql_num_rows($resu) > 0){    	
    	$html = "<td class='clase' style='border: 1px solid'><strong>$dia</strong>";
    	while($row = mysql_fetch_array($resu))
           {
                
                //echo "<td style=\"text-align: left\">".$row['descripcion']."</td>";
				//echo "<td style=\"text-align: left\">".$row['razon_social']."</td>";
           		if($band == false)
					$html .= '<div style="width: 110px; font-size: 15px; color: white; background:'.$row['color'].'; box-shadow: 2px 2px 5px #999; margin-bottom: 5px; padding: 5px;" > <p onclick="SeleccionarViaje('.$row['idViaje'].', \''.$row['Fecha'].'\', \''.$row['razon_social'].'\', \''.$row['descripcion'].'\')">'.$row['descripcion'].'</p></div>';
				else
					$html .= '<div style="width: 110px; font-size: 15px; color: white; background: #D8D8D8; box-shadow: 2px 2px 5px #999; margin-bottom: 5px; padding: 5px;">'.$row['descripcion'].'</div>';
           }
         $html .= "</td>";
    }
    else
    {
    	$html = "<td>$dia</td>";
    }

	return $html;
}
?>