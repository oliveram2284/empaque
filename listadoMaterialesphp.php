<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];


//id
$id = $valores[0];
//Nombre
$nombre = $valores[1];
//Coeficiente
$coef = $valores[2];
//Habilitación
$habi = $valores[3];


if($id == 0)
{
    //Insert
    $sql  = "Insert Into materiales (descripcion, matCoeficiente, habilitacion) Values ";
    $sql .= "('".$nombre."',".$coef.", '".$habi."')";
    $resu = mysql_query($sql) or die(mysql_error());

}
else
{
    //Modificar
    $sql = "Update materiales ";
    $sql.= "set descripcion = '".$nombre."', matCoeficiente = ".$coef.", habilitacion = '".$habi."' ";
    $sql.= "Where idMaterial = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}


echo json_encode(0);
?>