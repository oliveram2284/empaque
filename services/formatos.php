<?php
session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("../config.php");

function unserialize_params($data){
	$substring=explode('&', $data);
	$result=array();
	foreach ($substring as $key => $item) {
		$subdata=explode('=',$item);

		$result[$subdata[0]]=$subdata[1];
	}

	return $result;
}





//$cantidades=  R::getAll('SELECT fc.*,f.* FROM formatos_cantidades as fc INNER JOIN formatos as f ON f.idFormato=fc.formato_id;');
if(!isset($_REQUEST['action'])){
    return false;
}else{

    switch ($_REQUEST['action']) {
        case '1':
          # Retorna Listado de Formatos
          $formatos=R::getAll("SELECT idFormato as id ,descripcion  as name FROM formatos ORDER BY name ASC;");
          echo json_encode(array('result'=>$formatos));
          break;
        case '2':
        	# Inserta o Actualiza Listado de Formatos

        	$params=unserialize_params($_REQUEST['params']);
          if(isset($params['descripcion'])){
            $params['descripcion']=str_replace('+',' ',$params['descripcion']);
          }
          if($params['id']==0){
            $sql='INSERT INTO formatos_cantidades (articulo_id,articulo_nombre,formato_id,descripcion,largo,ancho,metros,multiplo)VALUES(" ", " ",'.$params['formato'].',"'.$params['descripcion'].'",'.$params['largo'].','.$params['ancho'].',0,'.$params['multiplo'].')' ;
            //echo $sql."<br>";
            R::exec( $sql);
            $id = R::getInsertID();
            echo json_encode(array('result'=>$id));
          }else{
            $sql_query_update='UPDATE formatos_cantidades SET formato_id='.$params['formato'].',
              articulo_id="",
              articulo_nombre= "",
              largo='.$params['largo'].',
              ancho='.$params['ancho'].',

              descripcion= "'.$params['descripcion'].'",
              multiplo= '.$params['multiplo'].' where id='.$params['id'].'; ' ;
            //  echo $sql_query_update."<br>";
            //die();
            R::exec($sql_query_update );
            //$id = R::getInsertID();
            echo json_encode(array('result'=>true));
          }

        	break;
        case '3':
          # Retorna Listado de Formatos
          $result=R::getAll("SELECT * FROM formatos_cantidades where id=".$_REQUEST['id'].";");

          $formato=$result[0];
          $formato['largo']= number_format((float)$formato['largo'], 2, '.', '');
          $formato['ancho']= number_format((float)$formato['ancho'], 2, '.', '');

          echo json_encode(array('formato'=>$formato));
          break;
        case '4':
          # Retorna Listado de Formatos

          R::exec( 'DELETE FROM formatos_cantidades  WHERE id='.$_REQUEST['id'].'; ' );
          //$id = R::getInsertID();
          echo json_encode(array('result'=>true));
          break;
        case '5':
          # Disable Listado de Formatos
          R::exec( 'UPDATE formatos_cantidades SET status='.$_REQUEST['status'].'  WHERE id='.$_REQUEST['id'].'; ' );
          //$id = R::getInsertID();
          echo json_encode(array('result'=>true));
          break;
        case '6':

          # Retorna Listado de Formatos
          $formato=R::getAll("SELECT * FROM formatos_cantidades where formato_id=".$_REQUEST['id_formato']."  and status=0 ; order by descripcion ;");

          echo json_encode(array('result'=>$formato));
          break;
        default:
          echo json_encode(array('result'=>false));
          break;
    }
}
