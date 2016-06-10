<?php
session_start();

include("conexion.php");
$var = new conexion();
$var->conectarse();

				$idUsuario = $_SESSION['id_usuario'];

				$idDep = $_POST['variable'];

				$consulta = "Select * From ingresopendiente Where idUsuario ='".$idUsuario."' && idDeposito= $idDep";
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