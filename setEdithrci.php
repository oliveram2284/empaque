<?php
session_start();
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['id'];
$val =  $_POST['val'];


$sql  = "Select esCI From pedidos Where npedido = ".$id;
$resu = mysql_query($sql) or die(mysql_error());

$array = array();

if(mysql_num_rows($resu) >= 0)
{
    while($row = mysql_fetch_array($resu))
    {
        $items = "";
        
        if($row[0] != null)
        {
            $update = "Update pedidos set esCI = '".$val."' Where npedido = ".$id;
            $resu = mysql_query($update) or die(mysql_error());
            
            if($val != "")
            {
                $update = "Update pedidos Set seCargoHRCI = 1 Where npedido = ".$id;
            }
            else
            {
                $update = "Update pedidos Set seCargoHRCI = 0 Where npedido = ".$id;
            }
            $r = mysql_query($update) or die(mysql_error());
            reg_log($id,"EH");
        }
        else
        {
            $delete  = "Delete from pedidoshojasderuta where idPedido = ".$id;
            $resu2 = mysql_query($delete) or die(mysql_error());
            
            $items = explode("-", $val);
            
            foreach ($items as $valor) {
                    if($valor != "")
                    {
                        $insert = "Insert Into pedidoshojasderuta (idPedido, HojaDeRuta) Values (".$id.",'".$valor."')";
                        $resu3 = mysql_query($insert) or die(mysql_error());
                    }
                    
                }
            
            if(count($items) > 1)
            {
                $update = "Update pedidos Set seCargoHRCI = 1 Where npedido = ".$id;
            }
            else
            {
                $update = "Update pedidos Set seCargoHRCI = 0 Where npedido = ".$id;
            }
            $r = mysql_query($update) or die(mysql_error());
            reg_log($id,"EH");
        }
        
        
    }
}

function reg_log($idPedido, $estado )
{
	$idUsuario = $_SESSION['id_usuario'];
	
	$sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
	$sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.")";
	$resu = mysql_query($sql)or die(mysql_error());
}

?>