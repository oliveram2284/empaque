<?php
session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("config.php");
include ("conexion.php");
require("header.php");

$vari = new conexion();
$vari->conectarse();


$sql="SELECT fc.*,f.descripcion as formato_descripcion FROM formatos_cantidades as fc INNER JOIN formatos as f ON f.idFormato=fc.formato_id ;";

$cantidades=  R::getAll($sql);


?>
<style type="text/css">
#ArticuloPop{

    z-index: 100000;
}
</style>
<br>
    <div class="container">
    <center>
	<div id="menu" class="well">
	    <div class="row">
		<div class="span11 text-center">
			<div class="page-header">
			  <h2>
                   Formato Cantidades
			  </h2>
			</div>
		</div>
	    </div>
	    <div class="row">
		<div class="span5 text-left ">
            <a href="principal.php" class="btn btn-danger">&nbsp;Atrás&nbsp;</a>
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger hidden" onClick="inicio()">
		    <input type="button" value="&nbsp;Agregar&nbsp;" class="btn btn-success" id="btnAceptar">
		</div>

    <div class="span5 pull-right ">
      <div class="btn-group">
        <a href="#" id="delete_selected_bt" class="btn btn-default"> Eliminar</a>
      <a href="#" id="enable_selected_bt" class="btn btn-default"> Hablitar</a>
      <a href="#" id="disable_selected_bt" class="btn btn-default"> Deshabilitar</a>
</div>


		</div>

	    </div>
        <br>
	    <div class="row">
            <div class="span10">
                <table class="table table-hover table-bordered text-center" id="cantidades">
                    <thead>
                        <tr>
                            <th >-</th>
                            <th ><strong>Formato</strong></th>
                            <th ><strong>Descripción</strong></th>
                            <th ><strong>Largo/Corte</strong></th>
                            <th ><strong>Ancho</strong></th>
                            <th ><strong>Multiplos de Bolsas</strong></th>
                            <th >Editar</th>

                            <th >Eliminar</th>
                            <th >Habilitado</th>
                        </tr>
                    </thead>
                    <tbody >
                        <?php foreach ($cantidades as $key => $value):?>
                            <tr class="text-center">
                                <td><input class="cant_check" type="checkbox" name="cant[]" value="<?php echo $value['id']?>" data-id="<?php echo $value['id']?>"></td>
                                <td><?php echo $value['formato_descripcion']?></td>
                                <td><?php echo $value['descripcion']?></td>
                                <td><?php echo str_replace('.', ',', $value['largo'])?></td>
                                <td><?php echo str_replace('.', ',', $value['ancho'])?></td>
                                <td><?php echo $value['multiplo']?> Unidades</td>
                                <td>
                                    <a href="#" class="bt_edit" data-id="<?php echo $value['id']?>">
                                        <i class="fa fa-pencil fa-2x label label-success" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="bt_delete" data-id="<?php echo $value['id']?>">
                                        <i class="fa fa-times fa-2x label label-important" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="bt_disabled" data-id="<?php echo $value['id']?>" data-status="<?php echo $value['status']?>">

                                        <i class="fa <?php echo ($value['status']==1)?'fa-check-square-o':'fa-square-o'?> fa-2x label label-warning" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
		</div>
	    </div>
	</div>
    </center>
    </div>

    <center>
        <div class="modal hide fade" id="ArticuloPop" style="width: 900px; margin-left: -450px;">
          <div class="modal-header">
            <input type="hidden" id="busc" value="1">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Búsqueda de Productos</h3>
          </div>
          <div class="modal-body">
            <table>
                <tr>
                    <td><strong>Buscar :   </strong>  <input type="text" id="inputArticulo" ></td>
                    <td>
                        <div class="btn-group" data-toggle="buttons-radio" style="margin-top: -8px;">
                            <button type="button" class="btn btn-primary active" onclick="setear(1)">  </button>
                            <button type="button" class="btn btn-primary" onclick="setear(2)">+</button>
                            <button type="button" class="btn btn-primary" onclick="setear(3)">-</button>
                            <button type="button" class="btn btn-primary" onclick="setear(4)">+ -</button>
                        </div>
                    </td>
                </tr>
            </table>
            <div id="resultado_Productos" style="width: 90%; min-height: 250px; max-height: 250px;">

            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn" id="btnCloseProductosPop" onclick="ClosePop('ProductosPop')">Cerrar</a>
          </div>
        </div>
    </center>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalCant">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Multiplos</h4>
            </div>
            <div class="modal-body">
                <div class="alert  alert-error hidden">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Error!</h4>
                    <p></p>
                </div>
                <form class="form-horizontal">
                    <input type="hidden" id="id" name="id" value=0>
                    <input type="hidden" id="articulo_nombre" name="articulo_nombre" value="">
                    <!--<div class="control-group">
                        <label class="control-label" for="field_formato" >Artículo:</label>
                        <div class="controls">
                            <input  class="input-large" type="text" id="id_articulo" name="articulo_id" placeholder="Codigo Artículo">
                        </div>
                    </div>-->
                    <div class="control-group">
                        <label class="control-label" for="field_formato" >Formato:</label>
                        <div class="controls">
                            <select id="field_formato" name="formato">
                            </select>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Descripción:</label>
                        <div class="controls">
                          <textarea  class="input-large" name="descripcion" id="field_description" ></textarea>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Largo (Corte) :</label>
                        <div class="controls">
                            <input  class="input-large" type="text" id="field_largo" name="largo" placeholder="Largo">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Ancho:</label>
                        <div class="controls">
                            <input  class="input-large" type="text" id="field_ancho" name="ancho" placeholder="Ancho">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Micronaje:</label>
                        <div class="controls">
                            <input  class="input-large" type="text" id="field_micronaje" name="micronaje" placeholder="Micronaje">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Multiplo:</label>
                        <div class="controls">
                            <input  class="input-large" type="text" id="field_multiplo" name="multiplo" placeholder="Multiplo">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="bt_submit" class="btn btn-success">Guardar Cantidad</button>
            </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php




