<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$value = $_POST['idP'];


$sql  = "Select * From pedidos Where npedido = ".$value;
$resu = mysql_query($sql) or die(mysql_error());

$array = array();

if(mysql_num_rows($resu) >= 0)
{
    while($row = mysql_fetch_array($resu))
    {
        $array[] = array(
                                "clienteTango" 			=> utf8_encode($row['clientefact']),
                                "clienteNombre" 		=> utf8_encode($row['clienteNombre']),
                                "productoCodigo"                => utf8_encode($row['descrip3']),
                                "productoCodigoT"               => utf8_encode($row['codigoTango']),
                                "cantidad"                      => utf8_encode(getCantidad($value)),
                                "medida"                        => utf8_encode(getMedida($value)),
                                "precio"                        => utf8_encode(armarPrecio($value)),
                                "cantidadEntregada"             => utf8_encode($row['cantidad_entregadas']),
                                "kgEntregados"                  => utf8_encode($row['kg_entregados']),
                                "bultosEntregados"              => utf8_encode($row['bultos_entregados']),
                                "iptObserv"                     => utf8_encode(getobservacion($value)),
                                "cotizacionMM"                  => utf8_encode(getCotizacion($value)),
                                "importe"                       => utf8_encode($row['ImporteFactPolimero']),
                                "yaSeFacturo"                   => utf8_encode($row['seFacturoPolimero']),
                                "ObservaPolimero"               => utf8_encode(getObservaPolimero($value)),
                                "descripcion"                   => $row['descripcion']
                        );
    }
}

echo json_encode($array);

function getCantidad($id)
{
    $sql = "Select cantidadTotal from pedidosdetalle where idpedido = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
}

function getMedida($id)
{
    $sql = "Select Unidad from pedidosdetalle where idpedido = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            $sql2 = "Select descripcion from unidades where idUnidad = ".$row[0];
            $resu2 = mysql_query($sql2) or die(mysql_error());
    
            if(mysql_num_rows($resu2) >= 0)
            {
                while($row2 = mysql_fetch_array($resu2))
                {
                    return $row2[0];
                }
            }
        }
    }
}

function armarPrecio($id)
{
    $sql = "Select moneda, PrecioImporte, IVA from pedidosdetalle where idpedido = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            $moneda = getMoneda($row[0]);
            $iva    = getIva($row[2]);
    
            return $moneda." ".$row[1]." ".$iva;
        }
    }
}

function getMoneda($id)
{
    $sql = "Select descripcion from monedas where idMoneda = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
}

function getIva($id)
{
    $sql = "Select descripcion from condicioniva where idIVA = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
}

function getobservacion($id)
{
    $sql = "Select Obseervaciones from pedidosdetalle where idpedido = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
}

function getCotizacion($id)
{
    $sql = "Select Moneda from pedidosdetalle where idpedido = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    $moneda = 0;
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            $moneda = $row[0];
        }
    }
    
    if($moneda == 0)
    {
        return 1;
    }
    else
    {
        $sql = "SELECT cotizacion FROM monedas WHERE idMoneda = ".$moneda;
        $resu = mysql_query($sql) or die(mysql_error());
    
        $cot = 1;
        if(mysql_num_rows($resu) >= 0)
        {
            while($row = mysql_fetch_array($resu))
            {
                $cot = $row[0];
            }
        }
        
        return $cot;
    }
}

function getObservaPolimero($id)
{
    $sql = "Select observacion from polimeros where idPedido = ".$id;
    $resu = mysql_query($sql) or die(mysql_error());
    
    if(mysql_num_rows($resu) >= 0)
    {
        while($row = mysql_fetch_array($resu))
        {
            return $row[0];
        }
    }
    else
    {
        return "";
    }
}

?>