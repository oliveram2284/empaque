<?php
class conexion
	{
	  var $server = "localhost";
	  var $user = "root";//mi000652_mauri o root
	  var $pass = "";//12345Mauriper
	  var $links;
	
	  function conectarse()   
	  	{
		 if(!($this->links =mysql_connect($this->server,$this->user,$this->pass)))
		 	{
			 return 1;
			} //si no se muestra ningun mensaje es que se realizo la conexion 
		
		 if (!mysql_select_db("mi000652_empaque1",$this->links ))//mi000652_gestion
   			{
      		 return 1;
   			}
		}
		
	function cerrar_conexion()
		{
		 mysql_close($this->links); //cierra la conexion 
		}
}		
?>