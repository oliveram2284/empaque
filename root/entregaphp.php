<?php
session_start();

include("conexion.php");

$var = new conexion();
$var->conectarse();

$tipEntr = $_POST['selecEntrega'];
$respo = $_POST['selecrespexp'];
$destino = $_POST['selecDestino'];
$transporte = $_POST['selectransporte'];
$chofer = isset($_POST['chofer']) ? $_POST['chofer'] : "";
$tel = isset($_POST['telefono']) ? $_POST['telefono'] : "";
$camion = isset($_POST['camion']) ? $_POST['camion'] : "";
$domi = isset($_POST['domicilio']) ? $_POST['domicilio'] : "";
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : "";

$arre = explode('-',$fecha);

$fecha = $arre[2].'-'.$arre[1].'-'.$arre[0]; 

$consulta = "Insert Into entregas (id_destino, id_tipodeentregas, id_usuarioexp, id_transporte, chofer, telefono, camion, domicilio, fecha )";
$consulta .= "Values ($destino, $tipEntr, $respo, $transporte, '$chofer', '$tel', '$camion', '$domi', '$fecha')";

mysql_query($consulta) or (die(mysql_error()));

//insertar el detalle 
//obtenemos los datos de la tabla entregatemporal
$identrega = mysql_insert_id(); 

$cons = "Select * from entregatemporal order by idPedido";
$resu = mysql_query($cons) or die(mysql_error());

$pedido = 0;

while($row = mysql_fetch_array($resu))
	{
		$tipoentrega = $row['idTipoEmpaque'];
		$numero = $row['numero'];
		$unidades = $row['unidades'];
		$bultos = $row['bultos'];
		$kg = $row['kg'];
		$remito = $row['remito'];
		$factura = $row['factura'];
		$aprox = $row['aprox'];
		$neto = $row['neto'];
		$estampa = $row['estampa'];
		$medida = $row['medidas'];
		$idPedido = $row['idPedido'];
		
		$sql = "Select estado from pedidos Where npedido = $idPedido";
		$re  = mysql_query($sql)or die(mysql_error());
		$valor = mysql_fetch_array($re);
		$estado = $valor[0];
		
		if($pedido != $idPedido)
		{
			$cantidad = "SELECT d.cantidad1
						 FROM pedidos p
						 INNER JOIN pedidosdetalle d ON p.npedido = d.idPedido
						 WHERE p.npedido = $idPedido";
						 
			$can = mysql_query($cantidad) or die (mysql_error());
			$can = mysql_fetch_array($can);
			$can = $can[0];
			
			//ver la cantidad actual 
			
			//cantidad ya entragada 
			$deta = "SELECT SUM( unidades )
					 FROM entregasdetalle
					 WHERE idPedido = $idPedido";
			$deta = mysql_query($deta) or die (mysql_error());
			$deta = mysql_fetch_array($deta);
			$deta = ($deta[0] == NULL) ? 0 : $deta[0];
			
			//cantidad por entrar
			$detaTemp = "SELECT SUM( unidades )
						 FROM entregatemporal
						 WHERE idPedido = $idPedido";
			$detaTemp = mysql_query($detaTemp) or die (mysql_error());
			$detaTemp = mysql_fetch_array($detaTemp);
			$detaTemp = ($detaTemp[0] == NULL) ? 0 : $detaTemp[0];	
			
			$cargado = $deta + $detaTemp;
			
			switch($estado)
				{
					case "T":
						//ver si para a ET o EP
						//obtener la cantidad pedida
							if($cargado >= $can)
								{
									//terminado total 
									$update = "Update pedidos SET estado = 'ET' Where npedido = $idPedido";
									mysql_query($update) or die (mysql_error());
										
								}else
								{
									//terminado parcial 
									$update = "Update pedidos SET estado = 'EP' Where npedido = $idPedido";
									mysql_query($update) or die (mysql_error());	
								}
						break;
					case "EP":
						//ver si pasa a ET o sigue en EP
						if($cargado >= $can)
								{
									//terminado total 
									$update = "Update pedidos SET estado = 'ET' Where npedido = $idPedido";
									mysql_query($update) or die (mysql_error());
										
								}
						break;
				}
				$pedido = $idPedido;
		}
		else
		{
			$pedido = $idPedido;
		}
		
		$consu = "Insert into entregasdetalle(identrega, tipoentrega, numero, unidades, bultos, kg, remito, factura, aprox, neto, estampa, medida, idPedido) Values";
		$consu .= "($identrega, $tipoentrega, $numero, $unidades, $bultos, '$kg', $remito, $factura, '$aprox', '$neto', '$estampa', '$medida', $idPedido)";
		
		mysql_query($consu) or die(mysql_error());
		
		//restar los montos de los pedidos.-
		$consSql = "Update pedidos SET cantidad_entregadas = ( cantidad_entregadas - $unidades), ";
		$consSql.= "kg_entregados = (kg_entregados - $kg), bultos_entregados = ( bultos_entregados - $bultos) Where npedido = $idPedido";
		mysql_query($consSql) or die (mysql_error());
	}

$delete = "Delete from entregatemporal";
mysql_query($delete) or die (mysql_error());

echo'<script>
			alert("Entrega de Productos registrado con exito.");
			window.open("impresionComprobantes.php?documento=3&id='.$identrega.'", "PopUp", "width=920,height=700");
			location.href="principal.php";
	 </script>';

?>