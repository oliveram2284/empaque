<?php

include('config.php');
include('lib/db_conn.php');

/********************************************/
$server = "(local)";
$database = "empaque";
$user = "sa";
$password = "123";

$cid = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $user, $password);

/*$cid = odbc_connect("Driver={SQLServer};Server=192.168.0.10\SQLEXPRESS_AXOFT', 'Axoft''Axoft');*/
$sql = "SELECT cod_client, observacio, cuit, domicilio, localidad, cod_provin, nom_com, razon_soci, telefono_1, e_mail from gva14";
/********************************************/

/* crear t_temp con datos actualizados */
$link = Conectarse();
$link_query = "CREATE TABLE clientes_temporal AS (SELECT * FROM clientes_template)";
mysql_query($link_query, $link);
echo mysql_error($link);



$cur = odbc_exec($cid,$sql)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
$Fields = odbc_num_fields($cur);
while( odbc_fetch_row( $cur )){

$instruccion = "insert into clientes_temporal (";
// Campos
    for ($i=1; $i <= $Fields; $i++){
		$instruccion .= odbc_field_name($cur,$i);
		if($i == $Fields){
			$instruccion .= ", close) values (";
		}else{
			$instruccion .= ", ";	
    	}
	}
// Valores

	for($i=1; $i <= $Fields; $i++){
		$instruccion .= "'" . odbc_result( $cur, $i ) . "'";
		if($i == $Fields){
			$instruccion .= ", '0')";
		}else{
			$instruccion .= ", ";
		}
	}
	//echo $instruccion, "<br />";
	mysql_query($instruccion, $link);
	echo mysql_error($link);
}


odbc_close($cid); 

/* borrar t_bckp_anterior */
mysql_query("DROP TABLE clientes_backup", $link);
echo mysql_error($link);

/* renombrar t_actual -> t_bckp */
mysql_query("RENAME TABLE clientes TO clientes_backup", $link);
echo mysql_error($link);

/* renombrar t_temp -> t_actual */
mysql_query("RENAME TABLE clientes_temporal TO clientes", $link);
echo mysql_error($link);
?>
<br /><br /><br />PROCESO FINALIZADO