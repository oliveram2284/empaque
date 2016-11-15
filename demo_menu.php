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
  $menu=array();

  function get_menu($parent_id=0){

      $sql="SELECT * FROM tbl_menu_emp WHERE parent_id=".$parent_id." ORDER BY orden ; ";
      $result= R::getAll($sql);
      if(!empty($result)){
        return $result;
      }else{
        return false;
      }
  }


  $menu=get_menu();

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
			  <h2>Menu Demo</h2>
			</div>
		</div>
	    </div>
	    <div class="row">
		<div class="span12 text-left ">
        <a href="sortable_menu.php" class="btn btn-danger">&nbsp;Atrás&nbsp;</a>
		    <?php if(!isset($_GET['id'])):?>
          <input type="button" value="&nbsp;Agregar&nbsp;" class="btn btn-success" id="btnAceptar">
        <?php endif?>
		</div>

	    </div>
        <br>
	    <div class="row">
        <div class="span10">


          <div class="navbar ">
            <div class="navbar-inner">
              <div class="container">
                <!--
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </a> -->

              <div class="nav-collapse">
                <ul class="nav">
                  <!-- <a class="brand" href="#">Present Ideas</a> -->
                  <?php foreach ($menu as $key => $level_1):?>

                    <?php if($menu_level_2=get_menu($level_1['id_menu'])):?>
                      <li class="dropdown" id="accountmenu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo utf8_encode($level_1['descripcion']);?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <?php foreach ($menu_level_2 as $key => $level_2):?>
                            <!---->
                            <?php if($menu_level_3=get_menu($level_2['id_menu'])):?>
                              <li class="dropdown" id="accountmenu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo utf8_encode($level_2['descripcion']);?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                  <?php foreach ($menu_level_3 as $key => $level_3):?>
                                    <li><a href="<?php echo $level_3['link'];?>"><?php echo utf8_encode($level_3['descripcion']);?></a></li>
                                  <?php endforeach;?>
                                </ul>
                              </li>

                            <?php else:?>
                              <li><a href="<?php echo $level_2['link'];?>"><?php echo utf8_encode($level_2['descripcion']);?></a></li>
                            <?php endif;?>
                          <?php endforeach;?>
                        </ul>
                      </li>
                    <?php else:?>
                      <li><a href="<?php echo $level_1['link'];?>"><?php echo utf8_encode($level_1['descripcion']);?></a></li>
                    <?php endif;?>

                  <?php endforeach;?>

                  <li class="active"><a href="#">Home</a></li>
                  <li><a href="#">Blog</a></li>
                  <li><a href="#">About</a></li>
                  <li><a href="#">Help</a></li>
                  <li class="dropdown" id="accountmenu">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account Settings<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Login</a></li>
                      <li><a href="#">Register</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Logout</a></li>
                    </ul>
                  </li>
                </ul>
                <ul class="nav pull-right">

                </ul>
              </div>
              <!--/.nav-collapse -->
            </div>
          </div>
      </div>



        </div>
	    </div>
	</div>
    </center>
    </div>

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
                console.debug("===> error Carga Formato");
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
        console.debug("keyup load: %o", $(this).val());

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

                            console.debug("=> articulo data: %o",articulo);
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
        $("#modalCant").modal("show");
    });
    $("#bt_submit").click(function(){
        console.debug("SUBMIT FORM");

        var validate=true;
        /*if($("#id_articulo").val().length<0){
            validate=false;
            $(".alert").find("p").text("Debe ingresar un Artículo");
            $(".alert").removeClass("hidden");
            $("#id_articulo").focus();
            return false;
        }*/

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
        /*
        if($("#field_peso").val().length<0){
            validate=false;
            $(".alert").find("p").text("Debe ingresar Peso de Material");
            $(".alert").removeClass("hidden");
            $("#field_peso").focus();
            return false;
        }
        */
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
                    console.debug("==> seria: %o",data);
                    $("#modalCant").modal("hide");
                    location.reload();
                },
                error:function(){
                    console.debug("===> error Carga Formato");
                },
                dataType: 'json'
            };
            $.ajax(data_ajax);

        }

        return false;
    });

</script>
