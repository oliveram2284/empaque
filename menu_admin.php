<?php  
session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("config.php");
include ("conexion.php");
require("header.php");

$vari = new conexion();
$vari->conectarse();
$cantidades=  R::getAll('SELECT fc.*,f.* FROM formatos_cantidades as fc INNER JOIN formatos as f ON f.idFormato=fc.formato_id;');
//var_dump($cantidades);

?>