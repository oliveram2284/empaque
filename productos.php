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
            width: 900px;
        }
        
    }

    .span6{
        border: 1px solid #dddddd;
        min-height: 320px;              
    }
    /* #articulo_detalle{
        border: 1px solid #dddddd;
    }*/
    #articulo_detalle li{
        
        padding: 10px;
    }
    #articulo_detalle li strong{
        font-size: 13px;
        text-transform: uppercase;
        min-width: 80px !important;
        padding-right: 15px;
    }
    
    #ficha_tabla table tbody td{
        height:30px !important;
        border:1px solid red;
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
          <table>
		<tr>
			<td><strong>Buscar :   </strong>  <input type="text" id="buscadorP" onkeyup="BuscadorDeProductos(this.value, 1)"></td>
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
    <div id="resultado_Productos" >

    </div>
            <!--
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
            </table> -->
          </div>
        </div>
      </div>
    </center>
  </div>

<?php include_once('_modal_ficha_tecnica.php')?>
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
                _ficha_tabla_row+='<tr>';
                _ficha_tabla_row+='<td style="width:100px;">'+ ((item.Nombre != null )? item.Nombre:'')+'</td>';
                _ficha_tabla_row+='<td style="width:150px;">'+ ((item.Detalle != null)? item.Detalle:'')+'</td>';                
                _ficha_tabla_row+='<td style="">'+ ((item.Valor != null)? item.Valor:'')+'</td>';
                _ficha_tabla_row+='<td style="">'+ ((item.Unidad != null)? item.Unidad:'')+'</td>';
                _ficha_tabla_row+='</tr>';   
            })
            console.debug(_ficha_tabla_row);
            $("#modal_Ficha").find("table#ficha_tabla tbody").empty().html(_ficha_tabla_row);
            
           
            $("#modal_Ficha").find(".btn.btn-info").hide();    
            $('#modal_Ficha').modal('show');
		  },
		  error:function(error_msg){
		  	alert( "error_msg: " + error_msg );
		  }
		};
		$.ajax(data_ajax);
    }

    function BuscadorDeProductos(value, page) {
    console.log(host_url_ajax);
    var color = '#FFFFFF';
    var data_ajax = {
        type: 'POST',
        //url: "http://190.3.7.29:301/empaque_demo/buscarProducto.php",
        url: host_url_ajax + "buscarProducto.php",
        data: { xinput: value, xpage: page, busq: 1 },
        success: function(data) {
            if (data != 0) {
                var fila = '<table class="table table-bordered table-condensed" >';
                fila += '<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th style="width: 500px;">Artículo</th><th>Código Producto</th></tr></thead>';
                fila += "<tbody>";
                $.each(data, function(k, v) {
                        console.debug("===> PRODUCTOS: %o - %o", k, v);
                        if (color == '#A9F5A9') {
                            color = '#FFFFFF';
                        } else {
                            color = '#A9F5A9';
                        }
                        //Datos de cada cliente
                        var idCodigo = "";
                        $.each(v, function(i, j) {
                            if (i == "Id") {
                                //Icono
                                fila += '<tr style="cursor: pointer; background-color:' + color + '" id="' + j + '" onClick="SeleccionadoP(\'' + j + '\')">';
                                fila += '<td>';
                                fila += '<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
                                fila += '</td>';
                                fila += "<td>" + j + "</td>";
                                fila += '<input type="hidden" id="' + j + '_cp" value="' + j + '">';
                                idCodigo = j;
                            }
                            if (i == "Articulo") {
                                fila += '<td style="padding-left: 10px;">' + j + '</td>';
                                fila += '<input type="hidden" id="' + idCodigo + '_arp" value="' + j + '">';
                            }
                            if (i == "Nombre_en_Facturacion") {
                                fila += "<td>" + j + "</td>";
                                fila += '<input type="hidden" id="' + idCodigo + '_ncp" value="' + j + '">';
                            }


                        });
                        fila += '<td> <a class="btn btn-mini btn-info" href="#" data-code="' + v.Id + '"><i class="icon-search"></i> Ficha Técnica</a> </td>';

                        fila += "</tr>";

                    }

                );
                fila += "</tbody></table>";

                $("#resultado_Productos").html(fila);

            } else {
                $("#resultado_Productos").html('<strong style="color: red;">No se encontraron resultados</strong>');
            }
        },
        error: function() {
            swal({
                title: "Error!",
                text: "Error de conexión.",
                type: "error",
                confirmButtonText: "Cerrar"
            });
        },
        dataType: 'json'
    };
    $.ajax(data_ajax);
}
</script>
