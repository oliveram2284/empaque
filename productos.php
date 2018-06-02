<?php
session_start();

if(!$_SESSION['Nombre']){
  return false;
}

require("header.php");
?>

  <style type="text/css">
  #ArticuloPop{

    z-index: 100000;
  }
  @media (min-width: 1200px){
      
.span6 {
    width: 45%;
}

.modal-body {
    max-height: 500px;
    padding: 15px;
    overflow-y: auto;
}

 .modal.fade.in {
    top: 40%;
}

.modal {
    top: 50%;
    left: 25%;
    width: 90%;
}
  }

 
  </style>

  <br>
  <div class="container">
    <center>
      <div id="menu" class="well">
        <div class="row">
          <div class="span11 text-center">
            <div class="page-header">
              <h2>Listado de Productos</h2>
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
            <table class="table table-hover table-bordered text-center" class="display" style="width:100%" id="tableProductos">
              <thead>
                <tr>
                  <th ><strong>Código</strong></th>
                  <th ><strong>Descripcíon</strong></th>
                  <th ><strong>Total de Pedidos Registrados</strong></th>
                  <th ><strong>Ficha Técnica</strong></th>
                </tr>
              </thead>
              <tbody >                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </center>
  </div>


<!-- Modal -->
<div id="modal_Ficha" class="modal hide fade modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Ficha Técnica: </h3>
  </div>
  <div class="modal-body  text-center">
    <div class="row">
        <div class="span6">
            <h3>Datos Artículo</h3>
            <ul id="articulo_detalle"  class="unstyled ">
            </ul>
        </div>
        <div class="span6 text-center">
            <img src="assest/images/no-image.jpg" alt="" class="img-rounded img-responsive">
        </div>
    </div>
    <div class="row">
        <div class="span12 text-center">
            <h3>Ficha Técnica</h3>
            <table id="ficha_tabla" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Id_Unidad_Medida</td>
                        <td>Valor</td>
                        <td>Referencia</td>
                        <td>Id_Maquina</td>
                        <td>Id_Matriz</td>
                        <td>Nombre</td>
                        <td>Detalle</td>
                        <td>Unidad</td>
                        <td>Tipo</td>
                        <td>Id_Sector</td>
                        <td>Id_Ubicacion</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <!-- <button class="btn btn-primary">Save changes</button> -->
  </div>
</div>

<script type="text/javascript">
    $(function(){
        console.log("=====> Carga de Listado de Productos  <=====");
        
        $('#tableProductos').DataTable( {
            'responsive': true,
            'processing': true,
            'serverSide': true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "pageLength": 50,
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
            ajax:  {
                'dataType': 'json',
                'type': 'POST',
                'data':{action:1},
                'url': "services/productos.php",
                'dataSrc': function(response) {
                    console.log(response);
                    console.log(response.data);
                    var output = [];
                    
                    $.each(response.data, function(index, item) {
                        console.log(item);
                        var col1, col2, col3, col4= '';
                        col1 = item.codigo;
                        col2 = item.descripcion;
                        col3 = item.total;
                        col4 = ' <a class="btn btn-mini btn-info" href="#" data-code="'+item.codigo+'"><i class="icon-search"></i></a> ';
                        output.push([col1, col2, col3, col4]);
                    });
                    return output;
                }
            }/*,
            "columns": [
            { "data": "codigo" },
            { "data": "descripcion" },
            { "data": "total" }
        ]*/
        });
    });


    $(document).on('click','.btn-info',function(){
        console.debug("====> btn-info clicked: code= %o ",$(this).data());
        var code= $(this).data('code');
        loadFichaTecnica(code);
        return false;
    })

    var hostname = $(location).attr('hostname');
    var host_url_ajax = '';
    if (hostname == 'empaque.des') {
        //host_url_ajax = 'http://190.3.7.29:301/empaque_demo/';
        host_url_ajax = 'http://58d70548161e.sn.mynetname.net:301/empaque_demo/';
    }
    function loadFichaTecnica(code){
        console.debug("====> loadFichaTecnica: code= %o ",code);
        var data_ajax={
		  method: "POST",
          url: host_url_ajax + "buscarProductoFicha.php",
		  data: {id:code},
		  dataType: "json",
		  success:function(data){
            
            console.debug("===> FICHA TECNICA: %o",data);
            
            
            var _art_detalle_list='';
            _art_detalle_list+='<li class="text-left"><strong>Código: </strong>'+data.articulo.Id+'</li>';
            _art_detalle_list+='<li class="text-left"><strong>Descripcíon: </strong>'+data.articulo.Articulo+'</li>';
            _art_detalle_list+='<li class="text-left" ><strong>Ancho: </strong>'+data.articulo.Ancho+'</li>';
            _art_detalle_list+='<li class="text-left"><strong>Largo: </strong>'+data.articulo.Largo+'</li>';
            _art_detalle_list+='<li class="text-left"><strong>Espesor: </strong>'+data.articulo.Espesor+'</li>';
            _art_detalle_list+='<li class="text-left"><strong>Color: </strong>'+data.Color.Color+'</li>';
            $("#modal_Ficha").find("ul#articulo_detalle").empty().html(_art_detalle_list);
            
            
            var _ficha_tabla_row='';
            
            $.each(data.Fichas_Tecnica_Detalle,function(index,item){
                //console.debug("====> Fichas_Tecnica_Detalle item: %o - %o",index,item);

               // if(item.Detalle=='Atributo'){
                    console.debug("====> Fichas_Tecnica_Detalle item: %o - %o",index,item.Detalle);
                    _ficha_tabla_row+='<tr>';
                    console.table(item);
                    $.each(item,function(sindex,sitem){
                        _ficha_tabla_row+='<td>'+sitem+'</td>';
                        /*console.log(sindex);
                        console.table(sitem);*/
                    });
                    _ficha_tabla_row+='</tr>';
                    
                //}
                
                
            })
            console.debug(_ficha_tabla_row);
            $("#modal_Ficha").find("table#ficha_tabla tbody").empty().html(_ficha_tabla_row);
            
           
            
            $('#modal_Ficha').modal('show');
		  },
		  error:function(error_msg){
		  	alert( "error_msg: " + error_msg );
		  }
		};
		$.ajax(data_ajax);
    }
</script>
