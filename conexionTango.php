<?php

include("ConexionSQL.php");
$var = new conexionSQL();
$cid = $var->conectarse();

$sql = "Select * from GVA14";

//Consulta para conocer los nombre de los campos de una tabla
//$sql = "SELECT COLUMN_NAME AS NombreCampo, * FROM INFORMATION_SCHEMA.COLUMNS
//WHERE TABLE_NAME = 'GVA14' ORDER BY ordinal_position";


	
$cur = odbc_exec($cid,$sql)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
$Fields = odbc_num_rows($cur);
	
if($Fields > 0)
    {
                
        while( $row = odbc_fetch_row( $cur ))
          {
		        echo utf8_encode(odbc_result($cur,'COD_VENDED'));

            echo utf8_encode(odbc_result($cur,'razon_soci'));

            echo utf8_encode(odbc_result($cur,'E_MAIL'));  

            echo '=====>'.utf8_encode(odbc_result($cur,'TELEFONO_1'));

            echo 'xxxxx>'.utf8_encode(odbc_result($cur,'TELEFONO_2'));

            echo '<br>' ;
            //echo utf8_encode(odbc_result($cur,'NombreCampo'))."<br>";
          } 
    }  
    else
    {
      echo "No se encontraron coincidencias";
    }
?>