<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['id'];

var
$sql  = "Select esCI From pedidos Where npedido = ".$id;
$resu = mysql_query($sql) or die(mysql_error());

$array = array();

if(mysql_num_rows($resu) >= 0)
{
    while($row = mysql_fetch_array($resu))
    {
        $items = "";
        
        if($row[0] != null)
        {
            $items = explode("-", $row[0]);
            
            foreach ($items as $valor) {
                    $array[] = array("value" => utf8_encode($valor));
                }
        }
        else
        {
            $sql2 = "Select HojaDeRuta from pedidoshojasderuta where idPedido = ".$id;
            $resu2 = mysql_query($sql2) or die(mysql_error());
            
            if(mysql_num_rows($resu2) >= 0)
            {
                while($row2 = mysql_fetch_array($resu2))
                {
                    $array[] = array("value" => utf8_encode($row2[0]));
                }
            }
        }
        
        
    }
}

echo json_encode($array);
?>