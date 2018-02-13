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
 <link rel="stylesheet" href="assest/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="assest/dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="assest/dist/js/bootstrap-multiselect.js"></script>
<link rel='stylesheet' href='assest/fullcalendar/fullcalendar.css' />
<link rel='stylesheet' href='assest/fullcalendar/bootstrap_fullcalendar.css' />
<!-------------------------------------------->

 <form id="adminPriori" name="adminPriori" method="post">
 	<div class="container">
        <div class="well"  id="titulo_main">
			<div class="page-header">
				<h2>
						Administrar Prioridades
				</h2>
			</div>
			<div class="row">
				<div class="span3">
					<input type="button" class="btn btn-danger" value="Atrás" onClick="Principal()">
					<input type="button" value="&nbsp;Nuevo Viaje&nbsp;" class="btn btn-success" onClick="nuevo()">
				</div>
			</div>
			<br>

			


			<div class="row">
				<div class="span10" id="calendar">					
					
				</div>
			</div>
			<div class="row hidden">
	 			<div class="span10">
	    			<div id="ViajesContent">
    	
    				</div>
	 			</div>
			</div> 	
		</div>
	</div>
 </form>
 

 <!-- Pop Calendarío -->
<div class="modal hide fade" id="ListadoDePrioridades" style="">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Autorizar Listado de Prioridades</h3>
  </div>
  <div class="modal-body" style="max-height: 700px;">

    <div id="PrioridadesContent_">
    	
    </div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('ListadoDePrioridades')">Cerrar</a>
  </div>
</div>

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
		    <label class="control-label" for="inputFecha">Fecha</label>
		    <div class="controls">
			<input type="text" id="inputFecha" placeholder="dd/mm/aaaa" readonly>
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

<script src='assest/fullcalendar/lib/moment.min.js'></script>
<script src='assest/fullcalendar/fullcalendar.js'></script> 
<script src='assest/fullcalendar/locale-all.js'></script>
<?php

require("footer.php");

?>

<script>
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
		locale: 'es',
		editable:true,
		left:   'today',
		center: 'title',
		right:  'prev,next',	
		events: function(start, end, timezone, callback) {
			var d = $('#calendar').fullCalendar('getDate');
			var   date=moment(d).format('YYYY-MM-DD');
			$.ajax({
				url: 'services/viajes.php',
				dataType: 'json',
				data: {
					action: 1,
					date:date
				},
				success: function(doc) {
					//console.debug("====> doc: %o",doc);
					var events = [];
					$.each(doc.result,function(index,item){
						events.push({
							title: item.destino_description,							
							date: item.fecha,
							color: item.destino_color.toLowerCase(),   // a non-ajax option
							borderColor:item.destino_color.toLowerCase(),
            				textColor: '#f9f9f9',
							tooltip: '- Empresa: '+item.transporte_razon_sosial+' <br> - Destino: '+item.destino_description+'  ',
							event_data:item
						});
					});
					callback(events);
				}
			});
		},
		eventMouseover: function (data, event, view) {
			//console.log(data.event_data);
            tooltip =''; 
			tooltip+='<div class="tooltiptopicevent" style="width:auto;height:auto;background:#dff9cc; border:1px solid #fff; position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">';
			tooltip+= '- Empresa: ' +data.event_data.transporte_razon_sosial+ '<br> - Destino: ' + data.event_data.destino_description + '</br>' + '- Horario Salida: ' + data.event_data.horaSalida+':'+data.event_data.minutoSalida + '</div>';


            $("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });


        },
		eventRender: function( event, element, view ) {
			if(event.event_data.todos > 0){				
				if(event.event_data.todos==event.event_data.aprobados){
					element.find(".fc-title").prepend('<i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>  ');
				}else{
					element.find(".fc-title").prepend('<i class="fa fa-circle" aria-hidden="true" style="color:red;"></i>  ');
				}
			}			
		},
        eventMouseout: function (data, event, view) {
            $(this).css('z-index', 8);

            $('.tooltiptopicevent').remove();

        },
        dayClick: function () {			
            tooltip.hide();
        },
        eventResizeStart: function () {
            tooltip.hide()
        },
        eventDragStart: function () {
            tooltip.hide()
        },
        viewDisplay: function () {
            tooltip.hide()
        },
		eventClick: function(calEvent, jsEvent, view) {		
			// change the border color just for fun
			//$(this).css('border-color', 'red');
			console.log(calEvent.event_data);
			id_= calEvent.event_data.idViaje;
			idUltimoViaje = id_;
			console.log(id_);
			var data_ajax={
						type: 'POST',
						url: "/empaque_demo/listadoDePrioridadesAd.php",
						data: { id: id_ },
						success: function( data ) {
							console.debug("data: %o",data);
							$("#PrioridadesContent_").html(data);
							$("#ListadoDePrioridades").modal('show');
						},
						error: function(data){
							console.debug("ERROR: %o",data);
							
								$("#PrioridadesContent_").html(data.responseText);
								},
						 dataType: "html",
						};
				$.ajax(data_ajax);

		}
		
		/*eventSources: [
			{
            url: 'services/viajes.php',
            type: 'POST',
            data: {
                action: 1
            },
            error: function() {
                alert('there was an error while fetching events!');
            },
            color: 'yellow',   // a non-ajax option
            textColor: 'black' // a non-ajax option
        }

        // any other sources...

    	]*/
	        // put your options and callbacks here
    })

});
</script>
 
 <script>
    $( document ).ready(function() {
		$( document ).tooltip();
		var f = new Date();
		AbrirCalendario((f.getMonth() + 1), f.getFullYear());
    }); 

