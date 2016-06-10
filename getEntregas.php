<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['id'];


$sql  = "Select * From tbl_log_entregas Where idPedido = ".$id." order by fecha desc";
$resu = mysql_query($sql) or die(mysql_error());

$array = array();

if(mysql_num_rows($resu) >= 0)
{
    while($row = mysql_fetch_array($resu))
    {
        $array[] = array(
                                "cantidad" 			=> utf8_encode($row['cantidad']),
                                "kg"		                => utf8_encode($row['kg']),
                                "bultos" 			=> utf8_encode($row['bultos']),
                                "fecha" 			=> utf8_encode(invertirFecha($row['fecha'])),
                                "userId" 			=> utf8_encode(getUsuario($row['userId']))
                        );
    }
}

echo json_encode($array);

function invertirFecha($date)
{
    $items = explode(" ", $date);
    
    $fecha = explode("-",$items[0]);
    
    return $fecha[2]."-".$fecha[1]."-".$fecha[0]." ".$items[1];
}

function getUsuario($id)
{
    $sql = "Select nombre_real from usuarios where id_usuario = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
}
?>