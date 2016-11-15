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
                    Listado Consulta de Protocolo
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
            <div class="offset7 span2">
                <input type="text" placeholder="Buscar..." id="buscador_txt" value="<?php echo (!isset($_GET['query'])) ? '' : $_GET['query'];?>">
            </div>
        </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><strong>Código</strong></th>
								<th style="text-align: left;"><strong>Cliente</strong></th>
                                <th style="text-align: left;"><strong>Producto</strong></th>
                                <th style="text-align: left;"><strong>E-Mail</strong></th>
                                <th></th>
                                <th>Acciones</th>
                                <th>Reenv.</th>
                                <th></th>
                            </tr>
                        </thead>
                        
			    <?php
			    if(isset($_GET['page']))
			    	$page = $_GET['page'];
			   	else 
			   		$page = 0;

                $search_by_txt = "";
                $query = "";
                if(isset($_GET['query']))
                {
                    $query = $_GET['query'];
                }
                if($query != "")
                {
                    $search_by_txt = " and (Pe.codigo like '%".$query."%' ";
                    $search_by_txt .= " or Pe.clienteNombre like '%".$query."%' ";
                    $search_by_txt .= " or Pe.descripcion like '%".$query."%') ";
                }

			   	$from = $page * 10;
				$sql = "SELECT  
                                P.prtId, 
                                P.estado, 
                                Pe.codigo, 
                                Pe.descripcion, 
                                Pe.clienteNombre, 
                                P.email, 
                                P.email2, 
                                P.email3, 
                                P.email4, 
                                P.email5,
                                (Select count(*) From tbl_log_entregas_protocolos as ep Where ep.idPedido = P.idPedido) as cant,
                                (Select count(*) From tbl_log_entregas_protocolos as ep Where ep.idPedido = P.idPedido and ep.estado = 'EN') as cantEnt,
                                (Select sum(reenviado) From tbl_log_entregas_protocolos as ep Where ep.idPedido = P.idPedido) as reenviado
                        FROM Protocolos as P
						Join pedidos as Pe on Pe.npedido = P.idPedido
						WHERE P.estado in ('PN','TP', 'T', 'LI') ".$search_by_txt."
						Order by Pe.codigo asc Limit ".$from.",10";

                $todos = "SELECT  
                                Count(*)
                        FROM Protocolos as P
                        Join pedidos as Pe on Pe.npedido = P.idPedido
                        WHERE P.estado in ('PN','TP', 'T', 'LI') ".$search_by_txt;

                $cant = mysql_query($todos);
                $fila = mysql_fetch_array($cant);
                $cantidad = $fila[0];
                                
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

                                            echo "<td style=\"text-align: center\">".$row['codigo']."</td>";
					    					echo "<td style=\"text-align: left\">".$row['clienteNombre']."</td>";
					    					echo "<td style=\"text-align: left\">".$row['descripcion']."</td>";
					    					echo "<td style=\"text-align: left\">".$row['email']."</td>";
                                            echo "<td>".$row['cantEnt']."/".$row['cant']."</td>";
                                            	if($row['estado'] == 'PN')
                                            	{	
                                            		echo '<td style="text-align: center">';
                                            		echo '<span class="label label-warning">Pend.</span>';
                                            		echo '</td>';
                                            	}
                                            	else
                                            	{
                                            		echo '<td style="text-align: center"><img src="./assest/plugins/buttons/icons/email.png" width="20px" heigth="20px" title="Enviar EMail" style="cursor:pointer" onClick="EnviarMail(
                                                                                                                                                                                                            '.($row['email'] == "" ? "''" : "'".$row['email']."'").', 
                                                                                                                                                                                                            '.($row['email2'] == "" ? "''" : "'".$row['email2']."'").', 
                                                                                                                                                                                                            '.($row['email3'] == "" ? "''" : "'".$row['email3']."'").', 
                                                                                                                                                                                                            '.($row['email4'] == "" ? "''" : "'".$row['email4']."'").', 
                                                                                                                                                                                                            '.($row['email5'] == "" ? "''" : "'".$row['email5']."'").', 
                                                                                                                                                                                                            '.$row['prtId'].'
                                                                                                                                                                                                            )">
                                                         </td>';
                                            	}
                                            echo '<td style="text-align: center">'.($row['reenviado'] == '' ? 0 : $row['reenviado']).'</td>';
                                            echo '<td>';
                                            if($row['estado'] == 'T'){
                                            	echo '<div
															style="width: 20px; height: 15px; background:White; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: red;" title="Terminado" 
                                                            onClick="ConsularEntregas('.$row['prtId'].')"
															>
															<b>T</b>
														</div>';
                                            }
                                            if($row['estado'] == 'TP'){
                                            	echo '<div
															style="width: 20px; height: 15px; background:White; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: orange;" title="Terminado Parcial" 
                                                            onClick="ConsularEntregas('.$row['prtId'].')"
															>
															<b>P</b>
														</div>';
                                            }
                                            if($row['estado'] == 'LI'){
                                                echo '<div
                                                            style="width: 20px; height: 15px; background:green; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; box-shadow: 2px 2px 5px #999; padding-top: 5px; text-align: center; color: white;" title="Listo" 
                                                            onClick="ConsularEntregas('.$row['prtId'].')"
                                                            >
                                                            <b>L</b>
                                                        </div>';
                                            }
                                            echo '</td>';
                                            echo "</tr>";
                                       }

                                    }
                                echo "</tbody>";
			    ?>
                    </table>
				<?php
                    $value = ceil($cantidad / 10);
					if($page == 0) {
						echo '<button class="btn btn-info" type="button" disabled title="Anterior"><i class="icon-chevron-left icon-white"></i></button>   Página '.($page + 1) .' de '. $value.'   ';
					} else {
						echo '<button class="btn btn-info" type="button" title="Anterior" onClick="window.location=\'./listadoConsultaProtocolo.php?page='.($page - 1).'\';"><i class="icon-chevron-left icon-white"></i></button>   Página '.($page + 1).' de '. $value.'   ';
					}
                    if(mysql_num_rows($resu) < 10){
                       		echo '<button class="btn btn-info" type="button" disabled title="Siguiente"><i class="icon-chevron-right icon-white"></i></button>';
                       } else {
                       		echo '<button class="btn btn-info" type="button" title="Siguiente" onClick="window.location=\'./listadoConsultaProtocolo.php?page='.($page + 1).'\';"><i class="icon-chevron-right icon-white"></i></button>';
                       }
                ?>
                    
		</div>
	    </div>
	</div>    
    </center>
    </div>
    <input type="hidden" id="idViaje" value="">
    <input type="hidden" id="idEntregaProtocolo" value="">
	
 <!-- Pop Destinos Protocolo -->
