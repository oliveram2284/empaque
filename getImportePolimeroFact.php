<?php
include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$idPolimero = $_POST['xId'];

$sql = "Select * from polimerosfacturacion where idPolimero = ".$idPolimero;
$resu = mysql_query($sql);

$importe = 0;
while($row = mysql_fetch_array($resu))
{
    $importe += $row['importe'];
    
    //if($row['seRestaNC'] == 1)
    //{
    //    $importe -= $row['importeNC'];
    //}
}

echo json_encode($importe * 1.1);

?>