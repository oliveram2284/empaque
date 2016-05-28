<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];


//id
$id     = $valores[0];
//Nombre
$nombre = $valores[1];
//Es Kg
$esKg   = $valores[2];
//Alta
$alta   = $valores[3];
//Baja
$baja   = $valores[4];
//Diseño
$dis    = $valores[5];
//Precio
$precio = $valores[6];
//Media
$media  = $valores[7];
//Fabricacio
$fabricacion = $valores[8];
//Coeficiente
$coeficiente = $valores[9];
if($id == 0)
{
    //Insert
    $sql  = "Insert Into tbl_estadisticas (estNombre, estEsKg, estAlta, estBaja, estDisenio, estPrecio, estMedia, estFabricacion, estCoeficiente) Values ";
    $sql .= "('".$nombre."',".$esKg.", ".$alta.", ".$baja.", ".$dis.", ".$precio.", ".$media.",".$fabricacion.",".$coeficiente.")";
    $resu = mysql_query($sql) or die(mysql_error());

}
else
{
    //Modificar
    $sql = "Update tbl_estadisticas ";
    $sql.= "set estNombre = '".$nombre."', estEsKg = ".$esKg.", estAlta = ".$alta.", estBaja = ".$baja.", estDisenio = ".$dis.", estPrecio = ".$precio.", estMedia = ".$media.", estFabricacion = ".$fabricacion.", estCoeficiente = ".$coeficiente." ";
    $sql.= "Where idEsta = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}


echo json_encode(0);
?>