<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$value = $_POST['val'];


$sql  = "Select * From motivo_cancelacion_p Where estado = 'H' and  motivo = '".$value."' ";
$resu = mysql_query($sql) or die(mysql_error());

$array = array();

if(mysql_num_rows($resu) >= 0)
{
    while($row = mysql_fetch_array($resu))
    {
        $array[] = array(
                                "id" 			=> utf8_encode($row['id']),
                                "descripcion"		=> utf8_encode($row['descripcion'])
                        );
    }
}

echo json_encode($array);
?>