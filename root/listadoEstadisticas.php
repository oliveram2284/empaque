<?php  
session_start();

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}

include ("conexion.php");


require("header.php");

$vari = new conexion();
$vari->conectarse();

?>
<br>
    <div class="container">
    <center>
	<div id="menu" class="well">
	
	    <div class="row">
		<div class="span6 offset2">
			  <div class="page-header">
			  <h2>
                                Configuración de Productos
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" value="&nbsp;Nuevo&nbsp;" class="btn btn-success" onClick="nuevo()">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 160px;"><strong>Nombre</strong></th>
				<th style="text-align: center;"><strong>Es Kg.</strong></th>
				<th style="text-align: center;"><strong>Prrecio/Kg</strong></th>
				<th style="text-align: center;"><strong>Temp. Alta</strong></th>
				<th style="text-align: center;"><strong>Temp. Media</strong></th>
				<th style="text-align: center;"><strong>Temp. Baja</strong></th>
				<th style="text-align: center;"><strong>Diseño</strong></th>
				<th style="text-align: center;"><strong>Comp./Fabr.</strong></th>
				<th style="text-align: center;"><strong>Coeficiente</strong></th>
                                <th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM tbl_estadisticas Order by estNombre";
                                
                                $resu = mysql_query($sql);
				echo "<tbody>";
                                if(mysql_num_rows($resu) <= 0)
                                    {
                                     echo '<tr><td colspan="10" style="text-align: center;">No se encontraron resultados.</td></tr>';
                                    }
                                    else
                                    {
                                       while($row = mysql_fetch_array($resu))
                                       {
                                            echo "<tr>";
                                            //Nombre
                                            echo "<td>";
						echo '<p id="'.$row['idEsta'].'_p">'.$row['estNombre'].'</p>';
						echo '<input type="text" value="'.$row['estNombre'].'" id="'.$row['idEsta'].'_input" style="display:none; width: 150px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_kg">'.($row['estEsKg'] == 1 ? 'Si' : 'No') .'</p>';
						echo '<select id="'.$row['idEsta'].'_select_kg" style="display:none; width: 55px;">
							<option value="1" '.($row['estEsKg'] == 1 ? 'selected' : '').'>Si</option>
							<option value="0" '.($row['estEsKg'] == 0 ? 'selected' : '').'>No</option>
						      </select>';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_pr">'.$row['estPrecio'].'</p>';
						echo '<input type="text" value="'.$row['estPrecio'].'" id="'.$row['idEsta'].'_input_pr" style="display:none; width: 100px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_ta">'.$row['estAlta'].'</p>';
						echo '<input type="text" value="'.$row['estAlta'].'" id="'.$row['idEsta'].'_input_ta" style="display:none; width: 60px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_tm">'.$row['estMedia'].'</p>';
						echo '<input type="text" value="'.$row['estMedia'].'" id="'.$row['idEsta'].'_input_tm" style="display:none; width: 60px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_tb">'.$row['estBaja'].'</p>';
						echo '<input type="text" value="'.$row['estBaja'].'" id="'.$row['idEsta'].'_input_tb" style="display:none; width: 60px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_di">'.$row['estDisenio'].'</p>';
						echo '<input type="text" value="'.$row['estDisenio'].'" id="'.$row['idEsta'].'_input_di" style="display:none; width: 60px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_fa">'.$row['estFabricacion'].'</p>';
						echo '<input type="text" value="'.$row['estFabricacion'].'" id="'.$row['idEsta'].'_input_fa" style="display:none; width: 60px;">';
					    echo "</td>";
					    echo "<td style='text-align: right;'>";
						echo '<p id="'.$row['idEsta'].'_p_co">'.$row['estCoeficiente'].'</p>';
						echo '<input type="text" value="'.$row['estCoeficiente'].'" id="'.$row['idEsta'].'_input_co" style="display:none; width: 60px;">';
					    echo "</td>";
					    echo "<td style='text-align: center;'>";
						echo '<img id="'.$row['idEsta'].'_edit" src="./assest/plugins/buttons/icons/pencil.png" width="15px" heigth="15px" title="Editar" style="cursor:pointer" onClick="Activar_Celdas('.$row['idEsta'].')"/>';
						echo '<img id="'.$row['idEsta'].'_save" src="./assest/plugins/buttons/icons/disk.png" width="15px" heigth="15px" title="Guardar" style="cursor:pointer; display:none;" onClick="Ocultar_Celdas('.$row['idEsta'].')"/>';
						echo '&nbsp;&nbsp;&nbsp;<img id="'.$row['idEsta'].'_cancel" src="./assest/plugins/buttons/icons/cancel.png" width="15px" heigth="15px" title="Cancelar" style="cursor:pointer; display:none;" onClick="Cancel_Celdas('.$row['idEsta'].')"/>';
                                            echo '</td>';
                                                                                            
                                            echo "</tr>";
                                       }
                                    }
                                echo "</tbody>";
			    ?>
                    </table>
                    
		</div>
	    </div>
	</div>    
    </center>
    </div>
    <input type="hidden" id="idFormat" value="">
	
    <!---------------------------------------------------->
    <div class="modal hide fade" id="modalFC">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="headerId"></h3>
        </div>
        <div class="modal-body">
	    <div class="form-horizontal">
		<div class="alert alert-error" id="box_error" style="display: none">
		    <strong id="msj_box_error"></strong>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputNombre">Nombre</label>
		    <div class="controls">
			<input type="text" id="inputNombre" placeholder="Nombre o Identificador">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputKg">Es Kilogramos</label>
		    <div class="controls" style="text-align: center;">
			<select id="inputKg" style="width: 208px;">
			    <option value="1">Si</option>
			    <option value="0">No</option>
			</select>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputPrecio">Precio por kilo</label>
		    <div class="controls">
			<input type="text" id="inputPrecio" placeholder="0.00" type="number">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputAlta">Temporada Alta</label>
		    <div class="controls">
			<input class="span1" id="inputAlta" type="number"> <small>(días)</small>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputMedia">Temporada Media</label>
		    <div class="controls">
			<input class="span1" id="inputMedia" type="number"> <small>(días)</small>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputBaja">Temporada Baja</label>
		    <div class="controls">
			<input class="span1" id="inputBaja" type="number"> <small>(días)</small>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputDisenio">Diseño</label>
		    <div class="controls">
			<input class="span1" id="inputDisenio" type="number"> <small>(días)</small>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputFabr">Material Comp./Fabr.</label>
		    <div class="controls">
			<input class="span1" id="inputFabr" type="number"> <small>(días)</small>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputCoef">Coeficiente</label>
		    <div class="controls">
			<input class="span1" id="inputCoef" type="number"> <small>(días)</small>
		    </div>
		</div>
	    
	    </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" id="btnClose">Cerrar</a>
          <a href="#" class="btn btn-primary" id="btnAceptar">Guardar</a>
        </div>
    </div>
    <!---------------------------------------------------->

