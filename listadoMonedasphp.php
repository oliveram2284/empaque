<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];


//id
$id     = $valores[0];
//Nombre
$nombre = $valores[1];
//Cotizacion
$cotiza   = $valores[2];

if($id == 0)
{
    //Insert
    $sql  = "Insert Into monedas (descripcion, cotizacion) Values ";
    $sql .= "('".$nombre."',".$cotiza.")";
    $resu = mysql_query($sql) or die(mysql_error());

}
else
{
    //Modificar
    $sql = "Update monedas ";
    $sql.= "set descripcion = '".$nombre."', cotizacion = ".$cotiza." ";
    $sql.= "Where idMoneda = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}


echo json_encode(0);
?>