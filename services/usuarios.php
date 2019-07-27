<?php
include ("../config.php");


  if(!isset($_REQUEST['action'])){
    echo json_encode(array('result'=>false));
  }

  $action=$_REQUEST['action'];

  switch ($action) {
    case '1':{
      $params=array();
      $params = $_REQUEST;

    if( isset($params['id']) && $params['id']!='-1'){
        $sql= "UPDATE usuarios SET  nombre='".$params['nombre']."',  nombre_real='".$params['nombre_real']."',  contrasenia='".$params['contrasenia']."', id_grupo=".$params['id_grupo'].", catId=".$params['catId']."   WHERE id_usuario ='".$params['id']."'  ";
       
    }else{
        $sql="INSERT INTO usuarios (nombre,nombre_real,contrasenia,creado_por,id_tipo,id_sector,id_puesto,id_grupo,catId)  VALUES ('".$params['nombre']."','".$params['nombre_real']."','".$params['contrasenia']."',0,0,0,0,".$params['id_grupo'].",".$params['catId']." );" ;
      }

      R::exec($sql);
      if( isset($params['id']) && $params['id']!='-1'){
        $id =$params['id'];
      }else{
        $id = R::getInsertID();
      }
      
      echo json_encode(array('result'=>true, 'id'=>$id));
      break;
    }
    case '2':{
      if(!isset($_REQUEST['id'])){
        echo json_encode(array('result'=>false));
      }
      $sql="DELETE  FROM usuarios WHERE id_usuario='".(int)$_REQUEST['id']."' ";
      
      $result= R::getRow($sql);

      echo json_encode(array('result'=>true, 'id'=>$_REQUEST['id']));
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
