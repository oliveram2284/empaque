<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];


//id
$id = $valores[0];
//Material1
$mat1 = $valores[1];
//Material2
$mat2 = $valores[2];
//Habilitación
$habi = $valores[3];


if($id == 0)
{
    //Insert
    $sql  = "Insert Into materialescombo (idMaterial1, idMaterial2, habilitacion) Values ";
    $sql .= "('".$mat1."',".$mat2.", '".$habi."')";
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