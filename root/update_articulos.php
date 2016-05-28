<?php
require("header.php");
?>
<br>
<div class="well">
	    	
	    <div class="row">
	      <div class="span6 offset2">
			<h2>Actualizaci&oacute;n de Art&iacute;culos</h2>
	      </div>
	    </div>	    
	    <div class="row">
	      <div class="span6 offset2">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<button class="btn btn-large btn btn-danger" onclick="atras()" id="cancela" type="button">Cancelar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-large btn btn-success" id="load" onclick="load()" type="button">Actualizar</button>
	      </div>
	    </div>

</div>

<script type="text/javascript">
	     function atras()
	     {
		history.back(1);
	     }
	     
	     function load()
	     {
		window.location="update_articulos_php.php";
	     }
	    
</script>
<?php
require("footer.php");
?>