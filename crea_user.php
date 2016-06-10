<?php
session_start();
include ("conexion.php");
$var= new conexion();
$var->conectarse();
$nombre=$_POST['nombre'];
$pass=$_POST['pass'];
$nom_re=$_POST['nombre_real'];
$idq=$_SESSION['id_usuario'];
$x=$_POST['usu'];
$id_grupo = $x[0];
$consulta="Insert Into usuarios (nombre,nombre_real,contraseña,creado_por,id_grupo) VALUES ('".$nombre."','".$nom_re."','".$pass."','".$idq."','".$id_grupo."')";
mysql_query($consulta, $var->links);

header("Location: exito.php");
?>