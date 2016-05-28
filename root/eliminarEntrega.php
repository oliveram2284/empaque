<?php
session_start();

$idUsuario = $_SESSION['id_usuario'];

include("conexion.php");

$var = new conexion();
$var->conectarse();

$id = $_POST['variable'];

$del = "Delete From entregatemporal Where identemp = $id";
mysql_query($del) or (die(mysql_error()));

$sql = "Select * from entregatemporal Where idUsuario=$idUsuario";
		$resu = mysql_query($sql);

		if(mysql_num_rows($resu) > 0)
			{
				echo "<table width='100'>";	
				echo "<tr><td>Nro. Pedido</td><td>Estampa</td><td>Medida</td><td>Unidades</td><td>Bultos</td>
					  <td>Kilogramos</td><td>Ubicación</td><td>Borrar</td></tr>";	
				while($row=mysql_fetch_array($resu))
				{
					echo "<tr>";
					echo "<td align='center'>".$row['codigo']."</td>";//str_pad($row['idPedido'], 8, "00000000", STR_PAD_LEFT)
					echo "<td>".$row['estampa']."</td>";
					echo "<td>".$row['medidas']."</td>";
					echo "<td>".$row['unidades']."</td>";
					echo "<td>".$row['bultos']."</td>";
					echo "<td>".$row['kg']."</td>";
					echo "<td>".$row['tipo']." ".$row['numero']."</td>";
					echo '<td><img src="assest/plugins/buttons/icons/delete.png" onclick="eliminar('.$row[0].',\'result\',\'eliminarEntrega.php\');"></td>';
					//echo '<td><img src="assest/plugins/buttons/icons/delete.png" onClick="eliminar('.$row['id'].',\'resultado\',\'quitarAtabla.php\')"></td>';
					echo "</tr>";
				}
				
				echo "</table>";
			}
?>