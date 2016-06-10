<?php

if(!isset($_SESSION['codigo']))
{
session_start();
}
class SQLM
    {
      var $server = "SERGIO-PC\SQLEXPRESS"; //nombre del servidor de base de datos SQL Server
      var $user = ""; //usuario para acceder a la base de datos
      var $pass = ""; //contraseña para acceder a la base de datos
      var $base = "plaza";//casamontes
      
      public function conect()
        {
	    //$cid = odbc_connect("SQLServer2000", "Empaque_admin", "666");

      $cid = odbc_connect("Driver={SQL Server};Server=SERVER2008;Database=empaque;", "empaque_admin", "666");
            /*$cid = odbc_connect("Driver={SQL Server};Server=192.168.0.91;Database=Empaque;", "empaque_admin", "666");
            */
            return $cid;
        }
	
 }

?>