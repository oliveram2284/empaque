<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$cant = $_GET['cant'];
$order = $_GET['order'];
$from = $_GET['from'];
$to = $_GET['to'];

$from = explode("-", $from);
$from = $from[2].'-'.$from[1].'-'.$from[0];
$to = explode("-", $to);
$to = $to[2].'-'.$to[1].'-'.$to[0];

$sql = "Select count(*) as cantidad, material From pedidos as p Join pedidosDetalle As d On p.npedido = d.idPedido Where femis BETWEEN '".$from."' And '".$to."' Group By material Order By cantidad ".$order." Limit ". $cant ." ";

$resu = mysql_query($sql) or die(mysql_error());

$array = array();

$table = '<table >
            <caption>Cantidad de Pedidos x Material</caption>
            <thead>
		<tr>
                    <th>Material</th>
                    <th scope="col">Cantidad</th>
                </tr>
            </thead>
            <tbody>';
if(mysql_num_rows($resu) > 0)
{
    while($row = mysql_fetch_array($resu))
    {
        $table.= '<tr>
                    <th scope="row">'.utf8_encode(getMaterial($row['material'])).'</th>
                    <td>'.utf8_encode($row['cantidad']).'</td>
                  </tr>';
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
				\'charting/js/example2.js\'
			],
			loadStyles: [
				\'charting/css/visualize.css\',
				\'charting/css/visualize-dark.css\'
			]	
		});   
            </script>';
            
    echo $links.$table;
}
else
{
    echo "No hay resultados";
}

function getMaterial($id){
    $sql = "Select descripcion From materiales Where idMaterial = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    if(mysql_num_rows($resu) > 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
}
?>