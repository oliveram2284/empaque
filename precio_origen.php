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


$sql="select id,nombre from precio_origen  ;";
$motivos=  R::getAll($sql);
?>
<style type="text/css">
  #ArticuloPop{

    z-index: 100000;
  }
  table th, table td {
   height: 20px !important;
    padding: 5px !important;
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
                Origen de Precio de Artículo
              </h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="span5 text-left ">
            <a href="principal.php" class="btn btn-danger">&nbsp;Atrás&nbsp;</a>
            <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger hidden" onClick="inicio()">
            <input type="button" value="&nbsp;Agregar&nbsp;" class="btn btn-success" id="btnAgregar">
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
            <table class="table table-hover table-bordered text-center table-condensed" id="cantidades">
              <thead>
                <tr>
                  <th >-</th>
                  <th ><strong>Nombre</strong></th>
                  <th >Editar</th>
                  <th >Eliminar</th>
                </tr>
              </thead>
              <tbody >
                <?php foreach ($motivos as $key => $value):?>
                  <tr class="text-center">
                    <td><input class="cant_check" type="checkbox" name="bobina[]" value="<?php echo $value['id']?>" data-id="<?php echo $value['id']?>"></td>
                    <td><?php echo $value['nombre']?></td>
                    <td class="text-center" style="text-align: center;margin-left: 10%;">
                      <a href="#" class="bt_edit" data-id="<?php echo $value['id']?>">
                        <i class="fa fa-pencil fa-2x label label-success" aria-hidden="true"></i>
                      </a>
                    </td>
                    <td style="text-align: center;margin-left: 10%;">
                      <a href="#" class="bt_delete" data-id="<?php echo $value['id']?>">
                        <i class="fa fa-times fa-2x label label-important" aria-hidden="true"></i>
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

<div class="modal hide fade" id="MotivoModal" style="width: 900px; margin-left: -450px;">
    <div class="modal-header">
      <input type="hidden" id="busc" value="1">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Motivo de Modificación</h3>
    </div>
    <form class="form-horizontal" action="" method="post" id="form_bobinas">
      <input type="hidden" name="id" id="motivo_id" >
    <div class="modal-body">

      <div class="control-group">
        <label class="control-label" for="nombre">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre" name="nombre" placeholder="Nombre">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="descripcion">Descripción</label>
        <div class="controls">
          <textarea name="descripcion" id="descripcion" ></textarea>
          <!-- <input type="text" id="descripcion" name="descripcion" placeholder="Descripción"> -->
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-default" id="btnCloseProductosPop" >Cerrar</a>
      <button type="submit" class="btn btn-info" name="button">Guardar</button>
    </div>

    </form>
  </div>


<script type="text/javascript">
  $(function(){
    $("#btnAgregar").click(function(the_event){
        $("#motivo_id").val(null);
        $('#form_bobinas').trigger("reset");
        $("#MotivoModal").modal("show");
    });

    $("#btnCloseProductosPop").click(function(the_event){
        $('#form_bobinas').trigger("reset");
        $("#MotivoModal").modal("hide");
    });

    $(".bt_edit").click(function(the_event){
      var id=$(this).data('id');

      $.ajax({
          type:'GET',
          data:{action:2,id:id},
          url: 'services/OrigenPrecio.php',
          success: function(data){
            if(data.data === undefined){
              return false;
            }
            var datos=data.data;
            console.log("===> DATOS: %o",datos);
            $("#motivo_id").val(datos.id);
            $("#nombre").val(datos.nombre);
            $("#descripcion").val(datos.descripcion);
            return false;
           },
           error: function(result){
          },
          dataType: 'json'
      });
      $("#MotivoModal").modal("show");
    });

    $(".bt_delete").click(function(){
        console.log("DELETE ITEM");
        var id=$(this).data('id');

        $.ajax({
            type:'GET',
            data:{action:3,id:id},
            url: 'services/OrigenPrecio.php',
            success: function(data){
              
              location.reload();
              return false;
            },
            error: function(result){
            },
            dataType: 'json'
        });
    });



    $("form").submit(function(){
      var form_data=$(this).serialize();
      console.debug(form_data);

      $.ajax({
          type:'POST',
          data:{action:1,params:form_data},
          url: 'services/OrigenPrecio.php',
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
    });
  });
</script>
