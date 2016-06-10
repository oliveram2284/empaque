<?php


include("lib/db_conn.php");
include("lib/listado.php");
$link = Conectarse();
$consulta = "SELECT horas.*, clientes.nom_com FROM horas LEFT JOIN clientes ON `clientes`.`cod_client` = `horas`.`cliente` where codigo='admin'";
if ($_GET["orden"] <> ""){
	$consulta = $consulta . " ORDER BY `". $_GET["orden"]. "`";
}else{
	$consulta = $consulta . " ORDER BY `fecha` DESC";
}

$result = mysql_query($consulta,$link);

include_once "Spreadsheet/Excel/Writer.php";
$xls =& new Spreadsheet_Excel_Writer();
$xls->send("horaspropias.xls");
$format =& $xls->addFormat();
$format->setBold();
$format->setColor("blue");
$sheet =& $xls->addWorksheet('Horas Propias');

/*echo "<tr>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=fecha'\">FECHA</th>
		<th style=\"width:55px;\" onclick=\"parent.location='zlistahoraspropias.php?orden=cliente'\">CLIENTE</th>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=horas'\">HORAS</th>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=tarea'\">TAREA</th>
		<th>OBSERVACIONES</th>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=aprobado'\">Aprobado</th>
		<th>Modificar</th>
		<th>Eliminar</th>
	</tr>";*/
	
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$sheet->write($fila, 0, $row["id"], 0);
$sheet->write($fila, 1, $row["fecha"], 0);
$sheet->write($fila, 2, $row["cliente"]."-".substr($row["nom_com"],0,30), 0);
$sheet->write($fila, 3, $row["horas"], 0);
$acumulador = $acumulador + $row["horas"];
$sheet->write($fila, 4, $row["tarea"], 0);
$sheet->write($fila, 5, $row["obs"], 0);
$sheet->write($fila, 6, $row["aprobado"], 0);
$fila = fila + 1;
}
$xls->close();
exit;
/*echo "<tr>
<th colspan='8'>&nbsp;</th></tr>
<tr>
<td colspan='2' bgcolor='#ffe0bb'><center>TOTAL DE HORAS</center></td><td colspan='6'>".$acumulador."</td></tr>";
*/
?>