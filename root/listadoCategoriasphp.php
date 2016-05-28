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
//Estado
$estado   = $valores[3];

if($id == 0)
{
    //Insert
    $sql  = "Insert Into categoria_usuarios (codigo, descripcion, estado) Values ";
    $sql .= "('".$nombre."','".$cotiza."',".$estado.")";
    $resu = mysql_query($sql) or die(mysql_error());

}
else
{
    //Modificar
    $sql = "Update categoria_usuarios ";
    $sql.= "set codigo = '".$nombre."', descripcion = '".$cotiza."', estado = ".$estado." ";
    $sql.= "Where id = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}


echo json_encode(0);
?>