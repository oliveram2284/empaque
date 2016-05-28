<?php
# FileName="db_conn.php"
# Type="MYSQL"
# HTTP="false"

function Conectarse()
	{
		if (!($link=mysql_connect("localhost","root","root"))){
			echo "<br /><br /><big><b>Error conectando al SERVIDOR de la base de datos.</b></big>";
			exit();
		}
		if (!mysql_select_db("mi000652_empaque1",$link)){
			echo "<br /><br /><big><b>Error seleccionando la base de datos.</b></big>";
			exit();
		}
		return $link;
	}

function ConectarseO()
	{
		$dsn = "CALYPSO";
		//debe ser de sistema no de usuario
		$usuario = "prueba";
		$clave="prueba";

		//realizamos la conexion mediante odbc
		$cid=odbc_connect($dsn, $usuario, $clave);
		if(!$cid)
			{
    			die('Something went wrong while connecting to MSSQL');
			}else{
				echo 'Todo ha ido bien!<br />';
	}
	return $cid;
}
?>