<div class="modal hide fade" id="EnviarMailPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Envio de Mail </h3>
  </div>
  <div class="modal-body">
    <div class="alert alert-error" id="box_error" style="display: none">
	    <strong id="msj_box_error"></strong>
	</div>
	<strong>E-Maill :   </strong>  <input type="text" id="emailDestinatario" placeholder="Sin E-Mail"><br>
	<strong>E-Maill :   </strong>  <input type="text" id="emailDestinatario2" placeholder="Sin E-Mail"><br>
	<strong>E-Maill :   </strong>  <input type="text" id="emailDestinatario3" placeholder="Sin E-Mail"><br>
	<strong>E-Maill :   </strong>  <input type="text" id="emailDestinatario4" placeholder="Sin E-Mail"><br>
	<strong>E-Maill :   </strong>  <input type="text" id="emailDestinatario5" placeholder="Sin E-Mail"><br>
	
	<a id="selectEntrega" href="#">Seleccionar Entrega</a><br><br>

	<div>
		
	</div>

    <div><!-- Observaciones -->
        <strong> Observaciones:   </strong>  <textarea id="observaciones" placeholder="Observaciones"></textarea>
    </div>

  </div>
  <div class="modal-footer">
    <a href="#" class="btn" onclick="ClosePop('EnviarMailPop')">Cerrar</a>
    <a href="#" class="btn btn-info" id="btnAceptar" onclick="EnviarMailFinal()">Enviar</a>
  </div>
