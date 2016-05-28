<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['xinput'];

$sql = "Select * from tbl_estadisticas Where idEsta = ".$id;
$resu = mysql_query($sql) or (die(mysql_error()));

while($row = mysql_fetch_assoc($resu))
{
    echo json_encode($row);
}
?>