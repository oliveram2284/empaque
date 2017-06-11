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

//Create Table if Doesn't exist
$sql_create_table="SET FOREIGN_KEY_CHECKS=0;
create database if not exists `bobinas`;
CREATE TABLE `bobinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formato_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `descripcion`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
  `largo` decimal(10,0) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


  $sql="select b.*,(SELECT descripcion from formatos WHERE idFormato=b.formato_id) as 'formato',(SELECT razon_social from proveedores where id_proveedor=b.proveedor_id) as 'proveedor' from bobinas b ;";
  $bobinas=  R::getAll($sql);
  $formatos = R::getAll("SELECT idFormato as 'id', descripcion as 'descripcion'  FROM formatos order by descripcion asc ");
  $proveedores = R::getAll("SELECT id_proveedor as 'id', razon_social as 'descripcion' FROM proveedores order by razon_social asc ");
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
                Bobinas
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
            <table class="table table-hover table-bordered text-center" id="cantidades">
              <thead>
                <tr>
                  <th >-</th>
                  <th ><strong>Nombre</strong></th>
                  <th ><strong>Formato</strong></th>
                  <th ><strong>Proveedor</strong></th>
                  <th ><strong>Largo Bobina</strong></th>
                  <th ><strong>Alta</strong></th>
                  <th >Editar</th>
                  <th >Eliminar</th>
                </tr>
              </thead>
              <tbody >
                <?php foreach ($bobinas as $key => $value):?>
                  <tr class="text-center">
                    <td><input class="cant_check" type="checkbox" name="bobina[]" value="<?php echo $value['id']?>" data-id="<?php echo $value['id']?>"></td>
                    <td><?php echo $value['nombre']?></td>
                    <td><?php echo $value['formato']?></td>
                    <td><?php echo $value['proveedor']?></td>
                    <td><?php echo str_replace('.', ',', $value['largo'])?></td>
                    <td><?php echo $value['created']?></td>

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

                  </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </center>
  </div>

<div class="modal hide fade" id="BobinaModal" style="width: 900px; margin-left: -450px;">
    <div class="modal-header">
      <input type="hidden" id="busc" value="1">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Alta Bobinas</h3>
    </div>
    <form class="form-horizontal" action="" method="post" id="form_bobinas">
      <input type="hidden" name="id" id="bobina_id" >
    <div class="modal-body">


        <div class="control-group">
          <label class="control-label" for="formato_id">Formato</label>
          <div class="controls">
            <select class="" name="formato_id" id="formato_id">
              <option value="">Seleccionar Formato</option>
              <?php foreach ($formatos as $key => $value):?>
                <option value="<?php echo $value['id']?>"><?php echo $value['descripcion']?></option>
              <?php endforeach;?>
            </select>

          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="proveedor_id">Proveedor</label>
          <div class="controls">
            <select class="" name="proveedor_id" id="proveedor_id">
              <option value="">Seleccionar Proveedor</option>
              <?php foreach ($proveedores as $key => $value):?>
                <option value="<?php echo $value['id']?>"><?php echo $value['descripcion']?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="nombre">Nombre</label>
          <div class="controls">
            <input type="text" id="nombre" name="nombre" placeholder="Nombre">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="descripcion">Descripción</label>
          <div class="controls">
            <input type="text" id="descripcion" name="descripcion" placeholder="Descripción">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="largo">Largo</label>
          <div class="controls">
            <input type="text" id="largo" name="largo" placeholder="largo">
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
        $("#bobina_id").val(null);
        $('#form_bobinas').trigger("reset");
        $("#BobinaModal").modal("show");
    });

    $("#btnCloseProductosPop").click(function(the_event){
        $('#form_bobinas').trigger("reset");
        $("#BobinaModal").modal("hide");
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
      $("#BobinaModal").modal("show");
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
    });
  });
</script>