</div>

<!--------- End Pop Destinos Protocolo -->

 <!-- Pop Destinos Protocolo -->
<div class="modal hide fade" id="EnviarMailEntregas">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Entregas</h3>
  </div>
  <div class="modal-body" style="min-height: 300px;" id="entregasBody">
    
  </div>
  <div class="modal-footer">
    /<!--<a href="#" class="btn btn-info" onclick="">Enviar</a>-->
  </div>
</div>

<!--------- End Pop Destinos Protocolo -->

<?php

require("footer.php");

?>
<script>
    $( document ).ready(function() {
        $( document ).tooltip();
    });

    $("#buscador_txt").keypress(function(e) {
        if(e.which == 13) {
        if ($("#buscador_txt").val() != "") {
            var query = $("#buscador_txt").val();
            window.location.replace("../empaque_demo/listadoConsultaProtocolo.php?page=0&query="+query+"");
        }
        }
    });

	var idProtocolo = 0;

    function EnviarMail(mail, mail2, mail3, mail4, mail5, id){

    	$('#box_error').hide();
		$('#msj_box_error').html("");
		$('#btnAceptar').removeAttr('disabled');	

    	$("#emailDestinatario").val(mail);
        $("#emailDestinatario2").val(mail2);
        $("#emailDestinatario3").val(mail3);
        $("#emailDestinatario4").val(mail4);
        $("#emailDestinatario5").val(mail5);
    	$("#EnviarMailPop").modal('show');
    	idProtocolo = id;
    }

    function ConsularEntregas(id_){
        var data_ajax={
                type: 'POST',
                url: "/empaque_demo/listadoEntregasProtocolo.php",
                data: { 
                        id: id_
                    },
                success: function( data ) {
                                            $('#entregasBody').html('');
                                            $("#entregasBody").append('<tr><th width="70">Kg.</th><th width="70">Un.</th><th width="70">Bu.</th><th>Fecha</th></tr>');
                                            $("#entregasBody").append( "<tr style=\"font-size:10px;\"><td colspan=\"5\"><hr></td></tr>");
                                            var totKg = 0;
                                            var totCant = 0;
                                            var totBul = 0;
                                            $.each(data, function(k,v){
                                                var cant = "";
                                                var kg  = "";
                                                var bul = "";
                                                var fec = "";
                                                var id  = 0;
                                                var est = "";
                                                $.each(v, function(i,j)
                                                    {
                                                        switch(i)
                                                        {
                                                        case "id":
                                                            id = j;
                                                            break;
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
                                                        case "estado":
                                                            est = j;
                                                            break;
                                                        }
                                                    });
                                                var color = "Black";
                                                if (kg < 0) {
                                                    color = "Red";
                                                }

                                                 $("#entregasBody").append( "<tr style=\"font-size:11px;color:"+color+"\"><td>"+kg+"</td><td>"+cant+"</td><td>"+bul+"</td><td>"+fec+"</td></tr>");
                                                 $("#entregasBody").append( "<tr style=\"font-size:2px;\"><td colspan=\"5\"><hr></td></tr>");
                                                
                                            });
                                            $("#entregasBody").append( "<tr style=\"font-size:15px;\"><td><strong>"+totKg.toFixed(2)+"</strong></td><td><strong>"+totCant.toFixed(2)+"</strong></td><td><strong>"+totBul+"</strong></td><td colspan=\"2\"><strong>Totales</strong></td></tr>");
                                            $("#EnviarMailEntregas").modal('show');

                                            $('#btnAceptar').removeAttr('disabled');
                                          },
                error: function(){
                                    alert('Error');
                                    $('#btnAceptar').removeAttr('disabled');
                                  },
                dataType: 'json'
                };
        $.ajax(data_ajax);
    }

    function validarEmail(valor) {
	  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(valor)){
	   return true;
	  } else {
	   return false;
	  }
	}

    function EnviarMailFinal(){
    	
    	$('#box_error').hide();
		$('#msj_box_error').html("");
    	$('#btnAceptar').attr("disabled", "disabled");
    	if($("#emailDestinatario").val() == "")
    	{
    		$('#msj_box_error').html("Revise los Email ingresados.");
		    $('#box_error').show();
		    $('#btnAceptar').removeAttr('disabled');
		    return false;
    	}
    	else
    	{
    		if(validarEmail($("#emailDestinatario").val()) == false){
    			$('#msj_box_error').html("Revise los Email ingresados.");
			    $('#box_error').show();
			    $('#btnAceptar').removeAttr('disabled');
			    return false;
    		}
    	}

    	//Validar email 2
    	if($("#emailDestinatario2").val() != "")
    	{
    		if(validarEmail($("#emailDestinatario2").val()) == false){
    			$('#msj_box_error').html("Revise los Email ingresados.");
			    $('#box_error').show();
			    $('#btnAceptar').removeAttr('disabled');
			    return false;
    		}
    	}

    	//Validar email 3
    	if($("#emailDestinatario3").val() != "")
    	{
    		if(validarEmail($("#emailDestinatario3").val()) == false){
    			$('#msj_box_error').html("Revise los Email ingresados.");
			    $('#box_error').show();
			    $('#btnAceptar').removeAttr('disabled');
			    return false;
    		}
    	}

    	//Validar email 4
    	if($("#emailDestinatario4").val() != "")
    	{
    		if(validarEmail($("#emailDestinatario4").val()) == false){
    			$('#msj_box_error').html("Revise los Email ingresados.");
			    $('#box_error').show();
			    $('#btnAceptar').removeAttr('disabled');
			    return false;
    		}
    	}

    	//Validar email 5
    	if($("#emailDestinatario5").val() != "")
    	{
    		if(validarEmail($("#emailDestinatario5").val()) == false){
    			$('#msj_box_error').html("Revise los Email ingresados.");
			    $('#box_error').show();
			    $('#btnAceptar').removeAttr('disabled');
			    return false;
    		}
    	}

    	if($("#idEntregaProtocolo").val() == ""){
    		$('#msj_box_error').html("Seleccione una entrega.");
		    $('#box_error').show();
		    $('#btnAceptar').removeAttr('disabled');
		    return false;
		}	

    	var data_ajax={
                    type: 'POST',
                    url: "/empaque_demo/enviarMail.php",
                    data: { 
                    		id: idProtocolo,
                    		mail: $("#emailDestinatario").val(),
                    		mail2: $("#emailDestinatario2").val(),
                    		mail3: $("#emailDestinatario3").val(),
                    		mail4: $("#emailDestinatario4").val(),
                    		mail5: $("#emailDestinatario5").val(),
                    		entId: $("#idEntregaProtocolo").val(),
                            observ: $("#observaciones").val(),
                            actualiza: 0
                    	},
                    success: function( data ) {
                                 				$('#btnAceptar').removeAttr('disabled');
                                                location.reload();
                                              },
                    error: function(){
                                        alert('Error');
                                        $('#btnAceptar').removeAttr('disabled');
                                      },
                    dataType: 'json'
                    };
        $.ajax(data_ajax);
    }
    function inicio()
    {
		location.href="principal.php";
    }
    
    $('#btnClose').click(function(){
	    $('#modalFC').modal('hide');			
	});
    

