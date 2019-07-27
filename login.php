<?php
session_start();
include ("config.php");

$params = $_POST;

$sql="select * from usuarios where nombre='".$params['username']."';";
$result=  R::getRow($sql);
//var_dump($result);
if(is_null($result)){
    header("Location: no_login.php");
}

if($result['contrasenia']!=$params['password']){
    header("Location: no_login.php");
}


$_SESSION['user']=$result;
$_SESSION['Nombre']=$params['username'];           //variable sesion.nombre = a nombre de usuario
$_SESSION['Pass']=$params['password'];             //variable sesion.pass = a pass del usuarios
$_SESSION['id_usuario']=$result['id_usuario'];     
$_SESSION['permisos'] = $result['id_grupo']; 

//var_dump($_SESSION);

header("Location: principal.php");
