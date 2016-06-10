<?php
session_start();

$idUsuario = $_SESSION['id_usuario'];

$idDep = $_GET['idDepo'];

$solicitante = $_GET['soli'];

$date = $_GET['fecha'];

include("conexion.php");
$var = new conexion();
$var->conectarse();

$consulta = "Select idProducto, descProducto, Cantidad, SUM(stockLote) as Stock, id From egresopendiente
			 INNER JOIN productosdepositos ON egresopendiente.idProducto = productosdepositos.id_articulo
			 WHERE productosdepositos.id_deposito=$idDep and egresopendiente.idUsuario ='".$idUsuario."'
			 GROUP BY idProducto";
			 
$resu = mysql_query($consulta) or die(mysql_error());

$noEntrar = true;
if(mysql_num_rows($resu) > 0)
	{
		while($row = mysql_fetch_array($resu))
		{
			if($row['Cantidad'] > $row['Stock'])
				{
					//el estock no es suficiente
					echo '<script>alert("La cantidad ingresada supera el stock actual.");</script>';
					echo '<script>location.href="EgresoStock.php?idDep='.$idDep.'"</script>';
					$noEntrar = false;
					break;
				}
		}
	}else
	{
		$noEntrar = false;
	}


if($noEntrar == true)
	{
	//encabezado orden de salida	
	$fecha = date("d-m-Y H:i:s");
	$con = "Insert Into ordensalida (fecha,idUsuario,idDeposito) Values ('".$date."',$solicitante,$idDep)";
	$res = mysql_query($con) or die(mysql_error());
	//--------------------------
	$ultimo_id = mysql_insert_id(); 
		
	$consulta2 = "Select idProducto, descProducto, Cantidad, SUM(stockLote) as Stock, id From egresopendiente
				 INNER JOIN productosdepositos ON egresopendiente.idProducto = productosdepositos.id_articulo
				 WHERE productosdepositos.id_deposito=$idDep and egresopendiente.idUsuario ='".$idUsuario."'
				 GROUP BY idProducto";
				  
	$resu2 = mysql_query($consulta2) or die(mysql_error());
	
	while($row2 = mysql_fetch_array($resu2))
		{
			$Cant = $row2['Cantidad'];
			
			$Cantidad = $Cant;
			
			$producto = $row2['descProducto'];
			
			while($Cant > 0 )
				{
					$consulta3 = "SELECT * FROM productosdepositos Where stockLote > 0 and id_deposito=$idDep
								 ORDER BY fechaIngresolote ASC
								 LIMIT 0 , 1";
								 
					$resu3 = mysql_query($consulta3) or die (mysql_error());
					
					$depos = mysql_fetch_array($resu3);
					
					if($Cant >= $depos['stockLote'])
						{
							$stock = 0;
							$Cant -= $depos['stockLote'];
							
						}else
							{
								$stock = $depos['stockLote'] - $Cant;
								$Cant = 0;
								$delete = "Delete From egresopendiente Where id = ".$row2['id'];
								$r = mysql_query($delete) or die(mysql_error());
							}
					
					$id = $depos['id_prodep'];
					$idArt = $depos['id_articulo'];
					
					$consulta4 = "Update productosdepositos set stockLote=".$stock." Where id_prodep=".$id."";
					$resu = mysql_query($consulta4) or die (mysql_error());
					
					$det = "Insert Into ordensalidadetalle(idorden,idProducto,desProducto,cantidad) Values ";
					$det.= "($ultimo_id,$idArt,'$producto',$Cantidad)";
					$res = mysql_query($det) or die(mysql_error());
				}
			
		}
	 
	 //imprimir 
	 echo'<script>
			alert("Egreso de Productos registrado con exito.");
			window.open("impresionComprobantes.php?documento=2&id='.$ultimo_id.'", "PopUp", "width=920,height=700");
			location.href="principal.php";
	 </script>';
	
	}

?>