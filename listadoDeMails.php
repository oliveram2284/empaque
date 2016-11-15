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
                                Listado de Mails
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" value="&nbsp;Nuevo&nbsp;" class="btn btn-success" onClick="Editar(0, '', 0, 'Add')">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><strong>Mail</strong></th>
								<th style="text-align: center;"><strong>Envía Protocolo</strong></th>
                                <th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM mails Order by mail";
                                
                                $resu = mysql_query($sql);
				echo "<tbody>";
                                if(mysql_num_rows($resu) <= 0)
                                    {
                                     echo '<tr><td colspan="3" style="text-align: center;">No se encontraron resultados.</td></tr>';
                                    }
                                    else
                                    {
                                       while($row = mysql_fetch_array($resu))
                                       {
                                            echo "<tr>";
                                            
                                            echo "<td>".$row['mail']."</td>";
                                            if($row['protocolo'] != 1)
                                            {
                                            	echo '<td style="text-align: center;"><input type="checkbox" disabled="disabled" ></td>';
                                            }
                                            else
                                            {
                                            	echo '<td style="text-align: center;"><input type="checkbox" readonly checked="checked" disabled="disabled"></td>';
                                            }
                                            echo '<td style="text-align: center;">';
                                            echo '<img src="./assest/plugins/buttons/icons/pencil.png" width="20" heigth="20" title="Editar" style="cursor:pointer" onClick="Editar('.$row['idMail'].', \''.$row['mail'].'\', '.$row['protocolo'].', \'Edit\')"/>';
                                            echo '<img src="./assest/plugins/buttons/icons/delete.png" width="20" heigth="20" title="Eliminar" style="cursor:pointer; padding-left: 20px;" onClick="Editar('.$row['idMail'].', \''.$row['mail'].'\', '.$row['protocolo'].',\'Del\')"/>';
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
    <input type="hidden" id="idMail" value="">
	
    <!---------------------------------------------------->
    <div class="modal hide fade" id="modalEM">
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
		    <label class="control-label" for="inputMail">Mail</label>
		    <div class="controls">
			<input type="text" id="inputMail" placeholder="Dirección de Mail">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputProtocolo">Envía Protocolo</label>
		    <div class="controls">
			<input type="checkbox" id="inputProtocolo">
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
var action = "";
    function Editar(id, mail, protocolo, act){
    	var title = "Editar Mail";
    	if(act == 'Del')
    		title = "Eliminar Mail";
    	else
	    	if(mail == "") 
	    		title = "Nuevo Mail";
    	Limpiar();
    	action = act;
    	$('#headerId').html(title);
    	$('#idMail').val(id);
    	$('#inputMail').val(mail);
    	if(protocolo == 1)
    		$('#inputProtocolo').attr('checked', true);
    	else
    		$('#inputProtocolo').attr('checked', false);
    	$('#modalEM').modal('show');
    	$('#btnAceptar').removeAttr('disabled');
    }
    
    function inicio()
    {
	location.href="principal.php";
    }
    
    $('#btnClose').click(function(){
	    $('#modalEM').modal('hide');			
	});
        
    function validarEmail(valor) {
	  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(valor)){
	   return true;
	  } else {
	   return false;
	  }
	}

    $('#btnAceptar').click(function(){
        $('#box_error').hide();
		$('#msj_box_error').html("");
		$('#btnAceptar').attr("disabled", "disabled");

        var email = validarEmail($('#inputMail').val());   
        
        if(email == false)
        {
        	$('#msj_box_error').html("Ingrese un email váido.");
		    $('#box_error').show();
		    $('#btnAceptar').removeAttr('disabled');
		    return false;
        }

		var input = [];
	    
		var EnviaProtocolo = 0;
	    if($("#inputProtocolo").is(':checked')) {  
            EnviaProtocolo = 1;
        }

	    input.push($('#idMail').val());
	    input.push($('#inputMail').val());
	    input.push(EnviaProtocolo);
	    input.push(action);
        
        var data_ajax={
                    type: 'POST',
                    url: "/empaque_demo/insertUpdateMail.php",
                    data: { xid: input},
                    success: function( data ) {
                                                if(data != 0)
                                                {
													$('#box_error').show();
													$('#msj_box_error').html("Ocurrio un error.");
													$('#btnAceptar').removeAttr('disabled');
                                                }
                                                else
                                                {
													Limpiar();
													$('#btnAceptar').removeAttr('disabled');
						                        	$('#modalEM').modal('hide');
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
            
	});
    
    function Limpiar()
    {
	$('#idMail').val('');
	$('#inputMail').val('');
	
	$('#box_error').hide();
	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
	Limpiar();
	$('#idEstadistica').val('0');
	var title = "Nuevo Registro";
        $('#headerId').html(title);
	$('#btnAceptar').removeAttr('disabled');
    }
</script>