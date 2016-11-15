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
						Reportes de Estadísticas
					    </h2>
					</div>
				</div>
			</div>
			
			
			<div class="row">
			    <div class="span1">
				<a href="javascript:history.back()" class="btn btn-danger">Atrás </a><br><br>
			    </div>
			</div>
			
			<div class="row">
				<div class="span4 alert alert-success">
					Cantidad de Pedidos por Vendedor<hr>
					<div class="row">
					    <div class="span1" style="padding-top: 5px;">
						Usuarios:
					    </div>
					    <div class="span2">
						<select id="graph1_cant">
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
						</select>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1" style="padding-top: 5px;">
						Orden:
					    </div>
					    <div class="span2">
						<select id="graph1_order">
						    <option value="desc">Primeros</option>
						    <option value="asc">Últimos</option>
						</select>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1">
						Desde:
					    </div>
					    <div class="span2">									
						<input type="text" id="fecha1" name="fecha1" class="input-small" readonly>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1">
						Hasta:
					    </div>
					    <div class="span2">
						<input type="text" id="fecha2" name="fecha2" class="input-small" readonly>
					    </div>    
					</div>
					<div class="row">
					    <div class="span4">
						<input type="button" id="btn_grhap_1" value="Aceptar" class="btn btn-primary">
					    </div>
					</div>
				</div>
				
				<div class="span4 offset1 alert alert-warning">
					Cantidad de materiales<hr>
					<div class="row">
					    <div class="span1" style="padding-top: 5px;">
						Materiales:
					    </div>
					    <div class="span2">
						<select id="graph2_cant">
						    <option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						    <option value="5">5</option>
						</select>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1" style="padding-top: 5px;">
						Orden:
					    </div>
					    <div class="span2">
						<select id="graph2_order">
						    <option value="desc">Primeros</option>
						    <option value="asc">Últimos</option>
						</select>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1">
						Desde:
					    </div>
					    <div class="span2">									
						<input type="text" id="fecha3" name="fecha3" class="input-small" readonly>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1">
						Hasta:
					    </div>
					    <div class="span2">
						<input type="text" id="fecha4" name="fecha4" class="input-small" readonly>
					    </div>    
					</div>
					<div class="row">
					    <div class="span4">
						<input type="button" id="btn_grhap_2" value="Aceptar" class="btn btn-primary">
					    </div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="span4 alert alert-error">
					Nuevos vs Habituales<hr>
					<div class="row">
					    <div class="span1">
						Vendedor:
					    </div>
					    <div class="span2">
						<input type="text" name="idUsuario" id="idUsuario" readonly="readonly" onclick="usuarioClick()"/>
						<input type="hidden" id="idUs">
					    </div>
					</div>
					<div class="row">
					    <div class="span1">
						Desde:
					    </div>
					    <div class="span2">									
						<input type="text" id="fecha5" name="fecha5" class="input-small" readonly>
					    </div>    
					</div>
					<div class="row">
					    <div class="span1">
						Hasta:
					    </div>
					    <div class="span2">
						<input type="text" id="fecha6" name="fecha6" class="input-small" readonly>
					    </div>    
					</div>
					<div class="row">
					    <div class="span4">
						<input type="button" id="btn_grhap_3" value="Aceptar" class="btn btn-primary">
					    </div>
					</div>
				</div>
				
				<div class="span4 offset1 alert alert-info">
					Cantidad de Pedidos por mes y año<hr>
					<div class="row">
					    <div class="span1" style="padding-top: 5px;">
						Año:
					    </div>
					    <div class="span2">
						<select id="anio" multiple="multiple">
						    <option value="2012">2012</option>
						    <option value="2013">2013</option>
						    <option value="2014">2014</option>
						    <option value="2015">2015</option>
						</select>
					    </div>    
					</div>
					<div class="row">
					    <div class="span4">
						<input type="button" id="btn_grhap_4" value="Aceptar" class="btn btn-primary">
					    </div>
					</div>
				</div>
			</div>
			
        </div>
	
<!-- Pop Usuarios -->
<div class="modal hide fade" id="UsariosPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Buscador de Vendedor </h3>
  </div>
  <div class="modal-body">
    
	<strong>Buscar :   </strong>  <input type="text" id="buscadorU" onkeyup="BuscadorDeUsuarios(this.value)"><br><br>
	<div id="resultado_Usuarios" value="0" style="width: 90%; min-height: 250px; max-height: 250px;">
	
	</div>
	
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('UsariosPop')">Cerrar</a>
  </div>
</div>

<!--------- End Pop Usuarios -->
<?php

require("footer.php");

?>
<script>
$(function() {
	var d=new Date();
	$('#fecha1').datepicker();
	$('#fecha1').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#fecha1').datepicker( 'setDate', '".$fechin."' );
	
	$('#fecha2').datepicker();
	$('#fecha2').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#fecha2').datepicker( 'setDate', '".$fechin."' );
	
	$('#fecha3').datepicker();
	$('#fecha3').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#fecha3').datepicker( 'setDate', '".$fechin."' );
	
	$('#fecha4').datepicker();
	$('#fecha4').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#fecha4').datepicker( 'setDate', '".$fechin."' );
	
	$('#fecha5').datepicker();
	$('#fecha5').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#fecha5').datepicker( 'setDate', '".$fechin."' );
	
	$('#fecha6').datepicker();
	$('#fecha6').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
	$('#fecha6').datepicker( 'setDate', '".$fechin."' );
      });

$("#btn_grhap_1").click(function(){
    window.open("./graph_1.php?cant="+$("#graph1_cant").val()+"&order="+$("#graph1_order").val()+"&from="+$('#fecha1').val()+"&to="+$('#fecha2').val(),"Graficos","width=600,height=900,scrollbars=yes");    
});

$("#btn_grhap_2").click(function(){
    window.open("./graph_2.php?cant="+$("#graph2_cant").val()+"&order="+$("#graph2_order").val()+"&from="+$('#fecha3').val()+"&to="+$('#fecha3').val(),"Graficos","width=600,height=600,scrollbars=yes");    
});

$("#btn_grhap_3").click(function(){
    window.open("./graph_3.php?from="+$('#fecha5').val()+"&to="+$('#fecha6').val()+"&vend="+$('#idUs').val(),"Graficos","width=600,height=900,scrollbars=yes");    
});

$("#btn_grhap_4").click(function(){
    window.open("./graph_4.php?anio="+$('#anio').val(),"Graficos","width=700,height=600,scrollbars=yes");    
});

function usuarioClick()
{
    $("#UsariosPop").modal('show');
    setTimeout(function () { $("#buscadorU").focus(); }, 1000);
}

function BuscadorDeUsuarios(value)
	{
	        var input = value;
		var color = '#FFFFFF';
		var data_ajax={
				type: 'POST',
				url: "/empaque_demo/buscarUsuariosXCategoria.php",
				data: { 
						xinput: input,
						xcateg: 'VEN'
					},
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

</script>