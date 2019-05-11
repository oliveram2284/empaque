<?php
session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("../config.php");

$sql_create_table="CREATE TABLE `motivo_modificacion` (
`id`  int(11) NULL AUTO_INCREMENT ,
`nombre`  varchar(250) NULL ,
`descripcion`  tinytext NOT NULL ,
`estado`  tinyint(1) NULL DEFAULT 0 ,
`creado`  datetime NULL 
)
;
";

/*
$sql="select id,nombre from motivo_modificacion  ;";
$motivos=  R::getAll($sql);

var_dump($motivos);*/


  if(!isset($_REQUEST['action'])){
    echo json_encode(array('result'=>false));
  }

  $action=$_REQUEST['action'];

  switch ($action) {
    case '1':{
        $params=array();
        parse_str($_REQUEST['params'], $params);
        $descipcion=(isset($params['descripcion']))?$params['descripcion']:'';
        if( isset($params['id']) && $params['id']!=''){
            $sql= "UPDATE motivo_modificacion SET 
            nombre='".$params['nombre']."',  descripcion='".$descipcion."'           
            WHERE id ='".$params['id']."'  ";
           // die($sql);
        }else{
            
            $sql="INSERT INTO motivo_modificacion (nombre,descripcion,estado,creado) 
             VALUES ('".$params['nombre']."','".$descipcion."',1,NOW());" ;
        }
        //var_dump($sql);
        //die("fin");
        R::exec($sql);
        $id = R::getInsertID();
        echo json_encode(array('result'=>true, 'id'=>$id));
        break;
    }
    case '2':{
      if(!isset($_REQUEST['id'])){
        echo json_encode(array('result'=>false));
      }
      $sql="SELECT * FROM motivo_modificacion WHERE id='".(int)$_REQUEST['id']."' ";
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

  return false;

