<?php

$link = mssql_connect('192.168.0.10\SQLEXPRESS_AXOFT', 'sa', 'Axoft2009');

$dbname = "1__EMPAQUE_S_A__-_SAN_JUAN";

mssql_select_db('['.$dbname.']' , $link);

//$all = mssql_query("select TOP 20 COD_ARTICU, DESCRIPCIO from STA11");

$all = mssql_query('SELECT * FROM ( SELECT COD_ARTICU, DESCRIPCIO, ROW_NUMBER() OVER (ORDER BY COD_ARTICU) as row FROM sta11 ) as alias WHERE row >= 1 and row <= 20');


while($lista = mssql_fetch_array($all)) { 

 echo $lista['COD_ARTICU'], ' - ', $lista['DESCRIPCIO'], '<br />';
 
}


// Clean up
mssql_free_result($all);
?>

