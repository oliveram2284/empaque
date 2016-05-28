<?php

function view_grilla($dato)
{



	$tabla="";
	
	$tabla.="<table class='sortable resizable editable' >";
	$tabla.="<thead>";
	$tabla.="<tr>";
	//$name_field=array_keys($dato);
	
	for ($i =0; $i < mysql_num_fields($dato); $i++)
      {  
	   
       $tabla.="<td><label>".htmlentities(mysql_field_name($dato, $i))."</label></td>\n";  
      }  
	$tabla.="</tr>";
	$tabla.="</thead>";
	
	$tabla.="<tbody>";
	
	 //print "<th align=\"center\" class=\"titulo_tabla\"> Modificar </th>\n<th  align=\"center\" class=\"titulo_tabla\" >Eliminar </th>"; 
      while ($registro = mysql_fetch_row($dato))
      {
       $tabla.= "<tr >";
	  
      for($i=0;$i<count($registro);$i++)
	  { 
	   		    $tabla.= "<td > ".$registro[$i]."</td> ";
	  }
		  
	  $tabla.="</tr>";
	  
	  }
	
	$tabla.="<tbody>";
	$tabla.="<tr>";
/*
foreach($dato as $row)
	{
		print_r($row);
		echo"<br><br>";
	}

	*/
	$tabla.="</tabla>";
	
	return $tabla;
}

?>