<?php

function listahorasterceros($tabla){

echo "<tr>
		<th>FECHA</th>
		<th>USUARIO</th>
		<th>CLIENTE</th>
		<th>HORAS</th>
		<th>EQUIVAL.</th>
		<th>TAREA</th>
		<th>Aprobado</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$id =  $row["id"];
$fecha = $row["fecha"];
$cliente = $row["cliente"];
$horas = $row["horas"];
$equivalentes = $row["equivalentes"];
$tarea = $row["tarea"];
$aprobado = $row["aprobado"];
$usuario = $row['codigo'];
$icono_modif="<a href=\"zmodifhorasterceros.php?id=$id\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_borrar="<a href=\"zmodifhorasterceros.php?id=$id&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";
if ($aprobado){
$icono_aprobado="<img BORDER=\"0\"src=\"img/check.png\">";
}else{
$icono_aprobado="<img BORDER=\"0\"src=\"img/enespera.gif\">";
}
$res_filas = ++$res_filas;
$res_horas = $res_horas + $horas;
$res_equiv = $res_equiv + $equivalentes;
printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
	</tr>",
	$fecha, $usuario, $cliente, $horas, $equivalentes, $tarea, $icono_aprobado
	);
}


if ($res_filas > 1){ 
printf("<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th><big>TOTAL</big></th>
		<th><big>%s</big></th>
		<th><big>%s</big></th>
		<th><big>%s</big></th>
		<th id=\"columnagraf\">&nbsp;</td>
	</tr>",
	$res_horas, $res_equiv, $res_filas);
}

}
?>