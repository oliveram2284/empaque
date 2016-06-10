<?php
include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$idP     = $_POST['id'];

$proveedor = array();
$proveedor['calidades'] = array();
$proveedor['name'] = "Proveedor no encontrado.";
$proveedor['domi'] = "-";
$proveedor['tele'] = "-";
$calidades_id = "";
$idProveedor = 0;

$sql = "Select calidad, id_proveedor from polimeros Where id_polimero = ".$idP;
$resu = mysql_query($sql);

while($row = mysql_fetch_assoc($resu))
    {
        $calidades_id = $row['calidad'];
        $idProveedor = $row['id_proveedor'];
    }

if($calidades_id != "" && $idProveedor != 0)
{
    $id_calidades = explode('/', $calidades_id);
    
    foreach($id_calidades as $ca)
    {
        if($ca != "")
        {
            $sql = "Select descTipoPoli from tipo_polimero Where idTipoPoli = ".$ca;
            $resu = mysql_query($sql);

            while($row = mysql_fetch_assoc($resu))
                {
                    $new = array(
                            'id'       => $ca,
                            'name'     => $row['descTipoPoli'],
                            'cot'      => GetCotizacion($ca, $idProveedor)
                    );
                    $proveedor['calidades'][] = $new;
                }
        }
    }
}

if($idProveedor != 0)
{
    $sql = "Select razon_social, direccion, telefono from proveedores Where id_proveedor = ".$idProveedor;
    $resu = mysql_query($sql);
    
    while($row = mysql_fetch_assoc($resu))
        {
            $proveedor['name'] = $row['razon_social'];
            $proveedor['domi'] = $row['direccion'];
            $proveedor['tele'] = $row['telefono'];
        }    
}

echo json_encode($proveedor);

function GetCotizacion($idTipo, $idProvedor)
{
    $sql = "Select precio from tbl_proveedores_tipo where idProveedor = ".$idProvedor." and idTipo = ".$idTipo;
    $resu = mysql_query($sql);

    while($row = mysql_fetch_assoc($resu))
        {
            return $row['precio'];
        }
}
?>