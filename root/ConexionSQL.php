<?php

if(!isset($_SESSION['codigo']))
{
session_start();
}
class conexionSQL
    {
      var $server = "SERGIO-PC\SQLEXPRESS"; //nombre del servidor de base de datos SQL Server
      var $user = ""; //usuario para acceder a la base de datos
      var $pass = ""; //contraseña para acceder a la base de datos
      var $base = "plaza";//casamontes
      
      public function conectarse()
        {
            $cid = odbc_connect("Driver={SQL Server};Server=SRV-TANGO\AXSQLEXPRESS;Database=Empaque_sa;", "Axoft", "Axoft");
            
            return $cid;
        }
	
 }

?>