
Procesando-........
<?php

include('config.php');
include('lib/db_conn.php');

/********************************************/
$server="(local)";
$database="Empaque";

$user="sa";

$password="123";

//$user="empaque_admin";

//$password="666";

$cid = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $user, $password);
$sql = "SELECT * from Articulos";
/********************************************/


/* crear t_temp con datos actualizados */
$link = Conectarse();
$link_query = "CREATE TABLE articulos_temporal AS (SELECT * FROM articulos_template)";
mysql_query($link_query, $link);
echo mysql_error($link);


//*************************************************//
//** Resguardar los articulos nuevos **************//
$nuevos = "Delete from articulos_new_copy";
mysql_query($nuevos, $link);

//* Pasar los nuevos a la tabla articulos_new_copy //
$nuevos = "Insert INTO articulos_new_copy Select * FROM ARTICULOS where id like 'n%'";
mysql_query($nuevos, $link);
//*************************************************//


$cur = odbc_exec($cid,$sql)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
$Fields = odbc_num_fields($cur);
while( odbc_fetch_row( $cur )){

$instruccion = "insert into articulos_temporal (";
// Campos
    for ($i=1; $i <= $Fields; $i++){
		$instruccion .= odbc_field_name($cur,$i);
		if($i == $Fields){
			$instruccion .= ") values (";
		}else{
			$instruccion .= ", ";	
    	}
	}
// Valores

	for($i=1; $i <= $Fields; $i++){
		$instruccion .= "'" . odbc_result( $cur, $i ) . "'";
		if($i == $Fields){
			$instruccion .= ")";
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
mysql_query("DROP TABLE articulos_backup", $link);
echo mysql_error($link);

/* renombrar t_actual -> t_bckp */
mysql_query("RENAME TABLE articulos  TO articulos_backup", $link);
echo mysql_error($link);

/* renombrar t_temp -> t_actual */
mysql_query("RENAME TABLE articulos_temporal  TO articulos", $link);
echo mysql_error($link);


$nuevos = "Insert INTO articulos Select * FROM articulos_new_copy";
mysql_query($nuevos, $link);

header ("Location: principal.php");
?>