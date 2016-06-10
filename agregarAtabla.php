<?php
session_start();
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
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

$consulta = "Select Count(*) from ingresopendiente Where idProducto = $idProd && idDeposito = $idDepo && idUsuario = $idUsuario";
$resu = mysql_query($consulta);

$row = mysql_fetch_array($resu);

if($row[0] == 0)
{
//producto-----
$cons = "select * from articulosdeposito Where idProducto = $idProd";
$resu = mysql_query($cons) or die(mysql_error());

$row = mysql_fetch_array($resu);
//-------------
//deposito-----
$cons = "select * from depositos Where id_deposito = $idDepo";
$resu = mysql_query($cons) or die(mysql_error());
$row2 = mysql_fetch_array($resu);
//-------------

$hoy = date("d-m-Y");

$consulta = "Insert Into ingresopendiente(idProducto, codProducto, desProducto, cantidad, fecha, deposito, idDeposito, usuario, idUsuario, bultos, kg) Values ";
$consulta.= "($idProd,'".$row['codProducto']."','".$row['descProducto']."',$cantid,'".$hoy."','".$row2['nombre']."' ,$idDepo,'".$nombre."' ,$idUsuario , $bultos, $kg)";

$resu = mysql_query($consulta);

}else
	{
	 	$consulta = "Select id, cantidad, bultos, kg from ingresopendiente Where idProducto = $idProd && idDeposito = $idDepo && idUsuario = $idUsuario";
		$resu = mysql_query($consulta);
		
		$row = mysql_fetch_array($resu);
		
		$id = $row['id'];
		$cantidad = $row['cantidad'] + $cantid;
		$bultos = $row['bultos'] + $bultos;
		$kg = $row['kg'] + $kg;
		
		$consulta = "Update ingresopendiente Set cantidad = $cantidad, bultos = $bultos, kg = $kg Where id = $id";
		$resu = mysql_query($consulta);
		
	}
				$consulta = "Select * From ingresopendiente Where idUsuario ='".$idUsuario."' && idDeposito = $idDepo";
				$resu = mysql_query($consulta)or die(mysql_error());

				//echo mysql_num_rows($resu);
				
				if(mysql_num_rows($resu) > 0)
				{
					echo '<input type="button" value="Confirmar" onClick="Confirmar()" class="button">';
					
						echo "<table>";
						echo "<tr><td>Codigo</td><td>Descripción</td>";
						echo "<td>Cantidad</td><td>Bultos</td>";
						echo "<td>Kilogramos</td><td>Borrar</td></tr>";
						
						while($row = mysql_fetch_array($resu))
						{
							echo "<tr>";
							echo "<td>".$row['codProducto']."</td>";
							echo "<td>".$row['desProducto']."</td>";
							echo "<td>".$row['cantidad']."</td>";
							echo "<td>".$row['bultos']."</td>";
							echo "<td>".$row['kg']."</td>";
							echo '<td><img src="assest/plugins/buttons/icons/delete.png" onClick="eliminar('.$row['id'].',\'resultado\',\'quitarAtabla.php\')"></td>';
							echo "</tr>";
						}
						
						echo "</table>";
				}
				else
				{
					echo '<table><tr><td colspan="6" align="center">No hay productos pendientes.</td></tr></table>';	
				}
?>