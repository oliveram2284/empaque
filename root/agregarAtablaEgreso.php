<?php
session_start();

$idUsuario = $_SESSION['id_usuario'];
$nombre = $_SESSION['NombreReal']; 

include("conexion.php");

$var = new conexion();
$var->conectarse();

$dato=$_POST['variable'];

$arre = explode('~',$dato);

$idProd = $arre[0];
$idDepo = $arre[1];
$cantid = $arre[2];
$bultos = $arre[3];
$kg = $arre[4];

$consulta = "Select Count(*) from egresopendiente Where idProducto = $idProd && idDeposito = $idDepo && idUsuario = $idUsuario";
$resu = mysql_query($consulta);

$row = mysql_fetch_array($resu);

if($row[0] == 0)
{
//producto-----
$cons = "select * from articulosdeposito Where idProducto = $idProd";
$resu = mysql_query($cons) or die(mysql_error());

$row = mysql_fetch_array($resu);
//-------------

$hoy = date("d-m-Y");

$consulta = "Insert Into egresopendiente(idProducto, descProducto, Cantidad, idDeposito, idUsuario, bultos, kg) Values ";
$consulta.= "($idProd,'".$row['descProducto']."',$cantid,$idDepo,$idUsuario,$bultos,$kg)";

$resu = mysql_query($consulta) or die(mysql_error());

}else
	{
	 	$consulta = "Select id,cantidad,bultos,kg from egresopendiente Where idProducto = $idProd && idDeposito = $idDepo && idUsuario = $idUsuario";
		$resu = mysql_query($consulta);
		
		$row = mysql_fetch_array($resu);
		
		$id = $row['id'];
		$cantidad = $row['cantidad'] + $cantid;
		$bultos = $row['bultos'] + $bultos;
		$kg = $row['kg'] + $kg;
		
		$consulta = "Update egresopendiente Set cantidad = $cantidad, bultos = $bultos, kg = $kg Where id = $id";
		$resu = mysql_query($consulta);
		
	}
				$consulta = "Select idProducto, descProducto, Cantidad, SUM(stockLote), SUM(productosdepositos.bultos), SUM(productosdepositos.kg), id From egresopendiente
							 INNER JOIN productosdepositos ON egresopendiente.idProducto = productosdepositos.id_articulo
							 WHERE productosdepositos.id_deposito=$idDepo and egresopendiente.idUsuario ='".$idUsuario."'
							 GROUP BY idProducto";
							 
				$resu = mysql_query($consulta)or die(mysql_error());

				//echo mysql_num_rows($resu);
				
				if(mysql_num_rows($resu) > 0)
				{
					echo '<input type="button" value="Confirmar" onClick="Confirmar('.$idDepo.')" class="button">';
					
						echo "<table>";
						echo "<tr><td>Descripción</td>";
						echo "<td>Stock Cantidad</td><td>Stock Bultos</td><td>Stock Kgs.</td>";
						echo "<td>Cantidad A Extraer</td><td>Borrar</td></tr>";
						
						while($row = mysql_fetch_array($resu))
						{
							echo "<tr>";
							echo "<td>".$row['descProducto']."</td>";
							echo "<td>".$row[3]."</td>";
							echo "<td>".$row[4]."</td>";
							echo "<td>".$row[5]."</td>";
							echo "<td>".$row['Cantidad']."</td>";
							echo '<td><img src="assest/plugins/buttons/icons/delete.png" onClick="eliminar2('.$row['id'].','.$idDepo.',\'resultado\',\'quitarAtablaEg.php\')"></td>';
							echo "</tr>";
						}
						
						echo "</table>";
				}
				else
				{
					echo '<table><tr><td colspan="6" align="center">No hay productos pendientes.</td></tr></table>';	
				}
?>