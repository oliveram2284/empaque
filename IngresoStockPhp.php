<?php
session_start();

/*
<!--

Documento: alta de stock, IngresoStockPhp.php
Creado por: Sergio J. Moyano
Dia: 10/01/2010
Observaciones:
Modificaciones:
dia            usuario
25/01/2010     SJM
19/04/2010     SJM

-->
*/
$idUsuario = $_SESSION['id_usuario'];
$idDep = $_POST['nombreDeposito'];
$fecha = $_POST['fechaIng'];

include("conexion.php");

$var = new conexion();
$var->conectarse();

$consulta = "Select * from ingresopendiente Where idUsuario = $idUsuario && idDeposito=$idDep ";
$resu = mysql_query($consulta);

while($row = mysql_fetch_array($resu))
	{
		$idProd = $row['idProducto'];
		
		$consulta = "Select Count(*) From productosdepositos Where id_articulo = '".$idProd."' and id_deposito = '".$idDep."'";
		$res = mysql_query($consulta);

		$fila = mysql_fetch_array($res);
		$contador = $fila[0];
		
		//$fecha = date("Y-m-d");
		$cantidad = $row['cantidad'];
		$idDeposito = $idDep;
		$bultos = $row['bultos'];
		$kg = $row['kg'];
		
        if($contador == 0)
            {
                //insertar nuevo registro
                $consulta = "insert into productosdepositos(id_articulo,id_deposito,lote,stockLote,fechaIngresoLote,bultos,kg) values";
                $consulta.= "('$idProd','$idDeposito',$contador,$cantidad,'$fecha',$bultos,$kg)";
            }else
            {
                //modificar existente
                $consulta = "update productosdepositos set stockLote = ($cantidad + stockLote), bultos = ($bultos + bultos), kg = ($kg + kg) ";
                $consulta.= "where id_articulo = '".$idProd."' and id_deposito = '".$idDeposito."'";
            }
        
		mysql_query($consulta);
	}

//------Guardar datos para el remito-----

$fecha = date("d-m-Y H:i:s");
$numero = 0;//$_POST['numeroRemito'];
$con = "Insert Into remito (fecha,idUsuario,comprobante,idDeposito) Values ('".$fecha."',$idUsuario,'".$numero."',$idDep)";
$res = mysql_query($con) or die(mysql_error());

$ultimo_id = mysql_insert_id(); 
$consulta = "Select * from ingresopendiente Where idUsuario = $idUsuario";
$resu = mysql_query($consulta);

while($row = mysql_fetch_array($resu))
	{
		$idProducto = (int)$row['idProducto'];
		$idDeposito = $idDep;
		$cantidad = (int)$row['cantidad'];
		$bultos = (int)$row['bultos'];
		$kg = (int)$row['kg'];
				
		$consulta = "Insert Into detalle_remito(idRemito, idProducto, idDeposito, Cantidad, bultos, kg ) Values ($ultimo_id, $idProducto, $idDeposito, $cantidad, $bultos, $kg)";
		$resul = mysql_query($consulta) or die(mysql_error());	
	}
//---------------------------------------

$consulta = "delete from ingresopendiente Where idUsuario = $idUsuario && idDeposito = $idDep";
$resu = mysql_query($consulta);

echo'<script>
			alert("Ingreso de Productos registrado con exito.");
			window.open("impresionComprobantes.php?documento=1&id='.$ultimo_id.'", "PopUp", "width=920,height=700");
			location.href="principal.php";
	 </script>';
?>