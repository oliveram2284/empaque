<?php
	include("conexion.php");
		
	$var = new conexion();
	$var->conectarse();
	
	$value = $_POST['xinput'];
	$categ = $_POST['xcateg'];
	
	$sql = "Select id from categoria_usuarios Where codigo = '".$categ."'";
	$resu = mysql_query($sql);
	
	$catId = 0;
	while($row = mysql_fetch_assoc($resu))
	{
	    $catId = $row['id'];
	}
	
	$array = array();
	
        if($value != "")
            $consulta = 	"Select
                                    id_usuario,
                                    nombre,
                                    nombre_real
                                From
                                        usuarios
                                Where
                                    (
										nombre like '%".$value."%' or
										nombre_real like '%".$value."%' 
									) and
									catId = $catId 
                                Order by
                                        nombre asc
                                        Limit 0,10";
            else
            $consulta = 	"Select
                                    id_usuario,
                                    nombre,
                                    nombre_real
                                From
                                        usuarios
								Where 
										catId = $catId 
                                Order by
                                        nombre asc
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