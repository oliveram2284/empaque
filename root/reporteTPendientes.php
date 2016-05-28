<?php

session_start();

$nombre = substr($_SESSION['Nombre'], 0, 2);

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}	
$idUsuario = $_SESSION['id_usuario'];
$esAdmin = $_SESSION['admin'];

require("header.php");

include("conexion.php");

$var = new conexion();
$var->conectarse();
 ?>
 
 <!-- Include Bootstrap Multiselect CSS, JS -->
<link rel="stylesheet" href="assest/dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="assest/dist/js/bootstrap-multiselect.js"></script>
<!-------------------------------------------->

 <form id="reportePolimeros" name="reportePolimeros" method="post">
 <div class="container">
        <div class="well"  id="titulo_main">
                <div class="page-header">
		<h2>
		      Trabajos Pendientes
		</h2>
		</div>
		<input type="hidden" id="orden_rep" value="Asc">
		<input type="hidden" id="campo_ord" value="1">
	<div class="row">
	 <div class="span10">
	   
	   <!--------->
	   <table>
	     <tr>
                <td><input type="checkbox" name="Cliente" id="Cliente" onClick="habilitar('Cliente','idCliente','clienteBand')"> Cliente:</td>
                <td>
		 <div id="_idCliente" class="control-group ok">
		  <input type="text" name="idCliente" id="idCliente" readonly="readonly" onclick="clienteClick()"/>
		  <input type="hidden" id="idCli">
		 </div>
		</td>
                <td><input type="checkbox" name="Articu" id="Articu" onClick="habilitar('Articu','idArticu')"> Artículo:</td>
                <td>
		 <div id="_idArticu" class="control-group ok">
		  <input type="text" name="idArticu" id="idArticu" readonly="readonly" onclick="articuloClick()"/>
		  <input type="hidden" id="idArt">
		 </div>
		</td>
                <td colspan="2">
		<!--    <input type="checkbox" name="Estados" id="Estados" onClick="habilitar('Estados','idEstados')"> Estado:</td>
		    <td>-->
		  <div id="_idEstados" class="control-group ok">
                    <!--<select name="idEstados" id="idEstados" style="width:145px" readonly="readonly" >
                		<option value="0" selected="selected">Estados</option>
				<option value="I">Ingresado</option>
				<option value="A">Recibidos</option>
				<option value="R">Rechazado</option>
				<option value="C">Cancelado</option>
				<option value="N">Diseñado</option>
				<option value="AP">Aprobación de Producción</option>
				<option value="CA">Generando Polímero</option>
				<option value="P">Producción</option>
				<option value="U">Curso</option>
				<option value="TP">Terminado Parcial</option>
				<option value="T">Terminado</option>
                    </select>-->
		    <script type="text/javascript">
			$(document).ready(function() {
			    $('#idEstados').multiselect();
			});
		    </script>
		    <center>
		    Estados<br>
		    </center>
		    <select id="idEstados" id="idEstados" multiple="multiple">
			<option value="A">Emitidos</option>
			<option value="B">Recibidos</option>
			<option value="C">Preprensa</option>
			<option value="D">Producción</option>
			<option value="E">Curso</option>
			<!--<option value="F">Terminados</option>-->
			<option value="G">Terminados Parcial</option>
			<!--<option value="H">Cancelados</option>-->
			<option value="I">Rechazados</option>
		    </select>
		  </div>
                </td>
	     </tr>
             <tr>
                <td>
                    <?php 
                    if($esAdmin == 1)
                        {
                    ?>
                    <input type="checkbox" name="Usuario" id="Usuario" onClick="habilitar('Usuario','idUsuario')"> Vendedor:</td>
                    <?php
                        }
                        else
                        {
                            ?>
                            <input type="checkbox" name="Usuario" id="Usuario" onClick="habilitar('Usuario','idUsuario')" disabled="false" title="No habilitado para este usuario">
                            Vendedor:</td>
                            <?php
                        }
                    ?>
                <td>
		 <div id="_idUsuario" class="control-group ok">
		  <input type="text" name="idUsuario" id="idUsuario" readonly="readonly" onclick="usuarioClick()"/>
		  <input type="hidden" id="idUs">
		 </div>
		</td>
                <td> Fecha:</td>
                <td colspan="3">
		 <div id="_idFecha" class="control-group ok">
		    <?php
			$desde = "01-".date("m")."-".date("Y");
			$hasta = date("d-m-Y");
		    ?>		    
		  <input type="text" name="FechDesde" id="FechDesde" readonly size="9" value="<?php echo $desde;?>">
		  <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechDesde,'dd-mm-yyyy',this);return false;" id="fDes">
		  &nbsp;&nbsp;A&nbsp;&nbsp;
		  <input type="text" name="FechHasta" id="FechHasta" readonly size="9" value="<?php echo $hasta;?>">
		  <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechHasta,'dd-mm-yyyy',this);return false;" id="fHas">
		 </div>
                </td>
            </tr>
            <tr>
            	<td colspan="6">
                <br>
                    <input type="button" class="btn btn-danger" value="Atrás" onClick="Principal()">
		     <input type="button" class="btn btn-success" value="Aceptar" onClick="Validar()">
		</td>
	     </tr>
	   </table>
	 </div>
	</div>
	<hr>
	<div id="div_find">
	  <b><i>No se cargaron resultados.</i></b>
	</div>
 </div>
 <input type="hidden" name="orderByField" value=", ped.codigo ASC">
 </form>
 
 <!-- Pop Clientes -->
