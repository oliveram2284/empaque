<?php

session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("../config.php");


if(!isset($_REQUEST['action'])){
  return false;
}



switch ($_REQUEST['action']) {
	case '1':
		# Get pedido by ID
		$formato=R::getAll("SELECT * FROM pedidos where npedido=".$_REQUEST['id'].";");            
          echo json_encode(array('pedido'=>$formato[0]));
		break;
	
	default:
		# code...
		break;
}