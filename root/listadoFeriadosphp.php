<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];

//id
$id= $valores[0];
//fecha
$fecha = $valores[1];
//nombre
$name = $valores[2];

$fecha = explode('-', $fecha);
$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

if($id == 0)
{
    //Insert
    $sql  = "INSERT INTO feriados( ferDay, ferName) VALUES ('".$fecha."','".$name."')";
    $resu = mysql_query($sql) or die(mysql_error());


}
else
{
    //Modificar
    $sql = "Update feriados ";
    $sql.= "set ferDay = '".$fecha."', ferName = '".$name."' ";
    $sql.= "Where ferId = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}

echo json_encode(0);
?>