<div class="modal hide fade" id="ClientesPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Clientes</h3>
  </div>
  <div class="modal-body">
    
	<strong>Buscar :   </strong>  <input type="text" id="buscador" onkeyup="BuscadorDeClientes(this.value)"><br><br>
	<div id="resultado_Cliente" style="width: 90%; min-height: 250px; max-height: 250px;">
	
	</div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('ClientesPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Clientes -->

<!-- Pop Artículos -->
<div class="modal hide fade" id="ArticulosPop" style="width: 900px; margin-left: -450px;">
  <div class="modal-header">
    <input type="hidden" id="busc" value="1">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Productos</h3>
  </div>
  <div class="modal-body">
    
     <table>
		<tr>
			<td><strong>Buscar :   </strong>  <input type="text" id="buscadorP" onkeyup="BuscadorDeProductos(this.value, 1)"></td>
			<td>
				<div class="btn-group" data-toggle="buttons-radio" style="margin-top: -8px;">
					<button type="button" class="btn btn-primary active" onclick="setear(1)">  </button>
					<button type="button" class="btn btn-primary" onclick="setear(2)">+</button>
					<button type="button" class="btn btn-primary" onclick="setear(3)">-</button>
					<button type="button" class="btn btn-primary" onclick="setear(4)">+ -</button>
	    		        </div>
			</td>
		</tr>
	</table>
    <div id="resultado_Productos" style="width: 90%; min-height: 250px; max-height: 250px;">
	
    </div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('ArticulosPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Artículos -->

 <!-- Pop Usuarios -->
<div class="modal hide fade" id="UsariosPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Usuarios </h3>
  </div>
  <div class="modal-body">
    
	<strong>Buscar :   </strong>  <input type="text" id="buscadorU" onkeyup="BuscadorDeUsuarios(this.value)"><br><br>
	<div id="resultado_Usuarios" style="width: 90%; min-height: 250px; max-height: 250px;">
	
	</div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('UsariosPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Usuarios -->

 <!-- Pop Mensajes de Error -->
<div class="modal hide fade" id="ErrorPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 style="color: red">Error!!</h3>
  </div>
  <div class="modal-body">
    <br>
    <div id="msj_error_pop" class="alert alert-error">
	
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('ErrorPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Mensajes de Error -->

<!-- Modal para el seguimiento de pedido-->
<div class="modal hide fade" id="modal_seguimiento">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Seguimiento de Pedido <strong><label id="idC" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <table width="100%">
	<tr>
		<td colspan="2" align="center">
			<div class="alert alert-error" id="error_div" style="display: none">
				<label id="error_msj" style="margin-top: 9px"></label>
			</div>
		</td>
	</tr>
        <tr>
          <td colspan="2">
		<div style="width: 100%; height: 200px;" id="div_seguimiento">
			
		</div>
	  </td>
        </tr>
      </table>
    </p>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Seguimiento de Pedido</i></strong>
  </div>
</div>
<!-- End seguimiento de pedido-->

<!-- Sub Modal para HR/CI -->
<div class="modal hide fade" id="modal_entregas_hrci">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Hojas de Ruta / Comunicaciones Internas</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
	<div id="HrList" style="width: 90%; text-align: left; height: 400px; background-color: #E6E6E6;">
	    
	</div>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Hojas de Ruta / Comunicaciones Internas</i></strong>
  </div>
</div>
<!-- -->

<!-- Sub Modal para Entregas -->
<div class="modal hide fade" id="modal_entregas_entregas">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Entregas</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
	<table id="EntList" style="width: 90%; text-align: left; background-color: #E6E6E6;">
	    
	</table>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Entregas</i></strong>
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

 <!-- Pop Info -->
<div class="modal hide fade" id="InfoPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="titleInfo">Información de Nota de Pedido </h3>
  </div>
  <div class="modal-body">
    
	<div class="row">
	    <!-- imprimir Nota de Pedido -->
	    <div class="span1 offset1">
		<div style="height: 35px;font-size: 13px; width: 100px;cursor: pointer;" class="btn btn-warning" onclick="infoNP()">
		    <img src="assest/plugins/buttons/icons/zoom.png"><br>
		    <b>Nota de Pedido</b>
		</div>
	    </div>
	    <!-- HR / CI -->
	    <div class="span1 offset1">
		<div style="height: 35px;font-size: 15px; width: 100px;cursor: pointer;" class="btn btn-success" onclick="infoCIHR()" id="infoCIHR_btn">
		    <img src="assest/plugins/buttons/icons/page_white_text.png"><br>
		    <b>HR / CI</b>
		</div>
	    </div>
	</div>
	<br>
	<div class="row">
	    <!-- Entregas -->
	    <div class="span1 offset1">
		<div style="height: 35px;font-size: 15px; width: 100px;cursor: pointer;" class="btn btn-danger" onclick="infoENT()">
		    <img src="assest/plugins/buttons/icons/box.png"><br>
		    <b>Entregas</b>
		</div>
	    </div>
	    <!-- log de NP -->
	    <div class="span1 offset1">
		<div style="height: 35px;font-size: 15px; width: 100px;cursor: pointer;" class="btn btn-primary" onclick="infoSeguimiento()">
		    <img src="assest/plugins/buttons/icons/application_view_list.png"><br>
		    <b>Log NP.</b>
		</div>
	    </div>
	</div>
	<br>
	<div class="row">
	    <!-- log de Polimero  -->
	    <div class="span1 offset1">
		<div style="height: 35px;font-size: 15px; width: 100px;cursor: pointer;" class="btn btn-info" id="infoLogPol_btn" onclick="infoSeguimientoPol()">
		    <img src="assest/plugins/buttons/icons/text_list_bullets.png"><br>
		    <b>Log Polímero</b>
		</div>
	    </div>
	    <!-- Polímero -->
	    <div class="span1 offset1">
		<div style="height: 35px;font-size: 15px; width: 100px;cursor: pointer;" class="btn btn-inverse" id="poliCheckList" onclick="openCheckList()">
		    <img src="assest/plugins/buttons/icons/application_view_tile.png"><br>
		    <b>Polímero</b>
		</div>
	    </div>
	</div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('InfoPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Info -->

<?php

require("footer.php");

?>
 
 <script>
    $( document ).ready(function() {
	$( document ).tooltip();
    });
    
    function getLogPolimero(id)
    {
	alert(id);
	$("#modal_polimero_log").modal('show');
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
		url: "/empaque/getLogPolimero.php",
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
		url: "/empaque/getCliente.php",
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
    
    function getHojaRuta(idPedido) {
	$("#HrList").html("");
	var data_ajax={
		      type: 'POST',
		      url: "/empaque/gethrci.php",
		      data: { id: idPedido },
		      success: function( data ) {
				    
				    $.each(data, function(k,v){
					    $.each(v, function(i,j)
						    {
							$("#HrList").append( "<b>- " + j + "</p><br>" );
						    });
				    });
				    $('#modal_entregas_hrci').modal('show');
			      },
		      error: function(){
					  alert("Error de conexión.");
					},
		      dataType: 'json'
		      };
	      
	$.ajax(data_ajax);
    }
    
    function openET(idPedido)
{
    $("#EntList").html("");
    
    var data_ajax={
		  type: 'POST',
		  url: "/empaque/getEntregas.php",
		  data: { id: idPedido },
		  success: function( data ) {
				$("#EntList").append('<tr><th width="70">Kg.</th><th width="70">Un.</th><th width="70">Bu.</th><th>Fecha</th><th>Usuario</th></tr>');
				$("#EntList").append( "<tr style=\"font-size:10px;\"><td colspan=\"5\"><hr></td></tr>");
				var totKg = 0;
				var totCant = 0;
				var totBul = 0;
				$.each(data, function(k,v){
					var cant = "";
					var kg 	= "";
					var bul = "";
					var fec = "";
					var us 	= "";
					$.each(v, function(i,j)
						{
						    switch(i)
						    {
							case "cantidad":
							    cant = j;
							    totCant += parseFloat(cant);
							    break;
							case "kg":
							    kg = j;
							    totKg += parseFloat(kg);
							    break;
							case "bultos":
							    bul = j;
							    totBul += parseInt(bul);
							    break;
							case "fecha":
							    fec = j;
							    break;
							case "userId":
							    us = j;
							    break;
						    }
						});
					
					 $("#EntList").append( "<tr style=\"font-size:11px;\"><td>"+kg+"</td><td>"+cant+"</td><td>"+bul+"</td><td>"+fec+"</td><td>"+us+"</td></tr>");
					 $("#EntList").append( "<tr style=\"font-size:2px;\"><td colspan=\"5\"><hr></td></tr>");
				});
				$("#EntList").append( "<tr style=\"font-size:15px;\"><td><strong>"+totKg.toFixed(2)+"</strong></td><td><strong>"+totCant.toFixed(2)+"</strong></td><td><strong>"+totBul+"</strong></td><td colspan=\"2\"><strong>Totales</strong></td></tr>");
				$("#modal_entregas_entregas").modal('show');
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
    $.ajax(data_ajax);
}
  function openLogPedido(id) {
    alert(id);
  }
  
  var idClienteBand = 'false';
  var idArticuBand = false;
  var idEstadosBand = false;
  var idUsuarioBand = false;
  var fechasBand = false;
  
 function Principal()
 	{
		document.reportePolimeros.action = "principal.php";
		document.reportePolimeros.submit();
	}
 function habilitar(id,camp,band)
	{
		if(document.getElementById(id).checked)
		{
			document.getElementById(camp).disabled=false;
			$("#_"+camp).removeClass("control-group ok");
			$("#_"+camp).addClass("control-group error");
			asginaValor(camp, true);
		}
			else
			{
				document.getElementById(camp).disabled=true;
				$("#_"+camp).removeClass("control-group error");
				$("#_"+camp).addClass("control-group ok");
				asginaValor(camp, false);
			}
	}
function habilitarFechas(id,desde,hasta)
	{
		if(document.getElementById(id).checked)
			{
				document.getElementById(desde).style.visibility = "visible";
				document.getElementById(hasta).style.visibility = "visible";
				$("#_idFecha").removeClass("control-group ok");
				$("#_idFecha").addClass("control-group error");
			}else
			{
				document.getElementById(desde).style.visibility = "collapse";
				document.getElementById(hasta).style.visibility = "collapse";
				$("#_idFecha").removeClass("control-group error");
				$("#_idFecha").addClass("control-group ok");
			}
	}
	
function asginaValor(id, value)
{
  switch(id)
  {
    case "idCliente":
	 idClienteBand = value;
	 $("#idCliente").val("");
	 $("#idCli").val("");
     break;
    case "idArticu":
	 idArticuBand = value;
	 $("#idArticu").val("");
	 $("#idArt").val("");
     break;
    case "idEstados":
	 idEstadosBand = value;
     break;
    case "idUsuario":
	 idUsuarioBand = value;
	 $("#idUsuario").val("");
	 $("#idUs").val("");
     break;
    case "fechas":
	 fechasBand = value;
     break;
  }
}
	
function clienteClick()
{
 if(idClienteBand == true)
 {
     $("#ClientesPop").modal('show');
     setTimeout(function () { $("#buscador").focus(); }, 1000);
 }
     
}

function articuloClick()
{
 if(idArticuBand == true)
 {
     $("#ArticulosPop").modal('show');
     setTimeout(function () { $("#buscadorP").focus(); }, 1000);
 }
}

function usuarioClick()
{
 if(idUsuarioBand == true)
 {
     $("#UsariosPop").modal('show');
     setTimeout(function () { $("#buscadorU").focus(); }, 1000);
 }
}

var idNP;
var ComInterna;
var HojaRuta;
var noClick;
var codeNP;
var infoPolimero;
var infoCliente;
var infoCaras;
var infoTrabajo;
var infoOT;
var noClickPol;

function openInfoPop(code, id, CI, HR, poli, client, caras, trabajo, ot) {
    $("#titleInfo").html("Información de Nota de Pedido : " + code );
    $("#InfoPop").modal('show');
    idNP = id;
    ComInterna = CI;
    HojaRuta = HR;
    codeNP = code;
    infoPolimero = poli;
    infoCliente = client;
    infoCaras = caras;
    infoTrabajo = trabajo;
    infoOT = ot;
    noClickPol = 0;
    
    if (ComInterna == null || ComInterna == '') {
	if (HojaRuta == 1) {
	    $("#infoCIHR_btn").attr("disabled", false);
	    $("#infoCIHR_btn").removeClass("btn-default");
	    $("#infoCIHR_btn").addClass("btn-success");
	    noClick = 1;
	}else{
	    $("#infoCIHR_btn").attr("disabled", true);
	    $("#infoCIHR_btn").addClass("btn-default");
	    $("#infoCIHR_btn").removeClass("btn-success");
	    noClick = 0;
	}
    }else{
	$("#infoCIHR_btn").attr("disabled", false);
	$("#infoCIHR_btn").removeClass("btn-default");
	$("#infoCIHR_btn").addClass("btn-success");
	noClick = 1;
    }
    
    if (caras == 0){
	//deshabilitar boton
	$("#infoLogPol_btn").attr("disabled", true);
	$("#infoLogPol_btn").removeClass("btn-info");
	$("#infoLogPol_btn").addClass("btn-default");
	$("#poliCheckList").attr("disabled", true);
	$("#poliCheckList").removeClass("btn-inverse");
	$("#poliCheckList").addClass("btn-default");
    }
    else
    {
	if (poli != 0 && poli != null) {
	    //habilitar boton
	    $("#infoLogPol_btn").attr("disabled", false);
	    $("#infoLogPol_btn").removeClass("btn-default");
	    $("#infoLogPol_btn").addClass("btn-info");
	    $("#poliCheckList").attr("disabled", false);
	    $("#poliCheckList").removeClass("btn-default");
	    $("#poliCheckList").addClass("btn-inverse");
	    noClickPol = 1;
	}
	else
	{
	    //deshabilitar boton
	    $("#infoLogPol_btn").attr("disabled", true);
	    $("#infoLogPol_btn").removeClass("btn-info");
	    $("#infoLogPol_btn").addClass("btn-default");
	    $("#poliCheckList").attr("disabled", true);
	    $("#poliCheckList").removeClass("btn-inverse");
	    $("#poliCheckList").addClass("btn-default");
	}
    }
}

function infoNP() {
    $("#InfoPop").modal('hide');
    ImprimirReporte(idNP);
}

function infoCIHR() {
    if (noClick == 1) {
	$("#InfoPop").modal('hide');
	getHojaRuta(idNP);
    }
}

function SumarORestarTodos(object){
    if (object.checked == true) {
	//sumar
	var total = 0;
	$(".sumadores").each(function( i ) {
	    total += parseInt(this.value);
	    this.checked = true;
	});
	$("#matTot").html(total.toLocaleString());
    }else{
	//restar
	$(".sumadores").each(function( i ) {
	    this.checked = false;
	});
	$("#matTot").html("0");
    }
}

function SumarORestar(value, object){
    var valuee = $("#matTot").html();
    valuee = valuee.replace(/\./g,'');
    var total = parseInt(valuee);
    if (object.checked == true) {
	//sumar
	total += value;
	
    }else{
	//restar
	total -= value;
    }
    $("#matTot").html(total.toLocaleString());
}

function infoENT()
{
    $("#InfoPop").modal('hide');
    openET(idNP);
}

function infoSeguimiento() {
    $("#InfoPop").modal('hide');
    Seguimiento(idNP, codeNP);
}

function infoSeguimientoPol() {
    if (noClickPol == 1) {
	$("#InfoPop").modal('hide');
	openLog(infoPolimero,infoOT,infoTrabajo,codeNP,infoCliente);
    }
}

function openCheckList() {
    if (noClickPol == 1) {
	$("#InfoPop").modal('hide');
	ImprimirPolimero(infoPolimero);
    }
}

function ImprimirPolimero(sql){
    //impresion individual
    window.open("impresionComprobantes.php?documento=6&id="+sql, "PopUp", "menubar=1,width=1000,height=900");
}

//function for search customers
function BuscadorDeClientes(value)
	{
		var input = [];
		input.push(value);
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque/buscarCliente.php",
				data: { xinput: input },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%;">';
								fila +='<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th>Razón Social</th></tr></thead>';
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
												 if(i == "cod_client")//<i class="iconic-o-check" style="color: #51A351"></i>
												 {
													//Icono  accept
													fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+j+'" onClick="Seleccionado(\''+j+'\')">';
													fila +='<td>';
													fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
													fila +='</td>';
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+j+'_c" value="'+j+'">';
													idCodigo = j;
												 }
												 if(i == "razon_soci")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_rz" value="'+j+'">';
												 }
												 if(i == "nom_com")
												 {
													fila += '<input type="hidden" id="'+idCodigo+'_n" value="'+j+'">';
												 }
											       }
											      );
										    
										    fila += "</tr>";
										    
										}
										
									       );
								fila += "</tbody></table>";
								
								$("#resultado_Cliente").html(fila);
								
							    }
							    else
							    {
								$("#resultado_Cliente").html('<strong style="color: red;">No se encontraron resultados</strong>');
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}
	
function Seleccionado(valor)
	{
		//tomar id pasado y buscar los valor para los campos correspondientes al cliente
		var id = "#"+valor+"_c";
		var rz = "#"+valor+"_rz";
		
		$("#idCliente").val($(rz).val());
		$("#idCli").val($(id).val());
		
		ClosePop("ClientesPop");
	}

//function for search articles
function BuscadorDeProductos(value, page)
	{
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque/buscarProducto.php",
				data: { xinput: value, xpage: page , busq: $('#busc').val() },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%; font-size: 10px;">';
								fila +='<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th style="width: 500px;">Artículo</th><th>Código Producto</th></tr></thead>';
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
												 if(i == "Id")
												 {
													//Icono
													fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+j+'" onClick="SeleccionadoP(\''+j+'\')">';
													fila +='<td>';
													fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>'; 
													fila +='</td>';
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+j+'_cp" value="'+j+'">';
													idCodigo = j;
												 } 
												 if(i == "Articulo")
												 {
													fila +='<td style="padding-left: 10px;">'+j+'</td>';
													fila += '<input type="hidden" id="'+idCodigo+'_arp" value="'+j+'">';
												 }
												 if(i == "Nombre_en_Facturacion")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_ncp" value="'+j+'">';
												 }
												 
											       }
											      );
										    
										    fila += "</tr>";
										    
										}
										
									       );
								fila += "</tbody></table>";
								
								$("#resultado_Productos").html(fila);
								
							    }
							    else
							    {
								$("#resultado_Productos").html('<strong style="color: red;">No se encontraron resultados</strong>');
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);		
	}

