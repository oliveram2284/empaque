<?php
session_start();
include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$idPolimero      = $_POST['xId'];
$Descuento       = $_POST['xDe'];
$Importe         = $_POST['xIm'];
$idPedido        = 0;

$sql = "Select idPedido from polimeros where id_polimero = ".$idPolimero;
$resu = mysql_query($sql);

while($row = mysql_fetch_assoc($resu))
{
    $idPedido = $row['idPedido'];
}

if($idPedido <= 0)
{
    return json_encode(0);
}
else
{
    $update = "Update polimeros set EnFacturacion = 'X' where id_polimero = ".$idPolimero;
    $resu = mysql_query($update);
    
    //Estado del polimero
    $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
    $_insert.= "(".$idPolimero.", 'X', ".$_SESSION['id_usuario'].", 'Autorización de Facturación', CURRENT_TIMESTAMP( ))";
    $resu = mysql_query($_insert);
    
    $update = "Update pedidos set SeDescuenta = ".$Descuento.", ImporteFactPolimero = ".$Importe." Where npedido = ".$idPedido;
    $resu = mysql_query($update);
    
    return json_encode(1);
}
?>