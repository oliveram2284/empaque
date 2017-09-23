<?php
include("ConexionSQLMercedario.php");
		
	$var = new SQLM();
	$cid = $var->conect();
/*
  $consulta="Select Top 10 * From	articulos WHERE Codigo_en_Cliente!='' ";
  if(isset($_REQUEST['str'])){
    var_dump($_REQUEST['str']);
  
    $str_find=explode('%',$_REQUEST['str']);
    var_dump($str_find);

    $consulta.=" ; ";
    
  }else{
    $consulta.=";";
  }



  $cur = odbc_exec($cid,$consulta)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
	$Fields = odbc_num_rows($cur);

  var_dump($cur);
  var_dump($Fields);




  

	if($Fields > 0)
	{
		    
	    while ($row = odbc_fetch_array($cur)) {
        var_dump($row);
        continue;
        print($row['id'].",".$row['url'].",".$row['time']."\n");
      }  
	    
	}
	else
	{
	    echo json_encode(0);
	}

*/
  
  include("ConexionSQL.php");
$var = new conexionSQL();
$cid = $var->conectarse();
$consulta="Select Top 10 * From	GVA14 ";
  if(isset($_REQUEST['str'])){
    var_dump($_REQUEST['str']);
  
    $str_find=explode('%',$_REQUEST['str']);
    var_dump($str_find);

    $consulta.=" ; ";
    
  }else{
    $consulta.=";";
  }



  $cur = odbc_exec($cid,$consulta)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
	$Fields = odbc_num_rows($cur);

  var_dump($cur);
  var_dump($Fields);




  

	if($Fields > 0)
	{
		    
	    while ($row = odbc_fetch_array($cur)) {
        var_dump($row);
        continue;
        print($row['id'].",".$row['url'].",".$row['time']."\n");
      }  
	    
	}
	else
	{
	    echo json_encode(0);
	}
