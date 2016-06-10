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
                    Empresas de Transportes
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
                                <th style="text-align: center;"><strong>Nombre</strong></th>
								<th style="text-align: center;"><strong>Correo Electronico</strong></th>
                                <th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM transportes Order by razon_social";
                                
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
                                            
                                            echo "<td>".$row['razon_social']."</td>";
					    					echo "<td style=\"text-align: left\">".$row['mail']."</td>";
                                            echo "<td onClick=\"EditarTransporte(
                                            									'".$row['id_transporte']."', 
                                            									'".$row['razon_social']."',
                                            									'".$row['direccion']."',
                                            									'".$row['telefono']."',
                                            									'".$row['mail']."',
                                            									'".$row['web']."',
                                            									'".$row['observacion']."',
                                            									'".$row['codigo']."'
                                            									)\" style=\"text-align: center;\">";
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
    <input type="hidden" id="idTransporte" value="">
	
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
		    <label class="control-label" for="inputRazon">Razón Social</label>
		    <div class="controls">
			<input type="text" id="inputRazon" placeholder="Razon Social">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputDireccion">Dirección</label>
		    <div class="controls">
			<input type="text" id="inputDireccion" placeholder="Dirección">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputTelefono">Teléfono</label>
		    <div class="controls">
			<input type="text" id="inputTelefono" placeholder="Teléfono" type="number">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputMail">E-Mail</label>
		    <div class="controls">
			<input type="text" id="inputMail" placeholder="E-Mail" type="mail">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputWeb">Web</label>
		    <div class="controls">
			<input type="text" id="inputWeb" placeholder="Web">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputContacto">Contacto</label>
		    <div class="controls">
			<input type="text" id="inputContacto" placeholder="Contacto">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputObserv">Observación</label>
		    <div class="controls">
			<input type="text" id="inputObserv" placeholder="Observacion">
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
    function EditarTransporte(id, razon_social, Dirección, telefono, mail, web, observacion, contacto )
    {
        $('#btnAceptar').removeAttr('disabled');
        var title = "Editar " + razon_social;
        $('#headerId').html(title);
		$('#inputRazon').val($.trim(razon_social));
		$('#inputDireccion').val(Dirección);
        $('#inputTelefono').val(telefono);
        $('#inputMail').val(mail);
        $('#inputWeb').val(web);
        $('#inputObserv').val(observacion);
        $('#idTransporte').val(id);
        $('#inputContacto').val(contacto);

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
		    
	if($('#inputRazon').val() == "")
	{
	    $('#msj_box_error').html("Ingrese una Razón Social.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputDireccion').val() == "")
	{
	    $('#msj_box_error').html("Ingrese una dirección válida.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputTelefono').val() == "")
	{
	    $('#msj_box_error').html("Ingrese un teléfono válido.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}

	if($('#inputMail').val() == "")
	{
	    $('#msj_box_error').html("Ingrese una E-Mail válido.");
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
	    
	    input.push($('#idTransporte').val());
	    input.push($('#inputRazon').val());
	    input.push($('#inputDireccion').val());
	    input.push($('#inputTelefono').val());
	    input.push($('#inputMail').val());
	    input.push($('#inputWeb').val());
	    input.push($('#inputObserv').val());
	    input.push($('#inputContacto').val());
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoEmpresasphp.php",
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
	$('#inputRazon').val('');
	$('#inputDireccion').val('');
    $('#inputTelefono').val('');
    $('#inputMail').val('');
    $('#inputWeb').val('');
    $('#inputObserv').val('');
    $('#idTransporte').val('');
    $('#inputContacto').val('');

	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
		Limpiar();
		$('#idTransporte').val('0');
		var title = "Nueva Empresa";
	    $('#headerId').html(title);
		
		$('#modalFC').modal('show');
		$('#box_error').hide();
		$('#msj_box_error').html("");
    }
</script>