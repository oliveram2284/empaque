<?php
session_start();

include("conexion.php");
$var = new conexion();
$var->conectarse();

$idUsuario = $_SESSION['id_usuario'];

$idDep = $_POST['variable'];

//$consulta = "Select * from egresopendiente Where idDeposito = $idDep and idUsuario = $idUsuario";
$consulta = "Select idProducto, descProducto, Cantidad, SUM(stockLote), SUM(productosdepositos.bultos), SUM(productosdepositos.kg), id From egresopendiente
			 INNER JOIN productosdepositos ON egresopendiente.idProducto = productosdepositos.id_articulo
			 WHERE productosdepositos.id_deposito=$idDep and egresopendiente.idUsuario ='".$idUsuario."'
			 GROUP BY idProducto";
			 
$resu = mysql_query($consulta);

if(mysql_num_rows($resu) <= 0 )
	{
		echo "No hay productos pendientes.";
	}
	else
	{
		echo '<input type="button" value="Confirmar" onClick="Confirmar('.$idDep.')" class="button">';
					
		echo "<table>";
		echo "<tr><td>Descripción</td>";
		echo "<td>Stock Cantidad</td><td>Stock Bultos</td><td>Stock Kgs.</td><td>Cantidad A Extraer</td>";
		echo "<td>Borrar</td></tr>";
		
		while($row = mysql_fetch_array($resu))
		{
			echo "<tr>";
			echo "<td>".$row['descProducto']."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>".$row[5]."</td>";
			echo "<td>".$row['Cantidad']."</td>";
			echo '<td><img src="assest/plugins/buttons/icons/delete.png" onClick="eliminar2('.$row['id'].','.$idDep.',\'resultado\',\'quitarAtablaEg.php\')"></td>';
			echo "</tr>";
		}
		
		echo "</table>";
	}
?>