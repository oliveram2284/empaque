<div class="modal hide fade" id="etiqueta_cantidad_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Cantidades Permitidas Para Etiquetas</h3>
  </div>
  <div class="modal-body">

		<table class="table table-bordered" id="table_bobina_cant">
			<thead>
				<tr>
					<th>#</th>
					<th>Descripción</th>
					<th>Largo Desarrollo Bobina</th>
          <th>Cantidad de Pistas</th>
					<th>Multiplo de Etiquetas</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
  	<div class="control-group">
	    <div class="controls">
	    	<input type="text" id="input_cant_etiqueta_pop" class="input_cant" placeholder="Ingrese Cantidad">
        <input type="hidden" id="multiplo_etiqueta_cant" >
	    	<input type="hidden" id="largo_etiqueta_cant" >
	    </div>
	  </div>
    <ul class="cant_etiquetas_allowed unstyled " data-multi=""></ul>

  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="pop_close">Cerrar</a>
    <a href="#" class="btn btn-primary">Seleccionar</a>
  </div>
</div>
