<?php
session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("../config.php");

  if(!isset($_REQUEST['action'])){
    echo json_encode(array('result'=>false));
  }

  $action=$_REQUEST['action'];

  switch ($action) {
    case '1':{
        $params=array();
        $sql  = "Insert into tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId, observacion) values ";
        $sql .= "(".$_REQUEST['id'].", 'I', ".$_SESSION['id_usuario'].", '".$_REQUEST['msg']."')";        
        R::exec($sql);
        $id = R::getInsertID();
        if($_REQUEST['value']=='1'){
            $sql= "UPDATE pedidos SET costo_aprobado='1',estado='A' WHERE npedido ='".$_REQUEST['id']."'; ";
        }else{
            $sql= "UPDATE pedidos SET costo_aprobado='2',estado='I' WHERE npedido ='".$_REQUEST['id']."'; ";
        }
       
        R::exec($sql);
        echo json_encode(array('result'=>true, 'id'=>$id));
        break;
    }
    case '2':{
      if(!isset($_REQUEST['id'])){
        echo json_encode(array('result'=>false));
      }
      $sql="SELECT * FROM precio_origen WHERE id='".(int)$_REQUEST['id']."' ";
      $result= R::getRow($sql);


      echo json_encode(array('result'=>true, 'data'=>$result));
      break;
    }
    case '3':{

      if(!isset($_REQUEST['id'])){
        echo json_encode(array('result'=>false));
      }
      $sql="DELETE FROM motivo_modificacion WHERE id='".$_REQUEST['id']."';";
      
      $result= R::getAll($sql);
      echo json_encode(array('result'=>true, 'datresulta'=>$result));
      break;
    }

    default:
      # code...
      break;
  }

  exit();