$('#selectEntrega').click(function(){
	$("#idEntregaProtocolo").val('');
	var data_ajax={
                type: 'POST',
                url: "/empaque_demo/listadoEntregasProtocolo.php",
                data: { 
                		id: idProtocolo
                	},
                success: function( data ) {
						                	$('#entregasBody').html('');
		                					$("#entregasBody").append('<tr><th></th><th></th><th width="70">Kg.</th><th width="70">Un.</th><th width="70">Bu.</th><th>Fecha</th></tr>');
											$("#entregasBody").append( "<tr style=\"font-size:10px;\"><td colspan=\"5\"><hr></td></tr>");
											var totKg = 0;
											var totCant = 0;
											var totBul = 0;
											$.each(data, function(k,v){
												var cant = "";
												var kg 	= "";
												var bul = "";
												var fec = "";
												var id 	= 0;
												var est = "";
                                                var pdf = "";
												$.each(v, function(i,j)
													{
													    switch(i)
													    {
													    case "id":
													    	id = j;
													    	break;
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
														case "estado":
															est = j;
															break;
                                                        case "idPDF":
                                                            pdf = j;
                                                            break;
													    }
													});
												var color = "Black";
												if (kg < 0) {
												    color = "Red";
												}
                                                /*
												if(est != "PN"){
												 $("#entregasBody").append( "<tr style=\"font-size:11px;color:"+color+"\"><td></td><td>"+kg+"</td><td>"+cant+"</td><td>"+bul+"</td><td>"+fec+"</td></tr>");
												 $("#entregasBody").append( "<tr style=\"font-size:2px;\"><td colspan=\"5\"><hr></td></tr>");
												}else{
                                                */
													$("#entregasBody").append( "<tr style=\"font-size:11px;color:"+color+"\"><td><img src=\"./assest/plugins/buttons/icons/add.png\" width=\"20\" heigth=\"20\" onClick=\"seleccionado("+id+")\"></td><td style=\"padding-left: 10px\"><a "+(pdf == "" ? "onClick=\"generarPDF("+id+")\"" : "href=\"sistema/"+pdf+"\" download")+"><img src=\"./assest/plugins/buttons/icons/page_white_acrobat.png\" width=\"20\" heigth=\"20\"></a></td><td>"+kg+"</td><td>"+cant+"</td><td>"+bul+"</td><td>"+fec+"</td></tr>");
												 	$("#entregasBody").append( "<tr style=\"font-size:2px;\"><td colspan=\"5\"><hr></td></tr>");
												//}
											});
											$("#entregasBody").append( "<tr style=\"font-size:15px;\"><td></td><td></td><td><strong>"+totKg.toFixed(2)+"</strong></td><td><strong>"+totCant.toFixed(2)+"</strong></td><td><strong>"+totBul+"</strong></td><td colspan=\"2\"><strong>Totales</strong></td></tr>");
											$("#EnviarMailEntregas").modal('show');

                             				$('#btnAceptar').removeAttr('disabled');
                                          },
                error: function(){
                                    alert('Error');
                                    $('#btnAceptar').removeAttr('disabled');
                                  },
                dataType: 'json'
                };
    $.ajax(data_ajax);
	//$('#EnviarMailEntregas').modal('show');
});  


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


function seleccionado(id)
{
	 //alert(id);
	 
	 $("#idEntregaProtocolo").val(id);
	// $("#inputDestino").val($(nc).val());
	 
	 ClosePop("EnviarMailEntregas");
}

function generarPDF(idEnt){
    var data_ajax={
                type: 'POST',
                url: "/empaque_demo/generarPDF.php",
                data: { 
                        id: idEnt
                    },
                success: function( data ) {
                                            var link = document.createElement("a");
                                            link.download = name;
                                            link.href = 'sistema/'+data;
                                            link.click();
                                            $('#EnviarMailEntregas').modal('hide');
                                            //$('#selectEntrega').click();

                                          },
                error: function(){
                                    alert('Error');
                                    //$('#btnAceptar').removeAttr('disabled');
                                  },
                dataType: 'json'
                };
    $.ajax(data_ajax);
}


</script>