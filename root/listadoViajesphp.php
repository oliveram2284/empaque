<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];

//id
$id= $valores[0];
//fecha
$fecha = $valores[1];
//idDestino
$idDestino = $valores[2];
//Codigo 
$codigo = $valores[3];
//idTransporte
$idTransporte = $valores[4];
//Dias
$dias = $valores[5];
//Horas
$horas = $valores[6];
//Hora salida
$horaSalida = $valores[7];
//Minuto salida
$minutoSalida = $valores[8];

$fecha = explode('-', $fecha);
$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];

if($id == 0)
{
    //Insert
    $sql  = "INSERT INTO viajes( fecha, idDestino, codigo, idTransporte, dias, horas, horaSalida, minutoSalida) VALUES ('".$fecha."',".$idDestino.",'".$codigo."', ".$idTransporte.", ".$dias.", ".$horas.", '".$horaSalida."', '".$minutoSalida."')";
    $resu = mysql_query($sql) or die(mysql_error());


}
else
{
    //Modificar
    $sql = "Update viajes ";
    $sql.= "set fecha = '".$fecha."', idDestino = ".$idDestino.", codigo = '".$codigo."', idTransporte = ".$idTransporte.", dias = ".$dias.", horas = ".$horas.", horaSalida = '".$horaSalida."', minutoSalida = '".$minutoSalida."' ";
    $sql.= "Where idViaje = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}



echo json_encode(0);
?>