function ClosePop(div)
{
	var idDiv = "#"+div;
	$(idDiv).modal('hide');			
}

function formatDate(date)
{
    var dates = date.split(" ");
    
    var day = dates[0].split("-");
    
    return day[2]+"-"+day[1]+"-"+day[0]+" "+dates[1];
}
     
 
function AbrirCalendario(mesx, ano){
	var f = new Date();
	if( mesx == 13 ){
		mesx = 1;
		ano++;
	}

	if(mesx == 0){
		mesx = 12;
		ano--;
	}
	var data_ajax={
				type: 'POST',
				url: "/empaque_demo/calendarioAd.php",
				data: { dia: f.getDate(), mes: mesx, anio: ano },
				success: function( data ) {
								$("#ViajesContent").html(data);
								
							  },
				error: function(data){
						   $("#ViajesContent").html(data.responseText);
						  },
				dataType: 'text/html'
				};
		$.ajax(data_ajax);
	//$("#CalendarioPop").modal('show');
}


var idUltimoViaje = 0;
function AbrirPorViaje(id_){
	idUltimoViaje = id_;
	console.log(id_);
	var data_ajax={
				type: 'POST',
				url: "/empaque_demo/listadoDePrioridadesAd.php",
				data: { id: id_ },
				success: function( data ) {
					console.debug("data: %o",data);
					$("#PrioridadesContent_").html(data);
					$("#ListadoDePrioridades").modal('show');
				},
				error: function(data){
					console.debug("data: %o",data);
					
						   $("#PrioridadesContent_").html(data.responseText);
						  },
				dataType: 'html'
				};
		$.ajax(data_ajax);
	
}

function Autorizar(codigo ,id, viaje)
{
	var cant = $('#'+codigo).val();
	if(cant == '' || cant == "0")
		return;
	//alert('Autorizar: '+ codigo + '----' + id);
	var data_ajax={
				type: 'POST',
				url: "/empaque_demo/listadoDePrioridadesAdAuto.php",
				data: { cnt: cant, ide: id, via: viaje },
				success: function( data ) {
								AbrirPorViaje(idUltimoViaje);
							  },
				error: function(data){
						   AbrirPorViaje(idUltimoViaje);
						  },
				dataType: 'text/html'
				};
		$.ajax(data_ajax);
}

function NoAutorizar(codigo ,id, viaje)
{
	var cant = $('#'+codigo).val();
	if(cant == '' || cant == "0")
		return;
	//alert('Autorizar: '+ codigo + '----' + id);
	var data_ajax={
				type: 'POST',
				url: "/empaque_demo/listadoDePrioridadesAdAuto.php",
				data: { cnt: -1, ide: id, via: viaje },
				success: function( data ) {
							//$('#'+codigo+'_fila').css("background-color", "#f2dede");
							//$('#'+codigo).val('');	
							//$('#'+codigo).attr('readonly', true);
							  },
				error: function(data){
							//$('#'+codigo+'_fila').css("background-color", "#f2dede");
							//$('#'+codigo).val('');
							//$('#'+codigo).attr('readonly', true);
							AbrirPorViaje(idUltimoViaje);
						  },
				dataType: 'text/html'
				};
		$.ajax(data_ajax);
}

 function Principal()
 	{
		document.adminPriori.action = "principal.php";
		document.adminPriori.submit();
	}

//----------------------------------
    
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
	    
	    input.push($('#inputFecha').val());
	    input.push($('#idDestino').val());
	    input.push($('#inputCodigo').val());
	    input.push($('#idTransporte').val());
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque_demo/listadoViajesphp.php",
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

function BuscadorDeDestinos(value)
	{
	        var input = value;
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque_demo/buscarDestinos.php",
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
				url: "/empaque_demo/buscarTransportes.php",
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
</script>

 </script>