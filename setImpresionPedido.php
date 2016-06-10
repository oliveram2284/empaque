<?php
session_start();

include("conexion.php");
$var = new conexion();
$var->conectarse();

$Id = $_POST['id'];
if($_POST['status'] == "S")
    $Status = 1;
    
if($_POST['status'] == "N")
    $Status = 0;
    
if($_POST['status'] == "P")
    $Status = 2;

$sql = "Update pedidos set estaImpreso = ".$Status." Where nPedido = ".$Id;
$resu = mysql_query($sql);

if($Status == 1)
    $Status = "IH";
    else
        if($Status == 0)
            $Status = "CH";
            else
                if($Status == 2)
                    $Status = "PH";
   
reg_log($Id,$Status);

function reg_log($idPedido, $estado )
{
	$idUsuario = $_SESSION['id_usuario'];
	
	$sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
	$sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.")";
	$resu = mysql_query($sql)or die(mysql_error());
}
?>