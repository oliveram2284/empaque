<?php

session_start();

include ("../config.php");


if(!isset($_REQUEST['action'])){
  return false;
}



switch ($_REQUEST['action']) {
	case '1':
		# INsert Articulo_formatos:

    if(!isset($_REQUEST['id'])){
      return false;
    }
    if(!isset($_REQUEST['formato'])){
      return false;
    }
    if(!isset($_REQUEST['material'])){
      return false;
    }
    $date_time=date("Y-m-d H:i:s");
    $result=R::getRow("SELECT * FROM articulo_formatos where articulo_code='".$_REQUEST['id']."';");

    if(!is_null($result)){
      $sql= "UPDATE articulo_formatos SET formato_id=".$_REQUEST['formato']." WHERE articulo_code ='".$_REQUEST['id']."'; ";//UPDATE articulo_formatos SET formato_id=".$_REQUEST['formato_id']."   WHERE articulo_code ='".$_REQUEST['id']."';
    }else{
      $sql="INSERT INTO articulo_formatos (articulo_code,formato_id,date_time)  VALUES ('".$_REQUEST['id']."',".$_REQUEST['formato'].",'".$date_time."');" ;
      //R::exec( $sql);
    }
    //echo $sql."<br>";
    R::exec($sql);

    $result=R::getRow("SELECT * FROM articulo_materiales where articulo_code='".$_REQUEST['id']."';");

    if(!is_null($result)){
      $sql= "UPDATE articulo_materiales SET material_id=".$_REQUEST['material']." WHERE articulo_code ='".$_REQUEST['id']."'; ";//UPDATE articulo_formatos SET formato_id=".$_REQUEST['formato_id']."   WHERE articulo_code ='".$_REQUEST['id']."';
    }else{
      $sql="INSERT INTO articulo_materiales (articulo_code,material_id,date_time)  VALUES ('".$_REQUEST['id']."',".$_REQUEST['material'].",'".$date_time."');" ;
      //R::exec( $sql);
    }
    //echo $sql."<br>";
    R::exec($sql);

    echo json_encode(array('result'=>true));
		break;

	default:
		# code...
		break;
}
