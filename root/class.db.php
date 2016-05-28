<?php
//include "conexion.php";

class DB{
		
		
	var $link;
		
    var $ar_select				= array();
	var $ar_distinct			= FALSE;
	var $ar_from				= array();
	var $ar_join				= array();
	var $ar_where				= array();
	var $ar_like				= array();
	var $ar_groupby				= array();
	var $ar_having				= array();
	var $ar_limit				= FALSE;
	var $ar_offset				= FALSE;
	var $ar_order				= FALSE;
	var $ar_orderby				= array();
	var $ar_set					= array();	
	var $ar_wherein				= array();
	var $ar_aliased_tables		= array();
	var $ar_store_array			= array();
	
		// Variables de Cache Active Record 
	var $ar_caching 			= FALSE;
	var $ar_cache_exists		= array();
	var $ar_cache_select		= array();
	var $ar_cache_from			= array();
	var $ar_cache_join			= array();
	var $ar_cache_where			= array();
	var $ar_cache_like			= array();
	var $ar_cache_groupby		= array();
	var $ar_cache_having		= array();
	var $ar_cache_orderby		= array();
	var $ar_cache_set			= array();	

	function _construct()
	{
		$link=new conexion();
	}
	
 function query($query=""){
	
		if($query!="")
		{
			$link=new conexion();
            $link=$link->conectarse();
			
			$result=mysql_query($query)or die(mysql_error());
				//echo"line 55: ";
				//rint_r(mysql_fetch_array($result));
				//return mysql_fetch_array($result);
				return $result;
		
			
		}
		else
		 return false;
	
 }
 
 function insert($array,$table)
 {
	$sql="Insert into ".$table." ";
	
	$keys=implode(",",array_keys($array));
	$values = implode(",",array_values($pallet));
	
	$sql="insert into ".$table."( ".$keys.") values(".$values.");";
	
	$link=new conexion();
        $link=$link->conectarse();	
	
	
 }
 
 function arrayKeys_to_string($array,$char)
 {	$string="";
	$aux=array_keys($array);
	foreach($aux as $row)
	{
		$string.=$row.$char."";
	}
	
	return $string;
 }

}

?>