<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$id = $_POST['id'];

$sql = "Select e.* from protocolos as p 
		Join tbl_log_entregas_protocolos as e on p.idPedido = e.idPedido
		Where p.prtId = ".$id;

$resu = mysql_query($sql);

$entregas = array();

while($row = mysql_fetch_array($resu)){
    $entregas[] = $row;
}

//var_dump($entregas);
echo json_encode($entregas);
?>