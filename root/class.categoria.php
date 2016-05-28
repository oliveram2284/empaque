<?php
include "class.db.php";


class Categorias{
 var $items;
 var $id_categoria;
 var $codigo;
 var $nombre;
 var $factor;
 
 function _construct(){
	$this->items=$this->set_alias("categorias");
	$this->name_field=
	$this->id_categoria=0;
	$this->codigo="";
	$this->nombre="";
	$this->factor="0.000";
 }
 
 function set_alias($table)
 {
	$sql="SHOW FIELDS from categorias";
	$arre= array( array('field'=>"id_categoria",'alias'=>"ID Categoría"),
							 array('field'=>"codigo",'alias'=>"Código"),
							 array('field'=>"nombre",'alias'=>"Nombre"),
							 array('field'=>"factor",'alias'=>"Factor")
						);
	return $arre;
 }
 function set()
 {
	
 }
 
 function get($id_cat=false)
 {
	
	$dbo= new db();
	$sql="select id_categoria 'Id Categoria',codigo 'Código',nombre 'Nombre',factor 'Factor' from  categorias";
	if($id_cat!=false)
	{
		$sql.=" where id_categoria = ".$id_cat." ;";
	}
	//echo $sql;
	$result= $dbo->query($sql);
	
 /*echo"line";
	print_r($result);*/
	
	$cat= new categorias();
	
	$cat->id_categoria=$result['Id Categoria'];
	$cat->codigo=$result['Código'];
	$cat->nombre=$result['Nombre'];
	$cat->cator=$result['Factor'];
	return $cat;	
	
 }
 
 function get_all()
 {
		$dbo= new db();
		$sql="select id_categoria 'Id Categoria', codigo 'Código',nombre 'Nombre',factor 'Factor' form categorias";
		
		$result= $dbo->get_all();
		
		$i=0;
		while($fila = mysql_fetch_array($query))
		{  
		  //$zana= new zona();
		  $zona[$i]->id_zona=$fila['id_categoria'];
		  $zona[$i]->descripcion=$fila['codigo'];
		  $zona[$i]->info=$fila['info'];
		  $zona[$i]->estado=$fila['estado'];
		  $zona[$i]->color=$fila['color'];
		  
		   $i++;
		}
		  	return $zona;//retorna array de clientes
 }

}
?>