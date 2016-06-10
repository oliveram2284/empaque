<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];


//id
$id = $valores[0];
//Nombre
$nombre = $valores[1];
//Motivo
$motivo = $valores[2];
//Estado
$estado = $valores[3];


if($id == 0)
{
    //Insert
    $sql  = "Insert Into motivo_cancelacion (descripcion, motivo, estado) Values ";
    $sql .= "('".$nombre."','".$motivo."', '".$estado."')";
    $resu = mysql_query($sql) or die(mysql_error());

}
else
{
    //Modificar
    $sql = "Update motivo_cancelacion ";
    $sql.= "set descripcion = '".$nombre."', motivo = '".$motivo."', estado='".$estado."' ";
    $sql.= "Where id = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}


echo json_encode(0);
?>