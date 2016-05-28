<?php
session_start();
include("conexion.php");
		
$var = new conexion();
$var->conectarse();


$action = $_POST['action'];
$idPoli = $_POST['id'];
$motive = $_POST['motive'];
$motives = $_POST['mot'];

//Actualizar estado del pedido
if($action != 'Z' && $action != 'X')
{
    $update = "Update polimeros set estado = '".$action."' Where id_Polimero = ".$idPoli;
    $resu = mysql_query($update);
    
    if($action == 'Y')
    {
        //Actualizar estado del pedido
        $update_p = "Update pedidos set estado = 'CP' Where poliNumero = ".$idPoli;
        $resu = mysql_query($update_p);
        
        $pedido = "Select idPedido from polimeros where id_polimero = ".$idPoli;
        $resu = mysql_query($pedido);
        $idPedido = mysql_fetch_array($resu);
        
        $idUsuario = $_SESSION['id_usuario'];
        
        $sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
        $sql .= "('".$idPedido[0]."', 'CP', ".$idUsuario.")";
        $resu = mysql_query($sql)or die(mysql_error());
    }
    
    if($action == "N")
    {
        $update_n = "Update polimeros set enProduccion = 0 Where id_Polimero = ".$idPoli;
        $resu = mysql_query($update_n);
    }
}
else
{
    $standBy = $action == 'Z' ? 1 : 0;
    $update = "Update polimeros set standBy = ".$standBy." Where id_Polimero = ".$idPoli;
    $resu = mysql_query($update);
}

//Agregar log de pedido
$_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, motives, logFecha) values";
$_insert.= "(".$idPoli.", '".$action."', ".$_SESSION['id_usuario'].", '".$motive."', '".$motives."', CURRENT_TIMESTAMP( ))";
$resu = mysql_query($_insert);

//retornar json = nada
echo json_encode(1);

?>