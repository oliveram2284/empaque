<?php
session_start();

$idUsuario = $_SESSION['id_usuario'];

include "conexion.php";

$var = new conexion();
$var->conectarse();
 
$dato=(isset($_POST['variable']))? $_POST['variable']:"";
    
  	if($dato!="")
    {
		$dato = explode("~",$dato);
		
		$tipoEmp=  $dato[0];
		$npedido=  $dato[1];
		$unidades= $dato[2];
		$bultos=   $dato[3];
		$kilos=    $dato[4];
		$remito=   $dato[5];
		$factura=  $dato[6];
		$valor=    $dato[7];
		$neto=     $dato[8];
		$medidas=  $dato[9];
		$estampa=  $dato[10];
		$numero=   $dato[11];
		$codigo=   $dato[12];
		
		$idUsu=    $idUsuario;
		
		//buscar el tipo de entrega
		$sql="select id_empaque,descripcion from tipo_empaque where id_empaque = $tipoEmp";
		
		$res= mysql_query($sql);;
			
		$row = mysql_fetch_array($res);
		$tipo = $row['descripcion'];
		
		$sql = "Insert Into entregatemporal (idTipoEmpaque, idPedido, estampa, medidas, unidades, bultos, kg, remito, factura, aprox, neto, idUsuario,numero,tipo,codigo)";
		$sql .= "Values ($tipoEmp, $npedido, '$estampa', '$medidas', $unidades, $bultos, '$kilos', '$remito', '$factura', '$valor', '$neto', $idUsu, $numero, '$tipo','$codigo')";
	
		mysql_query($sql) or (die(mysql_error()));
		
		//filtrar por usuario y por numero de pedido
		
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
	}


?>