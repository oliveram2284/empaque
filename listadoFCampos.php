<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['xinput'];

$id = $id[0];

$array = array();
$sql = "Select * from tbl_formato_campos Where fId = ".$id;
$resu = mysql_query($sql) or (die(mysql_error()));

while($row = mysql_fetch_assoc($resu))
{
    array_push($array, $row);
}

echo json_encode($array);
?>