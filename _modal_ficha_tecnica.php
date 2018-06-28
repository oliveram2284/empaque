<style>
 @media (min-width: 1200px){
      
    

   
      
  }
  #modal_Ficha  {
          top: 50%;
          left: 25%;
          width: 900px !important;
    }
  #modal_Ficha .span6{
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


<!-- Modal -->
<div id="modal_Ficha" class="modal hide fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Ficha Técnica: </h3>
  </div>
  <div class="modal-body ">
    <div class="row">
        <div class="span6">
            <h3>Datos Artículo</h3>
            <ul id="articulo_detalle"  class="unstyled ">
            </ul>
        </div>
        <div class="span6 text-center">
            <h3>Imagen Artículo</h3>
            <img src="imag/logo.jpg" alt="" class="img-rounded img-responsive" style="width: 250px;   height:  auto;">
        </div>
    </div>
    <div class="row">
        <div class="span8 text-center">
            <h3>Ficha Técnica</h3>
            <table id="ficha_tabla" class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Unidad</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-success btn_select" data-code="" >Seleccionar</button>
    <!-- <button class="btn btn-primary">Save changes</button> -->
  </div>
</div>