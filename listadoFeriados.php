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
                    Listado Feriados
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
								<th style="text-align: left;"><strong>Descripción</strong></th>
                                <th style="width: 100px">Acciones</th>
                            </tr>
                        </thead>
                        
			    <?php
			    if(isset($_GET['page']))
			    	$page = $_GET['page'];
			   	else 
			   		$page = 0;

			   	$from = $page * 10;
				$sql = "SELECT * FROM Feriados as F
						Order by ferDay desc Limit ".$from.",10";
                                
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
                                           	echo "<tr>";
                                            $fe = explode('-', $row['ferDay']);
                                            echo "<td style=\"text-align: center\">".$fe[2].'-'.$fe[1].'-'.$fe[0]."</td>";
					    					echo "<td style=\"text-align: left\">".$row['ferName']."</td>";
                                            echo "<td style=\"text-align: center;\">";
	                                        echo "<img src=\"./assest/plugins/buttons/icons/pencil.png\" width='20' heigth='20' title=\"Editar\" style=\"cursor:pointer\" onClick=\"EditarFeriado('".$row['ferId']."', '".$row['ferName']."', '".$row['ferDay']."')\"/>";
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
    <input type="hidden" id="ferId" value="">
	
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
		    <label class="control-label" for="inputFecha">Día</label>
		    <div class="controls">
				<input type="text" id="inputFecha" placeholder="dd/mm/aaaa" readonly>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputName">Descripción</label>
		    <div class="controls">
				<input type="text" id="inputName" placeholder="Destino" onclick="destinoClick()"/>
		    </div>
		</div>
		
	    </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" id="btnClose">Cerrar</a>
          <a href="#" class="btn btn-primary" id="btnAceptar">Guardar</a>
        </div>
    </div>
 	

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
	    $('#msj_box_error').html("Ingrese una Fecha válida.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputName').val() == "")
	{
	    $('#msj_box_error').html("Ingrese una daescripción válida.");
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
		    
		    input.push($('#ferId').val());
		    input.push($('#inputFecha').val());
		    input.push($('#inputName').val());
		                
            var data_ajax={
                        type: 'POST',
                        url: "/empaque_demo/listadoFeriadosphp.php",
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
	$('#inputName').val('');
    $('#ferId').val('');
	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
		Limpiar();
		$('#ferId').val('0');
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

function ClosePop(div)
{
	var idDiv = "#"+div;
	$(idDiv).modal('hide');			
}


function EditarFeriado(ferId, ferName, ferDay){
		Limpiar();
		$('#ferId').val(ferId);
		var title = "Editar Feriado";
	    $('#headerId').html(title);

	    var fecha = ferDay.split('-');
	 	$('#inputFecha').val(fecha[2] + '-' + fecha[1] + '-' +  fecha[0]);
	    $('#inputName').val(ferName);
	    
		$('#modalFC').modal('show');
		$('#box_error').hide();
		$('#msj_box_error').html("");
}

function CerrarViaje(id) {
	var data_ajax={
				type: 'POST',
				url: "/empaque_demo/listadoViajesClose.php",
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