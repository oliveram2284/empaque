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
			      Aprovación de Prioridad de Entrega
			</h2>
		</div>
		<div class="row">
			 <div class="span10">
			   
			   
			 </div>
		</div>
		</div>
 </div>
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


<?php

require("footer.php");

?>
 
<script>
    $( document ).ready(function() {
	$( document ).tooltip();
    });    
    
function ClosePop(div)
{
	var idDiv = "#"+div;
	$(idDiv).modal('hide');			
}
/***********************************************************/



function AbrirCalendario(mesx, ano){
	var f = new Date();
	var data_ajax={
				type: 'POST',
				url: "/empaque_demo/calendario.php",
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
	$("#CalendarioPop").modal('show');
}

function CrearPrioridad(){
	if($("#ViajeId").val() != "" && pedidosId.length > 0)
	{
		//Crear prioridad
		var data_ajax={
				type: 'POST',
				url: "/empaque_demo/prioridadCrear.php",
				data: { viaje: $("#ViajeId").val(), pedidos: pedidosId },
				success: function( data ) {
								location.reload();
							  },
				error: function(data){
							alert("Error al guardar los datos");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}
}
 </script>