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

$proveedor = null;
if(isset($_GET['id']))
{
    $sql = "Select * from proveedores Where id_proveedor = ".$_GET['id'];
    $resu = mysql_query($sql);
    
    while($row = mysql_fetch_array($resu))
        {
            $proveedor = $row;
        }
        echo $proveedor['razon_social'];
    echo "<input type=\"hidden\" id=\"idP\" value=\"".$_GET['id']."\" >";
}
else
{
    echo "<input type=\"hidden\" id=\"idP\" value=\"0\" >";
}
?>
<br>
    <div class="container">
    <center>
	<div id="menu" class="well">
	
	    <div class="row">
		<div class="span6 offset2">
			  <div class="page-header">
			  <h2>
                                Proveedores
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    <div class="row">
                        <div class="span5">
                            <!------>
                            <div class="bs-docs-proveedor">
                                <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label" for="inputRZ">Razón Social</label>
                                    <div class="controls">
                                        <input type="text" id="inputRZ" placeholder="Razón Social" value="<?php echo ($proveedor != null ? $proveedor['razon_social'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputDire">Dirección</label>
                                    <div class="controls">
                                        <input type="text" id="inputDire" placeholder="Dirección" value="<?php echo ($proveedor != null ? $proveedor['direccion'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEnv">Envíos</label>
                                    <div class="controls">
                                        <input type="text" id="inputEnv" placeholder="Envíos" value="<?php echo ($proveedor != null ? $proveedor['envios'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputTF1">Teléfono 1</label>
                                    <div class="controls">
                                        <input type="text" id="inputTF1" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['telefono'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputTF2">Teléfono 2</label>
                                    <div class="controls">
                                        <input type="text" id="inputTF2" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['telefono2'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputTF3">Teléfono 3</label>
                                    <div class="controls">
                                        <input type="text" id="inputTF3" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['telefono3'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputMailP">Correo Electrónico</label>
                                    <div class="controls">
                                        <input type="text" id="inputMailP" placeholder="Correo Electrónico" value="<?php echo ($proveedor != null ? $proveedor['mail'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputWeb">Web</label>
                                    <div class="controls">
                                        <input type="text" id="inputWeb" placeholder="Web" value="<?php echo ($proveedor != null ? $proveedor['web'] : "");?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputObs">Observación</label>
                                    <div class="controls">
                                        <textarea id="inputObs" placeholder="Observaciónes.."><?php echo ($proveedor != null ? $proveedor['observacion'] : "");?></textarea>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="bs-docs-tipos">
                                <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">Tipos</label>
                                    <label class="control-label" style="margin-left: 50px;">Cm2 en u$s</label>
                                </div>
                                <div class="control-group">
                                    <select id="tipo_poli">
                                        <?php
                                            $query = "SELECT * FROM tipo_polimero WHERE estado = 'AC' ";
                                            
                                            $resu = mysql_query($query);
                                            if(mysql_num_rows($resu) > 0)
                                                {
                                                   while($row = mysql_fetch_array($resu))
                                                   {
                                                       echo "<option id=".$row['idTipoPoli'].">".$row['descTipoPoli']."</option>";
                                                   }
                                                }
                                        ?>
                                    </select>
                                    <input type="text" id="inputCash" placeholder="Precio" class="input-small" style="width: 150px;">
                                    <input type="button" class="btn btn-success" value="+" onclick="addRow()">
                                </div>
                                <hr>
                                    <table class="table" id="table_polim">
                                        <thead>
                                            <th style="width: 50%">Tipo</th>
                                            <th style="width: 30%">Precio</th>
                                            <th style="width: 20%">Eliminar</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($_GET['id'] > 0)
                                                $sql = "SELECT tp.idTipo, tp.Precio, t.descTipoPoli
                                                        FROM tbl_proveedores_tipo AS tp
                                                        JOIN tipo_polimero AS t ON tp.idTipo = t.idTipoPoli
                                                        WHERE tp.idProveedor =".$_GET['id'];
                                                $resu = mysql_query($sql);
                                                if(mysql_num_rows($resu) > 0)
                                                {
                                                   while($row = mysql_fetch_array($resu))
                                                   {
                                                    echo "<tr id=\"".$row['idTipo']."_row\">";
                                                    echo "<td>".$row['descTipoPoli']."</td>";
                                                    echo "<td style=\"text-align: right\">".$row['Precio']."</td>";
                                                    echo "<td style=\"text-align: center\"><img src=\"./assest/plugins/buttons/icons/delete.png\" width=\"15\" heigth=\"15\" title=\"Eliminar\" onClick=\"deleteRow('".$row['idTipo']."_row')\" style=\"cursor:pointer\"/></td></tr>";
                                                   }
                                                }
                                                
                                                
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="span5">
                            <div class="bs-docs-resp_ventas">
                                <div class="form-horizontal">
				<div class="control-group">
				    <label class="control-label" for="inputNameRV">Nombre</label>
				    <div class="controls">
					<input type="text" id="inputNameRV" placeholder="Nombre" value="<?php echo ($proveedor != null ? $proveedor['rv_Nombre'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputTelRV">Teléfono</label>
				    <div class="controls">
					<input type="text" id="inputTelRV" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['rv_telefono'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputMailRV">Mail</label>
				    <div class="controls">
					<input type="text" id="inputMailRV" placeholder="Mail" value="<?php echo ($proveedor != null ? $proveedor['rv_mail'] : "");?>">
				    </div>
				</div>
                                </div>
			    </div>
                            <div class="bs-docs-resp_pre">
                                <div class="form-horizontal">
				<div class="control-group">
				    <label class="control-label" for="inputName1PR">Nombre</label>
				    <div class="controls">
					<input type="text" id="inputName1PR" placeholder="Nombre" value="<?php echo ($proveedor != null ? $proveedor['rp1_nombre'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputTel1PR">Teléfono</label>
				    <div class="controls">
					<input type="text" id="inputTel1PR" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['rp1_telefono'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputMail1PR">Mail</label>
				    <div class="controls">
					<input type="text" id="inputMail1PR" placeholder="Mail" value="<?php echo ($proveedor != null ? $proveedor['rp1_mail'] : "");?>">
				    </div>
				</div>
                                <div><hr></div>
                                <div class="control-group">
				    <label class="control-label" for="inputName2PR">Nombre</label>
				    <div class="controls">
					<input type="text" id="inputName2PR" placeholder="Nombre" value="<?php echo ($proveedor != null ? $proveedor['rp2_nombre'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputTel2PR">Teléfono</label>
				    <div class="controls">
					<input type="text" id="inputTel2PR" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['rp2_telefono'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputMail2PR">Mail</label>
				    <div class="controls">
					<input type="text" id="inputMail2PR" placeholder="Mail"  value="<?php echo ($proveedor != null ? $proveedor['rp2_mail'] : "");?>">
				    </div>
				</div>
                                <div><hr></div>
                                <div class="control-group">
				    <label class="control-label" for="inputName3PR">Nombre</label>
				    <div class="controls">
					<input type="text" id="inputName3PR" placeholder="Nombre" value="<?php echo ($proveedor != null ? $proveedor['rp3_nombre'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputTel3PR">Teléfono</label>
				    <div class="controls">
					<input type="text" id="inputTel3PR" placeholder="Teléfono" value="<?php echo ($proveedor != null ? $proveedor['rp3_telefono'] : "");?>">
				    </div>
				</div>
				<div class="control-group">
				    <label class="control-label" for="inputMail3PR">Mail</label>
				    <div class="controls">
					<input type="text" id="inputMail3PR" placeholder="Mail" value="<?php echo ($proveedor != null ? $proveedor['rp3_mail'] : "");?>">
				    </div>
				</div>
                                </div>
			    </div>
                        </div>
                    </div>
		</div>
	    </div>
            <!---->
            <div class="row">
                <div class="span10" style="text-align: right">
                        <input type="button" value="Cancelar" onClick="back();">&nbsp;&nbsp;&nbsp;</td>
                        <input type="button" id="btn_save" value="Aceptar" onClick="guardar()" class="btn btn-primary">
                </div>
            </div>
            <!---->
	</div>    
    </center>
    </div>
    <input type="hidden" id="idProveedor" value="">

<!-- Mensajes de Alertas y/o error -->
<div class="modal hide fade" id="MensajesPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 style="color: red;">Error!!</h3>
  </div>
  <div class="modal-body">
    <br>
    <div id="msj_error_pop" class="alert alert-error">
	
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseMensajePop" onclick="closeMensaje()">Cerrar</a>
  </div>
</div>

<!-- ---------------------->

<?php

require("footer.php");

?>
<script>
    function guardar()
    {
        var id  = 0;
        var razonSocial = "";
        var direccion = "";
        var envios = "";
        var telefono1 = "";
        var telefono2 = "";
        var telefono3 = "";
        var mail = "";
        var web = "";
        var observaciones = "";
        var nombreRV = "";
        var telefonoRV = "";
        var mailRV = "";
        var nombrePR1 = "";
        var telefonoPR1 = "";
        var mailPR1 = "";
        var nombrePR2 = "";
        var telefonoPR2 = "";
        var mailPR2 = "";
        var nombrePR3 = "";
        var telefonoPR3 = "";
        var mailPR3 = "";
        
        $('#btn_save').attr("disabled", "disabled");
        
        //Razon Social 
        if($("#inputRZ").val() == "")
            {
                    $('#msj_error_pop').html("<strong>Ingrese una razón social válida.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    razonSocial = $("#inputRZ").val();
            }
        
        //Direccion
        if($("#inputDire").val() == "")
            {
                    $('#msj_error_pop').html("<strong>Ingrese una dirección válida.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    direccion = $("#inputDire").val();
            }
            
        //Envios 
        if($("#inputEnv").val() == "")
            {
                    $('#msj_error_pop').html("<strong>El campo envíos es obligatorio.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    envios = $("#inputEnv").val();
            }
            
        //Telefono 1
        if($("#inputTF1").val() == "")
            {
                    $('#msj_error_pop').html("<strong>El campo teléfono 1 es obligatorio.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    var telefono1 = $("#inputTF1").val();
                    if($("#inputTF2").val() != "")
                        telefono2 = $("#inputTF2").val();
                    if($("#inputTF3").val() != "")
                        telefono3 = $("#inputTF3").val();
            }
            
        //Correo electronico
        if($("#inputMailP").val() == "")
            {
                    $('#msj_error_pop').html("<strong>El campo correo electrónico es obligatorio.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    mail = $("#inputMailP").val();
            }
        
        //Web
        if($("#inputWeb").val() != "")
            {
                web = $("#inputWeb").val();
            }
            
        //Observaciones
        if($("#inputObs").val() != "")
            {
                observaciones = $("#inputObs").val();
            }
            
        //Nombre del responsable de ventas
        if($("#inputNameRV").val() == "")
            {
                    $('#msj_error_pop').html("<strong>El nombre del responsable de ventas es obligatorio.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    nombreRV = $("#inputNameRV").val();
            }
            
        //Telefono del responsable de ventas
        if($("#inputTelRV").val() == "")
            {
                    $('#msj_error_pop').html("<strong>El teléfono del responsable de ventas es obligatorio.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    telefonoRV = $("#inputTelRV").val();
            }
            
        //Mail del responsable de ventas
        if($("#inputMailRV").val() == "")
            {
                    $('#msj_error_pop').html("<strong>El correo electrónico del responsable de ventas es obligatorio.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    mailRV = $("#inputMailRV").val();
            }    
        
        //Nombre de los responsables de preprensa
        if($("#inputName1PR").val() == "" || $("#inputTel1PR").val() == "" || $("#inputMail1PR").val() == "")
            {
                    $('#msj_error_pop').html("<strong>Los datos del responsable de preprensa 1 no estan completos.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    return false;	
            }
            else
            {
                    nombrePR1 = $("#inputName1PR").val();
                    telefonoPR1 = $("#inputTel1PR").val();
                    mailPR1 = $("#inputMail1PR").val();
                    
                    nombrePR2 = $("#inputName2PR").val();
                    telefonoPR2 = $("#inputTel2PR").val();
                    mailPR2 = $("#inputMail2PR").val();
                    
                    nombrePR3 = $("#inputName3PR").val();
                    telefonoPR3 = $("#inputTel3PR").val();
                    mailPR3 = $("#inputMail3PR").val();
            }
            
            var varIds = "";
            var precios = "";
            
            $("#table_polim tbody tr").each(function (index) {
                var id = $(this).attr('id');
                id = id.replace("_row", "");
                varIds += id + "~";
                $(this).children("td").each(function (index2) {
                    switch (index2) {
                        case 1:
                            precios += $(this).text() + "~";
                            break;
                    }
                });
            });
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoProveedoresSavephp.php",
                        data: {
                                inid            : $("#idP").val(),
                                inrazonSocial   : razonSocial,
                                indireccion     : direccion,
                                inenvios        : envios,
                                intelefono1     : telefono1,
                                intelefono2     : telefono2,
                                intelefono3     : telefono3,
                                inmail          : mail,
                                inweb           : web,
                                inobservaciones :observaciones,
                                innombreRV      : nombreRV,
                                intelefonoRV    : telefonoRV,
                                inmailRV        : mailRV,
                                innombrePR1     : nombrePR1,
                                intelefonoPR1   : telefonoPR1,
                                inmailPR1       : mailPR1,
                                innombrePR2     : nombrePR2,
                                intelefonoPR2   : telefonoPR2,
                                inmailPR2       : mailPR2,
                                innombrePR3     : nombrePR3,
                                intelefonoPR3   : telefonoPR3,
                                inmailPR3       : mailPR3,
                                invarId         : varIds,
                                inPrecios       : precios
                                },
                        success: function( data ) {
                                                    if(data == null)
                                                    {
							$(location).attr('href','../empaque/listadoProveedores.php');
                                                    }
                                                    else
                                                    {
							$('#MensajesPop').show();
							$('#msj_box_error_pop').html("Ocurrio un error, revise los campos ingresados y vuelva a intentarlo.");
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
        
        return false;
    }
    
    function addRow()
    {
        if ($('#'+$('#tipo_poli option:selected').attr('id')+'_row').length){
            $('#msj_error_pop').html("<strong>El tipo de calidad ya fue ingresado.</strong>");
            $('#MensajesPop').modal('show');
        }
        else
        {
            if ($("#inputCash").val() != "") {
                var row = "<tr id=\""+$('#tipo_poli option:selected').attr('id')+"_row\"><td>"+$("#tipo_poli").val()+"</td>";
                    row += "<td style=\"text-align: right\">"+$("#inputCash").val()+"</td>";
                    row += "<td style=\"text-align: center\"><img src=\"./assest/plugins/buttons/icons/delete.png\" width=\"15\" heigth=\"15\" title=\"Eliminar\" onClick=\"deleteRow('"+$('#tipo_poli option:selected').attr('id')+"_row')\" style=\"cursor:pointer\"/></td></tr>";
                $("#table_polim tbody").append(row);
                $("#inputCash").val("");
            }
        }
    }
    
    function deleteRow(id)
    {
        $("#"+id+"").remove();
        $("#inputCash").val("");
    }
    
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
	
	if($('#inputCotiza').val() == "")
	{
	    $('#msj_box_error').html("Ingrese cotización válida ( mayor o igual a cero ).");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	return true;
		
    }
    
    $('#btnCloseMensajePop').click(function(){
        $("#MensajesPop").modal('hide');
    });
    
    function back()
    {
        $(location).attr('href','../empaque/listadoProveedores.php');
    }
</script>