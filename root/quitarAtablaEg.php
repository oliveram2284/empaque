<?php
session_start();
$idUsuario = $_SESSION['id_usuario'];
include("conexion.php");

$var = new conexion();
$var->conectarse();

$arre = explode('~',$_POST['variable']);
$dato = $arre[0];
$dep = $arre[1];

$consulta = "Delete From egresopendiente Where id = $dato ";
$resu = mysql_query($consulta);

//$consulta = "Select * From egresopendiente Where idUsuario ='".$idUsuario."'";
$consulta = "Select idProducto, descProducto, Cantidad, SUM(stockLote), id From egresopendiente
			 INNER JOIN productosdepositos ON egresopendiente.idProducto = productosdepositos.id_articulo
			 WHERE productosdepositos.id_deposito=$dep and egresopendiente.idUsuario ='".$idUsuario."'
			 GROUP BY idProducto";
							 
$resu = mysql_query($consulta)or die(mysql_error());

//echo mysql_num_rows($resu);

if(mysql_num_rows($resu) > 0)
{
	echo '<input type="button" value="Confirmar" onClick="Confirmar()" class="button">';
		echo "<table>";
		echo "<tr><td>Descripción</td>";
		echo "<td>Stock Actual</td><td>Cantidad A Extraer</td>";
		echo "<td>Borrar</td></tr>";
		
		while($row = mysql_fetch_array($resu))
		{
			echo "<tr>";
			echo "<td>".$row['descProducto']."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row['Cantidad']."</td>";
			echo '<td><img src="assest/plugins/buttons/icons/delete.png" onClick="eliminar2('.$row['id'].','.$dep.',\'resultado\',\'quitarAtablaEg.php\')"></td>';
			echo "</tr>";
		}
		
		echo "</table>";
}
else
{
	echo '<table><tr><td colspan="6" align="center">No hay productos pendientes.</td></tr></table>';	
}

?>