<?PHP
 //  include("conexion.php");
  //include("cliente_libreria.php");
	$link= new Conexion();
    $link->conectarse();

function tabla_grilla($result)
{echo "<table id='table1'>";
     echo "<thead >
		<tr>";
		print "<td align=\"center\">-</td>\n";
	  for ($i =1; $i < mysql_num_fields($result); $i++)
      {  
	   
       print "<td>".mysql_field_name($result, $i)."</td>\n";  
      }  
	  echo "</tr></thead>";
	  echo" <tbody>	";
      while ($registro = mysql_fetch_row($result))
      {
       echo "<tr>";
	  
       for($i=0;$i<count($registro);$i++)
	  { 
	     if($i==0)
		  echo "<td><input type='checkbox' name='ck[]' id='ck[]' value=\"".$registro[$i]."\" value=\"alert('this.value');\"/> </td>";  else
	     echo "<td>".$registro[$i]."</td>";
	  }
	   
         echo "</tr>";
       }

         echo "<tbody></table>";

}


function listaTabla($result,$destino,$destino2,$titulo)
{  
   
 echo "<table width='100%' class='fondo_tabla' >";
 
     echo "<thead >
		<tr>";
      for ($i = 0; $i < mysql_num_fields($result); $i++)
      {
	          print "<td align=\"center\" class=\"titulo_tabla\">".mysql_field_name($result, $i)."</td>\n";  
	    
       //print "<th align=\"center\" class=\"titulo_tabla\" >".mysql_field_name($result, $i)."</th>\n";  
      }  
	  print "<td align=\"center\" class=\"titulo_tabla\"> Modificar </td>\n<td  align=\"center\" class=\"titulo_tabla\" >Eliminar </td>"; 
	   echo "</tr></thead>";
	  echo" <tbody>	";
	 //print "<th align=\"center\" class=\"titulo_tabla\"> Modificar </th>\n<th  align=\"center\" class=\"titulo_tabla\" >Eliminar </th>"; 
      while ($registro = mysql_fetch_row($result))
      {
       echo "<tr class=\"body\" align=\"left\">";
	  
      for($i=0;$i<count($registro) ;$i++)
	  { 
	   if($i==0)
	     echo "<td align=\"center\" > <a href='#' > ".$registro[$i]."</a></td> ";
	   else
	     echo "<td align=\"center\" > ".$registro[$i]."</td> ";
	  }
	   echo "<td align=\"center\" > <img align=\"middle\" src=\"assets/css/plugins/buttons/icons/pencil.png\" onclick=\" PopWindows('".$destino."?id=".$registro[0]."','".$titulo."','350','800');\" /></td><td align=\"center\" > <img align=\"middle\" src=\"assets/css/plugins/buttons/icons/shape_square_delete.png\" onclick=\" PopWindows('".$destino2."?id=".$registro[0]."','".$titulo."','350','800');\" /></td>";
		 echo "</tr>";
	  }

   echo "<tbody></table>";



}

function listaTabla_link($result,$destino,$destino2,$titulo)
{  
   
 echo "<table  id='myTable' width='100%' class='fondo_tabla' >";
      for ($i = 0; $i < mysql_num_fields($result); $i++)
      {  
       print "<th align=\"center\" > <u>".mysql_field_name($result, $i)."</u></th>";  
      }  
	  print "<th align=\"center\" ><u>Modifica</u></th>"; 
      while ($registro = mysql_fetch_row($result))
      {
       echo "<tr  align=\"left\">";
	  
      for($i=0;$i<count($registro) ;$i++)
	  { 
	   if($i==0)
	     echo "<td align=\"center\" > <a href='#' > ".$registro[$i]."</a></td> ";
	   else
	     echo "<td align=\"center\" > ".$registro[$i]."</td> ";
	  }
	   echo "<td align=\"center\" > <img align=\"middle\" src=\"assets/css/plugins/buttons/icons/pencil.png\" onclick=\" PopWindows('".$destino."?id=".$registro[0]."','".$titulo."','350','800');\" /></td>";
		
	  }

  echo "</tr></table> ";


}







function menu_ppal()
	{
     $var = new conexion();
     $var->conectarse();
	 // cantidad de elementos para el menu
$consulta = 'Select Count(*)as cantidad From tbl_menu Where imagen != ""';
$resu = mysql_query($consulta);
$reg=mysql_fetch_array($resu);
$cantidad=$reg['cantidad'];
//------

// crear menu(cada "i" es un item principal en el menu)
 echo"<div id=\"divmenu\" class=\"div1\">
<ul id=\"menu\">";
for($i=0;$i<$cantidad;$i++)
	{
	$item = ($i+1).'/';
	$consulta = "Select * From tbl_menu Where ubicacion Like '$item%' Order By ubicacion";
	$resu = mysql_query($consulta);
	//para determinar la cabecera del menu
	$cabecera = true;
	//cantidad de componentes que componen el submenu
	$filas = mysql_num_rows($resu);
	//menu
	
	while($row = mysql_fetch_array($resu))
		{
		 //cabecera
		 if($cabecera == true)
		 	{
			 echo '<li><a href="#">'.$row['descripcion'].'</a><ul>';
			 $cabecera = false;	
			 $filas--;		
			}else
				{
				 //cuerpo del item que se selecciona
				 echo '<li><a href="'.$row['link'].'">'.$row['descripcion'].'</a></li>';
				 $filas--;
				}
		 if($filas == 0)
		 	{
			 //cerrar opcion del menu
			 echo '</ul><li>';
			}
		}
	}


echo"</ul></div>";


	}



?>