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
                                 Destinos
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
                                <th style="text-align: center;"><strong>Destino</strong></th>
								<th style="text-align: center; width: 5px;"><strong>Color</strong></th>
                                <th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM destino Order by descripcion";
                                
                                $resu = mysql_query($sql);
				echo "<tbody>";
                                if(mysql_num_rows($resu) <= 0)
                                    {
                                     echo '<tr><td colspan="2" style="text-align: center;">No se encontraron resultados.</td></tr>';
                                    }
                                    else
                                    {
                                       while($row = mysql_fetch_array($resu))
                                       {
                                            echo "<tr>";
                                            
                                            echo "<td>".$row['descripcion']."</td>";
											echo "<td style=\"text-align: center\">";
											echo '<div
													style="width: 25px; height: 15px; background:'.$row['color'].'; -moz-border-radius: 30%; -webkit-border-radius: 30%; border-radius: 30%; box-shadow: 2px 2px 5px #999; color: white;">
												  </div></td>';
                                            echo "<td onClick=\"EditarFormato('".$row['id_destino']."', '".$row['descripcion']."','".$row['color']."')\" style=\"text-align: center;\">";
                                            echo "<img src=\"./assest/plugins/buttons/icons/pencil.png\" width='20' heigth='20' title=\"Editar\" style=\"cursor:pointer\"/>";
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
    <input type="hidden" id="idDestino" value="">
	
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
		    <label class="control-label" for="inputColor">Cotización</label>
		    <div class="controls">
			<input type="text" id="inputColor" placeholder="Color identificatorio" type="number">
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
    function EditarFormato(id, name, color )
    {
        $('#btnAceptar').removeAttr('disabled');
        var title = "Destino: " + name;
        $('#headerId').html(title);
		$('#inputNombre').val($.trim(name));
		$('#inputColor').val(color);
        $('#idDestino').val(id);
	$('#box_error').hide();
	$('#msj_box_error').html("");
	$('#modalFC').modal('show');
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
	
	if($('#inputColor').val() == "")
	{
	    $('#msj_box_error').html("Ingrese un color (puede ser en haxadecimal).");
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
	    
	    input.push($('#idDestino').val());
	    input.push($('#inputNombre').val());
	    input.push($('#inputColor').val());
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque_demo/listadoDestinosphp.php",
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
	$('#idDestino').val('');
	$('#inputNombre').val('');
	$('#inputColor').val('');
	$('#box_error').hide();
	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
	Limpiar();
	$('#idDestino').val('');
	var title = "Nuevo Destino";
        $('#headerId').html(title);
	$('#modalFC').modal('show');
	$('#box_error').hide();
	$('#msj_box_error').html("");
    }
</script>