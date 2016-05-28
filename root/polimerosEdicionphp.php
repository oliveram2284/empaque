<?php
session_start();

$usuario = $_SESSION['id_usuario'];

include("conexion.php");

$var = new conexion();
$var->conectarse();

$operacion = $_POST['Op'];
$idPolimero = $_POST['idPolimero'];

$idProveedor = $_POST['idProveedor'];
$fecha = $_POST['fecha'];
$fecha = explode('-',$fecha);
$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
$idMarca = $_POST['idMarca'];
$idCliente = $_POST['idCliente'];
$trabajo = $_POST['trabajo'];
$motivo = $_POST['idMotivo'];
$remitoDoc = isset($_POST['remitoDocumento']) ? $_POST['remitoDocumento'] : 0;
$pedidoProd = isset($_POST['pedidoProduccion']) ? $_POST['pedidoProduccion'] : 0;
$fechaTrab = $_POST['fechaTrab'];
$fechaTrab = explode('-',$fechaTrab);
$fechaTrab = $fechaTrab[2].'-'.$fechaTrab[1].'-'.$fechaTrab[0];
$espesor = $_POST['espesor'];
$color = $_POST['color'];
$medidas = $_POST['medidas'];
$remito = $_POST['remito'];
$precProv = $_POST['precioProv'];
$precFin = $_POST['precioFin'];
$estado = $_POST['estado'];
//$nfactura = ($estado == 1) ? $_POST['factura'] : 0;
$observacion = $_POST['observaciones'];

if($operacion == 'E')
    {
        $sql = "Update polimeros 
                Set 
                id_proveedor = $idProveedor,
                fecha = '$fecha',
                id_cliente = '$idCliente',
                id_etiqueta = $idMarca,
                id_motivo = $motivo,
                fecha_recepcion = '$fechaTrab',
                espesor = '$espesor',
                nro_remito = '$remito',
                pedido_P = '$pedidoProd',
                remito_d = '$remitoDoc',
                colores = '$color',
                medidas = '$medidas',
                precio_proveedor = $precProv,
                precio_final = $precFin,
                id_usuario = $usuario,
                estado = '$estado',
                observacion = '$observacion',
                trabajo = '$trabajo'
                Where id_Polimero = ".$idPolimero."";    
    }
    else
    {
        echo "entro";
        $sql = "Update polimeros Set estado = 5 Where id_Polimero = ".$idPolimero."";
    }
    
$resu = mysql_query($sql) or (die(mysql_error()));

echo'<script>
			alert("Operación realizada con exito.");
			location.href="principal.php";
	 </script>';

?>