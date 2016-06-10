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
		      Reporte de Polímeros
		</h2>
		</div>
		<input type="hidden" id="orden_rep" value="Asc">
		<input type="hidden" id="campo_ord" value="1">
	<div class="row">
	 <div class="span10">
	   
	   <!--------->
	   <table style="width: 100%">
	     <tr>
                <td><input type="checkbox" name="Cliente" id="Cliente" onClick="habilitar('Cliente','idCliente','clienteBand')"> Cliente:</td>
                <td>
		 <div id="_idCliente" class="control-group ok">
		  <input type="text" name="idCliente" id="idCliente" readonly="readonly" onclick="clienteClick()"/>
		  <input type="hidden" id="idCli">
		 </div>
		</td>
		<td>
                    <input type="checkbox" name="Proveedor" id="Proveedor" onClick="habilitar('Proveedor','idProveedor')"> Proveedor:</td>
                <td>
		 <div id="_idProveedor" class="control-group ok">
		  <input type="text" name="idProveedor" id="idProveedor" readonly="readonly" onclick="usuarioClick()"/>
		  <input type="hidden" id="idPr">
		 </div>
		</td>
		<td rowspan="2" style="vertical-align: baseline">
		    
		    <script type="text/javascript">
			$(document).ready(function() {
			    $('#estados').multiselect();
			});
		    </script>
		    <center>
		    Estados<br>
		    </center>
		    <select id="estados" multiple="multiple">
			<option value="N">Ingreso en prepresnsa</option>
			<option value="C">Enviado aprob. de cliente</option>
			<option value="E">Aprobado por el cliente</option>
			<option value="RV">Enviado aprob. de borradores</option>
			<option value="AP">Borrador aprobado</option>
			<option value="A">Preprensa empaque</option>
			<option value="G">Preprensa en proveedor</option>
			<option value="H">Confección de polímeros</option>
			<option value="I">Polímero en calidad</option>
			<option value="K">Producción / Impresión</option>
			<option value="M">Archivado</option>
		    </select>
		</td>
	     </tr>
             <tr>
                
                <td> Fecha:</td>
                <td colspan="4">
		 <div id="_idFecha" class="control-group ok">
		    <?php
			$desde = "01-".date("m")."-".date("Y");
			$hasta = date("d-m-Y");
		    ?>		    
		  <input type="text" name="FechDesde" id="FechDesde" readonly size="9" value="<?php echo $desde;?>">
		  <img src="assest/plugins/buttons/icons/calendar.png" onClick="displayCalendar(FechDesde,'dd-mm-yyyy',this);return false;" id="fDes">
		  &nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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

 <!-- Pop Proveedor -->
<div class="modal hide fade" id="UsariosPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Proveedores </h3>
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

<!--------- End Pop Proveedor -->

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



<!-- Modal para ver log de polimeros -->
<div class="modal hide fade" id="modal_polimero_log">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="titlePolimeroLog"></h3>
  </div>
  <div class="modal-body">
    <div style="text-align : center; min-height: 80px; font-size: 12px;" id="detailPolimero">
    </div>
    <div style="text-align : center;">
	<span class="label" id="status1" style="font-size: 30px;">1</span>
	<span class="label" id="status2" style="font-size: 30px; margin-left: 25px;">2</span>
	<span class="label" id="status3" style="font-size: 30px; margin-left: 25px;">3</span>
	<span class="label" id="status4" style="font-size: 30px; margin-left: 25px;">4</span>
	<span class="label" id="status5" style="font-size: 30px; margin-left: 25px;">5</span>
	<span class="label" id="status6" style="font-size: 30px; margin-left: 25px;">6</span>
	<span class="label" id="status7" style="font-size: 30px; margin-left: 25px;">7</span>
    </div>
    <hr>
	<div id="logpolimeros" style="width: 100%; max-height: 250px; overflow-y: scroll; overflow-x: hidden;">
	    
	</div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-success" onclick="ChangeStatus_()">Aceptar</a>
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
	    return "Polímero temporal";
	    break;
	case "AP":
	    return "Polímero aprobado";
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
	    return "Mod. Polímero Temporal";
	    break;
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
    
    $("#status1").removeClass('label-success');
    $("#status2").removeClass('label-success');
    $("#status3").removeClass('label-success');
    $("#status4").removeClass('label-success');
    $("#status5").removeClass('label-success');
    $("#status6").removeClass('label-success');
    $("#status7").removeClass('label-success');
    
    switch (code) {
	case "TP":
	    //
	    break;
	case "AP":
	    //
	    break;
	case "A":
	case "N":
	case "F":
	    $("#status1").addClass('label-success');
	    break;
	case "C":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-success');
	    break;
	case "E":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-success');
	    break;
	case "G":
	case "J":
	case "L":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-success');
	    break;
	case "H":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-success');
	    break;
	case "I":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-success');
	    break;
	case "K":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-success');
	    break;
	default:
	    //return "Op. no definida.";
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
								break;
							    case "kg":
								kg = j;
								break;
							    case "bultos":
								bul = j;
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
					     $("#EntList").append( "<tr style=\"font-size:10px;\"><td colspan=\"5\"><hr></td></tr>");
				    });
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
    case "idEstados":
	 idEstadosBand = value;
     break;
    case "idProveedor":
	 idUsuarioBand = value;
	 $("#idProveedor").val("");
	 $("#idPr").val("");
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

