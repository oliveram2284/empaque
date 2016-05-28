<?php
session_start();

include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['id'];
$precio = $_POST['precio'];
$ant = $_POST['ant'];
$moneda = $_POST['moneda'];
$condicion = $_POST['condicion'];


$sql  = "Update pedidosdetalle Set PrecioImporte = ".$precio.", Moneda = ".$moneda.", IVA = ".$condicion." Where idPedido = ".$id;
$resu = mysql_query($sql) or die(mysql_error());

$string = "Cambio de precio, ".$ant." por ".$precio;
$idUsuario = $_SESSION['id_usuario'];
	
$sql  = "Insert into tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId, observacion) values ";
$sql .= "('".$id."', 'PE', ".$idUsuario.", '".$string."')";
$resu = mysql_query($sql)or die(mysql_error());

echo json_encode(1);
?>