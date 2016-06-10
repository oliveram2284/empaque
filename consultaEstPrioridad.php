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

 <form id="adminPriori" name="adminPriori" method="post">
 <div class="container">
        <div class="well"  id="titulo_main">
                <div class="page-header">
					<h2>
					      Estado de Prioridades
					</h2>
				</div>
	<div class="row">
		<div class="span1">
			<input type="button" class="btn btn-danger" value="Atrás" onClick="Principal()">
		</div>
	</div>
	<br>
	<div class="row">
	</div>
	<div class="row">
	 <div class="span10">
	    <div id="ViajesContent">
    	
    	</div>
	 </div>
	</div>
	

 </div>

 </form>
 

 <!-- Pop Calendarío -->
<div class="modal hide fade" id="ListadoDePrioridades" style="width: 900px; margin-left: -450px; margin-top: -400px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Listado de Prioridades por Usuario</h3>
  </div>
  <div class="modal-body" style="max-height: 700px;">

    <div id="PrioridadesContent_">
    	
    </div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('ListadoDePrioridades')">Cerrar</a>
  </div>
</div>


<?php

require("footer.php");

?>
 
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
				url: "/empaque/calendarioEstConsulta.php",
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
	var data_ajax={
				type: 'POST',
				url: "/empaque/listadoDePrioridadesAdConsulta.php",
				data: { id: id_ },
				success: function( data ) {
								$("#PrioridadesContent_").html(data);
								
							  },
				error: function(data){
						   $("#PrioridadesContent_").html(data.responseText);
						  },
				dataType: 'text/html'
				};
		$.ajax(data_ajax);
	$("#ListadoDePrioridades").modal('show');
}

function Autorizar(codigo ,id, viaje)
{
	var cant = $('#'+codigo).val();
	if(cant == '' || cant == "0")
		return;
	//alert('Autorizar: '+ codigo + '----' + id);
	var data_ajax={
				type: 'POST',
				url: "/empaque/listadoDePrioridadesAdAuto.php",
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
				url: "/empaque/listadoDePrioridadesAdAuto.php",
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
 
</script>

 </script>