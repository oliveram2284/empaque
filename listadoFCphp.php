<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['xid'];
if(isset($_POST['xinput']))
{
    $valores = $_POST['xinput'];
    $pasar = true;
}
else
{
    $pasar = false;
}


//eliminar campos para el formato seleccionado
$sql = "Delete from tbl_formato_campos Where fId = ".$id;
$resu = mysql_query($sql);

if($pasar != false)
{
    foreach($valores as $v)
    {
        $sql = "Insert Into tbl_formato_campos (fId, cmpId) Values (".$id.",'".$v."')";
        $resu = mysql_query($sql);
    }
}

echo json_encode(0);
?>