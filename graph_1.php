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

$sql = "Select count(*) as cantidad ,SUBSTRING( codigo, 1, 2 ) as code from pedidos WHERE femis BETWEEN '".$from."' AND '".$to."' group by SUBSTRING( codigo, 1, 2 ) order by cantidad ".$order." Limit ". $cant ." ";

$resu = mysql_query($sql) or die(mysql_error());

$array = array();

$table = '';
if(mysql_num_rows($resu) > 0)
{
    $cantidad = 0;
    while($row = mysql_fetch_array($resu))
    {
        $table.= '<tr>
                    <th scope="row">'.utf8_encode($row['code']).'</th>
                    <td>'.utf8_encode($row['cantidad']).'</td>
                  </tr>';
                  
        $cantidad += $row['cantidad'];
    }
    
    $sql = "Select count(*) as cantidad from pedidos WHERE femis BETWEEN '".$from."' AND '".$to."' ";

    $resu = mysql_query($sql) or die(mysql_error());
    
    $resto = 0;
    while($row = mysql_fetch_array($resu))
    {
        $table.= '<tr>
                    <th scope="row">Resto</th>
                    <td>'.utf8_encode($row['cantidad'] - $cantidad).'</td>
                  </tr>';
                  
        $resto = $row['cantidad'] - $cantidad;
    }
echo '<center><h1>Cantidad de Pedidos x Vendedor</h1>';
echo '<h3>Vendedores Citados :<b>'.$cant.' => '.$cantidad.'</b> pedidos<br>
      Resto Vendedores   :<b> -- => '.$resto.'</b> pedidos<br>
      Desde: <b>'.$_GET['from'].' </b>Hasta: <b>'.$_GET['to'].'</b></h3></center>';
$header = '<table >
            <thead>
		<tr>
                    <td></td>
                    <th scope="col">Cantidad</th>
                </tr>
            </thead>
            <tbody>';

    $links = '  <link href="charting/css/basic.css" type="text/css" rel="stylesheet" />
            <script type="text/javascript" src="charting/_shared/EnhanceJS/enhance.js"></script>	
            <script type="text/javascript">
		// Run capabilities test
		enhance({
			loadScripts: [
				{src: \'charting/js/excanvas.js\', iecondition: \'all\'},
				\'charting/_shared/jquery.min.js\',
				\'charting/js/visualize.jQuery.js\',
				\'charting/js/example.js\'
			],
			loadStyles: [
				\'charting/css/visualize.css\',
				\'charting/css/visualize-dark.css\'
			]	
		});   
            </script>';
            
    echo $links.$header.$table;
}
else
{
    echo "No hay resultados";
}


?>