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
      parse_str($_REQUEST['params'], $params);

      if( isset($params['id']) && $params['id']!=''){
        $sql= "UPDATE bobinas SET formato_id=".$params['formato_id'].", proveedor_id=".$params['proveedor_id'].", nombre='".$params['nombre']."',  descripcion='".$params['descripcion']."', largo=".$params['largo']."   WHERE id ='".$params['id']."'  ";
      }else{
        $sql="INSERT INTO bobinas (formato_id,proveedor_id,nombre,descripcion,largo,created)  VALUES ( ".$params['formato_id'].", ".$params['proveedor_id'].",'".$params['nombre']."','".$params['descripcion']."',".$params['largo'].",NOW());" ;
      }

      R::exec($sql);
      $id = R::getInsertID();
      echo json_encode(array('result'=>true, 'id'=>$id));
      break;
    }
    case '2':{
      if(!isset($_REQUEST['id'])){
        echo json_encode(array('result'=>false));
      }
      $sql="SELECT * FROM bobinas WHERE id='".(int)$_REQUEST['id']."' ";
      $result= R::getRow($sql);


      echo json_encode(array('result'=>true, 'bobina'=>$result));
      break;
    }
    case '3':{

      if(!isset($_REQUEST['formato_id'])){
        echo json_encode(array('result'=>false));
      }
      $sql="SELECT *, (largo*100) as 'largo_cm' FROM bobinas WHERE formato_id='".(int)$_REQUEST['formato_id']."' ";
      $result= R::getAll($sql);
      //$result['largo_cm']=floatval($result['largo'])*100;
      echo json_encode(array('result'=>true, 'bobina'=>$result));
      break;
    }

    default:
      # code...
      break;
  }

  return false;
