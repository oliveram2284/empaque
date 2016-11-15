<?php  
session_start();

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}
include("conexion.php");

$var = new conexion();
$var->conectarse();

include("class_sesion.php");
require("header.php");

?>


	<br>
	<div class="well"> <!-- Contenerdor margen de Pantalla standarizado -->
			<div class="row">
				<div class="span6 offset2">
					  <div class="page-header">
					  <h2>
                        <?php 
                        switch($_GET['accion'])
                        {
                            case "A":
                                    echo "Preprensa empaque ";
                                    break;
				
			    case "C":
                                    echo "Borradores en producción";
                                    break;
				
			    case "E":
                                    echo "Borradores aprobado a preprensa"; //*
                                    break;
				
			    case "G":
                                    echo "Preprensa en proveedor";//*
                                    break;
				
			    case "H":
                                    echo "Confección de polímero";//*
                                    break;
				
			    case "I":
                                    echo "Polímero en calidad";
                                    break;
				
			    case "K":
                                    echo "Producción / impresión";
                                    break;
					
			    case "P":
                                    echo "Datos fact. polímeros";
                                    break;
				
			    case "Q":
                                    echo "Autorización fact. polímeros";
                                    break;
				
                            default :
                                    echo "Operación No Registrada";
                        }
                        ?>
					</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="span2">
					<input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="principalL()">
				</div>	
				<div class="offset5 span2">
				    <input type="text" placeholder="Buscar..." id="buscador_txt" value="<?php echo (!isset($_GET['query'])) ? '' : $_GET['query'];?>">
				</div>
			</div>
			
			<div class="row">
				<div class="span10">
					<form name="listado" method="post">
					<?php
					include("class_abm.php");
					
					$tabla = new abm();
					$tabla->listadoPolimero($_GET['accion'], isset($_GET['page']) ? $_GET['page'] : 0, (!isset($_GET['query'])) ? '' : $_GET['query']);
					
					?>
					</form>
					<input type="hidden" id="actionValue" value="<?php echo $_GET['accion']; ?>">
				</div>
			</div>
        </div>
	
<!-- Modal para Confirmar Operacion (+) -->
<div class="modal hide fade" id="modal_actions">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="titlePolimero"></h3>
  </div>
  <div class="modal-body">
    <div class="alert alert-success" style="text-align : justify;">
	<strong><label id="msjConfirm"></label></strong>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-success" onclick="ChangeStatus_()">Aceptar</a>
  </div>
  <input type="hidden" id="idPolimero">
  <input type="hidden" id="nextStatus">
</div>
<!-- -->

<!-- Modal para Stand By  -->
<div class="modal hide fade" id="modal_standby">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="titlePolimeroStanBy"></h3>
  </div>
  <div class="modal-body">
    <div class="alert alert-success" style="text-align : center;" id="confirmDiv">
	<strong><label id="msjConfirmStandBy"></label></strong>
    </div>
    <div style="width: 100%; text-align: left;">
	<!-- Mensaje de Advertencia -->
	<div class="alert alert-error" id="div_alert_er_c">
	  
	</div>
	<!-- Motivos de Cancelación o Anulación -->
	Motivos:
	<div id="div_motives_" style="max-height: 100px; height: 100px; min-height: 100px; overflow-y: auto; overflow-y: auto; background-color: #FAFAFA; margin-bottom: 10px; border: 1px solid; border-color: #cccccc;">
	
	</div>
	<!-- Observaciones -->
	<div style="width: 100%;">
	    Observaciones:
	    <textarea rows="3" style="width: 100%" id="motivo_"></textarea>
	</div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-success" id="btn_rehacer" onclick="ValidarMotivoCancel()">Aceptar</a>
  </div>
</div>
<!-- -->


<!-- Modal para Cargar datos de Facturación   -->
<div class="modal hide fade" id="modal_facturacion" style="width: 1000px;margin-left: -500px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Datos de Facturación</h3>
  </div>
  <div class="modal-body">
    <!--
    <div class="alert alert-success" style="text-align : center;" id="confirmDiv">
	<strong><label id="msjConfirmFactura"></label></strong>
    </div>
    -->
    
    <div>
	<table width="100%" style="font-size: 12px;">
	    <tr>
		<td style="width: 10%;text-align: left;"><b>Factura N°</b></td>
		<td style="width: 30%;text-align: left;"><input type="text" id="nroFactura"></td>
		<td rowspan="2" style="text-align: left; padding-left: 30px;">
		    <span id="name_sapan"></span><br><br>
		    <span id="dire_sapan"></span><br><br>
		    <span id="tele_sapan"></span>
		</td>
	    </tr>
	    <tr>
		<td style="width: 10%;text-align: left;"><b>Cotización Dolar U$S</b></td>
		<td><input type="text" id="cotDolar" name="cotDolar" style="text-align: right;" onKeyPress="return soloNumeros(event)" onKeyUp="CalcularDolar();"></td>
	    </tr>
	    <tr><td colspan="3"><hr></td></tr>
	    <tr>
		<td colspan="3">
		    <div id="divCalidades" style="width: 100%">
			
		    </div>	    
		</td>
	    </tr>
	    <tr>
		<td style="width: 10%;text-align: left; vertical-align: top;"><b>Observaciones</b></td>
		<td><textarea id="observacionFacturacion" placeholder="Observaciones"></textarea></td>
		<td style="text-align: left; padding-left: 30px; font-size: 20px;">
		    <span id="prove_sapan" style="color: red;">Importe Factura Proveedor: $ 0.00</span><br><br>
		    <span id="NC_sapan" style="color: green;">Importe Not. Cred. Proveedor: $ 0.00</span><br><br>
		</td>
	    </tr>
	</table>
		
    </div>
    
  </div>
  <div class="modal-footer">
    <table style="width: 100%">
	<tr>
	    <td style="width: 90%; text-align: left;color: blue; font-size: 20px;"><b>Importe a Facturar por Empaque: $ </b><b id="calculo">0.00</b><b> + IVA</b></td>
	    <td><a href="#" class="btn btn-success" id="btn_ok_fact">Aceptar</a></td>
	</tr>
    </table>
  </div>
