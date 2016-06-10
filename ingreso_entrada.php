<?php include "./layout/header.php"; ?>
<hr>
<div class="span-23 right"><!-- Cuerpo de Formulario -->
	<div class="span-23">
	<fieldset> <legend>Entrega</legend>
		<table>
			<tr>
				<td colspan="2"><label class="span-3">Nro de Entrega:</label><input type="text" id="nroentrega" name="nroentrega" size="30"  class="top"/></td>
			</tr>
			<tr>
				<td ><label class="span-3">Tipo de Entrega: </label> 
																					<select id="selecEntrega" name="selecEntrega" class="top">
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																					</select>
				</td>
				<td><label class="span-3">Estado:</label>
																				<select id="estado" name="estado" class="top">
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																					</select> 
					
				</td>	
			</tr>
			<tr>
				<td ><label class="span-3">Destino: </label> 
																					<select id="destino" name="destino" class="top">
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																					</select>
						<button class="button" id="bt_destino" name="bt_destino" >Nuevo</button>
				</td>
				<td><label class="span-3">Vendedor: </label>
																				<select id="vendedor" name="vendedor" class="top">
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																					</select> 
						<button class="button" id="bt_entrega" name="bt_entrega" >Nuevo</button>
				</td>	
			</tr>
			<tr>
				<td ><label class="span-3">Resp. Exp: </label> 
																					<select id="respexp" name="respexp" class="top">
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																					</select>
						<button class="button" id="bt_destino" name="bt_destino" >Nuevo</button>
				</td>
				<td><label class="span-3">Transporte: </label>
																				<select id="transporte" name="transporte" class="top">
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																							<option value="0">opction 0</option>
																					</select> 
						<button class="button" id="bt_entrega" name="bt_entrega" >Nuevo</button>
				</td>	
			</tr>
						<tr>
				<td ><label class="span-3">Chofer: </label> 
																					<input type="text" id="chofer" name="chofer" />
							
				</td>
				<td><label class="span-3">Teléfono: </label>
																					<input type="text" id="telefono" name="telefono" />
						
				</td>	
			</tr>
			</tr>
			<tr>
				<td ><label class="span-3">Camion: </label> 
																					<input type="text" id="camion" name="camion"  class="top"/>
							
				</td>
				<td><label class="span-3">Domicilio: </label>
																					<input type="text" id="domicilio" name="domicilio" size="40" class="top" />
						
				</td>	
			</tr>
			<tr>
				<td ><label class="span-3">Fecha: </label> 
																					<input type="text" id="fecha" name="fecha" class="top" />
																					
																					   <img src="./assest/plugins/buttons/icons/calendar.png" class="top" onclick="alert('Fecha');">
																					
				</td>
				<td>
						
				</td>	
			</tr>
	</table>
	</fieldset>
	<hr>
	<p class="span-18 " ><label >Pallet: </label>&nbsp;&nbsp;&nbsp;<button class="button" id="newpallet" name="newpallet" >Nuevo</button> </p>
	<div class="span-23">
	
	<p>
		   <label>Periodo</label>&nbsp;<input type="text" size="15" />&nbsp;&nbsp;
		   <label>Estampa</label>&nbsp;<input type="text" size="15" />&nbsp;&nbsp;
		   <label>Medidas</label>&nbsp;<input type="text" size="15" />&nbsp;&nbsp;
		   <label>Unidades</label>&nbsp;<input type="text" size="5" />&nbsp;&nbsp;
		   <label>Bultos</label>&nbsp;&nbsp;&nbsp;<input type="text"  size="5" />&nbsp;&nbsp;
	<br>
		    <label>Kg:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="5" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   <label>Remito</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="15" />&nbsp;&nbsp;
		   <label>Factuta</label>&nbsp;&nbsp;<input type="text" size="15" />&nbsp;&nbsp;
		   <label>$/u Aprox</label>&nbsp;<input type="text" size="5" />&nbsp;&nbsp;
		   <label>Imp. Neto</label>&nbsp;<input type="text"  size="5" />&nbsp;&nbsp;
	</p>
	
	</div>
	<hr>
	</div>
</div>

<?php include "./layout/footer.php"; ?>