require("footer.php");

?>
<script>


    var load_format=function(){
         var data_ajax={
            type: 'POST',
            url: "services/formatos.php",
            beforeSend:function(xhr){
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            },
            data: {action:1},
            success: function(data) {
                $("#field_formato").append($('<option>', {value: 0,text: "Seleccionar Formato"}));
                $.each(data.result,function(index,item){
                    $("#field_formato").append($('<option>', {value: item.id,text: item.name}));
                });
            },
            error:function(){
                //console.debug("===> error Carga Formato");
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
    }

$(function(){
    load_format();


    /*$("#id_articulo").click(function(the_event){
        $("#ArticuloPop").modal("show");
    });*/

    $("#inputArticulo").keyup(function(){
        //console.debug("keyup load: %o", $(this).val());

        var color = '#FFFFFF';
        var data_ajax={
                type: 'POST',
                url: "/empaque_demo/buscarProducto.php",
                //url: "jsons/buscarArticulo.json",
                data: { xinput: $(this).val(), xpage: 1 , busq: 1 },
                success: function( data ) {

                    if(data != 0){
                        var fila = '<table class="table" id="art_table">';
                        fila +='<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th style="width: 500px;">Artículo</th><th>Código Producto</th></tr></thead>';
                        fila += "<tbody>";
                        $.each(data, function(index,articulo){

                            if(color == '#A9F5A9'){
                                color = '#FFFFFF';
                            }
                            else{
                                color = '#A9F5A9';
                            }

                            //console.debug("=> articulo data: %o",articulo);
                            fila += '<tr style="cursor: pointer; background-color:'+color+'" id="'+articulo.Id+'" data-id="'+articulo.Id+'"  data-name="'+articulo.Articulo+'">';
                            fila +='<td>';
                            fila +='<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
                            fila +='</td>';
                            fila +="<td>"+articulo.Id+"</td>";
                            fila += '<input type="hidden" id="'+articulo.Id+'_cp" value="'+articulo.Id+'">';

                            fila +='<td style="padding-left: 10px;">'+articulo.Articulo+'</td>';
                            fila += '<input type="hidden" id="'+articulo.Id+'_arp" value="'+articulo.Articulo+'">';

                            fila +="<td>"+articulo.Nombre_en_Facturacion+"</td>";
                            fila += '<input type="hidden" id="'+articulo.Id+'_ncp" value="'+articulo.Nombre_en_Facturacion+'">';


                            fila += "</tr>";
                        });
                        fila += "</tbody></table>";
                        $("#resultado_Productos").html(fila);
                    }else{
                        $("#resultado_Productos").html('<strong style="color: red;">No se encontraron resultados</strong>');
                    }
                },
                error: function(){
                            alert("Error de conexión.");
                    },
                dataType: 'json'
                };
        $.ajax(data_ajax);
    });


    $(document).on('click','#art_table tr',function(){
        var code=$(this).data('id');
        var name=$(this).data('name');
        $("#id_articulo").val(code);
        $("#articulo_nombre").val(name);
        $("#ArticuloPop").modal("hide");
    });

    $("#btnAceptar").click(function(){
      $("form").trigger("reset");
      $("#modalCant").modal("show");
    });
    $("#bt_submit").click(function(){
        //////console.debug("SUBMIT FORM");

        var validate=true;
        if($("#field_formato").val() == 0){
            validate=false;
            $(".alert").find("p").text("Debe seleccionar un Formato de Material");
            $(".alert").removeClass("hidden");
            $("#field_formato").focus();
            return false;
        }


        if($("#field_largo").val().length<0){
            validate=false;
            $(".alert").find("p").text("Debe ingresar Largo de Formato");
            $(".alert").removeClass("hidden");
            $("#field_largo").focus();
            return false;
        }

        if($("#field_ancho").val().length<0){
            validate=false;
            $(".alert").find("p").text("Debe ingresar Ancho de Formato");
            $(".alert").removeClass("hidden");
            $("#field_ancho").focus();
            return false;
        }

       if($("#field_multiplo").val().length<0){
            validate=false;
            $(".alert").find("p").text("Debe ingresar Multiplos de Unidades de Formato");
            $(".alert").removeClass("hidden");
            $("#field_multiplo").focus();
            return false;
        }


        if(validate){

             var data_ajax={
                type: 'POST',
                url: "services/formatos.php",
                beforeSend:function(xhr){
                    xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                    $(".alert").find("p").text(null);
                    $(".alert").addClass("hidden");
                },
                data: {action:2,params:$("form").serialize()},
                success: function(data) {
                    ////console.debug("==> seria: %o",data);
                    $("#modalCant").modal("hide");
                    location.reload();
                },
                error:function(){
                    //console.debug("===> error Carga Formato");
                },
                dataType: 'json'
            };
            $.ajax(data_ajax);

        }

        return false;
    });

    $(".bt_edit").click(function(){
        //console.debug("bt_edit clicked");
        var id=$(this).data('id');
        //console.debug("Formato cantidad ID: %o",id);

        var data_ajax={
            type: 'POST',
            url: "services/formatos.php",
            beforeSend:function(xhr){
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            },
            data: {action:3,id:id},
            success: function(data) {
                formato=data.formato;
                //console.debug("Formato cantidad data: %o",formato);
                $('#field_formato option[value="'+formato.formato_id+'"]').prop('selected', true);
                $("#id").val(formato.id);
                $("#field_description").val(formato.descripcion);
                $("#field_ancho").val(formato.ancho);
                $("#field_largo").val(formato.largo);
                $("#field_micro").val(formato.micronaje);
                $("#field_micronaje").val(formato.micronaje);
                $("#field_peso").val(formato.peso);
                $("#field_multiplo").val(formato.multiplo);
                $("#modalCant").modal("show");

            },
            error:function(){
                //console.debug("===> error Carga Formato");
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);

        return false;
    });
    $(".bt_delete").click(function(){
        //console.debug("bt_delete clicked");
        var id=$(this).data('id');
        //console.debug("Formato cantidad ID: %o",id);
        var data_ajax={
            type: 'POST',
            url: "services/formatos.php",
            beforeSend:function(xhr){
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            },
            data: {action:4,id:id},
            success: function(data) {
                $("#modalCant").modal("hide");
                location.reload();
            },
            error:function(){
                //console.debug("===> error Carga Formato");
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
        return false;
    });
    $(".bt_disabled").click(function(){
        //console.debug("bt_delete clicked");
        var id=$(this).data('id');
        var status=0;
        var icon_bt="";
        if($(this).data('status')==0){
            status=1;
            icon_bt='fa fa-check fa-2x label label-warning';
        }else{
            icon_bt='fa fa-check-square-o fa-2x label label-warning';
        }
        //console.debug("Formato cantidad ID: %o",id);
        //console.debug("Formato cantidad status: %o",status);

        var data_ajax={
            type: 'POST',
            url: "services/formatos.php",
            beforeSend:function(xhr){
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            },
            data: {action:5,id:id,status:status},
            success: function(data) {
                location.reload();
            },
            error:function(){
                //console.debug("===> error Carga Formato");
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
        location.reload();
    });


    $("#delete_selected_bt").click(function(){
      if (confirm('Esta seguro que quiere ELIMINAR estas opciones?')) {
        var checkbox_checked=$("table").find("input[type=checkbox]:checked");
        ids=[];
        $.each(checkbox_checked,function(index,input){
          ids.push($(input).data('id'));
        });

        if(ids.length>0){
          var data_ajax={
               type: 'POST',
               url: "services/formatos.php",
               beforeSend:function(xhr){
                   xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
               },
               data: {action:7,ids:ids},
               success: function(data) {
                   location.reload();
               },
               error:function(){
                   alert("===> error ERROR AL ELIMINAR FORMATOS");
                   return false;
               },
               dataType: 'json'
           };
           $.ajax(data_ajax);
        }
      } else {
        return false;
      }
    });


    $("#enable_selected_bt").click(function(){
      if (confirm('Esta seguro que quiere Habilitar estas opciones?')) {
        var checkbox_checked=$("table").find("input[type=checkbox]:checked");
        ids=[];
        $.each(checkbox_checked,function(index,input){
          ids.push($(input).data('id'));
        });

        if(ids.length>0){
          var data_ajax={
               type: 'POST',
               url: "services/formatos.php",
               beforeSend:function(xhr){
                   xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
               },
               data: {action:8,status:1,ids:ids},
               success: function(data) {

                   location.reload();
               },
               error:function(){
                   alert("===> error ERROR AL ELIMINAR FORMATOS");
                   return false;
               },
               dataType: 'json'
           };
           $.ajax(data_ajax);
        }
      } else {
        return false;
      }
    });

    $("#disable_selected_bt").click(function(){
      if (confirm('Esta seguro que quiere Deshabilitar estas opciones?')) {
        var checkbox_checked=$("table").find("input[type=checkbox]:checked");
        ids=[];
        $.each(checkbox_checked,function(index,input){
          ids.push($(input).data('id'));
        });

        if(ids.length>0){
          var data_ajax={
               type: 'POST',
               url: "services/formatos.php",
               beforeSend:function(xhr){
                   xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
               },
               data: {action:8,status:0,ids:ids},
               success: function(data) {

                   location.reload();
               },
               error:function(){
                   alert("===> error ERROR AL ELIMINAR FORMATOS");
                   return false;
               },
               dataType: 'json'
           };
           $.ajax(data_ajax);
        }
      } else {
        return false;
      }
    });
});

</script>