</div>
<!-- -->

<!-- Sub Modal para Facturar -->
<div class="modal hide fade" id="modal_importes">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="header_importe" style="font-size: 18px; color: blue;">-</h3>
  </div>
  <div class="modal-body">
	<strong><div class="alert alert-error" id="errorMsj_importes"></div>
	<div style="width: 100%; alignment-adjust: central;">
	    Se Factura ?
	    <input type="radio" class="confirma" name="confir" value="1" style="margin-left: 20px; margin-top: 0px;"><span style="color: green;">SI</span>
	    <input type="radio" class="confirma" name="confir" value="0" style="margin-left: 30px; margin-top: 0px;"><span style="color: red;">NO</span>
		<a style="margin-left: 30px; cursor: pointer; text-decoration: none;" id="verDetalleLink">Ver detalle</a>
	</div>
	<hr>
	<div style="width: 60%; text-align: left; display: none;" id="divPorcentaje">
	    <input type="radio" class="imp" name="imp" value="1" style="margin-left: 20px; margin-top: 0px;">Total: <span style="margin-left: 30px;" id="spanTotal"></span><br>
	    <input type="radio" class="imp" name="imp" value="2" style="margin-left: 20px; margin-top: 0px;">Porcentaje: <input type="text" id="porc" class="input-small" onKeyPress="return soloNumeros(event)" onkeyup="calcularPor()"><span style="margin-left: 30px;" id="spanP">$ 0.00</span><br>
	    <input type="radio" class="imp" name="imp" value="3" style="margin-left: 20px; margin-top: 0px;">Parcial: <input type="text" id="parc" class="input-small" onKeyPress="return soloNumeros(event)"><br>
	</div>
	</strong>
  </div>
  <div class="modal-footer">
    <strong><a href="#" class="btn btn-success" id="btn_acept">Aceptar</a></strong>
  </div>
</div>
<!-- -->

<!-- Sub Modal para Errores -->
<div class="modal hide fade" id="modal_errores">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 style="color: red;">Error</h3>
  </div>
  <div class="modal-body">
	<strong><div class="alert alert-error" id="errorMsj"></div></strong>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Error</i></strong>
  </div>
</div>
<!-- -->


<!------------------------------------------------>

<!-- Modal para Mostrar datos de Facturación   -->
<div class="modal hide fade" id="modal_facturacion_detail" style="width: 1000px;margin-left: -500px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Datos de Facturación</h3>
  </div>
  <div class="modal-body">    
    <div>
	<table width="100%" style="font-size: 12px;">
	    <tr>
		<td style="width: 10%;text-align: left;"><b>Factura N°</b></td>
		<td style="width: 30%;text-align: left;"><input type="text" id="FactNumber" readonly></td>
		<td rowspan="2" style="text-align: left; padding-left: 30px;">
		    <span id="name_sapan_detail"></span><br><br>
		    <span id="dire_sapan_detail"></span><br><br>
		    <span id="tele_sapan_detail"></span>
		</td>
	    </tr>
	    <tr>
		<td style="width: 10%;text-align: left;"><b>Cotización Dolar U$S</b></td>
		<td><input type="text" id="dolarr" name="dolarr" style="text-align: right;" readonly></td>
	    </tr>
	    <tr><td colspan="3"><hr></td></tr>
	    <tr>
		<td colspan="3">
		    <div id="divCalidadesDet" style="width: 100%">
			
		    </div>	    
		</td>
	    </tr>
	    <tr>
		<td style="width: 10%;text-align: left; vertical-align: top;"><b>Observaciones</b></td>
		<td><textarea id="Observation" placeholder="Observaciones" rows="4" cols="40" style="width: 300px;" readonly></textarea></td>
		<td style="text-align: left; padding-left: 30px; font-size: 20px;">
		    <span id="prove_sapan_detail" style="color: red;">Importe Factura Proveedor: $ 0.00</span><br><br>
		    <span id="NC_sapan_detail" style="color: green;">Importe Not. Cred. Proveedor: $ 0.00</span><br><br>
		</td>
	    </tr>
	</table>
		
    </div>
    
  </div>
  <div class="modal-footer">
    <table style="width: 100%">
	<tr>
	    <td style="width: 90%; text-align: left;color: blue; font-size: 20px;"><b>Importe a Facturar por Empaque: $ </b><b id="calculo_detail">0.00</b><b> + IVA</b></td>
	    <td><a href="#" class="btn btn-primary" id="btn_ok_fact_detail">Cerrar</a></td>
	</tr>
    </table>
  </div>
</div>
<!-- -->

<!-- Modal para ver log de polimeros -->
<div class="modal hide fade" id="modal_polimero_log">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="titlePolimeroLog" style="text-align: center"></h3>
  </div>
  <div class="modal-body">
    <div style="text-align : center; min-height: 80px; font-size: 12px;" id="detailPolimero">
    </div>
    <div style="text-align : center;">
	<span class="label" id="status1" style="font-size: 30px;" title="Ingreso en Preprensa">1</span>
	<span class="label" id="status2" style="font-size: 30px; margin-left: 25px;" title="Enviado aprob. de Cliente">2</span>
	<span class="label" id="status3" style="font-size: 30px; margin-left: 25px;" title="Aprobado por el Cliente">3</span>
	<span class="label" id="status4" style="font-size: 30px; margin-left: 25px;" title="Enviado aprob. de Borradores">4</span>
	<span class="label" id="status5" style="font-size: 30px; margin-left: 25px;" title="Borrador Aprobado">5</span>
	<span class="label" id="status6" style="font-size: 30px; margin-left: 25px;" title="Preprensa Empaque">6</span>
	<span class="label" id="status7" style="font-size: 30px; margin-left: 25px;" title="Preprensa en Proveedor">7</span>
	<span class="label" id="status8" style="font-size: 30px; margin-left: 25px;" title="Confección de Polímeros">8</span>
	<span class="label" id="status9" style="font-size: 30px; margin-left: 25px;" title="Polímero en Calidad">9</span>
	<span class="label" id="status10" style="font-size: 30px; margin-left: 25px;" title="Producción/Impresión">10</span>
    </div><br>
    <div>
	<p id="estadoActual"><strong>Estado Actual: </strong>-.</p>
    </div>
    <hr>
	<div id="logpolimeros" style="width: 100%; max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
	    
	</div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-success" data-dismiss="modal">Aceptar</a>
  </div>
