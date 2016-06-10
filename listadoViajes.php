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
                    Listado Viajes
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
                                <th style="text-align: center;"><strong>Fecha</strong></th>
								<th style="text-align: left;"><strong>Destino</strong></th>
                                <th style="text-align: left;"><strong>Empresa</strong></th>
                                <th style="width: 50px"></th>
                                <th style="width: 100px">Acciones</th>
                            </tr>
                        </thead>
                        
			    <?php
			    if(isset($_GET['page']))
			    	$page = $_GET['page'];
			   	else 
			   		$page = 0;

			   	$from = $page * 10;
				$sql = "SELECT T.razon_social, D.descripcion, D.color, V.* FROM Viajes as V 
						Join Transportes as T on T.id_transporte = V.idTransporte
						Join Destino as D on D.id_destino = V.idDestino
						Order by fecha desc Limit ".$from.",10";
                                
                                $resu = mysql_query($sql);
				echo "<tbody>";
                                if(mysql_num_rows($resu) <= 0)
                                    {
                                     echo '<tr><td colspan="4" style="text-align: center;">No se encontraron resultados.</td></tr>';
                                    }
                                    else
                                    {
                                       while($row = mysql_fetch_array($resu))
                                       {
                                       		if($row['status'] == 1)
                                            	echo "<tr>";
                                            else
                                            	echo '<tr style="background-color: #fcf8e3">';
                                            $fe = explode('-', $row['fecha']);
                                            echo "<td style=\"text-align: center\">".$fe[2].'-'.$fe[1].'-'.$fe[0]."</td>";
					    					echo "<td style=\"text-align: left\">".$row['descripcion']."</td>";
					    					echo "<td style=\"text-align: left\">".$row['razon_social']."</td>";
					    					echo "<td style=\"text-align: center\">";
					    					echo '<div style="width: 25px; height: 15px; background:'.$row['color'].'; -moz-border-radius: 30%; -webkit-border-radius: 30%; border-radius: 30%; box-shadow: 2px 2px 5px #999;"></div>';
					    					echo "</td>";
                                            echo "<td style=\"text-align: center;\">";
                                            
                                            if($row['status'] == 1){
	                                            echo "	<img src=\"./assest/plugins/buttons/icons/pencil.png\" width='20' heigth='20' title=\"Editar\" style=\"cursor:pointer\" onClick=\"EditarViaje(
	                                            									'".$row['idViaje']."', 
	                                            									'".$fe[2].'-'.$fe[1].'-'.$fe[0]."',
	                                            									'".$row['idDestino']."',
	                                            									'".$row['codigo']."',
	                                            									'".$row['idTransporte']."',
	                                            									'".$row['razon_social']."',
	                                            									'".$row['descripcion']."',
	                                            									'".$row['dias']."',
	                                            									'".$row['horas']."',
	                                            									'".$row['horaSalida']."',
	                                            									'".$row['minutoSalida']."'
	                                            									)\"/>";
												echo "	<img src=\"./assest/plugins/buttons/icons/clock_stop.png\" width='20' heigth='20' title=\"Cerrar\" style=\"cursor:pointer\" onClick=\"CerrarViaje(
	                                            									'".$row['idViaje']."'
	                                            									)\"/>";
											}
											else
											{
												echo '<span class="label label-warning">Cerrado</span>';
											}
                                            echo '</td>';
                                                                                            
                                            echo "</tr>";
                                       }

                                    }
                                echo "</tbody>";
			    ?>
                    </table>
				<?php
					if($page == 0) {
						echo '<button class="btn btn-info" type="button" disabled title="Anterior"><i class="icon-chevron-left icon-white"></i></button>   Página '.($page + 1);
					} else {
						echo '<button class="btn btn-info" type="button" title="Anterior" onClick="window.location=\'./listadoViajes.php?page='.($page - 1).'\';"><i class="icon-chevron-left icon-white"></i></button>   Página '.($page + 1);
					}
                    if(mysql_num_rows($resu) < 10){
                       		echo '<button class="btn btn-info" type="button" disabled title="Siguiente"><i class="icon-chevron-right icon-white"></i></button>';
                       } else {
                       		echo '<button class="btn btn-info" type="button" title="Siguiente" onClick="window.location=\'./listadoViajes.php?page='.($page + 1).'\';"><i class="icon-chevron-right icon-white"></i></button>';
                       }
                ?>
                    
		</div>
	    </div>
	</div>    
    </center>
    </div>
    <input type="hidden" id="idViaje" value="">
	
    <!-- Modal y demas cuestiones -->
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
		    <label class="control-label" for="inputFecha">Fecha y Hora</label>
		    <div class="controls">
			<input type="text" id="inputFecha" placeholder="dd/mm/aaaa" readonly class="input-small">
			<select id="inputHorasSalida"class="input-mini">
	    		<option value="00">00</option>
	    		<option value="01">01</option>
	    		<option value="02">02</option>
	    		<option value="03">03</option>
	    		<option value="04">04</option>
	    		<option value="05">05</option>
	    		<option value="06">06</option>
	    		<option value="07">07</option>
	    		<option value="08">08</option>
	    		<option value="09">09</option>
	    		<option value="10">10</option>
	    		<option value="11">11</option>
	    		<option value="12">12</option>
	    		<option value="13">13</option>
	    		<option value="14">14</option>
	    		<option value="15">15</option>
	    		<option value="16">16</option>
	    		<option value="17">17</option>
	    		<option value="18">18</option>
	    		<option value="19">19</option>
	    		<option value="20">20</option>
	    		<option value="21">21</option>
	    		<option value="22">22</option>
	    		<option value="23">23</option>
	    	</select>
	    	<select id="inputMinutosSalida"class="input-mini">
	    		<option value="00">00</option>
	    		<option value="15">15</option>
	    		<option value="30">30</option>
	    		<option value="45">45</option>
	    	</select>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputDestino">Destino</label>
		    <div class="controls">
				<input type="text" id="inputDestino" placeholder="Destino" readonly onclick="destinoClick()"/>
			  	<input type="hidden" id="idDestino">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputCodigo">Código</label>
		    <div class="controls">
			<input type="text" id="inputCodigo" placeholder="Código">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputTransporte">Emp. De Transporte</label>
		    <div class="controls">
			<input type="text" id="inputTransporte" placeholder="Transporte" readonly onclick="transporteClick()"/>
			<input type="hidden" id="idTransporte">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputDias">Días Anticipación</label>
		    <div class="controls">
		    	<select id="inputDias">
		    		<option value="0">0</option>
		    		<option value="1">1</option>
		    		<option value="2">2</option>
		    		<option value="3">3</option>
		    		<option value="4">4</option>
		    		<option value="5">5</option>
		    		<option value="6">6</option>
		    		<option value="7">7</option>
		    	</select>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputHoras">Horas Anticipación</label>
		    <div class="controls">
		    	<select id="inputHoras">
		    		<option value="0">0</option>
		    		<option value="1">1</option>
		    		<option value="2">2</option>
		    		<option value="3">3</option>
		    		<option value="4">4</option>
		    		<option value="5">5</option>
		    		<option value="6">6</option>
		    		<option value="7">7</option>
		    		<option value="8">8</option>
		    		<option value="9">9</option>
		    		<option value="10">10</option>
		    		<option value="11">11</option>
		    		<option value="12">12</option>
		    	</select>
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

