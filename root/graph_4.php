<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$anio = $_GET['anio'];

$años = explode(',', $anio);
$meses = array();

$table = '<table >
            <caption>Pedidos por meses año ';
foreach($años as $a){
    $table .= $a.' ';    
}

$table .= '</caption>
            <thead>
		<tr>
			<td style="background-color: #f4f4f4;"><strong>Año</strong></td>
			<th scope="col">Ene</th>
		    <th scope="col">Feb</th>
		    <th scope="col">Mar</th>
		    <th scope="col">Abr</th>
		    <th scope="col">May</th>
		    <th scope="col">Jun</th>
		    <th scope="col">Jul</th>
		    <th scope="col">Ago</th>
		    <th scope="col">Sep</th>
		    <th scope="col">Oct</th>
		    <th scope="col">Nov</th>
		    <th scope="col">Dic</th>
                </tr>
            </thead>
            <tbody>';

foreach($años as $a){
    $sql = "Select
		   count(*) as cantidad,
		   MONTH( femis ) as Mes
	   From
		   pedidos
	   WHERE
		   YEAR( femis ) = ".$a." group by MONTH( femis ) ";
   
    $resu = mysql_query($sql) or die(mysql_error());
   
    $meses[1] = 0;
    $meses[2] = 0;
    $meses[3] = 0;
    $meses[4] = 0;
    $meses[5] = 0;
    $meses[6] = 0;
    $meses[7] = 0;
    $meses[8] = 0;
    $meses[9] = 0;
    $meses[10] = 0;
    $meses[11] = 0;
    $meses[12] = 0;
      
    while($r = mysql_fetch_assoc($resu)) {
       $meses[$r['Mes']] = $r['cantidad'];
    }
    
    $table .= '<tr><th scope="row">'.$a.'</th>';
    foreach($meses as $m)
    {
	$table .= '<td>'.$m.'</th>';
    }
    
    $table .= '</tr>';
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
				\'charting/js/example4.js\'
			],
			loadStyles: [
				\'charting/css/visualize.css\',
				\'charting/css/visualize-dark.css\'
			]	
		});   
            </script>';

echo $links.$table;
//if(mysql_num_rows($resu) > 0)
//{
//    while($row = mysql_fetch_array($resu))
//    {
//        $table.= '<tr>
//                    <th scope="row">'.utf8_encode($row['code']).'</th>
//                    <td>'.utf8_encode($row['cantidad']).'</td>
//                  </tr>';
//    }
//    
//    $links = '  <link href="charting/css/basic.css" type="text/css" rel="stylesheet" />
//            <script type="text/javascript" src="charting/_shared/EnhanceJS/enhance.js"></script>	
//            <script type="text/javascript">
//		// Run capabilities test
//		enhance({
//			loadScripts: [
//				{src: \'charting/js/excanvas.js\', iecondition: \'all\'},
//				\'charting/_shared/jquery.min.js\',
//				\'charting/js/visualize.jQuery.js\',
//				\'charting/js/example4.js\'
//			],
//			loadStyles: [
//				\'charting/css/visualize.css\',
//				\'charting/css/visualize-dark.css\'
//			]	
//		});   
//            </script>';
//            
//    echo $links.$table;
//}
//else
//{
//    echo "No hay resultados";
//}


?>