</div>
<!-- -->


<?php

require("footer.php");

?>
<script>
    $( document ).ready(function() {
	$( document ).tooltip();
    });
    
    function ChangeStatus(idPolimero, nextStatus) {
	GetStatus(nextStatus);
	$("#idPolimero").val(idPolimero);
	$("#nextStatus").val(nextStatus);
	$("#modal_actions").modal('show');
    }
    
    function GetStatus(status) {
	switch (status) {
	    case 'B':
		$("#titlePolimero").text("Borradores en producción");
		$("#msjConfirm").text("¿ Enviar trabajo a borradores en producción ?");
		break;
	    
	    case 'C':
		$("#titlePolimero").text("Borradores en producción");
		$("#msjConfirm").text("¿ Enviar trabajo a borradores en producción ?");
		break;
	    
	    case 'E':
		$("#titlePolimero").text("Borradores aprobado a preprensa");
		$("#msjConfirm").text("¿Aprobar borrador a preprensa?");
		break;
	    
	    case 'G':
		$("#titlePolimero").text("Preprensa en proveedor");
		$("#msjConfirm").text("¿ Enviar a preprensa del proveedor ?");
		break;
	
	    case 'H':
		$("#titlePolimero").text("Confección de polimero");
		$("#msjConfirm").text("¿ Enviar a confección de polimero ?");
		break;
	    
	    case 'I':
		$("#titlePolimero").text("Polímero en calidad");
		$("#msjConfirm").text("¿ Desea pasar polímero a calidad ?");
		break;
	    
	    case 'K':
		$("#titlePolimero").text("Producción/impresión");
		$("#msjConfirm").text("¿ Polímero correcto para enviar a producción/impresión ?");
		break;
	    
	    case 'M':
		$("#titlePolimero").text("Archivar Polímero");
		$("#msjConfirm").text("¿ Desea dar curso al polímero y archivar ?");
		break;
	}
    }
    function ChangeStatus_()
	{    
	    var data_ajax=
	    {
		type: 'POST',
		url: "/empaque_demo/loadLogPolimeros.php",
		data: { xId: $("#idPolimero").val(), xstatus: $("#nextStatus").val() },
		success: function( data )
		    {
			if(data != 1)
			{
			    alert("error");
			}
			else
			{
			    location.reload();
			}
		    },
		error: function(){
				    alert("error de conexion");
				},
		dataType: 'json'
	    }
	    $.ajax(data_ajax);
	}
	
    var MainAction = "";
    var idPoli = "";
    function OpenStandBy(idPolimero, nextStatus) {
	    //Z stand by
	    //X play
	    $("#div_alert_er_c").hide();
	    MainAction = nextStatus;
	    idPoli = idPolimero;
	    $("#confirmDiv").removeClass("alert-error").addClass("alert-success");
	    
	    if (nextStatus == 'Z') {
		$("#titlePolimeroStanBy").text('Polímero en StandBy');
		getMotives('S', 'div_motives_');
		$("#msjConfirmStandBy").text('¿ Esta seguro de poner en StandBy el polímero seleccionado ?');
	    }else
	    {
		$("#titlePolimeroStanBy").text('Activar Polímero');
		getMotives('A', 'div_motives_');
		$("#msjConfirmStandBy").text('¿ Esta seguro de poner en Activar el polímero seleccionado ?');
	    }
	    
	    $("#idPolimero").val(idPolimero);
	    $("#nextStatus").val(nextStatus);
	    $("#modal_standby").modal('show');
	}
	
    function CancelOrReturn(idPolimero, nextStatus){
	    //Y cancelar
	    //D devolver
	    $("#div_alert_er_c").hide();
	    MainAction = nextStatus;
	    idPoli = idPolimero;
	    $("#confirmDiv").removeClass("alert-success").addClass("alert-error");
	    
	    if (nextStatus == 'Y') {
		$("#titlePolimeroStanBy").text('Cancelar Polímero');
		getMotives('C', 'div_motives_');
		$("#msjConfirmStandBy").text('¿ Esta seguro de cancelar el polímero seleccionado ?');
	    }else
	    {
		$("#titlePolimeroStanBy").text('Corregir Polímero');
		getMotives('D', 'div_motives_');
		$("#msjConfirmStandBy").text('¿ Esta seguro de corregir polímero seleccionado ?');
	    }
	    
	    $("#idPolimero").val(idPolimero);
	    $("#nextStatus").val(nextStatus);
	    $("#modal_standby").modal('show');
    }

    var motives = new Array();	
    function getMotives(value, div)
    {
	motives = new Array();
	$("#"+div+"").html("");
	var data_ajax={
                        type: 'POST',
                        url: "/empaque_demo/getMotivesP.php",
                        data: { val: value},
                        success: function( data ) {
					
					var count = 0;
					$.each(data, function(k,v)
					       {
						    var id = "";
						    var desc = "";
						    $.each(v, function(i,j)
							   {
								if (i == "id")
								    id = j;
								else
								    desc = j;
							   });
						    count++;
						    if (count == 1) {
							$("#"+div+"").append('&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="'+id+'" value="'+id+'" onClick="addMotive('+id+')">'+desc+'</input><br>');
							count = 0;
						    }
						    else
						    { $("#"+div+"").append('&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="'+id+'" value="'+id+'" onClick="addMotive('+id+')">'+desc+'</input>'); }
					       });
                                },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
		
	$.ajax(data_ajax);  
    }
    
    function addMotive(value)
    {
	var index = motives.indexOf(value);
	
	if (index > -1) {
	    motives.splice(index, 1);
	}else
	{
	    motives.push(value);
	}
    }
    
    //falta el validar para cancelar o poner en stanby
    //$("#div_alert_er_c").hide();
    function ValidarMotivoCancel(){
	$('#div_alert_er_c').html("");
	$('#div_alert_er_c').css('display','none');
	
	var motivos = "";
	    
	if (motives.length <= 0)
	{
	    $('#div_alert_er_c').html("<center><strong>Ingrese al menos un motivo para poder cambiar el estado del polímero.</strong></center>");
	    $('#div_alert_er_c').css('display','block');
	    return;
	}
	
	for (var i = 0; i < motives.length; i++) {
	    if (motivos == "") {
		motivos = motives[i];
	    }
	    else{
		motivos += "-" + motives[i];
	    }
	}
	
	if($('#motivo_').val() == "")
	{
	    $('#div_alert_er_c').html("<center><strong>Ingrese una descripción para poder cambiar el estado del polímero.</strong></center>");
	    $('#div_alert_er_c').css('display','block');
	    return;
	}
	
	$('#btn_rehacer').attr('disabled', 'disabled');
	
	var data_ajax={
                        type: 'POST',
                        url: "/empaque_demo/insertPolimeroWithMotive.php",
                        data: { action: MainAction,
				id: idPoli,
				motive: $('#motivo_').val(),
				mot: motivos},
                        success: function( data ) {
					$("#modal_standby").modal('hide');
					location.reload();
                                },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
		
		$.ajax(data_ajax);
	
    }
    
    var Values;
    
    function FacturarPolimero(idPolimero, status)
    {
	$("#modal_facturacion").modal('show');
	$("#cotDolar").val("");
	$("#nroFactura").val("");
	$("#observacionFacturacion").val("");
	$("#calculo").text("0.00");
	$("#idPolimero").val(idPolimero);
	$("#prove_sapan").html("Importe Factura Proveedor: $ 0.00");
	$("#NC_sapan").html("Importe Not. Cred. Proveedor: $ 0.00");
	
	var data_ajax=
	{
	    type: 'POST',
	    url: "/empaque_demo/getPolimeroCalidades.php",
	    data: { id: idPolimero },
	    success: function( data )
		{
		    if(data != 1)
		    {
			 Values = new Array();
			$.each(data, function(id, value){
			    if (id == 'calidades') {
				var rows = '<table style="width: 100%;font-size: 12px;">';
				$.each(value, function(k,v)
				{
				    var id='';
				    var name='';
				    var cot = '';
				    $.each(v, function(i,j){
					if(i=='id')
					{
					    id=j;
					    Values.push(j);
					}
					
					if (i == 'cot') {
					    cot=j;
					}
					    else
					    name=j;
				    });
				    rows+='<tr>';
				    rows+='<td>Calidad <i><b>'+name+'</b></i> :<input type="hidden" id="'+id+'IdCal" value="'+id+'"></td>';
				    rows+='<td>Cant.:</td><td><input id="'+id+'Cantidad"type="text" class="input-small cantidad" onKeyPress="return soloNumeros(event)" style="text-align: right;"></td>';
				    rows+='<td>Cm2:</td><td><input id="'+id+'cm" type="text" class="input-small cm" onKeyPress="return soloNumeros(event)" onKeyUp="Calcular('+id+');" style="text-align: right;"></td>';
				    rows+='<td>Importe:</td><td><input id="'+id+'Importe" type="text" class="input-small importe" onKeyPress="return soloNumeros(event)" onKeyUp="Calcular('+id+');" style="text-align: right;"></td>';
				    rows+='<td>Importe Final:</td><td><input id="'+id+'Final" type="text" class="input-small final" onKeyPress="return soloNumeros(event)" onKeyUp="CalcularFinal();" style="text-align: right;"></td>';
				    rows+='</tr>';
				    rows+='<tr>';
				    rows+='<td></td>';
				    rows+='<td>Cm2 en $:</td><td><strong style="color: blue;"><label id="'+id+'LabelPesos" style="margin-top: 13px;">0.00</label></strong></td>';
				    rows+='<td>Cm2 en u$s <i style="color:green">('+cot+')</i>:</td><td><strong style="color: green;"><label id="'+id+'LabelDolar" style="margin-top: 13px;">0.00</label></strong></td>';
				    rows+='<td>Importe NC:</td><td><input id="'+id+'NC" type="text" class="input-small" onKeyPress="return soloNumeros(event)" onKeyUp="CalcularFinal();" style="text-align: right;"></td>';
				    rows+='<td>Se resta NC:</td><td><input id="'+id+'resta" type="checkbox" class="input-small" onChange="CalcularFinal();" ></td>';
				    rows+='</tr>';
				    rows+='<tr><td colspan="9"><hr></td></tr>';
				});
				rows+='</table>';
				$('#divCalidades').html(rows);
			    }
			    
			    if (id=="name") {
				$("#name_sapan").html("Proveedor: <b><i>"+value+"</i></b>");
			    }
			    if (id=="domi") {
				$("#dire_sapan").html("Domicilio: <b><i>"+value+"</i></b>");
			    }
			    if (id=="tele") {
				$("#tele_sapan").html("Teléfono: <b><i>"+value+"</i></b>");
			    }
			});
			
		    }
		    else
		    {
			location.reload();
		    }
		},
	    error: function(){
				alert("error de conexion");
			    },
	    dataType: 'json'
	}
	$.ajax(data_ajax);
    }
function Calcular(id)
{
    var idCant = '#'+id+'cm';
    var idImporte = '#'+id+'Importe';
    var idLabPesos = '#'+id+'LabelPesos';
    var idLabelDolar = '#'+id+'LabelDolar';
    var cotDolar = parseFloat($('#cotDolar').val()).toFixed(2);
    var total = 0;
    var aux;
    var proveedor = 0;
    
    
    var resultado  = parseFloat($(idImporte).val()) / parseFloat($(idCant).val());
    if(!isNaN(resultado)) 
	$(idLabPesos).text(resultado.toFixed(2));
	else
	$(idLabPesos).text("0.00");
	
    if(!isNaN(resultado) && !isNaN(cotDolar))
	$(idLabelDolar).text((resultado.toFixed(2)/cotDolar).toFixed(2));
	else
	$(idLabelDolar).text("0.00");
	
    for(var i in Values){
	if(!isNaN($("#"+Values[i]+"Importe").val()) && $("#"+Values[i]+"Importe").val() != "")
	{
	    aux = parseFloat($("#"+Values[i]+"Importe").val());
	    total = total + aux;
	    proveedor = proveedor + aux;
	}
    }
	
    //$("#prove_sapan").html("Importe Factura Proveedor: $ " + proveedor.toFixed(2));
    //$("#NC_sapan").html("Importe Not. Cred. Proveedor: $ " + nc.toFixed(2));
    $("#calculo").text((total * 1.1).toFixed(2)); 
}

function CalcularDolar() {
    if ($("#cotDolar").val() != "") {
	for(var i in Values){
	    var resultado = parseFloat($("#"+Values[i]+"LabelPesos").text()).toFixed(2) / parseFloat($("#cotDolar").val()).toFixed(2);
	    $("#"+Values[i]+"LabelDolar").text(resultado.toFixed(2));
	}
    }
}

function CalcularFinal()
{
    var total = 0;
    var aux;
    var proveedor = 0;
    var nc = 0;
    
    for(var i in Values){
	if(!isNaN($("#"+Values[i]+"Final").val()) && $("#"+Values[i]+"Final").val() != "")
	{
	    aux = parseFloat($("#"+Values[i]+"Final").val());
	    total = total + aux;
	    proveedor = proveedor + aux;
	    
	    if($("#"+Values[i]+"resta").is(':checked')) {
		if(!isNaN($("#"+Values[i]+"NC").val()) && $("#"+Values[i]+"NC").val() != "")
		{
		    aux = parseFloat($("#"+Values[i]+"NC").val());
		    total = total - aux;
		}
	    }
	    
	    if(!isNaN($("#"+Values[i]+"NC").val()) && $("#"+Values[i]+"NC").val() != "")
	    {
		aux = parseFloat($("#"+Values[i]+"NC").val());
		nc = nc + aux;
	    }
	}
    }
	
    $("#prove_sapan").html("Importe Factura Proveedor: $ " + proveedor.toFixed(2));
    $("#NC_sapan").html("Importe Not. Cred. Proveedor: $ " + nc.toFixed(2));
    //$("#calculo").text((total * 1.1).toFixed(2)); 
}

$("#verDetalleLink").click(function(){
   //alert(idPolimeroSelected);
   var data_ajax={
	    type: 'POST',
	    url: "/empaque_demo/getPolimeroFact.php",
	    data: {
		    Id : idPolimeroSelected
		  },
	    success: function( data ) {
			
			$("#FactNumber").val(data['factura']);
			$("#dolarr").val(data['dolar']);
			$("#Observation").val(data['observ']);
			$("#name_sapan_detail").html("Proveedor: <b><i>"+data['name']+"</i></b>");
			$("#dire_sapan_detail").html("Domicilio: <b><i>"+data['domi']+"</i></b>");
			$("#tele_sapan_detail").html("Teléfono: <b><i>"+data['tele']+"</i></b>");
			    
			var cotDolar = parseFloat(data['dolar']).toFixed(2);
			
			    var rows = '<table style="width: 100%;font-size: 12px;">';
			    var total = 0;
			    var nc = 0;
			    var impor = 0;
			    $.each(data['detalle'], function(id, value){
				
				var resultado  = parseFloat(value['importe']) / parseFloat(value['cm2']);
				var pesos = "0.00";
				var dolar = "0.00";
				
				if(!isNaN(resultado)) 
				    pesos = resultado.toFixed(2);
				    
				if(!isNaN(resultado) && !isNaN(cotDolar))
				    dolar = (resultado.toFixed(2)/cotDolar).toFixed(2);
	
				rows+='<tr>';
				rows+='<td>Calidad <i><b>'+value['name']+'</b></i> :</td>';
				rows+='<td>Cant.:</td><td><input type="text" class="input-small cantidad" style="text-align: right;" value="'+value['cantidad']+'" readonly></td>';
				rows+='<td>Cm2:</td><td><input type="text" class="input-small cm" style="text-align: right;" value="'+value['cm2']+'" readonly></td>';
				rows+='<td>Importe:</td><td><input type="text" class="input-small importe" style="text-align: right;" value="'+value['importe']+'" readonly></td>';
				rows+='<td>Importe Final:</td><td><input type="text" class="input-small final" style="text-align: right;" value="'+value['importeFinal']+'" readonly></td>';
				rows+='</tr>';
				rows+='<tr>';
				rows+='<td></td>';
				rows+='<td>Cm2 en $:</td><td><strong style="color: blue;"><label style="margin-top: 13px;">'+pesos+'</label></strong></td>';
				rows+='<td>Cm2 en u$s <i style="color:green">('+value['cotizacion']+')</i>:</td><td><strong style="color: green;"><label style="margin-top: 13px;">'+dolar+'</label></strong></td>';
				rows+='<td>Importe NC:</td><td><input type="text" class="input-small" style="text-align: right;" value="'+value['importeNC']+'" readonly></td>';
				var checked = value['seRestaNC'] == 1 ? "checked" : "";
				rows+='<td>Se resta NC:</td><td><input type="checkbox" class="input-small" '+checked+' readonly></td>';
				rows+='</tr>';
				rows+='<tr><td colspan="9"><hr></td></tr>';
				total = total + parseFloat(value['importeFinal']);
				nc = nc + parseFloat(value['importeNC']);
				impor = impor + parseFloat(value['importe']);
			    });
			    rows+='</table>';
			    $('#divCalidadesDet').html(rows);
			    $('#prove_sapan_detail').html("Importe Factura Proveedor: $ " + total.toFixed(2));
			    $("#NC_sapan_detail").html("Importe Not. Cred. Proveedor: $ " + nc.toFixed(2));
			    $("#calculo_detail").text((impor * 1.1).toFixed(2));
			
			
			$("#modal_facturacion_detail").modal('show');    
		    },
	    error: function(){
				$("#modal_errores").modal('show');
				$("#errorMsj").text("Error de Conexión");
				$('#btn_ok_fact').removeAttr('disabled');
			      },
	    dataType: 'json'
	    };
    
    $.ajax(data_ajax);
});

$("#btn_ok_fact_detail").click(function(){
    $("#modal_facturacion_detail").modal('hide'); 
});

$("#btn_ok_fact").click(function(){
    if ($("#nroFactura").val() == "") {
	$("#modal_errores").modal('show');
	$("#errorMsj").text("Ingrese el número de Factura");
	return;
    }
    if ($("#cotDolar").val() == "") {
	$("#modal_errores").modal('show');
	$("#errorMsj").text("Ingrese la cotización del dolar");
	return;
    }
    $(".cantidad").each(function( index ){
	    if (this.value == "") {
		$("#modal_errores").modal('show');
		$("#errorMsj").text("Revise que todos los campos de importes esten completos");
		return;
	    }
    });
    
    $(".cm").each(function( index ){
	    if (this.value == "") {
		$("#modal_errores").modal('show');
		$("#errorMsj").text("Revise que todos los campos de importes esten completos");
		return;
	    }
    });
    
    $(".importe").each(function( index ){
	    if (this.value == "") {
		$("#modal_errores").modal('show');
		$("#errorMsj").text("Revise que todos los campos de importes esten completos");
		return;
	    }
    });
    
    $(".final").each(function( index ){
	    if (this.value == "") {
		$("#modal_errores").modal('show');
		$("#errorMsj").text("Revise que todos los campos de importes esten completos");
		return;
	    }
    });
    
    var Fact = $("#nroFactura").val();
    var Dolar = $("#cotDolar").val();
    var Observ = $("#observacionFacturacion").val();
    var items = {};
    var idPoli = $("#idPolimero").val();
    
    for(var i in Values){
	var item = {};
	
	item.id = Values[i];
	item.cant = $("#"+Values[i]+"Cantidad").val();
	item.cm2 = $("#"+Values[i]+"cm").val();
	item.importe = $("#"+Values[i]+"Importe").val();
	item.final = $("#"+Values[i]+"Final").val();
	item.nc = $("#"+Values[i]+"NC").val() == "" ? 0 : $("#"+Values[i]+"NC").val();
	if($("#"+Values[i]+"resta").is(':checked'))
	    item.resta = 1;
	    else
	    item.resta = 0;
	    
	items[i] = item;
    }
    
    $('#btn_ok_fact').attr('disabled', 'disabled');
    var data_ajax={
	    type: 'POST',
	    url: "/empaque_demo/insertPolimeroFact.php",
	    data: {
		    xId : idPoli,
		    xFa : Fact,
		    xDo : Dolar,
		    xOb : Observ,
		    xAr : items
		  },
	    success: function( data ) {
			    location.reload();
			    
		    },
	    error: function(){
				$("#modal_errores").modal('show');
				$("#errorMsj").text("Error de Conexión");
				$('#btn_ok_fact').removeAttr('disabled');
			      },
	    dataType: 'json'
	    };
    
    $.ajax(data_ajax);
    
    });

var importeTotal = 0;
var idPolimeroSelected = 0;
function FacturarPolimeroSiNo(idPolimero) {
    
    //identificador del polimero seleccionado
    idPolimeroSelected = idPolimero;
    
    $("#idPolimero").val(idPolimero);
    $("#errorMsj_importes").hide();
    //Limpieza
    $(".confirma").each(function( index ){this.checked = false;});
    $("#divPorcentaje").hide();
    $(".imp").each(function( index ){this.checked = false;});
    $("#parc").val('');
    $("#porc").val('');
    $("#spanP").html("$ 0.00"); 
    
    var data_ajax={
	    type: 'POST',
	    url: "/empaque_demo/getImportePolimeroFact.php",
	    data: {
		    xId : $("#idPolimero").val()
		  },
	    success: function( data ) {
			    $("#header_importe").text("Importe a Facturar por Empaque: $" + data.toFixed(2) + " +IVA");
			    $("#spanTotal").text("$" + data.toFixed(2));
			    importeTotal = data.toFixed(2) ;
		    },
	    error: function(){
				$("#modal_errores").modal('show');
				$("#errorMsj").text("Error de Conexión");
			      },
	    dataType: 'json'
	    };
    
    $.ajax(data_ajax);
    $('#modal_importes').modal('show');
}

$(".confirma").change(function (){
    $(".confirma").each(function( index ){
	if (this.checked) {
	    if(this.value == 1)
	    {
		//show div
		$("#divPorcentaje").show('slow');
	    }
	    else
	    {
		//hide div
		$("#divPorcentaje").hide('slow');
	    }
	}
    });
});

$("#btn_acept").click(function(){
    var corte = true;
    var descuenta = 0;
    var tipo = 0;
    var importe = 0;
    
    $(".confirma").each(function( index ){
	if (this.checked) {
	    corte = false;
	    descuenta = this.value;
	}
    });
    
    if (corte == true) {
	$("#errorMsj").text("Indique si el polímero se factura o no");
	$("#modal_errores").modal('show');
	return;
    }
    
    if (descuenta == 1) {
	corte = true;
	$(".imp").each(function( index ){
	    if (this.checked) {
		corte = false;
		tipo = this.value;
	    }
	});
	
	if (corte == true) {
	    $("#errorMsj").text("Indique el importe a facturar");
	    $("#modal_errores").modal('show');
	    return;
	}
	
	if (tipo == 2) {
	//porcentaje
	    if(!isNaN($("#porc").val()) && $("#porc").val() != "")
	    {
		var porc = parseFloat($("#porc").val()).toFixed(2);
		
		if (porc > 0) {
		    importe = (porc * importeTotal) / 100;
		}
		else
		{
		    $("#errorMsj").text("Indique el porcentaje a facturar");
		    $("#modal_errores").modal('show');
		    return;	
		}
	    }
	    else
	    {
		$("#errorMsj").text("Indique el porcentaje a facturar");
		$("#modal_errores").modal('show');
		return;
	    }
	}
	
	if (tipo == 3) {
	    //parcial
	    if(!isNaN($("#parc").val()) && $("#parc").val() != "")
	    {
		importe = parseFloat($("#parc").val()).toFixed(2);
		
		if (importe <= 0) {
		    $("#errorMsj").text("Indique el monto a facturar");
		    $("#modal_errores").modal('show');
		    return;	
		}
	    }
	    else
	    {
		$("#errorMsj").text("Indique el monto a facturar");
		$("#modal_errores").modal('show');
		return;
	    }
	}
	
	if (tipo == 1) {
	    importe = importeTotal;
	}
    }
    
    $("#btn_acept").attr('disabled', 'disabled');
    var data_ajax={
	    type: 'POST',
	    url: "/empaque_demo/insertPolimeroFactFinal.php",
	    data: {
		    xId : $("#idPolimero").val(),
		    xDe : descuenta,
		    xIm : importe
		  },
	    success: function( data ) {
				$('#modal_importes').modal('hide');
				location.reload();
		    },
	    error: function(){
				$("#modal_errores").modal('show');
				$("#errorMsj").text("Error de Conexión");
				$('#btn_acept').removeAttr('disabled');
			      },
	    dataType: 'json'
	    };
    
    $.ajax(data_ajax);
});

function calcularPor()
{
    if(!isNaN($("#porc").val()) && $("#porc").val() != "")
    {
	var porc = parseFloat($("#porc").val()).toFixed(2);
	
	if (porc > 0) {
	    importe = (porc * importeTotal) / 100;
	    $("#spanP").html("$ " + importe.toFixed(2));   
	}
	else
	{
	    $("#spanP").html("$ 0.00");   
	}
    }
    else
    {
	$("#spanP").html("$ 0.00");
    }
}

function soloNumeros(e) 
{ 
    var key = window.Event ? e.which : e.keyCode 
    return ((key >= 48 && key <= 57) || (key==8) || (key==46)) 
}

function openLog(idPolimero, idPedido, trabajo, npdido, cliente)
{
    var texto = "Seguimiento de Polímero <br> Número: " + idPedido+"";
    var detalle = "<b>Trabajo:</b>" + trabajo + "<br> <b>Nota de Pedido referencia: </b>" + npdido + "<br><b>Cliente:</b>" + cliente;
    
    $("#titlePolimeroLog").html(texto);
    $("#detailPolimero").html(detalle);
    $("#logpolimeros").html('');
    $("#modal_polimero_log").modal('show');
    
    var tabla = '<table style="width: 100%; font-size: 10px;">';
    
    var data_ajax={
	    type: 'POST',
	    url: "/empaque_demo/getLogPolimero.php",
	    data: {
		    xId : idPolimero
		  },
	    success: function( data ) {
			var status = "";
			var yaPaso = false;
			$(data).each(function( index ){
			    if (yaPaso == false) {
				if (this['polimeroEstado'] != "Z" &&
				    this['polimeroEstado'] != "X" &&
				    this['polimeroEstado'] != "M" &&
				    this['polimeroEstado'] != "Q") {
				    status = this['polimeroEstado'];
				    yaPaso = true;
				}
			    }
			    tabla += '<tr><td><b>Estado:</b>';
			    tabla += (this['observacion'] == "Autorización de Facturación") ? getEstatus("XX") : getEstatus(this['polimeroEstado']);
			    tabla += '<br><b>Fecha:</b>'
			    tabla += formatDate(this['logFecha']);
			    tabla += '<br><b>Usuario:</b>'+this['nombre']+'</td>';
			    tabla += '</td><td>'+(this['observacion'] == null ? '-' : this['observacion'])+'</td></tr>';
			    tabla += '<tr><td colspan="2"><hr></td></tr>';
			    //alert(this);
			});
			tabla += '</table>';
			$("#logpolimeros").html(tabla);
			setStatusBar(status);
		    },
	    error: function(){
				$("#logpolimeros").html('Error de conexión.');
			      },
	    dataType: 'json'
	    };
    
    $.ajax(data_ajax);
    
    var data_ajax2={
	    type: 'POST',
	    url: "/empaque_demo/getCliente.php",
	    data: {
		    xId : idPolimero
		  },
	    success: function( data ) {
			var status = "";
			var yaPaso = false;
			$(data).each(function( index ){
			    if (yaPaso == false) {
				if (this['polimeroEstado'] != "Z" &&
				    this['polimeroEstado'] != "X" &&
				    this['polimeroEstado'] != "M" &&
				    this['polimeroEstado'] != "Q") {
				    status = this['polimeroEstado'];
				    yaPaso = true;
				}
			    }
			    tabla += '<tr><td><b>Estado:</b>';
			    tabla += (this['observacion'] == "Autorización de Facturación") ? getEstatus("XX") : getEstatus(this['polimeroEstado']);
			    tabla += '<br><b>Fecha:</b>'
			    tabla += formatDate(this['logFecha']);
			    tabla += '<br><b>Usuario:</b>'+this['nombre']+'</td>';
			    tabla += '</td><td>'+(this['observacion'] == null ? '-' : this['observacion'])+'</td></tr>';
			    tabla += '<tr><td colspan="2"><hr></td></tr>';
			    //alert(this);
			});
			tabla += '</table>';
			$("#logpolimeros").html(tabla);
			setStatusBar(status);
		    },
	    error: function(){
				$("#logpolimeros").html('Error de conexión.');
			      },
	    dataType: 'json'
	    };
    
    $.ajax(data_ajax2);
}

function getEstatus(code) {
    switch (code) {
	case "TP":
	    return "Enviado a Aprob. de Borradores";
	    break;
	case "AP":
	    return "Borrado Aprobado";
	    break;
	case "A":
	    return "Preprensa empaque";
	    break;
	case "C":
	    return "Borradores en producción";
	    break;
	case "E":
	    return "Borradores ap. a preprensa";
	    break;
	case "G":
	    return "Preprensa en proveedor";
	    break;
	case "H":
	    return "Confección de polímero";
	    break;
	case "I":
	    return "Polímero en calidad";
	    break;
	case "K":
	    return "Producción / impresión";
	    break;
	case "N":
	    return "Corrección (Prod./Imp.)";
	    break;
	case "F":
	    return "Corrección (Borr. en Prod.)";
	    break;
	case "J":
	    return "Corrección (Conf. de Pol.)";
	    break;
	case "L":
	    return "Rehacer (Pol. en Calidad)";
	    break;
	case "Z":
	    return "Polímero en StandBy";
	    break;
	case "X":
	    return "Polímero Reactivado (" + code + ")";
	    break;
	case "M":
	    return "Polímero Archivado";
	    break;
	case "Q":
	    return "Autorización Fact. Polímeros";
	    break;
	case "XX":
	    return "Facturación Autorizada";
	    break;
	case "MO":
	case "RV":
	    return "Borrador Correjido";
	    break;
	//--------------------------
	case "DI":
	    return "Ingreso en Preprensa";
	    break;
	case "CL":
	    return "Enviado aprob. de Cliente";
	    break;
	case "AC":
	    return "Aprobado por el Cliente";
	    break;
	case "NA":
	    return "NO Aprobado por el Cliente";
	    break;
	case "CR":
	    return "Generar Polímero";
	    break;
	case "RN":
	    return "Rehacer Pedido";
	    break;
	case "NO":
	    return "Borrador Rechazado";
	    break;
	//---------------------------
	default:
	    return "Op. no definida. ("+code+")";
    }
}
function setStatusBar(code)
{
    $("#status1").removeClass('label-warning');
    $("#status2").removeClass('label-warning');
    $("#status3").removeClass('label-warning');
    $("#status4").removeClass('label-warning');
    $("#status5").removeClass('label-warning');
    $("#status6").removeClass('label-warning');
    $("#status7").removeClass('label-warning');
    $("#status8").removeClass('label-warning');
    $("#status9").removeClass('label-warning');
    $("#status10").removeClass('label-warning');
    
    $("#status1").removeClass('label-success');
    $("#status2").removeClass('label-success');
    $("#status3").removeClass('label-success');
    $("#status4").removeClass('label-success');
    $("#status5").removeClass('label-success');
    $("#status6").removeClass('label-success');
    $("#status7").removeClass('label-success');
    $("#status8").removeClass('label-success');
    $("#status9").removeClass('label-success');
    $("#status10").removeClass('label-warning');
    
    switch (code) {
	case "N":
	
	case "DI":
	case "NA":
	    $("#status1").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Ingreso en Preprensa.");
	    break;
	case "C":
	    
	case "CL":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Enviado aprob. de Cliente.");
	    break;
	case "E":
	case "AC":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Aprobado por el Cliente.");
	    break;
	case "J":
	case "L":
	    
	case "RV":
	case "TP":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Enviado aprob. de Borradores.");
	    break;
	    
	case "CR":
	case "AP":
	case "MO":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Borrador Aprobado.");
	    break;
	    
	case "A":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Preprensa Empaque.");
	    break;
	    
	case "G":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Preprensa en Proveedor.");
	    break;
	
	case "H":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-warning');
	    $("#status8").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Confección de Polímeros.");
	    break;
	
	case "I":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-warning');
	    $("#status8").addClass('label-warning');
	    $("#status9").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Polímero en Calidad.");
	    break;
	
	case "K":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-warning');
	    $("#status8").addClass('label-warning');
	    $("#status9").addClass('label-warning');
	    $("#status10").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Producción/Impresión.");
	    break;
	
	default:
	    $("#estadoActual").html("<strong>Estado Actual:</strong> -.");
    }
}

function formatDate(date)
{
    var dates = date.split(" ");
    
    var day = dates[0].split("-");
    
    return day[2]+"-"+day[1]+"-"+day[0]+" "+dates[1];
}

function ImprimirPolimero(sql){
    //impresion individual
    window.open("impresionComprobantes.php?documento=6&id="+sql, "PopUp", "menubar=1,width=1000,height=900");
}

function ImprimirReporte(sql){
    //impresion individual
    window.open("impresionComprobantes.php?documento=4&id="+sql, "PopUp", "menubar=1,width=1000,height=900");
}

  $("#buscador_txt").keypress(function(e) {
    if(e.which == 13) {
	if ($("#buscador_txt").val() != "") {
	    var accion = $("#actionValue").val();
	    var query = $("#buscador_txt").val();
	    window.location.replace("../empaque_demo/listadoPolimero.php?accion="+accion+"&page=0&query="+query+"");
		//alert(accion + ' - ' + query);
	}
    }
  });
</script>