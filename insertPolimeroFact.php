<?php
session_start();
include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$IdPolimero = $_POST['xId'];
$Factura  = $_POST['xFa'];
$Cotizacion = $_POST['xDo'];
$Observacion = $_POST['xOb'];
$Items = $_POST['xAr'];


//Agregar datos de Facturacion
foreach ($Items as $item)
    {
        $_insert = "Insert into polimerosfacturacion (idPolimero, cantidad, cm2, importe, importeFinal, importeNC, seRestaNC, idCalidad) Values ";
        $_insert.= "(".$IdPolimero.", ".$item['cant'].", ".$item['cm2'].", ".$item['importe'].", ".$item['final'].", ".$item['nc'].", ".$item['resta'].", ".$item['id'].")";
        $resu = mysql_query($_insert);
    }

//CAmbiar el estado del polimero
$update = "Update polimeros set EnFacturacion = 'A', FacturaN = '".$Factura."', CotDolar = '".$Cotizacion."', observacionFactura = '".$Observacion."' Where id_Polimero = ".$IdPolimero;
$resu = mysql_query($update);

////Agregar log de pedido
$_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
$_insert.= "(".$IdPolimero.", 'Q', ".$_SESSION['id_usuario'].", 'Carga de datos de Facturación', CURRENT_TIMESTAMP( ))";
$resu = mysql_query($_insert);

//retornar json = nada
echo json_encode(1);

?>