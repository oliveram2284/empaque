<?php

$link = mssql_connect('192.168.0.91', 'cpyt', 'cpyt');

$dbname = "EMPAQUE";

mssql_select_db('['.$dbname.']' , $link);

//$all = mssql_query("select TOP 20 COD_ARTICU, DESCRIPCIO from STA11");

$all = mssql_query('SELECT * FROM ( SELECT articulos.id, articulo, ROW_NUMBER() OVER (ORDER BY articulos.id) as row FROM articulos ) as alias WHERE row >= 1 and row <= 20');


while($lista = mssql_fetch_array($all)) { 

 echo $lista['id'], ' - ', $lista['articulo'], '<br />';
 
}


// Clean up
mssql_free_result($all);
?>

