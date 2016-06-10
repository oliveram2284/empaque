<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$temporada = $_POST['tmp'];
$value = $_POST['val'];
$indice = 0;

foreach($temporada as $t)
{
    $sql  = "Update tbl_temporada ";
    $sql .= "Set tmpTipo = '".$value[$indice]."' ";
    $sql .= "Where tmpId =".$t;
    
    //echo $sql."<br>";
    mysql_query($sql);
    $indice++;
}

echo json_encode(0);
?>