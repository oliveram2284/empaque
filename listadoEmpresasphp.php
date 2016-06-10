<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xinput'];


//id
$id = $valores[0];
//Razon Social
$razon = $valores[1];
//Direccion 
$direccion = $valores[2];
//Telefono
$telefono = $valores[3];
//Mail
$mail = $valores[4];
//Web
$web = $valores[5];
//Observacion 
$obs = $valores[6];
//Contacto
$con = $valores[7];

if($id == 0)
{
    //Insert
    $sql  = "Insert Into transportes (razon_social, direccion, telefono, mail, 	web, observacion, codigo) Values ";
    $sql .= "('".$razon."','".$direccion."','".$telefono."','".$mail."','".$web."', '".$obs."', '".$con."')";
    $resu = mysql_query($sql) or die(mysql_error());

}
else
{
    //Modificar
    $sql = "Update transportes ";
    $sql.= "set razon_social = '".$razon."', direccion = '".$direccion."', telefono = '".$telefono."', mail = '".$mail."', web = '".$web."', observacion = '".$obs."', codigo ='".$con."' ";
    $sql.= "Where id_transporte = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
}


echo json_encode(0);
?>