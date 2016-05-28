<?php

include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$idPolimero = $_POST['Id'];

$Polimero = array();

$sql = "select FacturaN,CotDolar,observacionFactura, id_proveedor from polimeros where id_polimero = ".$idPolimero;
$resu = mysql_query($sql);
while($row = mysql_fetch_assoc($resu))
    {
        $Polimero['factura'] = $row['FacturaN'];
        $Polimero['dolar'] = $row['CotDolar'];
        $Polimero['observ'] = $row['observacionFactura'];
        
        $sqlP = "Select razon_social, direccion, telefono from proveedores Where id_proveedor = ".$row['id_proveedor'];
        $resuP = mysql_query($sqlP);
        while($rowP = mysql_fetch_assoc($resuP))
            {
                $Polimero['name'] = $rowP['razon_social'];
                $Polimero['domi'] = $rowP['direccion'];
                $Polimero['tele'] = $rowP['telefono'];
            } 
        
        $detalle = "select * from polimerosfacturacion where idPolimero = ".$idPolimero;
        $resuD = mysql_query($detalle);
        while($rowD = mysql_fetch_assoc($resuD))
        {
            $obj = array();
            $obj['cantidad'] = $rowD['cantidad'];
            $obj['cm2'] = $rowD['cm2'];
            $obj['importe'] = $rowD['importe'];
            $obj['importeFinal'] = $rowD['importeFinal'];
            $obj['importeNC'] = $rowD['importeNC'];
            $obj['seRestaNC'] = $rowD['seRestaNC'];
            $obj['name'] = getName($rowD['idCalidad']);
            $obj['cotizacion'] = GetCotizacion($rowD['idCalidad'], $row['id_proveedor']);
            $Polimero['detalle'][] = $obj;    
        }
    }

echo json_encode($Polimero);


function getName($id)
{
    $sql = "Select descTipoPoli from tipo_polimero Where idTipoPoli = ".$id;
    $resu = mysql_query($sql);

    while($row = mysql_fetch_assoc($resu))
        {
            return $row['descTipoPoli'];
        }
        
    return "--";
}

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