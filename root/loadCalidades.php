<?php

include("conexion.php");
		
$var = new conexion();
$var->conectarse();
$array = array();

$value = $_POST['xinput'];

$sql = "SELECT tp.idTipo, tp.Precio, t.descTipoPoli
        FROM tbl_proveedores_tipo AS tp
        JOIN tipo_polimero AS t ON tp.idTipo = t.idTipoPoli
        WHERE tp.idProveedor =".$value;

$resu = mysql_query($sql);

while($row = mysql_fetch_assoc($resu))
	{
	    array_push($array, $row);
	}
	
echo json_encode($array);
?>