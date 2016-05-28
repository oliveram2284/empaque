<?php
session_start();
$idUsuario = $_SESSION['id_usuario'];
include("conexion.php");

$var = new conexion();
$var->conectarse();

$dato=$_POST['variable'];

$consulta = "Delete From ingresopendiente Where id = $dato";
$resu = mysql_query($consulta);

$consulta = "Select * From ingresopendiente Where idUsuario ='".$idUsuario."'";
$resu = mysql_query($consulta)or die(mysql_error());

//echo mysql_num_rows($resu);

if(mysql_num_rows($resu) > 0)
{
	echo '<input type="button" value="Confirmar" onClick="Confirmar()" class="button">';
		echo "<table>";
		echo "<tr><td>Codigo</td><td>Descripción</td>";
		echo "<td>Depósito</td><td>Cantidad</td>";
		echo "<td>Fecha</td><td>Borrar</td></tr>";
		
		while($row = mysql_fetch_array($resu))
		{
			echo "<tr>";
			echo "<td>".$row['codProducto']."</td>";
			echo "<td>".$row['desProducto']."</td>";
			echo "<td>".$row['deposito']."</td>";
			echo "<td>".$row['cantidad']."</td>";
			echo "<td>".$row['fecha']."</td>";
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