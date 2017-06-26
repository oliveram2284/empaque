<?php
include("ConexionSQL.php");
$var = new conexionSQL();
$cid = $var->conectarse();


	$value = $_POST['xinput'];
	$page = 1 ; //$_POST['xpage'];
	$min = 10 * ($page - 1);
	$max = 10 * $page;

	//$value = $value[0];

	$array = array();

	$consulta = 	"Select  * from
				(
				Select
				ROW_NUMBER() OVER(ORDER BY razon_soci) AS rownum,
				*
				From
					GVA14
				Where
					(
					razon_soci like '%".$value."%' or
					cod_client like '%".$value."%' or
					nom_com like '%".$value."%'
					)
					and
					(
					razon_soci not like '%*%' and
					cod_client not like '%*%' and
					nom_com not like '%*%'
					)
					and
					(
					razon_soci not like '%(%' and
					cod_client not like '%(%' and
					nom_com not like '%(%'
					)
				) as resultado
				Where
					rownum > ".$min." and rownum <= ".$max."
				Order by
					razon_soci
				";

$cur = odbc_exec($cid,$consulta)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
$Fields = odbc_num_rows($cur);

if($Fields > 0)
    {

        while( $row = odbc_fetch_row( $cur ))
		{
			$array[] = array(
						"cod_client" => utf8_encode(odbc_result($cur,'cod_client')),
						"razon_soci" => utf8_encode(odbc_result($cur,'razon_soci')),
						"domicilio"  => utf8_encode(odbc_result($cur,'domicilio')),
						"telefono_1" => utf8_encode(odbc_result($cur,'telefono_1')),
						"cuit"       => utf8_encode(odbc_result($cur,'cuit')),
						"e_mail"     => utf8_encode(odbc_result($cur,'e_mail')),
						"id_gv14"    => utf8_encode(odbc_result($cur,'id_gva14')),
						"telefono_2" => utf8_encode(odbc_result($cur,'telefono_2'))
					);

		}
	echo json_encode($array);

    }
    else
    {
	echo json_encode(0);
    }
/*
$pagina = 10;
		echo '<dir><input type="button" value="<<" onClick="ajaxx(buscador.value,\'div_find\',\'buscarClienteAjax.php\', 0,10, 0)">&nbsp;';

		for($i=1; $i<= 10; $i++)
			{
			 echo'<input type="button" value="'.$i.'" onClick="ajaxx(buscador.value,\'div_find\',\'buscarClienteAjax.php\', '.$i * $pagina .','.$pagina.', 0)">&nbsp;';
			}

		echo'<input type="button" value=">>" onClick="ajaxx(buscador.value,\'div_find\',\'buscarClienteAjax.php\', '.$pagina.','.$pagina.', 0)">&nbsp;';

		echo '</dir>';
*/
?>