function SeleccionadoP(valor)
	{
		//tomar id pasado y buscar los valor para los campos correspondientes al producto
		var ar = "#"+valor+"_arp";
		//var nc = "#"+valor+"_ncp";
		
		$("#idArt").val(valor);
		$("#idArticu").val($(ar).val());
		//$("#descripcionProducto").val($(nc).val());
		
		ClosePop("ArticulosPop");
	}	

function BuscadorDeUsuarios(value)
	{
	        var input = value;
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque/buscarUsuarios.php",
				data: { xinput: input },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%;">';
								fila +='<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th>Nombre</th></tr></thead>';
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
												 if(i == "id_usuario")
												 {
													//Icono  accept
													fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+j+'" onClick="SeleccionadoU(\''+j+'\')">';
													fila +='<td>';
													fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
													fila +='</td>';
													fila += '<input type="hidden" id="'+j+'_cu" value="'+j+'">';
													idCodigo = j;
												 }
												 if(i == "nombre")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_no" value="'+j+'">';
												 }
												 if(i == "nombre_real")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_nc" value="'+j+'">';
												 }
											       }
											      );
										    
										    fila += "</tr>";
										    
										}
										
									       );
								fila += "</tbody></table>";
								
								$("#resultado_Usuarios").html(fila);
								
							    }
							    else
							    {
								$("#resultado_Usuarios").html('<strong style="color: red;">No se encontraron resultados</strong>');
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}

