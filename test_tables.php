<?php
	include("ConexionSQLMercedario.php");

	//$id_articulo=$_REQUEST['id'];
	//var_dump($id_articulo);
	$var = new SQLM();
	$cid = $var->conect();	
	$response=array();
	$array = array();
		
	$sql="SELECT * FROM information_schema.tables where TABLE_TYPE = 'BASE TABLE'";
	if($result = odbc_exec($cid,$sql))
	{	
		while($obts = odbc_fetch_array ($result))
		{
			var_dump($obts['TABLE_NAME']);
			//$response['articulo']=$articulo;
		}
		
	



	}
	else
	{
	  exit("Error in SQL Query");
	}	


	
	//var_dump($response);
	
  
	//echo json_encode($response);


	

?>