<!--------- End Pop Artículos -->

 <!-- Pop Destinos -->
<div class="modal hide fade" id="DestinosPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Destinos </h3>
  </div>
  <div class="modal-body">
    
	<strong>Buscar :   </strong>  <input type="text" id="buscadorD_" onkeyup="BuscadorDeDestinos(this.value)"><br><br>
	<div id="resultado_Destinos" style="width: 90%; min-height: 250px; max-height: 250px;">
	
	</div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('DestinosPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Destinos -->

<!-- Pop Transporte -->
<div class="modal hide fade" id="TransportesPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Emp. De Trasnporte </h3>
  </div>
  <div class="modal-body">
    
	<strong>Buscar :   </strong>  <input type="text" id="buscadorT" onkeyup="BuscadorDeTransporte(this.value)"><br><br>
	<div id="resultado_Transportes" style="width: 90%; min-height: 250px; max-height: 250px;">
	
	</div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('TransportesPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Trasnporte -->

<?php

require("footer.php");

?>
<script>
    
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
		    
	if($('#inputFecha').val() == "")
	{
	    $('#msj_box_error').html("Ingrese una Fecha.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#idDestino').val() == "")
	{
	    $('#msj_box_error').html("Ingrese un Destino válido.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#idTransporte').val() == "")
	{
	    $('#msj_box_error').html("Ingrese una Empresa de Trasnporte válida.");
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
	    
	    input.push($('#idViaje').val());
	    input.push($('#inputFecha').val());
	    input.push($('#idDestino').val());
	    input.push($('#inputCodigo').val());
	    input.push($('#idTransporte').val());
	    input.push($('#inputDias').val());
	    input.push($('#inputHoras').val());
	    input.push($('#inputHorasSalida').val());
	    input.push($('#inputMinutosSalida').val());
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoViajesphp.php",
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
	$('#inputFecha').val('');
	$('#inputDestino').val('');
    $('#inputCodigo').val('');
    $('#inputTransporte').val('');
    $('#idTransporte').val('');
    $('#idDestino').val('');
    
	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
		Limpiar();
		$('#idViaje').val('0');
		var title = "Nuevo Viaje";
	    $('#headerId').html(title);
		
		$('#modalFC').modal('show');
		$('#box_error').hide();
		$('#msj_box_error').html("");
    }

$(function() {
	var d=new Date();
	$('#inputFecha').datepicker({ minDate: new Date(d.getFullYear(), d.getMonth(), d.getDate()) });
	$('#inputFecha').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#inputFecha').datepicker( 'setDate', '".$fechin."' );
      });

function destinoClick()
{
    $("#DestinosPop").modal('show');
    setTimeout(function () { $("#buscadorD_").focus(); }, 1000);
}

function transporteClick()
{
    $("#TransportesPop").modal('show');
    setTimeout(function () { $("#buscadorT").focus(); }, 1000);
}

function ClosePop(div)
{
	var idDiv = "#"+div;
	$(idDiv).modal('hide');			
}

function BuscadorDeDestinos(value)
	{
	        var input = value;
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque/buscarDestinos.php",
				data: { xinput: input },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%;">';
								fila +='<thead><th style="width: 20px;"></th><th>Destino</th><th style="width: 70px;">Color</th></tr></thead>';
								fila += "<tbody>";
								$.each(data, function(k,v)
										{
										    if(color == '#A9F5A9')
										    {
											color = '#FFFFFF';
										    }
										    else
										    {
											color = '#A9F5A9';
										    }
										    //Datos de cada cliente
										    var idCodigo = "";
										    $.each(v, function(i,j)
											       {
												 if(i == "id_destino")
												 {
													//Icono  accept
													fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+j+'" onClick="SeleccionadoD(\''+j+'\')">';
													fila +='<td>';
													fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
													fila +='</td>';
													fila += '<input type="hidden" id="'+j+'_cu" value="'+j+'">';
													idCodigo = j;
												 }
												 if(i == "descripcion")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_de" value="'+j+'">';
												 }
												 if(i == "color")
												 {
													fila +='<td style="text-align: center;"><div style="width: 25px; height: 15px; background:'+ j +'; -moz-border-radius: 30%; -webkit-border-radius: 30%; border-radius: 30%; box-shadow: 2px 2px 5px #999;"></div></td>';
													fila += '<input type="hidden" id="'+idCodigo+'_co" value="'+j+'">';
												 }
											       }
											      );
										    
										    fila += "</tr>";
										    
										}
										
									       );
								fila += "</tbody></table>";
								
								$("#resultado_Destinos").html(fila);
								
							    }
							    else
							    {
								$("#resultado_Destinos").html('<strong style="color: red;">No se encontraron resultados</strong>');
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}

function BuscadorDeTransporte(value)
	{
	    var input = value;
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque/buscarTransportes.php",
				data: { xinput: input },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%;">';
								fila +='<thead><th style="width: 20px;"></th><th>Empresa</th><th style="width: 70px;">-</th></tr></thead>';
								fila += "<tbody>";
								$.each(data, function(k,v)
										{
										    if(color == '#A9F5A9')
										    {
											color = '#FFFFFF';
										    }
										    else
										    {
											color = '#A9F5A9';
										    }
										    //Datos de cada cliente
										    var idCodigo = "";
										    $.each(v, function(i,j)
											       {
												 if(i == "id_transporte")
												 {
													//Icono  accept
													fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+j+'" onClick="SeleccionadoT(\''+j+'\')">';
													fila +='<td>';
													fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
													fila +='</td>';
													fila += '<input type="hidden" id="'+j+'_cu" value="'+j+'">';
													idCodigo = j;
												 }
												 if(i == "razon_social")
												 {
													fila +="<td>"+j+"</td><td></td>";
													fila += '<input type="hidden" id="'+idCodigo+'_rz" value="'+j+'">';
												 }
											       }
											      );
										    
										    fila += "</tr>";
										    
										}
										
									       );
								fila += "</tbody></table>";
								
								$("#resultado_Transportes").html(fila);
								
							    }
							    else
							    {
								$("#resultado_Transportes").html('<strong style="color: red;">No se encontraron resultados</strong>');
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}

function SeleccionadoD(code)
{
	 var nc = "#"+code+"_de";
	 
	 $("#idDestino").val(code);
	 $("#inputDestino").val($(nc).val());
	 
	 ClosePop("DestinosPop");
}

function SeleccionadoT(code)
{
	 var nc = "#"+code+"_rz";
	 
	 $("#idTransporte").val(code);
	 $("#inputTransporte").val($(nc).val());
	 
	 ClosePop("TransportesPop");
}

function EditarViaje(idViaje, fecha, idDestino, codigo, idTransporte, razon_social, descripcion, dias, horas, horaSalida, minutoSalida){
		Limpiar();
		$('#idViaje').val(idViaje);
		var title = "Editar Viaje";
	    $('#headerId').html(title);
		
	    $("#idTransporte").val(idTransporte);
	 	$("#inputTransporte").val(razon_social);

	 	$("#idDestino").val(idDestino);
	 	$("#inputDestino").val(descripcion);

	 	$('#inputFecha').val(fecha);
	    $('#inputCodigo').val(codigo);

	    $('#inputDias').val(dias);
	    $('#inputHoras').val(horas);

	    $('#inputHorasSalida').val(horaSalida);
	    $('#inputMinutosSalida').val(minutoSalida);
	    
		$('#modalFC').modal('show');
		$('#box_error').hide();
		$('#msj_box_error').html("");
}

function CerrarViaje(id) {
	var data_ajax={
				type: 'POST',
				url: "/empaque/listadoViajesClose.php",
				data: { xid: id },
				success: function( data ) {
							    location.reload();
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
}
</script>