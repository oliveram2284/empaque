<?php
session_start();

$usuario = $_SESSION['id_usuario'];

include("conexion.php");

$var = new conexion();
$var->conectarse();

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

$sql = "Insert into polimeros (id_proveedor, fecha, id_cliente, id_etiqueta, id_motivo, fecha_recepcion, espesor, nro_remito, pedido_P,";
$sql.= " remito_d, colores, medidas, precio_proveedor, precio_final, id_usuario, estado, observacion, trabajo ) values "; //nro_factura,
$sql.= "($idProveedor, '$fecha', '$idCliente', $idMarca, $motivo, '$fechaTrab', '$espesor', '$remito', '$pedidoProd', '$remitoDoc', '$color', ";
$sql.= "'$medidas', $precProv, $precFin, $usuario, '$estado', '$observacion', '$trabajo') ";//'$nfactura'

$resu = mysql_query($sql) or (die(mysql_error()));

echo'<script>
			alert("Operación realizada con exito.");
			location.href="principal.php";
	 </script>';

?>