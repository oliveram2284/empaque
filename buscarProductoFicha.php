<?php
	include ("config.php");
	include("ConexionSQLMercedario.php");



	if(!isset($_REQUEST['id'])){
		echo json_encode(array('error'=>"ID Articulo No existe"));
	}else{

		$id_articulo=$_REQUEST['id'];
		$var = new SQLM();
		$cid = $var->conect();
		$response=array();
		$array = array();

	//Obtener Datos Articulo
	$articulo_sql="SELECT  * FROM dbo.Articulos WHERE  id = '".$id_articulo."' ";
	if($result = odbc_exec($cid,$articulo_sql)){

		while($articulo = odbc_fetch_array ($result))
		{
			//var_dump($articulo);
			$response['articulo']=$articulo;
		}
		//Obtener Datos Fichas_Tecnicas
		$ficha_tecnica_query="SELECT TOP 1 * FROM dbo.Fichas_Tecnicas  WHERE Id_Articulo='".$id_articulo."';";
		if($result = odbc_exec($cid,$ficha_tecnica_query)){
			while($ficha = odbc_fetch_array ($result))
			{
				//var_dump($ficha);
				$response['Fichas_Tecnica']=$ficha;
			}

			//Obtener Datos Fichas_Tecnicas_Detalle
			$ficha_tecnica_detalle_query="SELECT
			ftd.id, ftd.Id_Unidad_Medida,ftd.Valor,ftd.Referencia,ftd.Id_Maquina,ftd.Id_Matriz, um.Nombre,um.Detalle,
			um.Unidad,um.Tipo,um.Id_Sector,um.Id_Ubicacion
			FROM
				dbo.Fichas_Tecnicas_Detalle as ftd
			INNER JOIN dbo.Unidades_Medida as um ON ftd.Id_Unidad_Medida=um.Id
			WHERE Id_Ficha_Tecnica ='".$response['Fichas_Tecnica']['Id']."' ;";

			//echo $ficha_tecnica_detalle_query."<br>";

			if($result = odbc_exec($cid,$ficha_tecnica_detalle_query)){
				while($ficha_detalle = odbc_fetch_array ($result))
				{
					//var_dump($ficha_detalle);
					$response['Fichas_Tecnica_Detalle'][]=$ficha_detalle;
				}
			}else{
				$response['Fichas_Tecnica_Detalle']=array();
			}


		}else{
			$response['Fichas_Tecnica']=array();
		}


		$color_query="SELECT TOP 1 * FROM dbo.Colores  WHERE Id='".$response['articulo']['Id_Color']."';";
		if($result = odbc_exec($cid,$color_query)){
			while($color = odbc_fetch_array ($result)){
				//var_dump($ficha);
				$response['Color']=$color;
			}
		}else{
			$response['Color']=array();
		}


		$sql="SELECT * FROM articulo_formatos where articulo_code='".$id_articulo."';";
		$formato=R::getRow($sql);
		$sql="SELECT * FROM articulo_materiales where articulo_code='".$id_articulo."';";
		$material=R::getRow($sql);
		$response['Formato']=$formato;
		$response['Material']=$material;


	}
	else
	{
	  exit("Error in SQL Query");
	}

	//Obtiene Formato de PRoducto

	/*if($formatos=R::getAll("SELECT f.*, fc.multiplo from formatos as f LEFT JOIN formatos_cantidades as fc ON f.idFormato=fc.formato_id WHERE fc.articulo_id='".$id_articulo."';")){
		$response['Formato']=$formatos[0];
	}else{
		$response['Formato']=false;
	}*/




	echo json_encode($response);

	}



?>
