<?php	include "conexion.php";
            include "class.db.php";
			include "./layout/header_popup.php";
/*function new_tipo($nom,$desc)
{
	
}

function is_entrega($nom,$desc)
{
	$sql="select * from tipo_entrega where nombre like '%$nom%' and  descripcion like '%$desc%' ; ";
	if(mysql_query($sql))
		return true
	else
		return false
}

if(isset($oper))
{
	
}
*/
?>
			
</hr>
<center>
<h3 id="titulo_main" aling="center">Destino</h3>
</center>
<div class="span-10 left" >

<fieldset><legend>Datos de Destino</legend>
<p><label>Descripción</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nombre" id="nombre" /><br>
<label>Observación</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="descripcion" id="descripcion" /></p>
<p><input type="submit" name="enviar" id="enviar" value="Aceptar" class="button">
	   <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="button">
</p>

</fieldset>

</div>

<div class="span-10 push-1">
	<fieldset>
	<table>
		<thead>
			<tr>
				<td><b> Descripción</b> </td>
				<td><b> Observación</b></td>
				<td colspan="2"></td>
			</tr>
		</thead>
		<tbody>
			<?php
			$odb= new db();
			$sql="select *  from destino order by id_destino ";
			
			$res= $odb->query($sql);
				
			//echo '	<select id="selecEntrega" name="selecEntrega" class="top">';
			//echo"<option value='0'>&nbsp;&nbsp;Tipo de Entregas</option> ";
			while($row = mysql_fetch_array($res))
				{
					echo"<tr>";
					echo"<td>".$row[1]."</td><td>".$row[2]."</td>";
					echo"<td><img src=\"./assest/plugins/buttons/icons/pencil.png\" width='15' heigth='15' /></td>";
					echo"</td>";
				}	
			
			?>
		</tbody>
	</table>
	</fieldset>
</div>
<?php include "./layout/footer.php"; ?>