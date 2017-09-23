<?php
	include("ConexionSQLMercedario.php");
	header('Access-Control-Allow-Origin: *'); 	
	$var = new SQLM();
	$cid = $var->conect();
	
	$value = $_POST['xinput'];
	$page = $_POST['xpage'];
	$tipo = $_POST['busq'];
		
	$array = array();
	
	switch($tipo)
	{
		
		case 1:
			
			$consulta = 	"Select
						Top 80 Id, Articulo, Nombre_en_Facturacion
					From
						articulos
					Where
						(Id like '%".$value."%' or
						Articulo like '%".$value."%' or
						Nombre_en_Cliente like '%".$value."%') and
						Articulo not like '-%' and
						Articulo not like '+%'
					Order by
						Articulo";
				
			break;
	
		case 3:
			
			$consulta = 	"Select
						Top 80 Id, Articulo, Nombre_en_Facturacion
					From
						articulos
					Where
						(Id like '%".$value."%' or
						Articulo like '%".$value."%' or
						Nombre_en_Cliente like '%".$value."%') and
						Articulo like '-%'
					Order by
						Articulo";
				
			break;
		
		case 2:
			
			$consulta = 	"Select
						Top 80 Id, Articulo, Nombre_en_Facturacion
					From
						articulos
					Where
						(Id like '%".$value."%' or
						Articulo like '%".$value."%' or
						Nombre_en_Cliente like '%".$value."%') and
						Articulo like '+%'
					Order by
						Articulo";
				
			break;
		
		case 4:
			
			$consulta = 	"Select
						Top 80 Id, Articulo, Nombre_en_Facturacion
					From
						articulos
					Where
						(Id like '%".$value."%' or
						Articulo like '%".$value."%' or
						Nombre_en_Cliente like '%".$value."%') and
						(Articulo like '-%' or Articulo like '+%')
					Order by
						Articulo";
				
			break;
	}
	
	//die($consulta);

	$cur = odbc_exec($cid,$consulta)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
	$Fields = odbc_num_rows($cur);

	if($Fields > 0)
	{
		    
	    while( $row = odbc_fetch_row( $cur ))
		    {
			    $array[] = array(
						    "Id" 			=> utf8_encode(odbc_result($cur,'Id')),
						    "Articulo" 			=> utf8_encode(odbc_result($cur,'Articulo')),
						    "Nombre_en_Facturacion" 	=> utf8_encode(odbc_result($cur,'Nombre_en_Facturacion'))
					    );
			    
		    }
	    echo json_encode($array);
	    
	}
	else
	{
	    echo json_encode(0);
	}
	
?>