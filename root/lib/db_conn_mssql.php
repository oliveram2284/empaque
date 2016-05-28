<?php
# FileName="db_conn.php"
# Type="MYSQL"
# HTTP="false"

function Conectarse()
	{
		if (!($link=mssql_connect("192.168.0.10\SQLEXPRESS_AXOFT","sa","Axoft2009"))){
			echo "<br /><br /><big><b>Error conectando al SERVIDOR de la base de datos.</b></big>";
			exit();
		}

		$dbname = "1__EMPAQUE_S_A__-_SAN_JUAN";

		if (!mssql_select_db('['.$dbname.']' ,$link)){
			echo "<br /><br /><big><b>Error seleccionando la base de datos.</b></big>";
			exit();
		}
		return $link;
	}

function Conectarse2()
	{
		if (!($link=mssql_connect("192.168.0.91","sa","asd"))){
			echo "<br /><br /><big><b>Error conectando al SERVIDOR de la base de datos.</b></big>";
			exit();
		}

		$dbname = "EMPAQUE";

		if (!mssql_select_db($dbname ,$link)){
			echo "<br /><br /><big><b>Error seleccionando la base de datos.</b></big>";
			exit();
		}
		return $link;
	}
	

	
?>