function SeleccionadoU(code)
{
	//tomar id pasado y buscar los valor para los campos correspondientes al producto
	 var nc = "#"+code+"_nc";
	 
	 $("#idUs").val(code);
	 $("#idUsuario").val($(nc).val());
	 //$("#descripcionProducto").val($(nc).val());
	 
	 ClosePop("UsariosPop");
}
function ClosePop(div)
{
	var idDiv = "#"+div;
	$(idDiv).modal('hide');			
}
/***********************************************************/
function Validar(value)
	{
	if(
           !(document.getElementById('Cliente').checked) && !(document.getElementById('Articu').checked) && 
           !(document.getElementById('Usuario').checked)
          )	
			{
				//ninguno chequeado
				var filtros = "";
				//El de estados va siempre
				var selectedValues = $('#idEstados').val();
				
				if(selectedValues == null)
					{
						if(filtros == "")
							filtros = 3 + ":0";
							else
							filtros = filtros + "~" + 3 + ":0";
					}else 
					{
						if(filtros == "")
							filtros = 3 + ":" + selectedValues;
							else
							filtros = filtros + "~" + 3 + ":" + selectedValues;
					}
				//------------------------
				if(filtros == "")
					filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
					else
					filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
			
				if(value === undefined)
				    {
					$("#orden_rep").val("Asc");
				    }
				    else//
				    {
					if($("#campo_ord").val() == value)
					{
					    if($("#orden_rep").val() == "Asc")
					    {$("#orden_rep").val("Desc");}
					    else
					    {$("#orden_rep").val("Asc");}
					}
				    }
				$("#campo_ord").val(value);
				reporteAjax('div_find','reporteTPendientesphp.php',filtros);
			}
			else
				{
					var filtros = "";
					//aplicar filtro para el/los chequeados
					//si esta chequeado el Cliente -----------------------------
					if(document.getElementById('Cliente').checked)
						{
							if(document.getElementById('idCli').value == "")
								{
									$("#msj_error_pop").html("Seleccione un cliente válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									filtros = 1 + ":" + document.getElementById('idCli').value;
								}
						}
					//si esta chequeado el artículo -------------------------------
					if(document.getElementById('Articu').checked)
						{
							if(document.getElementById('idArt').value == "")
								{
									$("#msj_error_pop").html("Seleccione un artículo válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idArt').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idArt').value;
								}
						}
					//si esta chequeado el estado -----------------------------
					//if(document.getElementById('Estados').checked)
					//	{
					var selectedValues = $('#idEstados').val();
					
					if(selectedValues == null)
						{
							if(filtros == "")
								filtros = 3 + ":0";
								else
								filtros = filtros + "~" + 3 + ":0";
						}else 
						{
							if(filtros == "")
								filtros = 3 + ":" + selectedValues;
								else
								filtros = filtros + "~" + 3 + ":" + selectedValues;
						}
					//	}
					//si esta chequeado el vendedor --------------------------
					if(document.getElementById('Usuario').checked)
						{
						    if(document.getElementById('idUs').value == "")
							{
							    $("#msj_error_pop").html("Seleccione un usuario válido.");
							    $("#ErrorPop").modal("show");
							    return false;
							}else 
							{
								if(filtros == "")
									filtros = 4 + ":" + document.getElementById('idUs').value;
									else
									filtros = filtros + "~" + 4 + ":" + document.getElementById('idUs').value;
							}
						}
					//la fecha va siempre -------------------------------
					if(filtros == "")
						filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
						else
						filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
				
					if(value === undefined)
					    {
						$("#orden_rep").val("Asc");
					    }
					    else//
					    {
						if($("#campo_ord").val() == value)
						{
						    if($("#orden_rep").val() == "Asc")
						    {$("#orden_rep").val("Desc");}
						    else
						    {$("#orden_rep").val("Asc");}
						}
					    }
					$("#campo_ord").val(value);
					reporteAjax('div_find','reporteTPendientesphp.php',filtros);
					
					
				}
	}
var OrderByPedido = "DESC";
var OrderByCliente = "ASC";
var OrderByArticulo = "ASC";
var OrderByFechaEm = "ASC";
var OrderBy_ = "";

function orderBy(value)
{
    debugger;
  switch(value)
  {
   case "ped.codigo":
	OrderBy_ = ", "+value+" "+OrderByPedido;
	if(OrderByPedido == "ASC")
	 OrderByPedido = "DESC";
	 else OrderByPedido = "ASC";
    break;
   
   case "ped.clienteNombre":
	OrderBy_ = ", "+value+" "+OrderByCliente;
	if(OrderByCliente == "ASC")
	 OrderByCliente = "DESC";
	 else OrderByCliente = "ASC";
    break;
   
   case "ped.descripcion":
	OrderBy_ = ", "+value+" "+OrderByArticulo;
	if(OrderByArticulo == "ASC")
	 OrderByArticulo = "DESC";
	 else OrderByArticulo = "ASC";
    break;
   
   case "ped.femis":
	OrderBy_ = ", "+value+" "+OrderByFechaEm;
	if(OrderByFechaEm == "ASC")
	 OrderByFechaEm = "DESC";
	 else OrderByFechaEm = "ASC";
    break;
  }
  
  AjaxOrdenamiento('div_find', 'reportePedidosphpOrdenar.php', document.reportePolimeros.consul.value + OrderBy_);   
}

function ImprimirReporte(sql)
	{
	   if(isNaN(sql)== false)
        {
            //impresion individual
            window.open("impresionComprobantes.php?documento=4&id="+sql, "PopUp", "menubar=1,width=900,height=900");
        }else
        {
            //impresion de filtro 
            window.open("impresionComprobantes.php?documento=7&id="+sql, "PopUp", "menubar=1,width=900,height=900");
        }
	}	
    
function ExportarExcel()
	{
		window.open("archivoExcel.php?consulta="+document.getElementById('consulImpr').value, "PopUp", "menubar=1,width=300,height=300");
	}

function ExportarExcel1(condicion)
	{
		window.open("archivoExcel.php?consulta="+condicion, "PopUp", "menubar=1,width=300,height=300");
	}
	
 function ImprimirNuevo()
    {
        window.open("impresionComprobantes.php?documento=7&id="+document.getElementById('consulImpr').value, "PopUp", "menubar=1,width=900,height=900");
    }
//----------------- AJAX --------------------------------
function nuevoAjax1()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

function reporteAjax(div, archivo, filtros)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax1();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo+"?order="+ $("#orden_rep").val()+"&By="+$("#campo_ord").val(), true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+filtros);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
	
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

//...........................................................
//.. Funciones para ordenar el filtro para atributo .........
//...........................................................

function Ordenamiento(parametro, orden)
{
    var ParBus = "ORDER BY";
    
    switch(parametro)
        {
        //ordenar por numero de pedido
        case "1":
            ParBus = ParBus + " ped.npedido ";    
            break;
        //ordenar por cliente
        case "2":
            ParBus = ParBus + " cli.razon_soci ";    
            break;
        //ordenar por artículo
        case "3":
            ParBus = ParBus + " art.Articulo ";    
            break;
        //oredenar por fecha
        case "4":
            ParBus = ParBus + " ped.femis ";    
            break;
        default :
             
            break;
        }
    
    if(orden == "ASC")
    {
        ParBus = ParBus + " ASC ";
    }
    else
    {
        ParBus = ParBus + " DESC ";
    }
    alert($("#consul").val());
    AjaxOrdenamiento('div_find', 'reportePedidosphpOrdenar.php', document.reportePolimeros.consul.value + " " + ParBus);    
}
 
function AjaxOrdenamiento(div, archivo, consulta)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax1();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+consulta);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
	
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
			
		}
	}
}

