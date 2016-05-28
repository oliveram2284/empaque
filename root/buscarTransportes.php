<?php
	include("conexion.php");
		
	$var = new conexion();
	$var->conectarse();
	
	$value = $_POST['xinput'];
	
	$array = array();
	
        if($value != "")
            $consulta = 	"Select
                                    id_transporte,
                                    razon_social,
                                    direccion
                                From
                                        transportes
                                Where
                                    razon_social like '%".$value."%' or
                                    direccion like '%".$value."%' 
                                Order by
                                        razon_social asc
                                        Limit 0,10";
            else
            $consulta = 	"Select
                                    id_transporte,
                                    razon_social,
                                    direccion
                                From
                                        transportes
                                Order by
                                        razon_social asc
                                        Limit 0,10";
            
	
	$resu = mysql_query($consulta);

	while($row = mysql_fetch_assoc($resu))
	{
	    array_push($array, $row);
	}
	
	echo json_encode($array);
	
	
	
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