<?php

require("footer.php");

?>
<script>
    function EditarFormato(id, value)
    {
        $('#btnAceptar').removeAttr('disabled');
        var title = "Campos para " + value;
        $('#headerId').html(title);
        $('#idFormat').val(id);
	$('#box_error').hide();
	$('#msj_box_error').html("");
        
        var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoEstadisticasCons.php",
                        data: { xinput: id },
                        success: function( data ) {
                                                    if(data != 0)
                                                    {
							$('#inputNombre').val(data['estNombre']);
							$("#inputKg option[value="+data['estEsKg']+"]").attr("selected",true);
							$('#inputPrecio').val(data['estPrecio']);
							$('#inputAlta').val(data['estAlta']);
							$('#inputMedia').val(data['estMedia']);
							$('#inputBaja').val(data['estBaja']);
							$('#inputDisenio').val(data['estDisenio']);
							$('#modalFC').modal('show');
						    }
                                                        
                                                  },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
        $.ajax(data_ajax);
    }
    
    function inicio()
    {
	location.href="principal.php";
    }
    
    $('#btnClose').click(function(){
	    $('#modalFC').modal('hide');			
	});
    
    function validar()
    {
	$('#box_error').hide();
	$('#msj_box_error').html("");
		    
	if($('#inputNombre').val() == "")
	{
	    $('#msj_box_error').html("Ingrese un nombre o identificador.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputPrecio').val() == "")
	{
	    $('#msj_box_error').html("Ingrese precio válido ( mayor o igual a cero ).");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputAlta').val() == "")
	{
	    $('#msj_box_error').html("Ingrese los días de demora en temporada alta.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputMedia').val() == "")
	{
	    $('#msj_box_error').html("Ingrese los días de demora en temporada media.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputBaja').val() == "")
	{
	    $('#msj_box_error').html("Ingrese los días de demora en temporada baja.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputDisenio').val() == "")
	{
	    $('#msj_box_error').html("Ingrese los días de demora en estado de diseño.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputFabr').val() == "")
	{
	    $('#msj_box_error').html("Ingrese los días de demora de compra/fabricación de material.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputCoef').val() == "")
	{
	    $('#msj_box_error').html("Ingrese coeficiente.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	return true;
		
    }
    
    $('#btnAceptar').click(function(){
            
            $('#btnAceptar').attr("disabled", "disabled");
	    if(validar() == true)
	    {
		var input = [];
	    
	    input.push($('#idFormat').val());
	    input.push($('#inputNombre').val());
	    input.push($('#inputKg').val());
	    input.push($('#inputAlta').val());
	    input.push($('#inputBaja').val());
	    input.push($('#inputDisenio').val());
	    input.push($('#inputPrecio').val());
	    input.push($('#inputMedia').val());
	    input.push($('#inputFabr').val());
	    input.push($('#inputCoef').val());
	    
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoEstadisticasphp.php",
                        data: { xinput: input},
                        success: function( data ) {
                                                    if(data != 0)
                                                    {
							$('#box_error').show();
							$('#msj_box_error').html("Ocurrio un error.");
                                                    }
                                                    else
                                                    {
							Limpiar();
							$('#btnAceptar').removeAttr('disabled');
                                                        $('#modalFC').modal('hide');
							location.reload();
                                                    }
                                                  },
                        error: function(){
                                            $('#btnAceptar').removeAttr('disabled');
                                            $('#box_error').show();
					    $('#msj_box_error').html("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
            $.ajax(data_ajax);
	    }
            
	});
    
    function Limpiar()
    {
	$('#idFormat').val('');
	$('#inputNombre').val('');
	$('#inputKg').val('');
	$('#inputCoef').val('');
	$('#inputAlta').val('');
	$('#inputBaja').val('');
	$('#inputDisenio').val('');
	$('#inputPrecio').val('');
	$('#inputFabr').val('');
	$('#inputCoef').val('');
	$('#box_error').hide();
	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
	Limpiar();
	$('#idEstadistica').val('0');
	var title = "Nuevo Registro";
        $('#headerId').html(title);
	$('#modalFC').modal('show');
	$('#box_error').hide();
	$('#msj_box_error').html("");
    }
    
    function Activar_Celdas(estId){
	var p_ = '#' + estId + '_p';
	var input_ = '#' + estId + '_input';
	var edit_ = '#' + estId + '_edit';
	var cancel_ = '#' + estId + '_cancel';
	var save_ = '#' + estId + '_save';
	var esKg_ = '#' + estId + '_p_kg';
	var selectKg_ = '#' + estId + '_select_kg';
	var precio_ = '#' + estId + '_p_pr';
	var precioInput_ = '#' + estId + '_input_pr';
	var ta_ = '#' + estId + '_p_ta';
	var taInput = '#' + estId + '_input_ta';
	var tm_ = '#' + estId + '_p_tm';
	var tmInput = '#' + estId + '_input_tm';
	var tb_ = '#' + estId + '_p_tb';
	var tbInput = '#' + estId + '_input_tb';
	var di_ = '#' + estId + '_p_di';
	var diInput = '#' + estId + '_input_di';
	var fa_ = '#' + estId + '_p_fa';
	var faInput = '#' + estId + '_input_fa';
	var co_ = '#' + estId + '_p_co';
	var coInput = '#' + estId + '_input_co';
	$(p_).hide();
	$(edit_).hide();
	$(esKg_).hide();
	$(precio_).hide();
	$(ta_).hide();
	$(tm_).hide();
	$(tb_).hide();
	$(di_).hide();
	$(fa_).hide();
	$(co_).hide();
	$(input_).show();
	$(selectKg_).show();
	$(precioInput_).show();
	$(taInput).show();
	$(tmInput).show();
	$(tbInput).show();
	$(diInput).show();
	$(faInput).show();
	$(coInput).show();
	$(cancel_).show();
	$(save_).show();
    }
    
    function Ocultar_Celdas(estId) {
	var p_ = '#' + estId + '_p';
	var input_ = '#' + estId + '_input';
	var edit_ = '#' + estId + '_edit';
	var cancel_ = '#' + estId + '_save';
	var esKg_ = '#' + estId + '_p_kg';
	var selectKg_ = '#' + estId +'_select_kg';
	var precio_ = '#' + estId + '_p_pr';
	var precioInput_ = '#' + estId + '_input_pr';
	var ta_ = '#' + estId + '_p_ta';
	var taInput = '#' + estId + '_input_ta';
	var tm_ = '#' + estId + '_p_tm';
	var tmInput = '#' + estId + '_input_tm';
	var tb_ = '#' + estId + '_p_tb';
	var tbInput = '#' + estId + '_input_tb';
	var di_ = '#' + estId + '_p_di';
	var diInput = '#' + estId + '_input_di';
	var fa_ = '#' + estId + '_p_fa';
	var faInput = '#' + estId + '_input_fa';
	var co_ = '#' + estId + '_p_co';
	var coInput = '#' + estId + '_input_co';
	
	//Guardar Valores
	var input = [];
	    
	input.push(estId);//Id
	input.push($(input_).val());//Nombre
	input.push($(selectKg_).val());//Es kilogramo
	input.push($(taInput).val());//Temporada Alta
	input.push($(tbInput).val());//Temporada Baja
	input.push($(diInput).val());//Diseño
	input.push($(precioInput_).val());//Precio por kilo
	input.push($(tmInput).val());//Temporada Media
	input.push($(faInput).val());//Fabricacion
	input.push($(coInput).val());//Coeficiente	
	
	var data_ajax={
		    type: 'POST',
		    url: "/empaque/listadoEstadisticasphp.php",
		    data: { xinput: input},
		    success: function( data ) {
						if(data != 0)
						{
						   alert("error");
						}
						else
						{
						    location.reload();
						}
					      },
		    error: function(){
					alert("error");
				      },
		    dataType: 'json'
		    };
	$.ajax(data_ajax);
    }
    
    function Cancel_Celdas(estId) {
	var p_ = '#' + estId + '_p';
	var input_ = '#' + estId + '_input';
	var edit_ = '#' + estId + '_edit';
	var cancel_ = '#' + estId + '_cancel';
	var save_ = '#' + estId + '_save';
	var esKg_ = '#' + estId + '_p_kg';
	var selectKg_ = '#' + estId + '_select_kg';
	var precio_ = '#' + estId + '_p_pr';
	var precioInput_ = '#' + estId + '_input_pr';
	var ta_ = '#' + estId + '_p_ta';
	var taInput = '#' + estId + '_input_ta';
	var tm_ = '#' + estId + '_p_tm';
	var tmInput = '#' + estId + '_input_tm';
	var tb_ = '#' + estId + '_p_tb';
	var tbInput = '#' + estId + '_input_tb';
	var di_ = '#' + estId + '_p_di';
	var diInput = '#' + estId + '_input_di';
	var fa_ = '#' + estId + '_p_fa';
	var faInput = '#' + estId + '_input_fa';
	var co_ = '#' + estId + '_p_co';
	var coInput = '#' + estId + '_input_co';
	
	$(p_).show();
	$(edit_).show();
	$(esKg_).show();
	$(precio_).show();
	$(ta_).show();
	$(tm_).show();
	$(tb_).show();
	$(di_).show();
	$(fa_).show();
	$(co_).show();
	$(input_).hide();
	$(selectKg_).hide();
	$(precioInput_).hide();
	$(taInput).hide();
	$(tmInput).hide();
	$(tbInput).hide();
	$(diInput).hide();
	$(faInput).hide();
	$(coInput).hide();
	$(cancel_).hide();
	$(save_).hide();
    }
</script>