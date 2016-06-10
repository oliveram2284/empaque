<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$from = $_GET['from'];
$to = $_GET['to'];
$ven = $_GET['vend'];

$from = explode("-", $from);
$from = $from[2].'-'.$from[1].'-'.$from[0];
$to = explode("-", $to);
$to = $to[2].'-'.$to[1].'-'.$to[0];

if($ven == "")
    $ven = 0;
$sql = "Select SUBSTRING( nombre, 1, 2 ) as code, nombre_real From Usuarios Where id_usuario = ".$ven;
$resu = mysql_query($sql) or die(mysql_error());
$code = "";
$nombre = "Todos";
if(mysql_num_rows($resu) > 0)
    {
	while($row = mysql_fetch_array($resu))
	{
	    $code = $row['code'];
	    $nombre = $row['nombre_real'];
	}
    }

if($ven != 0)
{
    $sql = "Select
		    count(*) as cantidad,
		    CASE prodHabitual When 1 THEN 'Nuevo' ELSE 'Habitual' END as code
	    From
		    pedidos
	    WHERE
		    femis BETWEEN '".$from."' AND '".$to."' AND codigo Like '".$code."-%' group by prodHabitual ";
}
else
{
    $sql = "Select
		    count(*) as cantidad,
		    CASE prodHabitual When 1 THEN 'Nuevo' ELSE 'Habitual' END as code
	    From
		    pedidos
	    WHERE
		    femis BETWEEN '".$from."' AND '".$to."'  group by prodHabitual ";
}

    $resu = mysql_query($sql) or die(mysql_error());
    
    $array = array();
    
    $table = '<table >
		<thead>
		    <tr>
			<th></th>
			<th scope="col">Cantidad</th>
		    </tr>
		</thead>
		<tbody>';
    if(mysql_num_rows($resu) > 0)
    {
	while($row = mysql_fetch_array($resu))
	{
	    $table.= '<tr>
			<th scope="row">'.utf8_encode($row['code']).'</th>
			<td>'.utf8_encode($row['cantidad']).'</td>
		      </tr>';
	}
    }
    else
    {
	echo "No hay resultados";
	return;
    }
    
    
    $links = '  <link href="charting/css/basic.css" type="text/css" rel="stylesheet" />
            <script type="text/javascript" src="charting/_shared/EnhanceJS/enhance.js"></script>	
            <script type="text/javascript">
		// Run capabilities test
		enhance({
			loadScripts: [
				{src: \'charting/js/excanvas.js\', iecondition: \'all\'},
				\'charting/_shared/jquery.min.js\',
				\'charting/js/visualize.jQuery.js\',
				\'charting/js/example3.js\'
			],
			loadStyles: [
				\'charting/css/visualize.css\',
				\'charting/css/visualize-dark.css\'
			]	
		});   
            </script>';
    
    echo '<center><h1>Nuevos Vs Habituales</h1>';
    echo '<h3>Vendedor Selecionado :<b> '.$nombre.'</b><br>
	  Desde: <b>'.$_GET['from'].' </b>Hasta: <b>'.$_GET['to'].'</b></h3></center>';
            
    echo $links.$table;


?>