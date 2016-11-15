<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");
ini_set('max_execution_time', 0);
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', -1);

include ("../config.php");

$resultado=R::getAll("SELECT  p.descrip3 as 'articulo_code' , pd.Formato as 'formato_id', pd.Material as 'material_id' FROM pedidos as p INNER JOIN pedidosdetalle as pd ON p.npedido=pd.idPedido WHERE p.descrip3!='' ORDER BY p.descrip3;");
//var_dump(count($resultado));

$total_formato_inserted=0;
$total_material_inserted=0;
foreach ($resultado as $key => $item) {

  //echo "=> $key => '".$item['formato_id']."' <br>";
  $sql_query="SELECT * FROM articulo_formatos WHERE articulo_code='".$item['articulo_code']."'";
  //echo "==> sql_query: $sql_query <br>";
  $check=R::getAll($sql_query);
  //var_dump($check);
  if(empty($check)){
    $query_insert="INSERT INTO articulo_formatos (articulo_code,formato_id) VALUES ('".$item['articulo_code']."','".$item['formato_id']."')";
    //echo " ===> | $query_insert <br> ";
    R::exec( $query_insert);
    if($id = R::getInsertID()){
      //var_dump($id);
      $total_formato_inserted++;
    }
  }


  $sql_query="SELECT * FROM articulo_materiales WHERE articulo_code='".$item['articulo_code']."'";
  //echo "==> sql_query: $sql_query <br>";
  $check=R::getAll($sql_query);
  //var_dump($check);
  if(empty($check)){
    $query_insert="INSERT INTO articulo_materiales (articulo_code,material_id) VALUES ('".$item['articulo_code']."','".$item['material_id']."')";
    //echo " ===> | $query_insert <br> ";
    R::exec( $query_insert);
    if($id = R::getInsertID()){
      //var_dump($id);
      $total_material_inserted++;
    }
  }

}

echo "<br>  OK ==> | Total_formato_inserted: $total_formato_inserted <br> ";
echo "<br>  OK ==> | Ttotal_material_inserted: $total_material_inserted <br> ";
