<?php
session_start();
$id = $_POST['xId'];
$st = $_POST['xstatus'];

include("conexion.php");
	
$var = new conexion();
$var->conectarse();

if($st != 'Z' && $st != 'X')
{
    switch($st)
    {
        case "E":
            $_search = "Update polimeros Set estado = '".$st."', EnFacturacion ='F' Where id_polimero = ".$id;
            $resu = mysql_query($_search);
            break;
            
        case "Q":
            $_search = "Update polimeros Set EnFacturacion ='A' Where id_polimero = ".$id;
            $resu = mysql_query($_search);
            break;
        
        case "R":
        case "S":
            $_search = "Update polimeros Set EnFacturacion ='".$st."' Where id_polimero = ".$id;
            $resu = mysql_query($_search);
            break;
	
	case "K":
	    $_search = "Update polimeros Set estado = '".$st."', enProduccion=1 Where id_polimero = ".$id;
            $resu = mysql_query($_search);
            break;
        
        default:
            $_search = "Update polimeros Set estado = '".$st."' Where id_polimero = ".$id;
            $resu = mysql_query($_search);
            break;
    }
    
    //Para que sea visible en produccion
    if($st == "E")
    {
        $update = "Update pedidos Set polimeroEnFacturacion = '1' Where poliNumero = ".$id;
        $resu = mysql_query($update);
    }
    
    if($st == "S" || $st == "R")
    {
        $update = "Update pedidos Set polimeroEnFacturacion = '2' Where poliNumero = ".$id;
        $resu = mysql_query($update);
    }
    
    //Habilitar en produccion
    if($st == "G")
    {
	    //	$st = "";
	    //	$get  = "Select seCargoHRCI From pedidos Where npedido = ".$id;
	    //	$getR = mysql_query($get) or die(mysql_error());
	    //	
	    //	if(mysql_num_rows($getR) >= 0)
	    //	{
	    //	    while($getRow= mysql_fetch_array($getR))
	    //	    {
	    //		if($getRow[0] == 1)
	    //		{ $st = "U"; }
	    //		else
	    //		{ $st = "P"; }
	    //	    }
	    //	}
	    //	else{ $st = "P"; }
	    //	
	    //	$update = "Update pedidos Set estado = '".$st."' Where poliNumero = ".$id;
	    //        $resu = mysql_query($update);
	    //	
	    //	$idPedido = "Select npedido from pedidos Where poliNumero = ".$id;
	    //	$resu = mysql_query($idPedido);
	    //	
	    //	while($row = mysql_fetch_array($resu))
	    //	{
	    //	    $idPedido = $row[0];
	    //	}
	    //	//reg log pedido
	    //        reg_log($idPedido, $st);
    }
}
else
{
    if($st == 'Z')
    {
        $_search = "Update polimeros Set standBy = 1 Where id_polimero = ".$id;
    }
    else
    {
        $_search = "Update polimeros Set standBy = 0 Where id_polimero = ".$id;
    }
    $resu = mysql_query($_search);
}

$_insert = "Insert tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, logFecha, observacion) values ";
$_insert.= "(".$id.", '".$st."', ".$_SESSION['id_usuario'].", CURRENT_TIMESTAMP( ), '')"; 

$resu = mysql_query($_insert);

function reg_log($idPedido, $estado )
{
    $idUsuario = $_SESSION['id_usuario'];
    
    $sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
    $sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.")";
    $resu = mysql_query($sql)or die(mysql_error());
}

echo json_encode(1);
?>