function BuscadorDeUsuarios(value)
	{
	        var input = value;
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque/buscarProveedores.php",
				data: { xinput: input },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%;">';
								fila +='<thead><th style="width: 20px;"></th><th style="width: 70px;">Nombre</th><th>Teléfono</th></tr></thead>';
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
												 if(i == "id_proveedor")
												 {
													//Icono  accept
													fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+j+'" onClick="SeleccionadoU(\''+j+'\')">';
													fila +='<td>';
													fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
													fila +='</td>';
													fila += '<input type="hidden" id="'+j+'_cu" value="'+j+'">';
													idCodigo = j;
												 }
												 if(i == "razon_social")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_no" value="'+j+'">';
												 }
												 if(i == "telefono")
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
	 var nc = "#"+code+"_no";
	 
	 $("#idPr").val(code);
	 $("#idProveedor").val($(nc).val());
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
	 
	var selectedValues = $('#estados').val();
	
	if (selectedValues == null) {
	    selectedValues = "";
	}
	if(
           !(document.getElementById('Cliente').checked) && !(document.getElementById('Proveedor').checked)
          )	
			{
				var filtros = "";
				if(filtros == "")
					filtros = 4  + ":" + selectedValues;
					else
					filtros = filtros + "~" + 4 + ":" + selectedValues;
				
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
				reporteAjax('div_find','reportePolimerosphp.php',filtros);
			}
			else
				{
					var filtros = "";
					if(filtros == "")
					    filtros = 4  + ":" + selectedValues;
					    else
					    filtros = filtros + "~" + 4 + ":" + selectedValues;
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
					if(document.getElementById('Proveedor').checked)
						{
							if(document.getElementById('idPr').value == "")
								{
									$("#msj_error_pop").html("Seleccione un proveedor válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idPr').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idPr').value;
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
					reporteAjax('div_find','reportePolimerosphp.php',filtros);
					
					
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
/*    
function ExportarExcel()
	{
		window.open("archivoExcel.php?consulta="+document.getElementById('consulImpr').value, "PopUp", "menubar=1,width=300,height=300");
	}
*/
function ExportarAExcel (value)
	{
		var selectedValues = $('#estados').val();
	
	if (selectedValues == null) {
	    selectedValues = "";
	}
	if(
           !(document.getElementById('Cliente').checked) && !(document.getElementById('Proveedor').checked)
          )	
			{
				var filtros = "";
				if(filtros == "")
					filtros = 4  + ":" + selectedValues;
					else
					filtros = filtros + "~" + 4 + ":" + selectedValues;
				
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
				window.open("reportePolimeroExcel.php?consulta="+filtros, "PopUp", "menubar=1,width=300,height=300");
				//reporteAjax('div_find','reportePolimerosphp.php',filtros);
			}
			else
				{
					var filtros = "";
					if(filtros == "")
					    filtros = 4  + ":" + selectedValues;
					    else
					    filtros = filtros + "~" + 4 + ":" + selectedValues;
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
					if(document.getElementById('Proveedor').checked)
						{
							if(document.getElementById('idPr').value == "")
								{
									$("#msj_error_pop").html("Seleccione un proveedor válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idPr').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idPr').value;
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
					window.open("reportePolimeroExcel.php?consulta="+filtros, "PopUp", "menubar=1,width=300,height=300");
					
					
				}
		//window.open("archivoExcel.php?consulta="+condicion, "PopUp", "menubar=1,width=300,height=300");
	}

function ValidarExportacion (value)
	{
		var selectedValues = $('#estados').val();
	
	if (selectedValues == null) {
	    selectedValues = "";
	}
	if(
           !(document.getElementById('Cliente').checked) && !(document.getElementById('Proveedor').checked)
          )	
			{
				var filtros = "";
				if(filtros == "")
					filtros = 4  + ":" + selectedValues;
					else
					filtros = filtros + "~" + 4 + ":" + selectedValues;
				
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
				window.open("reportePolimeroPDF.php?consulta="+filtros, "PopUp", "menubar=1,width=300,height=300");
				//reporteAjax('div_find','reportePolimerosphp.php',filtros);
			}
			else
				{
					var filtros = "";
					if(filtros == "")
					    filtros = 4  + ":" + selectedValues;
					    else
					    filtros = filtros + "~" + 4 + ":" + selectedValues;
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
					if(document.getElementById('Proveedor').checked)
						{
							if(document.getElementById('idPr').value == "")
								{
									$("#msj_error_pop").html("Seleccione un proveedor válido.");
									$("#ErrorPop").modal("show");
									return false;
								}
								else 
								{
									if(filtros == "")
										filtros = 2 + ":" + document.getElementById('idPr').value;
										else
										filtros = filtros + "~" + 2 + ":" + document.getElementById('idPr').value;
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
					window.open("reportePolimeroPDF.php?consulta="+filtros, "PopUp", "menubar=1,width=300,height=300");
					
					
				}
		//window.open("archivoExcel.php?consulta="+condicion, "PopUp", "menubar=1,width=300,height=300");
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

//----------------------------------------------------------
 </script>