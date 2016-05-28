<?php
/*// Server in the this format: <computer>\<instance name> or 
// <server>,<port> when using a non default port number
$server = '\\\\192.168.0.10\SQLEXPRESS_AXOFT';

// Connect to MSSQL
$link = mssql_connect($server, 'sa', 'Axoft2009');


if (!$link) {
    die('Ouch! Algo no va del todo bien! MSSQL dice que ' . mssql_get_last_message());
}else{
    die('Pepeeee pe pe pe pe! Bueno bueno! MSSQL dice: ' . mssql_get_last_message());
}*/

// Connect to MSSQL
$link = mssql_connect('192.168.0.10\SQLEXPRESS_AXOFT', 'sa', 'Axoft2009');


$dbname = "1__EMPAQUE_S_A__-_SAN_JUAN";
//$dbname = "CONVERT(varbinary, '1__EMPAQUE_S_A__-_SAN_JUAN')";

mssql_select_db('['.$dbname.']' , $link);

// Do a simple query, select the version of 
// MSSQL and print it.

$version = mssql_query('SELECT @@VERSION');
$row = mssql_fetch_array($version);
$all = mssql_query("select TABLE_NAME, COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS order by TABLE_NAME, ORDINAL_POSITION");

$tables = array();
$columns = array();

while($fet_tbl = mssql_fetch_assoc($all)) { // PUSH ALL TABLES AND COLUMNS INTO THE ARRAY

  $tables[] = $fet_tbl[TABLE_NAME];
  $columns[] = $fet_tbl[COLUMN_NAME];

}

$sltml = array_count_values($tables); // HOW MANY COLUMNS ARE IN THE TABLE

foreach($sltml as $table_name => $id) {
 
 echo "<h2>". $table_name ." (". $id .")</h2><ol>";
 
    for($i = 0; $i <= $id-1; $i++) {
   
    echo "<li>". $columns[$i] ."</li>";
   
    }
   
  echo"</ol>";
 
 
}

echo $row[0];

// Clean up
mssql_free_result($version);
?>