//...........................................................
//Exportación de datos
function ValidarExportarPDF(value)
	{
	if(
           !(document.getElementById('Cliente').checked) && !(document.getElementById('Articu').checked) && 
           !(document.getElementById('Usuario').checked)
          )	
			{
				//ninguno chequeado
				var filtros = "";
				//El de estados va siempre
				var selectedValues = $('#idEstados').val();
				
				if(selectedValues == null)
					{
						if(filtros == "")
							filtros = 3 + ":0";
							else
							filtros = filtros + "~" + 3 + ":0";
					}else 
					{
						if(filtros == "")
							filtros = 3 + ":" + selectedValues;
							else
							filtros = filtros + "~" + 3 + ":" + selectedValues;
					}
				//------------------------
				if(filtros == "")
					filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
					else
					filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
			
				if(value === undefined)
				    {
					$("#orden_rep").val("Asc");
				    }
				    else//
				    {
					if($("#campo_ord").val() == value)
					{
					    if($("#orden_rep").val() == "Asc")
					    {$("#orden_rep").val("Desc");}
					    else
					    {$("#orden_rep").val("Asc");}
					}
				    }
				$("#campo_ord").val(value);
				reporteAjaxPDF('reporteTPendientesPDF.php',filtros);
			}
			else
				{
					var filtros = "";
					//aplicar filtro para el/los chequeados
					//si esta chequeado el Cliente -----------------------------
					if(document.getElementById('Cliente').checked)
						{
							if(document.getElementById('idCli').value == "")
								{
									$("#msj_error_pop").html("Seleccione un cliente válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									filtros = 1 + ":" + document.getElementById('idCli').value;
								}
						}
					//si esta chequeado el artículo -------------------------------
					if(document.getElementById('Articu').checked)
						{
							if(document.getElementById('idArt').value == "")
								{
									$("#msj_error_pop").html("Seleccione un artículo válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idArt').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idArt').value;
								}
						}
					//si esta chequeado el estado -----------------------------
					//if(document.getElementById('Estados').checked)
					//	{
					var selectedValues = $('#idEstados').val();
					
					if(selectedValues == null)
						{
							if(filtros == "")
								filtros = 3 + ":0";
								else
								filtros = filtros + "~" + 3 + ":0";
						}else 
						{
							if(filtros == "")
								filtros = 3 + ":" + selectedValues;
								else
								filtros = filtros + "~" + 3 + ":" + selectedValues;
						}
					//	}
					//si esta chequeado el vendedor --------------------------
					if(document.getElementById('Usuario').checked)
						{
						    if(document.getElementById('idUs').value == "")
							{
							    $("#msj_error_pop").html("Seleccione un usuario válido.");
							    $("#ErrorPop").modal("show");
							    return false;
							}else 
							{
								if(filtros == "")
									filtros = 4 + ":" + document.getElementById('idUs').value;
									else
									filtros = filtros + "~" + 4 + ":" + document.getElementById('idUs').value;
							}
						}
					//la fecha va siempre -------------------------------
					if(filtros == "")
						filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
						else
						filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
				
					if(value === undefined)
					    {
						$("#orden_rep").val("Asc");
					    }
					    else//
					    {
						if($("#campo_ord").val() == value)
						{
						    if($("#orden_rep").val() == "Asc")
						    {$("#orden_rep").val("Desc");}
						    else
						    {$("#orden_rep").val("Asc");}
						}
					    }
					$("#campo_ord").val(value);
					reporteAjaxPDF('reporteTPendientesPDF.php',filtros);
					
					
				}
	}

function ValidarExportarExcel(value)
	{
	if(
           !(document.getElementById('Cliente').checked) && !(document.getElementById('Articu').checked) && 
           !(document.getElementById('Usuario').checked)
          )	
			{
				//ninguno chequeado
				var filtros = "";
				//El de estados va siempre
				var selectedValues = $('#idEstados').val();
				
				if(selectedValues == null)
					{
						if(filtros == "")
							filtros = 3 + ":0";
							else
							filtros = filtros + "~" + 3 + ":0";
					}else 
					{
						if(filtros == "")
							filtros = 3 + ":" + selectedValues;
							else
							filtros = filtros + "~" + 3 + ":" + selectedValues;
					}
				//------------------------
				if(filtros == "")
					filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
					else
					filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
			
				if(value === undefined)
				    {
					$("#orden_rep").val("Asc");
				    }
				    else//
				    {
					if($("#campo_ord").val() == value)
					{
					    if($("#orden_rep").val() == "Asc")
					    {$("#orden_rep").val("Desc");}
					    else
					    {$("#orden_rep").val("Asc");}
					}
				    }
				$("#campo_ord").val(value);
				reporteAjaxPDF('reporteTPendientesEXCEL.php',filtros);
			}
			else
				{
					var filtros = "";
					//aplicar filtro para el/los chequeados
					//si esta chequeado el Cliente -----------------------------
					if(document.getElementById('Cliente').checked)
						{
							if(document.getElementById('idCli').value == "")
								{
									$("#msj_error_pop").html("Seleccione un cliente válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									filtros = 1 + ":" + document.getElementById('idCli').value;
								}
						}
					//si esta chequeado el artículo -------------------------------
					if(document.getElementById('Articu').checked)
						{
							if(document.getElementById('idArt').value == "")
								{
									$("#msj_error_pop").html("Seleccione un artículo válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idArt').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idArt').value;
								}
						}
					//si esta chequeado el estado -----------------------------
					//if(document.getElementById('Estados').checked)
					//	{
					var selectedValues = $('#idEstados').val();
					
					if(selectedValues == null)
						{
							if(filtros == "")
								filtros = 3 + ":0";
								else
								filtros = filtros + "~" + 3 + ":0";
						}else 
						{
							if(filtros == "")
								filtros = 3 + ":" + selectedValues;
								else
								filtros = filtros + "~" + 3 + ":" + selectedValues;
						}
					//	}
					//si esta chequeado el vendedor --------------------------
					if(document.getElementById('Usuario').checked)
						{
						    if(document.getElementById('idUs').value == "")
							{
							    $("#msj_error_pop").html("Seleccione un usuario válido.");
							    $("#ErrorPop").modal("show");
							    return false;
							}else 
							{
								if(filtros == "")
									filtros = 4 + ":" + document.getElementById('idUs').value;
									else
									filtros = filtros + "~" + 4 + ":" + document.getElementById('idUs').value;
							}
						}
					//la fecha va siempre -------------------------------
					if(filtros == "")
						filtros = 5  + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
						else
						filtros = filtros + "~" + 5 + ":" + document.getElementById('FechDesde').value + "/" + document.getElementById('FechHasta').value;
				
					if(value === undefined)
					    {
						$("#orden_rep").val("Asc");
					    }
					    else//
					    {
						if($("#campo_ord").val() == value)
						{
						    if($("#orden_rep").val() == "Asc")
						    {$("#orden_rep").val("Desc");}
						    else
						    {$("#orden_rep").val("Asc");}
						}
					    }
					$("#campo_ord").val(value);
					reporteAjaxPDF('reporteTPendientesEXCEL.php',filtros);
					
					
				}
	}

	
function reporteAjaxPDF(archivo, filtros)
{
	window.open(archivo+"?xfiltros="+filtros+"&order="+$("#orden_rep").val()+"&By="+$("#campo_ord").val(), "PopUp", "menubar=1,width=300,height=300");
}
//----------------------------------------------------------
 </script>