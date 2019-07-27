<?php
session_start();
if(!$_SESSION['Nombre'])
{
  return false;
}


//include ("conexion.php");

//
include ("config.php");
require("header.php");

//$vari = new conexion();
//$vari->conectarse();

  $sql="select * from usuarios";
  $usuarios=  R::getAll($sql);
  ?>

  <style type="text/css">
    #ArticuloPop{

        z-index: 100000;
    }
    .table{
        font-size:15px !important;
    }

    .table td{
        height:30px !important;
    }
    table.dataTable tbody td{
        height:30   px !important;
    }
  </style>
  <br>
  <div class="container">
    <center>
      <div id="menu" class="well">
        <div class="row">
          <div class="span10 text-center">
            <div class="page-header">
              <h2>
                Bobinas
              </h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="span10 text-left ">
            <a href="principal.php" class="btn btn-danger">&nbsp;Atrás&nbsp;</a>
            <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger hidden" onClick="inicio()">
            <input type="button" value="&nbsp;Agregar&nbsp;" class="btn btn-success pull-right" id="btnAgregar">
          </div>

          <div class="span5 pull-right hidden ">
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
            <table class="table table-hover table-bordered text-center table-sm" id="cantidades">
              <thead>
                <tr>
                  <th >-</th>
                  <th ><strong>Usuario</strong></th>
                  <th ><strong>Nombre / Apellido</strong></th>
                  <th >Acciones</th>
                </tr>
              </thead>
              <tbody >
                <?php foreach ($usuarios as $key => $value): ?>
                  <tr class="text-center">
                    <td class="text-center" style="text-align: center;" ><input class="cant_check" type="checkbox" name="bobina[]" value="<?php echo $value['id_usuario']?>" data-id="<?php echo $value['id_usuario']?>"></td>
                    <td><?php echo $value['nombre']?></td>
                    <td><?php echo $value['nombre_real']?></td>
                    <td class="text-center" style="text-align: center;">
                      <a href="#" class="bt_edit" data-id="<?php echo $value['id_usuario']?>">
                        <i class="fa fa-pencil fa-1x label label-success" aria-hidden="true"></i>
                      </a>
                    
                      <a href="#" class="bt_edit" data-id="<?php echo $value['id_usuario']?>">
                        <i class="fa fa-eye fa-1x label label-info" aria-hidden="true"></i>
                      </a>
                   
                      <a href="#" class="bt_delete" data-id="<?php echo $value['id_usuario']?>">
                        <i class="fa fa-times fa-1x label label-important" aria-hidden="true"></i>
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

<div class="modal hide fade" id="myModal" style="margin-left: -450px;">
    <div class="modal-header">      
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Usuarios</h3>
    </div>
    
      
    <div class="modal-body">




    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-default" id="btnCloseProductosPop" >Cerrar</a>
      <button type="submit" class="btn btn-info" id="form_submit" name="button">Guardar</button>
    </div>

    
  </div>


<script type="text/javascript">
  $(function(){

    $('table').DataTable( {
        "language": {
                "lengthMenu": "Ver _MENU_ filas por página",
                "zeroRecords": "No hay registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrando de un total de _MAX_ registros)",
                "sSearch": "Buscar:  ",
                "oPaginate": {
                    "sNext": "Sig.",
                    "sPrevious": "Ant."
                }
            },
    });
    
    $("#btnAgregar").click(function(event){
        console.log("NEW USER");
        $("#myModal").find(".modal-body").load('_modal_usuario_form.php');
        $("#myModal").modal("show");
        return false;       
    });

    $(document).on('click','.bt_edit',function(event){
        var id=$(this).data('id');
        console.log("===> id: %o",id);
        $("#myModal").find(".modal-body").load('_modal_usuario_form.php?id='+id);
        $("#myModal").modal("show");
        return false;
    });
    /*
    $(".bt_edit").click(function(the_event){
      var id=$(this).data('id');*/


    $(document).on('click','#myModal #form_submit',function(event){

        $("#myModal form ").find(".help-inline").remove();
        var inputs= $("#myModal").find("form input,form select");
        console.log("===> INPUTS: %o",inputs.length);
        var form_error=false;
        $.each(inputs,function(index,item){
            if($(this).val().length==0 && $(this).attr('id')!='user_id'){        
                console.log("===> form_error: %o",$(this).attr('name'));
                $(this).after("<span class='help-inline'>Debe Completar este campo</span>");
                form_error=true;                
            }
        });

        console.log("===> form_error: %o",form_error);
        if(form_error){
            return false;
        }

        var inputs_data= $("#myModal").find("form").serialize();     

        inputs_data+="&action=1";
        $.ajax({
          type:'POST',
          data:inputs_data,
          url: 'services/usuarios.php',
          success: function(data){
            window.location.href = "listado_usuarios.php";
            return false;
           },
           error: function(result){
          },
          dataType: 'json'
      });
        return false;
    });
    /*
    $("#btnAgregar").click(function(the_event){
        $("#bobina_id").val(null);
        $('#form_bobinas').trigger("reset");
        $("#myModal").modal("show");
    });

    $("#btnCloseProductosPop").click(function(the_event){
        $('#form_bobinas').trigger("reset");
        $("#myModal").modal("hide");
    });

    $(".bt_edit").click(function(the_event){
      var id=$(this).data('id');

      $.ajax({
          type:'GET',
          data:{action:2,id:id},
          url: 'services/bobinas.php',
          success: function(data){
            if(data.bobina === undefined){
              return false;
            }
            var bobina=data.bobina;
            $('#formato_id option[value='+bobina.formato_id+']').attr('selected','selected');
            $('#proveedor_id option[value='+bobina.proveedor_id+']').attr('selected','selected');
            $("#bobina_id").val(bobina.id);
            $("#nombre").val(bobina.nombre);
            $("#descripcion").val(bobina.descripcion);
            $("#largo").val(bobina.largo);
            return false;
           },
           error: function(result){
          },
          dataType: 'json'
      });
      $("#myModal").modal("show");
    });







    $("form").submit(function(){
      var form_data=$(this).serialize();
      console.debug(form_data);

      $.ajax({
          type:'POST',
          data:{action:1,params:form_data},
          url: 'services/bobinas.php',
          success: function(result){
            console.debug("===> result: %o",result);
            location.reload();
            return false;

           },
           error: function(result){
          },
          dataType: 'json'
      });
      return false;
    });*/
  });
</script>
