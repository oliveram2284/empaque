<?php  
session_start();

$nombre = substr($_SESSION['Nombre'], 0, 2);
//var_dump($_SESSION);
/*
if($_SESSION['permisos']=56){
	$action='CO';
}else{
	$action=$_REQUEST['action'];
}*/

$action=$_REQUEST['accion'];

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}
include("conexion.php");
include("diccionario/diccionario.php");

$var = new conexion();
$var->conectarse();

include("class_sesion.php");

require("header.php");

?>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="assest/dist/css/bootstrap-multiselect.css" type="text/css">
<!-------------------------------------------->

<input type="hidden" id="onlyEdit">
<!-- Modal para cargar el numero de hoja de ruta -->
<div class="modal hide fade" id="modal_produccion">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Pedido en Curso</h3>
  </div>
  <div class="modal-body">
    <p>
      <table width="100%">
	<tr>
		<td colspan="2" align="center">
			<div class="alert alert-error" id="error_div" style="display: none">
				<label id="error_msj" style="margin-top: 9px"></label>
			</div>
		</td>
	</tr>
        <tr>
          <td style="width: 50%; text-align: right;"><b>N° de hoja de ruta &nbsp;&nbsp;</b></td>
	  <td>
	    <input type="text" id="hojaRuta" class="input-large" placeholder="hoja de ruta">
		<button id="hojaBtn" class="btn btn-small btn-primary" type="button" style="margin-top: -9px" onclick="AddHojaDeRuta()">
			<i class="icon-plus icon-white"></i>
		</button>
	  </td>
        </tr>
	<tr>
	    <td colspan="2">
		<div style="max-height: 100px; height: 100px; min-height: 100px; overflow-y: auto; overflow-y: auto; background-color: #FAFAFA; margin-bottom: 10px; border: 1px solid; border-color: #cccccc;">
		    <table style="width: 100%;" id="table_hoja_ruta">
			<tbody></tbody>
		    </table>
		</div>
	    </td>
	</tr>
	<div id="articulo_div" style="display: none">
		<tr>
			<td><b id="codigoLbl">Asignar nuevo cód. de producto &nbsp;&nbsp;</b></td>
			<td>
				<div id="groupBtn">
				<input type="text" id="codigoProducto" class="input-large" placeholder="código de producto" disabled>
				<button id="codigoBtn" class="btn btn-small btn-success" type="button" style="margin-top: -9px" onclick="BuscarProducto()">
					<i class="icon-search icon-white"></i>
				</button>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="text" id="descriptionProd" class="input-xxlarge" placeholder="descripción de producto" disabled>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="text" id="codigoTangoProd" class="input-xxlarge" placeholder="código tango del producto" disabled>
			</td>
		</tr>
	</div>		
      </table>
    </p>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <a href="#" class="btn btn-primary" onclick="PedidoEnCurso()">Aceptar</a>
  </div>
</div>
<!-- Fin modal hoja de ruta-->

<input type="hidden" id="idPed">
	
<!-- Modal para terminar pedidos -->
<div class="modal hide fade" id="modal_terminado" style="width: 900px;margin-left: -450;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="NTPid">Terminar Nota de Pedido</h3>
  </div>
  <div class="modal-body">
    <p>
      <table width="100%" style="font-size: 12px;">
	<tr>
		<td colspan="5" align="center">
			<div class="alert alert-error" id="error_div_ter" style="display: none">
				<label id="error_msj_ter" style="margin-top: 9px"></label>
			</div>
		</td>
	</tr>
	<tr>
		<td style="width: 20%; text-align: right;">
		    <b>Cliente:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="clienteNombre"></i>
		</td>
		<td style="width: 25%;" rowspan="2">
		    <div style="float: left;">
			<br>
			    <button class="btn btn-primary" onclick="ooopenObsr()" id="esconderBtn"><i id="iconDetailPolimero" class="icon-tag icon-white"></i></button>
		    </div>
		    <div style="float: left; margin-left: 5px;">
		    <!-- Sirve para indicar que se tiene que facturar el polimero -->
		    <a href="#" class="btn btn-danger" style="height: 40px" id="btnFacturarSiNo">
			<strong>
			    <span id="spanMoneyTitle"></span><br>
			    <span id="spanMoney">$0.00</span>
			</strong>
		    </a>
		    </div>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Cód. Tango:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="clienteTango"></i>
		</td>
	</tr>
	<tr>
	    <td colspan="5"><hr></td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Código:</b>
		</td>
		<td style="text-align: left" colspan="4">
		    <i id="productoCodigo"></i>	
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Descripción:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="nomProducto"></i>
		</td>
		<td rowspan="2">
		    <span id="linkObservaciones" class="btn btn-danger" onclick="verObservacion()" style="cursor: pointer; text-decoration: none;"><b>Observaciones</b></span>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Cód. Tango:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <id id="productoCodigoT"></id>	
		</td>
	</tr>
	<tr>
	    <td colspan="5"><hr></td>
	</tr>
	<tr>
	    <td colspan="5">
		<table style="width: 100%; font-size: 12px;">
		    <tr>
			<td style="text-align: right;"><b>Cant. Solic.:</b></td>
			<td style="text-align: left;"><i id="cantidad"></i></td>
			<td style="text-align: right;"><b>Precio:</b></td>
			<td style="text-align: left">
			    <i id="precio"></i>
			    <a onclick="openEP()" style="cursor: pointer;"><img style="margin-left: 20px; margin-top: -5px;" src="./assest/plugins/buttons/icons/pencil.png" width="15" heigth="15"/></a>
			</td>
			<td style="text-align: right;"><b>Kilogr. Ent.:</b> </td>
			<td style="text-align: left; color: red;"><b><i id="kgEntregados"></i></b></td>
		    </tr>
		    <tr>
			<td style="text-align: right;"><b>Unidad de Medida:</b></td>
			<td style="text-align: left;"><i id="medida"></i></td>
			<td style="text-align: right;"><b>Cotización:</b></td>
			<td style="text-align: left;"><i id="CotCot"></td>
			<td style="text-align: right;"><b>Unid./Cant. Ent.:</b> </td>
			<td style="text-align: left; color: red;"><b><i id="cantidadEntregada"></i></b></td>
		    </tr>
		    <tr>
			<td></td>
			<td></td>
			<td style="text-align: right;"><b>Precio a Fact.:</b></td>
			<td style="text-align: left;"><i id="PrecioCotCot"></td>
			<td style="text-align: right;"><b>Bultos/Bob. Ent.:</b> </td>
			<td style="text-align: left; color: red;"><b><i id="bultosEntregados"></i></b></td>
		    </tr>
		</table>
	    </td>
	</tr>
	<tr>
		<td colspan="5"><hr></td>
	</tr>
	<tr>
		<td >
			&nbsp;&nbsp;&nbsp;
				<input style="margin-top: -3px;" type="radio" name="optionsRadios" id="optionsRadios" value="T"><b>Total</b><br><br>
			&nbsp;&nbsp;&nbsp;
				<input style="margin-top: -3px;" type="radio" name="optionsRadios" id="optionsRadios1" value="TP" checked><b>Parcial</b>
		</td>
		<td colspan="3">
				<input type="text" class="input-medium" id="tbkg" placeholder="Kilogramos" onkeyup="decimal(tbkg),calculaPP()"><b>&nbsp;&nbsp;Kilogramos</b><br>
				<input type="text" class="input-medium" id="tbcantidad" placeholder="Cantidad" onkeyup="decimal(tbcantidad),calculaPP(),calculaEst()"><b>&nbsp;&nbsp;Unid./Cant.</b><br>
				<input type="text" class="input-medium" id="tbbulto"placeholder="Bultos" onkeyup="numerico(tbbulto)"><b>&nbsp;&nbsp;Bultos/Bob.</b>
				
		</td>
		<td>
		    <a onclick="openHR()" style="cursor: pointer;"><i>HR/CI</i></a><br><br>
		    <a onclick="openET()" style="cursor: pointer;"><i>Entregas</i></a><br><br>
		    <input type="text" id="fechaOper" name="fechaOper" class="input-small" readonly="">
		    
			<script>
			$(function() {
				var d=new Date();
				$('#fechaOper').datepicker({ maxDate:  new Date(d.getFullYear(), d.getMonth(), d.getDate())});
				$('#fechaOper').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
				$('#fechaOper').datepicker( 'setDate', new Date(d.getFullYear(), d.getMonth(), d.getDate()) );
			      });
			</script>			
		</td>
	</tr>
	<input type="hidden" id="cotizacionMM" value="1">
      </table>
    </p>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <table style="width: 100%">
	<tr>
	    <td style="width: 40%; text-align: left;color: red; font-size: 20px;"><b>Promedio</b><br><b id="calculo">$ 0.00 /Kg.</b></td>
	    <td style="width: 40%; text-align: center;font-size: 20px; color: blue;"><b>Tot. Entregado</b><br><b id="calc2"></b></td>
	    <td style="text-align: right;"><a href="#" class="btn btn-primary" onclick="PedidoTerminado()">Aceptar</a></td>
	</tr>
    </table>
    
  </div>
</div>


<!-- Modal para Editar precios -->
<div class="modal hide fade" id="modal_editar_precio">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="NTPidEditP">Editar Precio NP N°: </h3>
  </div>
  <div class="modal-body">
    <p>
      <table width="100%" style="font-size: 12px;">
	<tr>
		<td colspan="4" align="center">
			<div class="alert alert-error" id="error_div_edt_p" style="display: none">
				<label id="error_msj_edt_p" style="margin-top: 9px"></label>
			</div>
		</td>
	</tr>
	<tr>
		<td style="width: 20%; text-align: right;">
		    <b>Cliente:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="clienteNombreEdit"></i>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Cód. Tango:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="clienteTangoEdit"></i>
		</td>
	</tr>
	<tr>
	    <td colspan="4"><hr></td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Código:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="productoCodigoEdit"></i>	
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Descripción:</b>
		</td>
		<td style="text-align: left" colspan="3">
		    <i id="nomProductoEdit"></i>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Cód. Tango:</b>
		</td>
		<td style="text-align: left" colspan="2">
		    <id id="productoCodigoTEdit"></id>	
		</td>
		<td>
		    <i><a onclick="verObservacion()" style="cursor: pointer;">Observaciones</a></i>
		</td>
	</tr>
	<tr>
	    <td colspan="4"><hr></td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Cantidad:</b>
		</td>
		<td style="text-align: left">
		    <i id="cantidadEdit"></i>	
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Medida:</b>
		</td>
		<td style="text-align: left">
		    <i id="medidaEdit"></i>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;">
		    <b>Precio:</b>
		</td>
		<td style="text-align: left">
		    <i id="precioEdit"></i>
		    <a onclick="openEPE()" style="cursor: pointer;"><img style="margin-left: 20px; margin-top: -5px;" src="./assest/plugins/buttons/icons/pencil.png" width="15" heigth="15"/></a>
		</td>
	</tr>
	
      </table>
    </p>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <table style="width: 100%">
	<tr>
	    <td style="text-align: right;"><a href="#" class="btn btn-primary" onclick="ClosePop('modal_editar_precio')">Cerrar</a></td>
	</tr>
    </table>
    
  </div>
</div>


<!-- Sub Modal para Observaciones -->
<div class="modal hide fade" id="modal_entregas_observacion">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Observaciones</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
    <div class="alert alert-success">
	<label id="iptObserv"></label>
    </div>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Observaciones</i></strong>
  </div>
</div>
<!-- -->

<!-- Sub Modal para Observaciones -->
<div class="modal hide fade" id="modal_entregas_observacion_polimero">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Observaciones</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
    <div class="alert alert-success">
	<label id="iptObservPolll"></label>
    </div>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Observaciones</i></strong>
  </div>
</div>
<!-- -->

<!-- Sub Modal para HR/CI -->
<div class="modal hide fade" id="modal_entregas_hrci">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Hojas de Ruta / Comunicaciones Internas</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
	<div id="HrList" style="width: 90%; text-align: left; height: 400px; background-color: #E6E6E6;">
	    
	</div>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Hojas de Ruta / Comunicaciones Internas</i></strong>
  </div>
</div>
<!-- -->


<!-- Sub Modal para Entregas -->
<div class="modal hide fade" id="modal_entregas_entregas">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Entregas</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
	<table id="EntList" style="width: 90%; text-align: left; background-color: #E6E6E6;">
	    
	</table>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Entregas</i></strong>
  </div>
</div>
<!-- -->

<!-- Sub Modal para Editar Precio -->
<div class="modal hide fade" id="modal_entregas_edit">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Editar Precio</h3>
  </div>
  <div class="modal-body" style="min-height: 400px;">
	<div id="EditP" style="width: 90%; text-align: center; vertical-align: middle; height: 400px; background-color: #E6E6E6;">
	    <br><br><br><br><br><br><br>
	    <div>Precio Actual:<b style="font-size: 30px; color: red;" id="pa"></b></p></div><br>
	    <br><br>
	    <div>Nuevo Precio:<select class="input-small" id="monedaEdit">
			      <?php
			      
			      $sql = "Select idMoneda, descripcion From monedas order by descripcion";
			      $resu = mysql_query($sql);
			      while($row = mysql_fetch_array($resu))
			      {
				echo '<option value="'.$row[0].'">'.$row[1].'</option>';
			      }
			      
			      ?>
			      </select>
			      <input type="text" id="nprecio" onkeyup="decimal(nprecio)" style="margin-left: 10px; margin-right: 10px; width: 150px;">
			      <select class="input-small" id="condicionEdit">
			      <?php
			      
			      $sql = "Select idIVA, descripcion From condicionIVA order by descripcion";
			      $resu = mysql_query($sql);
			      while($row = mysql_fetch_array($resu))
			      {
				echo '<option value="'.$row[0].'">'.$row[1].'</option>';
			      }
			      
			      ?>
			      </select>
	    </b></p></div><br>
	    
	</div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" onclick="ValidarEditPrecio()">Editar</a>
    <!--<strong><i>Editar Precio</i></strong>-->
  </div>
</div>
<!-- -->

<!-- -->

<!-- Modal para el seguimiento de pedido-->
<div class="modal hide fade" id="modal_seguimiento">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Seguimiento de Pedido <strong><label id="idC" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    
    <table class="table ">	
    	<tr>
				<td align="center">
					<div class="alert alert-error" id="error_div" style="display: none">
						<label id="error_msj" style="margin-top: 9px"></label>
					</div>
				</td>
			</tr>
      <tr>
        <td >
					<div style="width: 100%; height: 200px;" id="div_seguimiento">		
					</div>	  
				</td>        
			</tr>      
		</table>
    <div class="head_div text-left">
    	<p >
    		<label>Tiene Hoja de Ruta</label>
    	</p>
    </div>
  </div>
  <div class="modal-footer">
    <!--<a href="#" class="btn">Cancelar</a>-->
    <strong><i>Seguimiento de Pedido</i></strong>
  </div>
</div>
<!-- -->

<!-- Modal para rehacer el pedido-->
<div class="modal hide fade" id="modal_rehacer">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="header_div_r"><strong><label id="idC" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <table width="100%">	
      	<tr>		
      		<td colspan="2" align="center">			
      			<div class="alert alert-error" id="error_rehacer_div" style="display: none">				
      				<label id="error_rehacer_msj" style="margin-top: 9px"></label>			
      			</div>		
      		</td>	
      	</tr>
        <tr>
          <td colspan="2">		
          	<div style="width: 100%;">		    
          		<!-- Mensaje de Advertencia -->		    
          		<div class="alert alert-error" id="div_alert_er"></div>		    
          		<!-- Motivos de Cancelación o Anulación -->		   
          		Motivos :		    
          		<div id="div_motives" style="max-height: 100px; height: 100px; min-height: 100px; overflow-y: auto; overflow-y: auto; background-color: #FAFAFA; margin-bottom: 10px; border: 1px solid; border-color: #cccccc;"> 	    
          		</div>		    
          		<!-- Observaciones -->		    
          		<div style="width: 100%;">			
          			Observaciones:			
          			<textarea rows="3" style="width: 100%" id="motivo"></textarea>		    
          		</div>		
          	</div>	  
          </td>
        </tr>
        <?php if($_GET['accion']=='P'):?>
        	<tr>
        		<td colspan="2">
        			<div style="width: 100%;">			
          			<label>Nota de Pedido fue impresa ?:  <input type="checkbox" id="esta_impreso" value=""></label>          			
          			    
          		</div>
          		<div style="width: 100%;">			
          			Hoja de Ruta:          			
          			<input type="text" id="dev_HojaRuta" value="<?php echo ($row[1])?$row[1]:'-'?>">    
          		</div>	
          		
        		</td>
        	</tr>

      	<?php endif;?>
      </table>
    </p>
  </div>

  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_rehacer" onclick="ClosePop('modal_rehacer')">No</a>
    <a href="#" class="btn btn-success" id="btn_rehacer_acp" onclick="ValidarMotivo()">Si</a>
  </div>
</div>

<input type="hidden" id="statusNow">
<input type="hidden" id="statusAction">
<!-- -->

<!-- Modal para Cancelar el pedido-->
<div class="modal hide fade" id="modal_cancel">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="header_div_c"><strong><label id="idCc" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <table width="100%">
	<tr>
		<td colspan="2" align="center">
			<div class="alert alert-error" id="error_cancel_div" style="display: none">
				<label id="error_cancelar_msj" style="margin-top: 9px"></label>
			</div>
		</td>
	</tr>
        <tr>
          <td colspan="2">
		<div style="width: 100%;">
		    <!-- Mensaje de Advertencia -->
		    <div class="alert alert-error" id="div_alert_er_c">
		      
		    </div>
		    <!-- Motivos de Cancelación o Anulación -->
		    Motivos:
		    <div id="div_motives_" style="max-height: 100px; height: 100px; min-height: 100px; overflow-y: auto; overflow-y: auto; background-color: #FAFAFA; margin-bottom: 10px; border: 1px solid; border-color: #cccccc;">
		    
		    </div>
		    <!-- Observaciones -->
		    <div style="width: 100%;">
			Observaciones:
			<textarea rows="3" style="width: 100%" id="motivo_"></textarea>
		    </div>
		</div>
	  </td>
        </tr>
      </table>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_cancelar_p" onclick="ClosePop('modal_cancel')">No</a>
    <a href="#" class="btn btn-success" id="btn_cancelar_p_acp" onclick="ValidarMotivoCancel()">Si</a>
  </div>
</div>
<!-- -->

<!-- Modal para pasar a Calidad -->
<div class="modal hide fade" id="modal_calidad">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Evaluar Calidad <strong><label id="title_c" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" style="text-align: center">
	    <strong>
	    ¿ Esta seguro de enviar el pedido para evaluar su calidad ?
	    </strong>
	  </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_rehacer" onclick="ClosePop('modal_calidad')">No</a>
    <a href="#" class="btn btn-success" id="btn_rehacer_acp" onclick="ValidarMotivoCalidad('PO')">Si</a>
  </div>
</div>
<!-- ----------->

<!-- Productos -->
<center>
<div class="modal hide fade" id="ProductosPop" style="width: 900px; margin-left: -450px;">
  <div class="modal-header">
    <input type="hidden" id="busc" value="1">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Búsqueda de Productos</h3>
  </div>
  <div class="modal-body">
	<table>
		<tr>
			<td><strong>Buscar :   </strong>  <input type="text" id="buscadorPO" onkeyup="BuscadorDeProductos(this.value, 1)"></td>
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
<!-- Fin modal Productos -->

<!-- Modal para pasar a Calidad -->
<div class="modal hide fade" id="modal_disenio" style="margin-left: -500px; width: 1000px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Crear Polímero<strong><label id="title_c" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">

    <div class="alert alert-error" id="error_asoc" style="text-align: center; display: none;">
	Error!!
    </div>
    <input type="hidden" id="id_polimero_new" value="0">
    <table style="width: 100%; font-size: 12px;">
	<tr style="vertical-align: top;">
	    <td style="width: 50%">
		<div class="bordeDiv">
		    <p><b>Código: </b><i id="poli_code"></i></p>
		    <p><b>Cliente: </b><i id="poli_cliente"></i></p>
		    <p><b>Producto: </b><i id="poli_produ"></i></p>
		</div><br>
		
		<div class="bordeDiv">
		    <table style="font-size: 12px;">
			<tr>
			     <td style="text-align: right; padding-right: 15px;"><strong>Medidas</strong></td>
			    <td><input id="poliMedidas" type="text" class="input-large"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Colores</strong></td>
			    <td><input id="poliColores" type="text" class="input-large"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Ptas. x Módulos</strong></td>
			    <td><input id="pistas" type="text" class="input-large"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Máquina</strong></td>
			    <td>
				<select id="maquina" name="maquina" style="width: 210px;">
				<?php
				    $consulta = "Select * from maquinas Where estado = 'AC' order by descMaquina";
				    $resu = mysql_query($consulta); 
				    
				    while($uni = mysql_fetch_array($resu))
				    {
					    echo "<option value=".$uni['idMaquina'].">".$uni['descMaquina']."</option>";
				    }
				?>
				</select>
			    </td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Cilindro</strong></td>
			    <td><input id="cilindro" type="text" class="input-large"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Camisa de Lam.</strong></td>
			    <td><input id="camisa" type="text" class="input-large"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Ancho Mat. Sug.</strong></td>
			    <td><input id="anchoSugerido" type="text" class="input-large"></td>
			</tr>
			<tr>
			    <td colspan="2">
				<strong>AVT:</strong><input type="checkbox" class="AVT" id="AVT_1" value="1" style="margin-top: -1px;margin-right: 30px;">
				<strong>Banda de refile:</strong><input type="checkbox" class="AVT" id="AVT_2" value="2" style="margin-top: -1px;margin-right: 30px;">
				<strong>Hexag./Cuadros:</strong><input type="checkbox" class="AVT" id="AVT_3" value="3" style="margin-top: -1px;margin-right: 30px;">
			    </td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Sentido de Imp.</strong></td>
			    <td>Frente<input type="radio" name="sentido" class="sentido" value="1" style="margin-top: -1px; padding-right: 20px;">
			    Dorso<input type="radio" name="sentido" class="sentido" value="0" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Código de Barra</strong></td>
			    <td>
				Si<input type="radio" name="barra" class="barra" value="1" style="margin-top: -1px;">
				No<input type="radio" name="barra" class="barra" value="0" style="margin-top: -1px;">
				<input type="text" id="codeBar" onkeyup="decimal(codeBar)">
			    </td>
			</tr>
		    </table>
		</div><br>
		
		<div class="bordeDiv">
		    <table style="font-size: 12px; width: 100%">
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Diseño:</strong></td>
			    <td>Nuevo <input type="radio" name="diseno" class="diseno" value="1" style="margin-top: -1px;"></td>
			    <td>C/Modificación <input type="radio" name="diseno" class="diseno" value="2" style="margin-top: -1px;"></td>
			    <td>Variador <input type="radio" name="diseno" class="diseno" value="3" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td colspan="4"><hr></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px; vertical-align: top; margin-top: 15px;" colspan="2" rowspan="2"><strong>Estado de Polímero en planta:</strong></td>
			    <td>Verificar <input type="radio" name="estadoPolPlanta" class="estadoPolPlanta" value="1" style="margin-top: -1px;"></td>
			    <td>Reponer <input type="text" class="input-small" id="reponer" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td>Reponer Todo <input type="radio" name="estadoPolPlanta" class="estadoPolPlanta" value="2" style="margin-top: -1px;"></td>
			    <td>Buen Estado <input type="radio" name="estadoPolPlanta" class="estadoPolPlanta" value="3" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px; vertical-align: top; margin-top: 15px;" colspan="2" rowspan="2"><strong>Solicitar Muestra a:</strong></td>
			    <td>Producción <input type="radio" name="muestra" class="muestra" value="1" style="margin-top: -1px;"></td>
			    <td>Cliente <input type="radio"  name="muestra" class="muestra" value="2" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td>Ventas <input type="radio"  name="muestra" class="muestra" value="3" style="margin-top: -1px;"></td>
			    <td>Preprensa <input type="radio"  name="muestra" class="muestra" value="4" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td colspan="4"><hr></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;" colspan="2"><strong>Fecha a Entregar polímeros:</strong></td>
			    <td colspan="2">
				<input type="text" id="fechaEnt" class="input-small" readonly="">
		    
				<script>
				$(function() {
					var d=new Date();
					$('#fechaEnt').datepicker({ minDate:  new Date('2013', d.getMonth(), d.getDate())});
					$('#fechaEnt').datepicker( 'option', 'dateFormat', 'dd-mm-yy' );
					$('#fechaEnt').datepicker( 'setDate', new Date(d.getFullYear(), d.getMonth(), d.getDate()) );
				      });
				</script>
			    </td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;" colspan="2"><strong>Presupuesto Aprox. polímeros:</strong></td>
			    <td colspan="2"><input type="text" id="presupuestoAprox" onkeyup="decimal(presupuestoAprox)"></td>
			</tr>
		    </table>
		</div>
	    </td>
	    <td style="width: 50%; padding-left: 5px;">
		<div class="bordeDiv" >
		    <table style="font-size: 12px; width: 100%;">
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Proveedor</strong></td>
			    <td>
				<div class="control-group error">
				    <input type="hidden" id="idProveedor">
				    <input type="text" class="input-large" id="Proveedor" readonly onclick="BuscarProveedor()">
				</div>	
		    	    </td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Lineatura</strong></td>
			    <td><input type="text" class="input-large" id="Lineatura" placeholder="Lineatura"></td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Espesor</strong></td>	
			    <td>
				<select id="espesor" name="espesor" style="width: 210px;">
				<?php
				    $consulta = "Select * from espesor Where estado = 'AC' order by descEspesor";
				    $resu = mysql_query($consulta); 
				    
				    while($uni = mysql_fetch_array($resu))
				    {
					    echo "<option value=".$uni['idEspesor'].">".$uni['descEspesor']."</option>";
				    }
				?>
				</select>
			    </td>
			</tr>
			<tr>
			    <td style="text-align: right; padding-right: 15px;"><strong>Calidad:</strong></td>
			</tr>
			<tr>
			    <td colspan="2" style="padding-right: 5px;">
				<div class="bordeDiv" style="width: 95%;" id="calidadesDiv"></div>
			    </td>
			</tr>
		    </table>
		</div><br>
		<div class="bordeDiv">
		    <table style="width: 100%; font-size: 12px;" >
			<tr>
			    <td colspan="2"><strong>Diseño en base a:</strong></td>
			    <td>Muestra<input type="checkbox" class="disenoBase" value="1" style="margin-top: -1px;"></td>
			    <td>Archivo/Pdf<input type="checkbox" class="disenoBase" value="2" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td><strong>Detalla vendedor:</strong></td>
			    <td>Por Mail<input type="checkbox" class="detallaVend" value="1" style="margin-top: -1px;"></td>
			    <td>Personalmente<input type="checkbox" class="detallaVend" value="2" style="margin-top: -1px;"></td>
			    <td>tel.<input type="checkbox" class="detallaVend" value="3" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td><strong>Detalla Cliente:</strong></td>
			    <td>Por Mail<input type="checkbox" class="detallaClien" value="1" style="margin-top: -1px;"></td>
			    <td>Personalmente<input type="checkbox" class="detallaClien" value="2" style="margin-top: -1px;"></td>
			    <td>tel.<input type="checkbox" class="detallaClien" value="3" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td><strong>Gerencia:</strong></td>
			    <td>Por Mail<input type="checkbox" class="detallaGeren" value="1" style="margin-top: -1px;"></td>
			    <td>Personalmente<input type="checkbox"class="detallaGeren" value="2" style="margin-top: -1px;"></td>
			    <td>tel.<input type="checkbox" class="detallaGeren" value="3" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td><strong>Producción:</strong></td>
			    <td>Por Mail<input type="checkbox" class="detallaProd" value="1" style="margin-top: -1px;"></td>
			    <td>Personalmente<input type="checkbox" class="detallaProd" value="2" style="margin-top: -1px;"></td>
			    <td>tel.<input type="checkbox" class="detallaProd" value="3" style="margin-top: -1px;"></td>
			</tr>
			<tr>
			    <td><strong>Impresión:</strong></td>
			    <td>Por Mail<input type="checkbox" class="detallaImp" value="1" style="margin-top: -1px;"></td>
			    <td>Personalmente<input type="checkbox" class="detallaImp" value="3" style="margin-top: -1px;"></td>
			    <td>tel.<input type="checkbox" class="detallaImp" value="3" style="margin-top: -1px;"></td>
			</tr>
		    </table>
		</div><br>
		<div class="bordeDiv">
		    <table style="width: 100%; font-size: 12px;" >
			<tr>
			    <td colspan="2"><strong>Requiere reunión:</strong></td>
			    <td>Si<input type="radio" name="reunion" class="reunion" value="1" style="margin-top: -1px;"></td>
			    <td>No<input type="radio" name="reunion" class="reunion" value="0" style="margin-top: -1px;"></td>
			</tr>
		    </table>
		</div>
		<br>
		<div class="bordeDiv">
		    <table style="width: 100%; font-size: 12px;" >
			<tr>
			    <td style="width: 40%"><strong>Detalles:</strong></td>
			    <td><textarea cols="8" rows="4" id="obs_poli"></textarea></td>
			</tr>
		    </table>
		</div>
	    </td>
	</tr>
    </table>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_rehacer_dis" onclick="ClosePop('modal_disenio')">Cancelar</a>
    <a href="#" class="btn btn-warning" id="btn_rehacer_update" onclick="ValidarPolimeroNuevo()">Modificar</a>
    <a href="#" class="btn btn-warning" id="btn_rehacer_devolver" onclick="ValidarPolimeroNuevo()">Devolver</a>
    <a href="#" class="btn btn-success" id="btn_rehacer_disi" onclick="ValidarPolimeroNuevo()">Aceptar</a>
  </div>
</div>
<!-- ----------->

<!-- Proveedores -->
<div class="modal hide fade" id="ProveedoresPop">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Búsqueda de Proveedores</h3>
  </div>
  <div class="modal-body">
    <strong>Buscar :   </strong>  <input type="text" id="buscadorPro" onkeyup="BuscadorDeProveedores(this.value)"><br><br>
    <div id="resultado_Proveedor" style="min-height: 320px;">
	
    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="btnCloseClientesPop" onclick="ClosePop('ProveedoresPop')">Cerrar</a>
  </div>
</div>

<!-- Aprobación de calidad de polimero -->
<div class="modal hide fade" id="modal_aprovacion">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Aprobación de Calidad de Polimero<strong><label id="title_c1" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" id="error_rehacer_calidad" style="display: none">
		  <label id="error_rehacer_msj" style="margin-top: 9px"><strong>Ingrese un motivo de no aprobación del polimero</strong></label>
	  </div>
	  <div class="alert alert-error" style="text-align: center">
	    <strong id="label_calidad">
	    ¿ Esta seguro de enviar el pedido para evaluar su calidad ?
	    </strong>
	  </div>
	  <div style="width: 100%; text-align: left;" id="div_motivo_calidad">
	      <strong>Motivo:</strong>
	      <textarea rows="3" style="width: 100%" id="observaciones"></textarea>
	  </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_rehacer" onclick="ClosePop('modal_aprovacion')">No</a>
    <a href="#" class="btn btn-success" id="btn_rehacer_acp" onclick="ValidarCalidadPolimero()">Si</a>
  </div>
</div>
<!-- ----------->

<!-- Modal para Recibir polimero -->
<div class="modal hide fade" id="modal_recibir_polimero">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Recepción de Polimero <strong><label id="title_c" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" style="text-align: center">
	    <strong>
	    ¿ Esta seguro de la recepción del Polimero ?
	    </strong>
	  </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_rehacer" onclick="ClosePop('modal_recibir_polimero')">No</a>
    <a href="#" class="btn btn-success" id="btn_recep_poli" onclick="ValidarRecibirPolimero()">Si</a>
  </div>
</div>
<!-- ----------->

<!-- Modal para asociar Polimero con Pedido -->
<div class="modal hide fade" id="modal_asosiacion">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Asociar con Polimero <strong><label id="title_c" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" id="error_asoc" style="text-align: center; display: none;">
	    <strong>
	    Ingrese un número de polímero válido.
	    </strong>
	  </div>
	  
	  <table width="100%">
	    <tr>
		<td>
		  <strong>
		    Número de Polímero:
		  </strong>
		</td>
		<td>
		  <input type="text" class="input-medium" id="numPolim" placeholder="Número de Pólimero">
		</td>
	    </tr>
	  </table>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_no_aso" onclick="ClosePop('modal_asosiacion')">Cancelar</a>
    <a href="#" class="btn btn-success" id="btn_asoc_poli" onclick="AsociarPolimero()">Aceptar</a>
  </div>
</div>
<!-- ----------->

<div class="modal hide fade" id="modal_error" style="z-index: 12000">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Error !! <strong><label id="title_c" style="font-size: 22px; font-weight: bold;"></label></strong></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" style="text-align: center" id="error_polimero">
	    
	  </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="btn_cancel" onclick="ClosePop('modal_error')">No</a>
  </div>
</div>

<!-- Modal para Recibir polimero -->
<div class="modal hide fade" id="modal_edithrci">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Editar HR / CI</h3>
  </div>
  <div class="modal-body" style="min-height: 250px;">
      <div style="width: 100%;" id="hrciEdit">
	  <table style="width: 100%;" id="tableEditHRCI">
	    <thead>
		<tr>
		    <th style="text-align: right;">Número: </th>
		    <th style="text-align: left;">
			<input type="text" id="numHRCI" placeholder="Número de HR / CI" style="width: 150px; margin-left: 10px;">
			<input style="margin-left:10px; margin-top: -10px;" type="button" value="+" class="btn btn-primary" onclick="addValueHRCI()">
		    </th>
		</tr>
		<tr><th colspan="2"><hr></th></tr>
	    </thead>
	    <tbody>
		
	    </tbody>
	  </table>
      </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" onclick="ClosePop('modal_edithrci')">Cancelar</a>
    <a href="#" class="btn btn-success" onclick="SaveEditHRCI()">Aceptar</a>
  </div>
</div>
<!-- ----------->

	<br>
	<div class="well"> <!-- Contenerdor margen de Pantalla standarizado -->
	
			<div class="row">
				<div class="span6 offset2">
					  <div class="page-header">
					  <h2>
                        <?php echo _listadoTitle($_GET['accion'])?>
					</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="span2">
					<input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="principalL()">
					<?php
					if($_GET['accion'] == "I")
					{
					    if($_SESSION["admin"] != "1")
					    {
						?>
						&nbsp;&nbsp;&nbsp;<input type="button" name="nuevo" value="Nuevo"  class="btn btn-success" onClick="AbrirVentanaPedido('0','I')">
						<?php
					    }
					}
					?>
				</div>
				<div class="offset5 span2 hidden">
				    <input type="text" placeholder="Buscar..." id="buscador_txt" value="<?php echo (!isset($_GET['query'])) ? '' : $_GET['query'];?>">
				</div>
			</div>
			
			<div class="row">
				<div class="span10">
					<form name="listado" method="post">

					<?php if($_GET['accion']!='TO'){
							include("class_abm.php");					
							$tabla = new abm();
							$tabla->listadoPedido($action,$nombre, $_GET['page'],(!isset($_GET['query'])) ? '' : $_GET['query']);				
							
					 }else{?>
						<table id="listado_todos">
							<thead>
								<tr>
								<th>Código</th></th>
								<th>Cliente</th>
								<th>Producto</th>
								<th></th>
								</tr>
							</thead>
						</table>
					 <?php } ?>

					</form>
				</div>
			</div>
			
			<input type="hidden" id="actionValue" value="<?php echo $_GET['accion']; ?>">
        </div>
	
	<input type="hidden" id="actionPoli">
<?php

require("footer.php");

?>

<!-- Modal para ver log de polimeros -->
<div class="modal hide fade" id="modal_polimero_log">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="titlePolimeroLog" style="text-align: center"></h3>
  </div>
  <div class="modal-body">
    <div style="text-align : center; min-height: 80px; font-size: 12px;" id="detailPolimero">
    </div>
    <div style="text-align : center;">
	<span class="label" id="status1" style="font-size: 30px;" title="Ingreso en Preprensa">1</span>
	<span class="label" id="status2" style="font-size: 30px; margin-left: 25px;" title="Enviado aprob. de Cliente">2</span>
	<span class="label" id="status3" style="font-size: 30px; margin-left: 25px;" title="Aprobado por el Cliente">3</span>
	<span class="label" id="status4" style="font-size: 30px; margin-left: 25px;" title="Enviado aprob. de Borradores">4</span>
	<span class="label" id="status5" style="font-size: 30px; margin-left: 25px;" title="Borrador Aprobado">5</span>
	<span class="label" id="status6" style="font-size: 30px; margin-left: 25px;" title="Preprensa Empaque">6</span>
	<span class="label" id="status7" style="font-size: 30px; margin-left: 25px;" title="Preprensa en Proveedor">7</span>
	<span class="label" id="status8" style="font-size: 30px; margin-left: 25px;" title="Confección de Polímeros">8</span>
	<span class="label" id="status9" style="font-size: 30px; margin-left: 25px;" title="Polímero en Calidad">9</span>
	<span class="label" id="status10" style="font-size: 30px; margin-left: 25px;" title="Producción/Impresión">10</span>
    </div><br>
    <div>
	<p id="estadoActual"><strong>Estado Actual: </strong>-.</p>
    </div>
    <hr>
	<div id="logpolimeros" style="width: 100%; max-height: 200px; overflow-y: scroll; overflow-x: hidden;">
	    
	</div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-success" data-dismiss="modal">Aceptar</a>
  </div>
</div>
<!-- -->


<script>
 $( document ).ready(function() {
  $("#modal_disenio").on('change',function(index){
	if ($('#actionPoli').val() != 'TP' && $('#actionPoli').val() != 'CR' && $('#actionPoli').val() != 'RV') {
	    $('#btn_rehacer_update').show();
	    $('#actionPoli').val('MO');
	    $('#btn_rehacer_disi').hide();
	}
	else{
	    if ($('#actionPoli').val() == 'CR') {
		$('#btn_rehacer_devolver').show();
		$('#actionPoli').val('RV');
		$('#btn_rehacer_disi').hide();
	    }
	}
    });
  
  $("#buscador_txt").keypress(function(e) {
    if(e.which == 13) {
	if ($("#buscador_txt").val() != "") {
	    var accion = $("#actionValue").val();
	    var query = $("#buscador_txt").val();
	    window.location.replace("..listadoPedidos.php?accion="+accion+"&page=0&query="+query+"");
	}
    }
  });
  
  $("#btnFacturarSiNo").click(function() {
    if(!$("#btnFacturarSiNo").attr('disabled')){
	if($("#btnFacturarSiNo").hasClass('btn-success'))
	    {
		$("#btnFacturarSiNo").removeClass('btn-success');
		$("#btnFacturarSiNo").addClass('btn-danger');
	    }
	    else
	    {
		$("#btnFacturarSiNo").removeClass('btn-danger');
		$("#btnFacturarSiNo").addClass('btn-success');
	    }
    }
  });
  
  $( document ).tooltip();
});   
    
function BuscarProducto()
{
    //window.open("buscarProductoPop.php", "PopUp", 'width=700px,scrollbars=YES');
    $("#buscadorP").val("");
    $("#resultado_Productos").html("");
    $('#ProductosPop').modal('show');
    setTimeout(function () { document.getElementById("buscadorPO").focus(); }, 1000);
    
}

function BuscadorDeProductos(value, page)
  {
	  
	  var data_ajax={
			  type: 'POST',
			  url: "buscarProducto.php",
			  data: { xinput: value, xpage: page , busq: $('#busc').val() },
			  success: function( data ) {
						      if(data != 0)
						      {
							  var fila = '<table style="width: 90%; font-size: 10px;">';
							  fila +='<tbody><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th style="width: 500px;">Artículo</th><th>Código Producto</th></tr></tbody>';
							  $.each(data, function(k,v)
									  {
									      //Datos de cada cliente
									      fila += "<tbody><tr>";
									      var idCodigo = "";
									      $.each(v, function(i,j)
											 {
											   if(i == "Id")
											   {
												  //Icono
												  fila +='<td><i class="icon-plus" style="color: #51A351; cursor: pointer;" title="Seleccionar" id="'+j+'" onClick="SeleccionadoPP(\''+j+'\')"></i></td>';
												  fila +="<td>"+j+"</td>";
												  fila += '<input type="hidden" id="'+j+'_cp" value="'+j+'">';
												  idCodigo = j;
											   } 
											   if(i == "Articulo")
											   {
												  fila +='<td style="padding-left: 10px;">'+j+'</td>';
												  fila += '<input type="hidden" id="'+idCodigo+'_arp" value="'+j+'">';
											   }
											   if(i == "Nombre_en_Facturacion")
											   {
												  fila +="<td>"+j+"</td>";
												  fila += '<input type="hidden" id="'+idCodigo+'_ncp" value="'+j+'">';
											   }
											   
											 }
											);
									      
									      fila += "</tr></tbody>";
									      
									  }
									  
									 );
							  fila += "</table>";
							  
							  $("#resultado_Productos").html(fila);
							  
						      }
						      else
						      {
							  $("#resultado_Productos").html('<strong style="color: red;">No se encontraron resultados</strong>');
						      }
						    },
			  error: function(){
					      alert("Error de conexión.");
					    },
			  dataType: 'json'
			  };
	  $.ajax(data_ajax);		
  }
  
function SeleccionadoPP(valor)
{
	//tomar id pasado y buscar los valor para los campos correspondientes al producto
	var ar = "#"+valor+"_arp";
	var nc = "#"+valor+"_ncp";
	
	$("#codigoProducto").val(valor);
	$("#descriptionProd").val($(ar).val());
	$("#codigoTangoProd").val($(nc).val());
	
	ClosePop("ProductosPop");
}

function ClosePop(div)
	{
		var idDiv = "#"+div;
		$(idDiv).modal('hide');			
	}
	
function ValidarMotivo()
{


  $('#error_rehacer_msj').html("");
  $('#error_rehacer_div').css('display','none');
  
	var motivos = "";
	    
	if (motives.length <= 0)
	{
    $('#error_rehacer_msj').html("<strong>Ingrese al menos un motivo para poder cambiar de estado el pedido.</strong>");
    $('#error_rehacer_div').css('display','block');
    return;
	}
	
	for (var i = 0; i < motives.length; i++) {
    if (motivos == "") {
			motivos = motives[i];
    }
    else{
			motivos += "-" + motives[i];
    }
	}
	
	if($('#motivo').val() == "")
	{
    $('#error_rehacer_msj').html("<strong>Ingrese una descripción para poder cambiar de estado el pedido.</strong>");
    $('#error_rehacer_div').css('display','block');
    return;
	}


	var hojaruta=$("#dev_HojaRuta").val();
	var estaImpreso=0;
	if($("#esta_impreso").is(':checked')){
		estaImpreso=1;
	}
	$('#btn_rehacer_acp').attr('disabled', 'disabled');
	
	var data_ajax={
    type: 'POST',
    //url: "insertPedido.php",
    url: "insertPedido.php",
    data: { 
    	action: $("#statusAction").val(),
		id: $('#idPed').val(),
		motive: $('#motivo').val(),
		status: $("#statusNow").val(),			
		hojaruta: hojaruta,
		estaImpreso: estaImpreso,
		mot: motivos
	},
    success: function( data ) {		 
    	$("#modal_rehacer").modal('hide');		
		location.reload();                                
    },
    error: function(){
    	//alert("Error de conexión.");
    },
    dataType: 'json'
  };
		
	$.ajax(data_ajax);
    
}

function ValidarMotivoCancel()
{
    $('#error_cancelar_msj').html("");
    $('#error_cancel_div').css('display','none');
  
	var motivos = "";
	    
	if (motives.length <= 0)
	{
	    $('#error_cancelar_msj').html("<center><strong>Ingrese al menos un motivo para poder cancelar el pedido.</strong></center>");
	    $('#error_cancel_div').css('display','block');
	    return;
	}
	
	for (var i = 0; i < motives.length; i++) {
	    if (motivos == "") {
		motivos = motives[i];
	    }
	    else{
		motivos += "-" + motives[i];
	    }
	}
	
	if($('#motivo_').val() == "")
	{
	    $('#error_cancelar_msj').html("<strong>Ingrese una descripción para poder cancelar el pedido.</strong>");
	    $('#error_cancel_div').css('display','block');
	    return;
	}
	
	$('#btn_rehacer_p_acp').attr('disabled', 'disabled');
	
	
	var data_ajax={
                        type: 'POST',
                        url: "insertPedido.php",
                        data: { action: 'C',
				id: $('#idPed').val(),
				motive: $('#motivo_').val(),
				status: $("#statusNow").val(),
				mot: motivos},
                        success: function( data ) {
					$("#modal_cancel").modal('hide');
					location.reload();
                                },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
		
		$.ajax(data_ajax);
    
}

function AbrirPopPedidosCancel(id, accion)
{
    var msj = "<center><b style=\"font-size: 13px;\">Esta seguro de CANCELAR el pedido seleccionado ?</b></center>";
    var msj_h = "Cancelar Pedido";
    
    $('#idPed').val(id);
    $('#motivo').val("");
    $('#error_cancelar_msj').html("");
    $('#div_alert_er_c').html(msj);
    $('#header_div_c').html(msj_h);
    $('#error_cancel_div').css('display','none');
    $('#btn_cancelar_p_acp').removeAttr('disabled');
    getMotives('C', 'div_motives_');
    $("#modal_cancel").modal('show'); 
}

function AbrirPopPedidos(id, accion)
{	
    var msj = "Esta seguro de pasar el pedido seleccionado al estado de rehacer ?";
    var msj_h = "Rehacer pedido";
      switch(accion)
      {
	case "I":
	  {
	    $("#statusNow").val(accion);
	    $("#statusAction").val('R');
	    msj = "<center><b style=\"font-size: 13px;\">Esta seguro de rehacer el pedido seleccionado ?</b></center>";
	    msj_h = "Rehacer Pedido";
	    getMotives('D', 'div_motives');
	    break;
	  }
	case "A":
	  {
	    $("#statusNow").val(accion);
	    $("#statusAction").val('RR');
	    msj = "<center><b style=\"font-size: 13px;\">Esta seguro de rehacer el pedido seleccionado ?</b></center>";
	    msj_h = "Rehacer Pedido";
	    getMotives('D', 'div_motives');
	    break;
	  }
	case "N":
	  {
	    $("#statusNow").val(accion);
	    $("#statusAction").val('RN');
	    msj = "<center><b style=\"font-size: 13px; margin-left: 20px;\">Esta seguro de rehacer el pedido seleccionado ?</b></center>";
	    msj_h = "Rehacer Pedido";
	    getMotives('D', 'div_motives');
	    break;
	  }
	case "AP":
	  {
	    $("#statusNow").val(accion);
	    $("#statusAction").val('NO');
	    msj = "<center><b style=\"font-size: 13px; margin-left: 20px;\">Esta seguro de rehacer el pedido seleccionado ?</b></center>";
	    msj_h = "Rehacer Pedido";
	    getMotives('D', 'div_motives');
	    break;
	  }
	case "D":
	  {
	    $("#statusNow").val('P');
	    $("#statusAction").val(accion);
	    msj = "<b style=\"font-size: 13px; margin-left: 20px;\">Esta seguro de pasar el pedido seleccionado al estado de devolución ?</b>";
	    msj_h = "Devolver Pedido";
	    getMotives('D', 'div_motives');
	    break;
	  }
	case "C":
	  {
	    $("#statusNow").val('R');
	    $("#statusAction").val(accion);
	    msj = "Esta seguro de cancelar el pedido seleccionado ?";
	    msj_h = "Cancelar Pedido";
	    break;
	  }
        case "NC":
	    {
	    $("#statusNow").val('CL');
	    $("#statusAction").val(accion);
	    msj = "<b style=\"font-size: 13px; margin-left: 20px;\">Esta seguro de pasar el pedido seleccionado al estado de rechazado por el cliente ?</b>";
	    msj_h = "Cancelar pedido";
	    getMotives('D', 'div_motives');
	    }
      }
      $('#idPed').val(id);
      $('#motivo').val("");
      $('#error_rehacer_msj').html("");
      $('#div_alert_er').html(msj);
      $('#header_div_r').html(msj_h);
      $('#error_rehacer_div').css('display','none');
      $('#btn_rehacer_acp').removeAttr('disabled');
      $("#modal_rehacer").modal('show');
      
}
/*
$( "td.td_dev" ).live('click',function(the_event){
	alert("hola live td.td_dev");
});
*/
$(document).on('click','td.td_dev',function(the_event){
	var data = $(this).data();
	console.debug("===> DATA: %o",data);
  	//return false;
	$("#statusNow").val('P');
  	$("#statusAction").val(data.action);
 	msj = "<b style=\"font-size: 13px; margin-left: 20px;\">Esta seguro de pasar el pedido seleccionado al estado de devolución ?</b>";
  	msj_h = "Devolver Pedido";
  	getMotives('D', 'div_motives');

	$('#idPed').val(data.id);
	console.debug("===> rh: %o",data.rh);
	if(data.rh!=''){
		//$("#tieneHojaRuta").prop('checked', true);
		$('#dev_HojaRuta').val(data.rh);	
	}else{
		//$("#tieneHojaRuta").prop('checked', false);
		$('#dev_HojaRuta').val(null);	
	}
	
  $('#motivo').val("");
  $('#error_rehacer_msj').html("");
  $('#div_alert_er').html(msj);
  $('#header_div_r').html(msj_h);
  $('#error_rehacer_div').css('display','none');
  $('#btn_rehacer_acp').removeAttr('disabled');
  $("#modal_rehacer").modal('show');


});

var motives = new Array();
function addMotive(value)
{
    var index = motives.indexOf(value);
    
    if (index > -1) {
	motives.splice(index, 1);
    }else
    {
	motives.push(value);
    }
}

function getMotives(value, div)
{
	motives = new Array();
	$("#"+div+"").html("");
	var data_ajax={
                        type: 'POST',
                        url: "getMotives.php",
                        data: { val: value},
                        success: function( data ) {
					
					var count = 0;
					$.each(data, function(k,v)
					       {
						    var id = "";
						    var desc = "";
						    $.each(v, function(i,j)
							   {
								if (i == "id")
								    id = j;
								else
								    desc = j;
							   });
						    count++;
						    if (count == 1) {
							$("#"+div+"").append('&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="'+id+'" value="'+id+'" onClick="addMotive('+id+')">'+desc+'</input><br>');
							count = 0;
						    }
						    else
						    { $("#"+div+"").append('&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="'+id+'" value="'+id+'" onClick="addMotive('+id+')">'+desc+'</input>'); }
					       });
                                },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
		
	$.ajax(data_ajax);  
}

function AbrirCalidad(id)
{
      $('#idPed').val(id);
      $("#modal_calidad").modal('show');
}

function ValidarMotivoCalidad(estado)
{
	$('#btn_rehacer_acp').attr('disabled', 'disabled');
	
	var data_ajax={
                        type: 'POST',
                        url: "insertPedido.php",
                        data: { action: estado, id: $('#idPed').val()},
                        success: function( data ) {
					$("#modal_calidad").modal('hide');
					location.reload();
                                },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
		
		$.ajax(data_ajax);
}

function AbrirDisenio(id, code, cli, prod, action)
{
      $('#actionPoli').val(action);
      $('#error_msj_dis').html("");
      $('#error_div_dis').css('display','none');
      
      $('#idPed').val(id);
      
      $('#poli_code').html(code);
      $('#poli_cliente').html(cli);
      $('#poli_produ').html(prod);
      
      $('#btn_rehacer_update').hide();
      $('#btn_rehacer_disi').show();
      
      Limpiar();
      $("#modal_disenio").modal('show');
}

function ValidarMotivoDiseño()
{
    $('#error_asoc').html("");
    $('#error_asoc').css('display','none');
    $('#btn_rehacer_disi').removeAttr('disabled');
    
  
	if($('#idProveedor').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccione un proveedor válido.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
    
	if($('#poliObservaciones').val() == "")
	{
	    $('#error_asoc').html('<strong>Ingrese una observación válida para el polímero.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	if($('#maquina').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccione una máquina válida.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	if($('#poliColores').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccion un color válido.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	if($('#espesor').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccione un espesor válido.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	if($('#tipoPolimero').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccione un tipo válido.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	if($('#poliMedidas').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccione una medida válida.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	if($('#poliMarcas').val() == "")
	{
	    $('#error_asoc').html('<strong>Seleccione una marca de registro válida.</strong>');
	    $('#error_asoc').css('display','block');
	    return;
	}
	
	$('#btn_rehacer_disi').attr('disabled', 'disabled');
	
	var data_ajax={
                        type: 'POST',
                        url: "insertPedido.php",
                        data: {
				action: 	'CA',
				id: 		$('#idPed').val(),
				idProveedor: 	$('#idProveedor').val(),
				desc: 		$('#poliObservaciones').val(),
				idMaquina:	$('#maquina').val(),
				color:		$('#poliColores').val(),
				idEspesor:	$('#espesor').val(),
				tipo:		$('#tipoPolimero').val(),
				medidas:	$('#poliMedidas').val(),
				marcas:		$('#poliMarcas').val()
			      },
                        success: function( data ) {
					$("#modal_disenio").modal('hide');
					$('#btn_rehacer_disi').removeAttr('disabled');
					alert("Se genero la Orden de Trabajo Número: " + data);
					location.reload();
                                },
                        error: function(){
                                            alert("Error de conexión.");
					    $('#btn_rehacer_disi').removeAttr('disabled');
                                          },
                        dataType: 'json'
                        };
		
		$.ajax(data_ajax);
    
}


var validarMotivo;
function AprobarCalidad(id, estado)
{
      $("#error_rehacer_calidad").css('display','none');
      $('#idPed').val(id);
      if(estado == "SI")
      {
	$("#label_calidad").html("¿ Esta seguro de aprobar la calidad del polimero ?");
	$("#div_motivo_calidad").css('display','none');
	validarMotivo = false;
      }
      else
      {
	$("#label_calidad").html("¿ Esta seguro de 'NO' aprobar la calidad del polimero ?");
	$("#div_motivo_calidad").css('display','block');
	$("#motivo_calidad").val("");
	validarMotivo = true;
      }
      $("#modal_aprovacion").modal('show');
}

function ValidarCalidadPolimero()
{
  var acction;
  var obs = "";
  $('#btn_rehacer_acp').attr('disabled', 'disabled');
  if(validarMotivo == true)
  {
    acction = "PX";
    if($("#motivo_calidad").val() != "")
    {
      obs = $("#motivo_calidad").val();
    }
    else
    {
	$("#error_rehacer_calidad").css('display','block');
	$('#btn_rehacer_acp').removeAttr('disabled');
	return;
    }
  }
  else
  {
    acction = "PA";
  }
  
	
  var data_ajax={
		  type: 'POST',
		  url: "insertPedido.php",
		  data: { action: acction, id: $('#idPed').val(), observation: obs},
		  success: function( data ) {
				  $("#modal_aprovacion").modal('hide');
				  location.reload();
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	  $.ajax(data_ajax);
}

function AbrirRecibirPolimero(id)
{
      $('#idPed').val(id);
      $("#modal_recibir_polimero").modal('show');
}

function ValidarRecibirPolimero()
{
  $('#btn_recep_poli').attr('disabled', 'disabled');
  
  var data_ajax={
		  type: 'POST',
		  url: "insertPedido.php",
		  data: { action: "PR", id: $('#idPed').val()},
		  success: function( data ) {
				  $("#modal_aprovacion").modal('hide');
				  location.reload();
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	  $.ajax(data_ajax);
}

function AsociarPolimeroOpen(id)
{
  $('#idPed').val(id);
  $("#error_asoc").css('display','none');
  $("#modal_asosiacion").modal('show');
}

function AsociarPolimero()
{
  $('#btn_asoc_poli').attr('disabled', 'disabled');
  
  if($("#numPolim").val() == "" || $("#numPolim").val() == null)
    {
	$("#error_asoc").css('display','block');
	$('#btn_asoc_poli').removeAttr('disabled');
	return;
    }

  var data_ajax={
		  type: 'POST',
		  url: "insertPedido.php",
		  data: { action: "P1", id: $('#idPed').val(), nume: $("#numPolim").val()},
		  success: function( data ) {
				  $("#modal_asosiacion").modal('hide');
				  location.reload();
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	  $.ajax(data_ajax);
}

function BuscarProveedor()
    {
	    cliente = true;
	    $("#buscadorPro").val("");
	    $("#resultado_Proveedor").html("");
	    $('#ProveedoresPop').modal('show');
	    setTimeout(function () { document.getElementById("buscadorPro").focus(); }, 1000);
    };
    
function BuscadorDeProveedores(value)
	{
		var input = [];
		input.push(value);
		var color = '#FFFFFF';
		
		var data_ajax={
				type: 'POST',
				url: "buscarProveedor.php",
				data: { xinput: input },
				success: function( data ) {
							    if(data != 0)
							    {
								var fila = '<table style="width: 90%; font-size:12px;">';
								fila +='<tbody><th style="width: 20px;"></th><th style="width: 70px;">Razón Social</th><th>Localidad</th></tr></tbody>';
								$.each(data, function(k,v)
										{
										    if(color == '#A9F5A9')
										    {
											color = '#FFFFFF';
										    }
										    else
										    {
											color = '#A9F5A9';
										    }
										    //Datos de cada cliente
										    var idCodigo = "";
										    $.each(v, function(i,j)
											       {
												 if(i == "id_proveedor")
												 {
													fila += '<tr style="cursor: pointer; background-color:'+color+'"  onClick="SeleccionadoP(\''+j+'\')">';
													//Icono
													fila += '<td><img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" style="cursor: pointer;" id="'+j+'"/></td>';
													//fila +='<td><i class="icon-plus" style="color: #51A351; cursor: pointer;" title="Seleccionar" id="'+j+'" onClick="SeleccionadoP(\''+j+'\')"></i></td>';
													fila += '<input type="hidden" id="'+j+'_c" value="'+j+'">';
													idCodigo = j;
												 }
												 if(i == "razon_social")
												 {
													fila +="<td>"+j+"</td>";
													fila += '<input type="hidden" id="'+idCodigo+'_rz" value="'+j+'">';
												 }
												 if(i == "direccion")
												 {
													fila +="<td>"+j+"</td>";
												 }
											       }
											      );
										    
										    fila += "</tr>";
										    
										}
										
									       );
								fila += "</table>";
								
								$("#resultado_Proveedor").html(fila);
								
							    }
							    else
							    {
								$("#resultado_Cliente").html('<strong style="color: red;">No se encontraron resultados</strong>');
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}
	
function SeleccionadoP(valor)
	{
		//tomar id pasado y buscar los valor para los campos correspondientes al cliente
		var id = "#"+valor+"_c";
		var rz = "#"+valor+"_rz";
					
		$("#idProveedor").val($(id).val());
		$("#Proveedor").val($(rz).val());	
		
		ClosePop("ProveedoresPop");
		
		var container = "";
		var item = ""
		
		//Load calidades
		var data_ajax={
				type: 'POST',
				url: "loadCalidades.php",
				data: { xinput: valor },
				success: function( data ) {
							    if(data != 0)
							    {
								$.each(data, function(k,v)
										{
										    $.each(v, function(i,j){
								    			switch (i) {
											    case "idTipo":
												item += "<input type=\"checkbox\" value=\"" + j + "\" class=\"calidad\" style=\"margin-top: -1px;\">";
												break;
											    
											    case "descTipoPoli":
												item += j;
												break;
											}
										    });
										}
									);
								$("#calidadesDiv").html(item);
							    }
							    else
							    {
								$("#calidadesDiv").html("<p style=\"font-color: red;\">No hay tipos asociados al proveedor.</p>");
							    }
							  },
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		$.ajax(data_ajax);
	}
	
function AddHojaDeRuta() {
    if($("#hojaRuta").val() != "" && $("#hojaRuta").val() != null)
    {
	var fila = "<tr id=\""+$("#hojaRuta").val()+"\"><td>"+$("#hojaRuta").val()+"</td>";
	fila += "<td style=\"text-align: right;\"><input style=\"margin-right:100px;\" type=\"button\" value=\"X\" class=\"btn btn-danger\" onclick=\"removerFila('"+$("#hojaRuta").val()+"')\"></td></tr>";
	$('#table_hoja_ruta > tbody:last').append(fila);
	//$('#table_hoja_ruta > tbody:last').append('<tr><td>' + $("#hojaRuta").val() + '<br></td></tr></tr>');
	//HojasDeRutaArray.push($("#hojaRuta").val());
	$("#hojaRuta").val('');
    }
}

function ImprimirReporte(sql){
    //impresion individual
    window.open("impresionComprobantes.php?documento=4&id="+sql, "PopUp", "menubar=1,width=900,height=900");
}

function verObservacion()
{
    $('#modal_entregas_observacion').modal('show');
}

function openHR() {
    $("#HrList").html("");
    var data_ajax={
		  type: 'POST',
		  url: "gethrci.php",
		  data: { id: $('#idPed').val() },
		  success: function( data ) {
				
				$.each(data, function(k,v){
					$.each(v, function(i,j)
						{
						    $("#HrList").append( "<b>- " + j + "</p><br>" );
						});
				});
				$('#modal_entregas_hrci').modal('show');
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
    $.ajax(data_ajax);
}

function openET()
{
    $("#EntList").html("");
    
    var data_ajax={
		  type: 'POST',
		  url: "getEntregas.php",
		  data: { id: $('#idPed').val() },
		  success: function( data ) {
				$("#EntList").append('<tr><th width="70">Kg.</th><th width="70">Un.</th><th width="70">Bu.</th><th>Fecha</th><th>Usuario</th></tr>');
				$("#EntList").append( "<tr style=\"font-size:10px;\"><td colspan=\"5\"><hr></td></tr>");
				var totKg = 0;
				var totCant = 0;
				var totBul = 0;
				$.each(data, function(k,v){
					var cant = "";
					var kg 	= "";
					var bul = "";
					var fec = "";
					var us 	= "";
					$.each(v, function(i,j)
						{
						    switch(i)
						    {
							case "cantidad":
							    cant = j;
							    totCant += parseFloat(cant);
							    break;
							case "kg":
							    kg = j;
							    totKg += parseFloat(kg);
							    break;
							case "bultos":
							    bul = j;
							    totBul += parseInt(bul);
							    break;
							case "fecha":
							    fec = j;
							    break;
							case "userId":
							    us = j;
							    break;
						    }
						});
					var color = "Black";
					if (kg < 0) {
					    color = "Red";
					}
					 $("#EntList").append( "<tr style=\"font-size:11px;color:"+color+"\"><td>"+kg+"</td><td>"+cant+"</td><td>"+bul+"</td><td>"+fec+"</td><td>"+us+"</td></tr>");
					 $("#EntList").append( "<tr style=\"font-size:2px;\"><td colspan=\"5\"><hr></td></tr>");
				});
				$("#EntList").append( "<tr style=\"font-size:15px;\"><td><strong>"+totKg.toFixed(2)+"</strong></td><td><strong>"+totCant.toFixed(2)+"</strong></td><td><strong>"+totBul+"</strong></td><td colspan=\"2\"><strong>Totales</strong></td></tr>");
				$("#modal_entregas_entregas").modal('show');
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
    $.ajax(data_ajax);
}

function openEP()
{
    $("#pa").html($("#precio").text());
    $("#modal_entregas_edit").modal("show");
}

function openEPE()
{
    $("#pa").html($("#precioEdit").text());
    $("#modal_entregas_edit").modal("show");
}

function SetImpresion(Id,Status)
{
    var data_ajax={
		  type: 'POST',
		  url: "setImpresionPedido.php",
		  data: { id: Id, status: Status},
		  success: function( data ) {
				location.reload();
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	  $.ajax(data_ajax);
}

function ValidarEditPrecio()
{
    if ($("#nprecio").val() != "") {
	var data_ajax={
		  type: 'POST',
		  url: "editPrice.php",
		  data: {
			    id: $('#idPed').val(),
			    precio: $("#nprecio").val(),
			    ant: $("#precio").text(),
			    moneda: $("#monedaEdit").val() ,
			    condicion: $("#condicionEdit").val()
			},
		  success: function( data ) {
				if (data == 1) {
				   
				   $("#modal_entregas_edit").modal("hide");
				   
				   if ($("#onlyEdit").val() == "1") {
				    $("#modal_editar_precio").modal('hide');
				    $("#nprecio").val('');
				    $("#monedaEdit").val(1);
				    $("#condicionEdit").val(1);
				    setTimeout(
				    function(){
				       AbrirPopEditarPrecio($('#idPed').val(), $('#nomProductoEdit').text(), $('#NTPidEditP').text() );
				    }, 1000);
				   }
				   else
				   {
				    $('#modal_terminado').modal('hide');
				    
				    setTimeout(
				    function(){
				       AbrirPopTerminado($('#idPed').val(), $('#nomProducto').text(), $('#NTPid').text() );
				    }, 1000);
				    
				    $("#onlyEdit").val('');
				   }
				   
				   
				}
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	$.ajax(data_ajax);
    }
}

function calculaPP()
{
    var data = $('#precio').text();
    var arr = data.split(' ');
    var precio = 0;
    if(arr[4]== undefined)
    {
	precio = arr[1];
    }
    else
    {
	precio = arr[4];
    }
    var cantidad = parseFloat($("#tbcantidad").val());
    var kilos = parseFloat($("#tbkg").val());
    var cotizacion = parseFloat($("#cotizacionMM").val());
    
    if (isNaN(precio) || precio <= 0 || isNaN(cantidad) || cantidad <= 0 || isNaN(kilos) || kilos <= 0) {
	$("#calculo").html("$ 0.00 /Kg.");
    }
    else
    {
	var divideEn = 1;
	if(data.indexOf("Final") != -1)
		divideEn = 1.21;
	var importe = (((cantidad * precio) / kilos) * cotizacion) / divideEn;
	$("#calculo").html("$ " + importe.toFixed(2) + " /Kg.");
    }
}

function calculaEst()
{
    var ingreso = $("#tbcantidad").val() == "" ? 0 : ($("#tbcantidad").val() * 1).toFixed(2);
    var porcent = ((5 * $("#cantidad").html()) / 100);
    var entregado = (($("#cantidadEntregada").html() * 1) - (ingreso * -1)).toFixed(2);
    var cantidad = ($("#cantidad").html() * 1).toFixed(2);
    
    if ( entregado < (parseFloat(cantidad) + parseFloat(porcent)) && entregado > (cantidad - porcent)) {
	    $("#calc2").html('<b style="color: green">' + entregado + '</b>');
    }
    else
	    {
		    if (entregado < (cantidad - porcent)) {
			    $("#calc2").html('<b style="color: blue">' + entregado + '</b>');
		    }
		    else
		    {
			    $("#calc2").html('<b style="color: red">' + entregado + '</b>');
		    }
	    }
}
//Solo se permiten numero y punto
function decimal(campo)
	{ 
	var charpos = campo.value.search("[^0-9.]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value =  campo.value.slice(0, -1)
		campo.focus();
		return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//

//Solo numeros en el campo
function numerico(campo) 
	{
	var charpos = campo.value.search("[^0-9]"); 
    if (campo.value.length > 0 &&  charpos >= 0)  
		{ 
		campo.value = campo.value.slice(0, -1);
		campo.focus();
	    return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//

function ValidarPolimeroNuevo()
{
    var idProveedor 	= "";
    var Lineatura	= "";
    var calidad		= "";
    var poliMedidas	= "";
    var poliColores	= "";
    var pistas 		= "";
    var cilindro	= "";
    var camisa		= "";
    var anchoSugerido	= "";
    var AVT		= "";
    var diseno		= "";
    var estadoPolPlanta	= "";
    var reponer		= "";
    var muestra		= "";
    var fechaEnt	= "";
    var presupuesto	= "";
    var disenoBase	= "";
    var detallaVend	= "";
    var detallaClien	= "";
    var detallaGeren	= "";
    var detallaProd	= "";
    var detallaImp	= "";
    var reunion 	= "";
    var observaciones	= "";
    var sentido		= "";
    var barra		= "";
    var codeBarCodigo	= "";
    
    $('#btn_rehacer_disi').attr('disabled', 'disabled');
    $('#btn_rehacer_devolver').attr('disabled', 'disabled');
    $('#btn_rehacer_update').attr('disabled', 'disabled');
    
	if($('#idProveedor').val() == "")
	{
	    $('#error_polimero').html('<strong>Seleccione un proveedor válido.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ idProveedor = $('#idProveedor').val(); }
    
	if($('#Lineatura').val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese una lineatura válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ Lineatura = $('#Lineatura').val(); }
	
	var corte = true;
	$(".calidad").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		calidad += this.value +"/";
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Seleccione al menos un tipo de calidad.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	
	if($('#poliMedidas').val() == "")
	{
	    $('#error_polimero').html('<strong>Seleccione una medida válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ poliMedidas = $('#poliMedidas').val(); }
	
	if($('#poliColores').val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese una descripción de color válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else { poliColores = $('#poliColores').val(); }
	
	if($('#pistas').val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese una descripción de pistas válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ pistas = $('#pistas').val(); }
	
	if($('#cilindro').val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese una descripción de cilindro válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ cilindro = $('#cilindro').val(); }
	
	//Campos no obligatorio
	camisa = $('#camisa').val();
	
	//if($('#camisa').val() == "")
	//{
	//    $('#error_polimero').html('<strong>Ingrese una descripción de camisa válida.</strong>');
	//    $('#modal_error').modal('show');
	//    $('#btn_rehacer_disi').removeAttr('disabled');
	//    $('#btn_rehacer_devolver').removeAttr('disabled');
	//    $('#btn_rehacer_update').removeAttr('disabled');
	//    return;
	//}else{ camisa = $('#camisa').val(); }
	
	if($('#anchoSugerido').val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese una descripción de ancho sugerido válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ anchoSugerido = $('#anchoSugerido').val(); }
	
	//Campo no obligatorio
	$(".AVT").each(function( index ){
	  
	    if (this.checked == true) {
		AVT += this.value + "/";
	    }
	});
	
	//if (corte == true) {
	//    $('#error_polimero').html('<strong>Ingrese al menos un AVT.</strong>');
	//    $('#modal_error').modal('show');
	//    $('#btn_rehacer_disi').removeAttr('disabled');
	//    $('#btn_rehacer_devolver').removeAttr('disabled');
	//    $('#btn_rehacer_update').removeAttr('disabled');
	//    return;
	//}
	
	corte = true;
	$(".sentido").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		sentido = this.value;
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Ingrese el sentido de Impresión.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	
	corte = true;
	$(".barra").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		barra = this.value;
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Indique si el polímero tiene código de barra.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	
	if (barra == 1) {
	    if ($("#codeBar").val() == "") {
		$('#error_polimero').html('<strong>Ingrese el código de barra.</strong>');
		$('#modal_error').modal('show');
		$('#btn_rehacer_disi').removeAttr('disabled');
		$('#btn_rehacer_devolver').removeAttr('disabled');
		$('#btn_rehacer_update').removeAttr('disabled');
		return;
	    }
	    else
	    {
		//codeBar = $("#codeBar").val();
	    }
	}
	else
	{
	    $("#codeBar").val('0')
	}
		
	
	corte = true;
	$(".diseno").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		diseno = this.value;
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Seleccione el tipo de diseño.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
    
	if (diseno != 1)
	{
	    corte = true;
	    $(".estadoPolPlanta").each(function( index ){
	      
		if (this.checked == true) {
		    corte = false;
		    estadoPolPlanta = this.value;
		}
	    });
	    
	    if (corte == true) {
		$('#error_polimero').html('<strong>Seleccione el estado de polímero en planta.</strong>');
		$('#modal_error').modal('show');
		$('#btn_rehacer_disi').removeAttr('disabled');
		$('#btn_rehacer_devolver').removeAttr('disabled');
		$('#btn_rehacer_update').removeAttr('disabled');
		return;
	    }
	    
	    //Campo no obligatorio
	    reponer = $("#reponer").val();
	    
	    corte = true;
	    $(".muestra").each(function( index ){
	      
		if (this.checked == true) {
		    corte = false;
		    muestra = this.value;
		}
	    });
	    
	    if (corte == true) {
		$('#error_polimero').html('<strong>Seleccione a quien solicita la muestra.</strong>');
		$('#modal_error').modal('show');
		$('#btn_rehacer_disi').removeAttr('disabled');
		$('#btn_rehacer_devolver').removeAttr('disabled');
		$('#btn_rehacer_update').removeAttr('disabled');
		return;
	    }
	}
	
	if($("#fechaEnt").val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese una fecha de entrega válida.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ fechaEnt = $("#fechaEnt").val(); }
	
	if($("#presupuestoAprox").val() == "")
	{
	    $('#error_polimero').html('<strong>Ingrese un presupuesto válido.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}else{ presupuesto = $("#presupuestoAprox").val(); }
	
	corte = true;
	$(".disenoBase").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		disenoBase += this.value + "/";
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Seleccione al menos una base de diseño.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	
	corte = true;
	$(".detallaVend").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		detallaVend += this.value + "/";
	    }
	});
	
	$(".detallaClien").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		detallaClien += this.value + "/";
	    }
	});
	
	$(".detallaGeren").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		detallaGeren += this.value + "/";
	    }
	});
	
	$(".detallaProd").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		detallaProd += this.value + "/";
	    }
	});
	
	$(".detallaImp").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		detallaImp += this.value + "/";
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Seleccione al menos una opción de diseño.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	
	
	corte = true;
	$(".reunion").each(function( index ){
	  
	    if (this.checked == true) {
		corte = false;
		reunion = this.value;
	    }
	});
	
	if (corte == true) {
	    $('#error_polimero').html('<strong>Seleccione si requiere o no reunión.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	
	if ($("#obs_poli").val() == "") {
	    $('#error_polimero').html('<strong>Ingrese un detalle válido.</strong>');
	    $('#modal_error').modal('show');
	    $('#btn_rehacer_disi').removeAttr('disabled');
	    $('#btn_rehacer_devolver').removeAttr('disabled');
	    $('#btn_rehacer_update').removeAttr('disabled');
	    return;
	}
	else{ observaciones = $("#obs_poli").val(); }
	
	var data_ajax={
                        type: 'POST',
                        url: "insertPolimero.php",
                        data: {
				xidProveedor	: idProveedor,
				xLineatura	: Lineatura,
				xcalidad	: calidad,
				xpoliMedidas	: poliMedidas,
				xpoliColores	: poliColores,
				xpistas		: pistas,
				xcilindro	: cilindro,
				xcamisa		: camisa,
				xanchoSugerido	: anchoSugerido,
				xAVT		: AVT,
				xdiseno		: diseno,
				xestadoPolPlanta: estadoPolPlanta,
				xreponer	: reponer,
				xmuestra	: muestra,
				xfechaEnt	: fechaEnt,
				xpresupuesto	: presupuesto,
				xdisenoBase	: disenoBase,
				xdetallaVend	: detallaVend,
				xdetallaClien	: detallaClien,
				xdetallaGeren	: detallaGeren,
				xdetallaProd	: detallaProd,
				xdetallaImp	: detallaImp,
				xreunion	: reunion,
				xobservaciones	: observaciones,
				xtrabajo 	: $("#poli_produ").html(),
				xidPedido	: $('#idPed').val(),
				xmaquina	: $("#maquina").val(),
				xespesor	: $("#espesor").val(),
				xactionPoli 	: $('#actionPoli').val(),
				xidPolimero	: $('#id_polimero_new').val(),
				xsentido	: sentido,
				xbarra		: barra,
				xcodeBar	: $("#codeBar").val()
			      },
                        success: function( data ) {
					$("#modal_disenio").modal('hide');
					$('#btn_rehacer_disi').removeAttr('disabled');
					$('#btn_rehacer_devolver').removeAttr('disabled');
					$('#btn_rehacer_update').removeAttr('disabled');
					
					if ($('#actionPoli').val() != 'CR') {
					    location.reload();
					}
					else
					{
					    alert("Se genero la Orden de Trabajo Número: " + data);
					    location.reload();
					}
					
                                },
                        error: function(){
                                            alert("Error de conexión.");
					    $('#btn_rehacer_disi').removeAttr('disabled');
					    $('#btn_rehacer_devolver').removeAttr('disabled');
					    $('#btn_rehacer_update').removeAttr('disabled');
                                          },
                        dataType: 'json'
                        };
		
		$.ajax(data_ajax);
    
}

$(".diseno").change(function (){
    $(".diseno").each(function( index ){
	if (this.checked) {
	    if(this.value == 1)
	    {
		 $(".estadoPolPlanta").each(function( index ){
		    this.disabled = true;
		 });
		 $(".muestra").each(function( index ){
		    this.disabled = true;
		 });
		 $('#reponer').attr('disabled', 'disabled');
	    }
	    else
	    {
		$(".estadoPolPlanta").each(function( index ){
		    this.disabled = false;
		 });
		$(".muestra").each(function( index ){
		    this.disabled = false;
		 });
		$('#reponer').removeAttr('disabled');
	    }
	}
    });
});

$(".barra").change(function (){
    $(".barra").each(function( index ){
	if (this.checked) {
	    if(this.value == 1)
	    {
		$('#codeBar').val('');
		$('#codeBar').removeAttr('disabled');
	    }
	    else
	    {
		$('#codeBar').val('');
		$('#codeBar').attr('disabled', 'disabled');
	    }
	}
    });
});

function ooopenObsr() {
    $("#iptObservPolll").html('');
    var text = $("#iconDetailPolimero").attr('title');
    $("#iptObservPolll").html(text);
    $("#modal_entregas_observacion_polimero").modal('show');
}

function AbrirDisenioById(id, code, cli, prod, action)
{
    $('#actionPoli').val(action);
    $('#error_msj_dis').html("");
    $('#error_div_dis').css('display','none');
    
    $('#btn_rehacer_disi').attr('disabled', 'disabled');
    $('#idPed').val(id);
    
    $('#poli_code').html(code);
    $('#poli_cliente').html(cli);
    $('#poli_produ').html(prod);
    Limpiar();
    $("#modal_disenio").modal('show');
    
    var data_ajax={
                        type: 'POST',
                        url: "getPolimero.php",
                        data: { ntpId : id },
                        success: function( data ) {
					$("#poliColores").val(data[0]['colores']);
					$("#poliMedidas").val(data[0]['medidas']);
					$("#Lineatura").val(data[0]['lineatura']);
					$("#espesor").val(data[0]['idEspesor']);
					$("#pistas").val(data[0]['pistas']);
					$("#maquina").val(data[0]['idMaquina']);
					$("#cilindro").val(data[0]['cilindro']);
					$("#camisa").val(data[0]['camisa']);
					$("#anchoSugerido").val(data[0]['anchoSugerido']);
					$("#idProveedor").val(data[0]['id_proveedor']);
					$("#Proveedor").val(data[0]['proveedorName']);
					$("#id_polimero_new").val(data[0]['id_polimero']);
					//AVT
					var array = data[0]['AVT'].split("/");
					array.forEach(function(entry) {
					    if (entry != "") {
						var id = "#AVT_"+entry;
						$(id).attr('checked','checked');
					    }
					});
					
					$(".sentido").each(function( index ){
					    if (this.value == data[0]['sentido']) {
						this.checked = true;
					    }
					});
					
					$(".barra").each(function( index ){
					    if (this.value == data[0]['barra']) {
						this.checked = true;
						if (this.value == 1) {
						    $("#codeBar").val(data[0]['barcode']);
						    $('#codeBar').removeAttr('disabled');
						}
						else
						{
						    $('#codeBar').val('');
						    $('#codeBar').attr('disabled', 'disabled');
						}
					    }
					});
					
					$(".diseno").each(function( index ){
					    if (this.value == data[0]['disenio']) {
						this.checked = true;
						if (data[0]['disenio'] == 1) {
						    $(".estadoPolPlanta").each(function( index ){
							this.disabled = true;
						     });
						     $(".muestra").each(function( index ){
							this.disabled = true;
						     });
						     $('#reponer').attr('disabled', 'disabled');
						}
						else
						{
						    $(".estadoPolPlanta").each(function( index ){
							this.disabled = false;
						     });
						    $(".muestra").each(function( index ){
							this.disabled = false;
						     });
						    $('#reponer').removeAttr('disabled');
						}
					    }
					});
					$(".estadoPolPlanta").each(function( index ){
					    if (this.value == data[0]['estadoPolPlanta']) {
						this.checked = true;
					    }
					});
					$("#reponer").val(data[0]['reponer']);
					$(".muestra").each(function( index ){
					    if (this.value == data[0]['muestra']) {
						this.checked = true;
					    }
					});
					$("#fechaEnt").val(data[0]['fechaEnt']);
					$("#presupuestoAprox").val(data[0]['presupuesto']);
					$(".reunion").each(function( index ){
					    if (this.value == data[0]['reunion']) {
						this.checked = true;
					    }
					});
					var a = data[0]['calidades'];
					var item = "";
					a.forEach(function( index ) {
						item += "<input type=\"checkbox\" value=\"" + index['id'] + "\" class=\"calidad\"" + index['checked'] + " style=\"margin-top: -1px;\">"+ index['name'];
					});
					if (item == "") {
					    $("#calidadesDiv").html("<p style=\"font-color: red;\">No hay tipos asociados al proveedor.</p>");
					}
					else
					{
					    $("#calidadesDiv").html(item);
					}
					
					$.each(data[0]['disenioBase'].split("/"), function( index, value ) {
					    if (value != "") {
						$(".disenoBase").each(function( item ){
						    if (this.value == value) {
							this.checked = true;
						    }
						});
					    }
					});
					
					$.each(data[0]['detallaVend'].split("/"), function( index, value ) {
					    if (value != "") {
						$(".detallaVend").each(function( item ){
						    if (this.value == value) {
							this.checked = true;
						    }
						});
					    }
					});
					
					$.each(data[0]['detallaClien'].split("/"), function( index, value ) {
					    if (value != "") {
						$(".detallaClien").each(function( item ){
						    if (this.value == value) {
							this.checked = true;
						    }
						});
					    }
					});
					
					$.each(data[0]['detallaGeren'].split("/"), function( index, value ) {
					    if (value != "") {
						$(".detallaGeren").each(function( item ){
						    if (this.value == value) {
							this.checked = true;
						    }
						});
					    }
					});
					
					$.each(data[0]['detallaProd'].split("/"), function( index, value ) {
					    if (value != "") {
						$(".detallaProd").each(function( item ){
						    if (this.value == value) {
							this.checked = true;
						    }
						});
					    }
					});
					
					$.each(data[0]['detallaImp'].split("/"), function( index, value ) {
					    if (value != "") {
						$(".detallaImp").each(function( item ){
						    if (this.value == value) {
							this.checked = true;
						    }
						});
					    }
					});
					
					$("#obs_poli").val(data[0]['observacion']);
					
					$('#btn_rehacer_disi').removeAttr('disabled');
                                },
                        error: function(){
                                            alert("Error de conexión.");
					    $('#btn_rehacer_disi').removeAttr('disabled');
                                          },
                        dataType: 'json'
                        };
		
		$.ajax(data_ajax);
}

function Limpiar() {
    //Proveedor
    $("#idProveedor").val("");
    $("#Proveedor").val("");
    $("#Lineatura").val("");
    $("#espesor").val("");
    $("#calidadesDiv").html("");
    
    //Medidas
    $("#poliMedidas").val("");
    $("#poliColores").val("");
    $("#pistas").val("");
    $("#maquina").val("");
    $("#cilindro").val("");
    $("#camisa").val("");
    $("#anchoSugerido").val("");
    $(".AVT").each(function( index ){ this.checked = false; });
    $(".sentido").each(function( index ){ this.checked = false; });
    $(".barra").each(function( index ){ this.checked = false; });
    $("#codeBar").val("");
    
    //Diseño en base
    $(".disenoBase").each(function( item ){ this.checked = false; });
    $(".detallaVend").each(function( item ){ this.checked = false; });
    $(".detallaClien").each(function( item ){ this.checked = false; });
    $(".detallaGeren").each(function( item ){ this.checked = false; });
    $(".detallaProd").each(function( item ){ this.checked = false; });
    $(".detallaImp").each(function( item ){ this.checked = false; });
    
    //Reunion
    $(".reunion").each(function( index ){ this.checked = false; });
    
    //Observacion
    $("#obs_poli").val("");
    
    //Diseño
    $(".diseno").each(function( index ){ this.checked = false; });
    $(".estadoPolPlanta").each(function( index ){ this.checked = false; });
    $("#reponer").val("");
    $(".muestra").each(function( index ){ this.checked = false; });
    $("#fechaEnt").val("");
    $("#presupuestoAprox").val("");
    
    //Btn Aceptar
    $('#btn_rehacer_disi').removeAttr('disabled');
    $('#btn_rehacer_update').hide();
    $('#btn_rehacer_devolver').hide();
    $('#btn_rehacer_disi').show();
}

function ImprimirPolimero(sql){
    //impresion individual
    window.open("impresionComprobantes.php?documento=6&id="+sql, "PopUp", "menubar=1,width=1000,height=900");
}
var GlobalIdPedido;
function EditHRCI(xid)
{
    $('#tableEditHRCI tbody').html('');
    GlobalIdPedido = xid;
    var data_ajax={
		  type: 'POST',
		  url: "gethrci.php",
		  data: { id: xid},
		  success: function( data ) {
				   $.each(data, function(k,v)
				    {
					var fila = "<tr id=\""+v.value+"\"><td>"+v.value+"</td>";
					fila += "<td style=\"text-align: right;\"><input style=\"margin-right:100px;\" type=\"button\" value=\"X\" class=\"btn btn-danger\" onclick=\"removerFila('"+v.value+"')\"></td></tr>";
					$('#tableEditHRCI > tbody:last').append(fila);
				    });
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	  $.ajax(data_ajax);
    
    $("#modal_edithrci").modal('show');
    
}

function removerFila(id)
{
    $("#"+id+"").remove();
}

function addValueHRCI()
{
    if ($("#numHRCI").val()!= "") {
	var v = $("#numHRCI").val();
	var fila = "<tr id=\""+v+"\"><td>"+v+"</td>";
	fila += "<td style=\"text-align: right;\"><input style=\"margin-right:100px;\" type=\"button\" value=\"X\" class=\"btn btn-danger\" onclick=\"removerFila('"+v+"')\"></td></tr>";
	$('#tableEditHRCI > tbody:last').append(fila);
	$("#numHRCI").val('');
    }
}

function SaveEditHRCI()
{
    var hojas = "";
     $("#tableEditHRCI tbody tr").each(function (index) {
	hojas += $(this)[0].id+"-";
     });
     
     var data_ajax={
		  type: 'POST',
		  url: "setEdithrci.php",
		  data: { id: GlobalIdPedido, val: hojas},
		  success: function( data ) {
				 $("#modal_edithrci").modal('hide');  
			  },
		  error: function(){
				      alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
    $.ajax(data_ajax);
}

function openLog(idPolimero, idPedido, trabajo, npdido, cliente)
    {
	var texto = "Seguimiento de Polímero <br> Número: " + (idPedido == "" ? "----" : idPedido)+"";
	var detalle = "<b>Trabajo:</b>" + trabajo + "<br> <b>Nota de Pedido referencia: </b>" + npdido + "<br><b>Cliente:</b>" + cliente;
	
	$("#titlePolimeroLog").html(texto);
	$("#detailPolimero").html(detalle);
	$("#logpolimeros").html('');
	$("#modal_polimero_log").modal('show');
	
	var tabla = '<table style="width: 100%; font-size: 10px;">';
	
	var data_ajax={
		type: 'POST',
		url: "getLogPolimero.php",
		data: {
			xId : idPolimero
		      },
		success: function( data ) {
			    var status = "";
			    var yaPaso = false;
			    $(data).each(function( index ){
				if (yaPaso == false) {
				    if (this['polimeroEstado'] != "Z" &&
					this['polimeroEstado'] != "X" &&
					this['polimeroEstado'] != "M" &&
					this['polimeroEstado'] != "Q") {
					status = this['polimeroEstado'];
					yaPaso = true;
				    }
				}
				tabla += '<tr><td><b>Estado:</b>';
				tabla += (this['observacion'] == "Autorización de Facturación") ? getEstatus("XX") : getEstatus(this['polimeroEstado']);
				tabla += '<br><b>Fecha:</b>'
				tabla += formatDate(this['logFecha']);
				tabla += '<br><b>Usuario:</b>'+this['nombre']+'</td>';
				tabla += '</td><td>'+(this['observacion'] == null ? '-' : this['observacion'])+'</td></tr>';
				tabla += '<tr><td colspan="2"><hr></td></tr>';
				//alert(this);
			    });
			    tabla += '</table>';
			    $("#logpolimeros").html(tabla);
			    setStatusBar(status);
			},
		error: function(){
				    $("#logpolimeros").html('Error de conexión.');
				  },
		dataType: 'json'
		};
	
	$.ajax(data_ajax);
	
	//var data_ajax2={
	//	type: 'POST',
	//	url: "getCliente.php",
	//	data: {
	//		xId : idPolimero
	//	      },
	//	success: function( data ) {
	//		    var status = "";
	//		    var yaPaso = false;
	//		    $(data).each(function( index ){
	//			if (yaPaso == false) {
	//			    if (this['polimeroEstado'] != "Z" &&
	//				this['polimeroEstado'] != "X" &&
	//				this['polimeroEstado'] != "M" &&
	//				this['polimeroEstado'] != "Q") {
	//				status = this['polimeroEstado'];
	//				yaPaso = true;
	//			    }
	//			}
	//			tabla += '<tr><td><b>Estado:</b>';
	//			tabla += (this['observacion'] == "Autorización de Facturación") ? getEstatus("XX") : getEstatus(this['polimeroEstado']);
	//			tabla += '<br><b>Fecha:</b>'
	//			tabla += formatDate(this['logFecha']);
	//			tabla += '<br><b>Usuario:</b>'+this['nombre']+'</td>';
	//			tabla += '</td><td>'+(this['observacion'] == null ? '-' : this['observacion'])+'</td></tr>';
	//			tabla += '<tr><td colspan="2"><hr></td></tr>';
	//			//alert(this);
	//		    });
	//		    tabla += '</table>';
	//		    $("#logpolimeros").html(tabla);
	//		    setStatusBar(status);
	//		},
	//	error: function(){
	//			    $("#logpolimeros").html('Error de conexión.');
	//			  },
	//	dataType: 'json'
	//	};
	//
	//$.ajax(data_ajax2);
    }
    
function formatDate(date)
{
    var dates = date.split(" ");
    
    var day = dates[0].split("-");
    
    return day[2]+"-"+day[1]+"-"+day[0]+" "+dates[1];
}

function getEstatus(code) {
    switch (code) {
	case "TP":
	    return "Enviado a Aprob. de Borradores";
	    break;
	case "AP":
	    return "Borrado Aprobado";
	    break;
	case "A":
	    return "Preprensa empaque";
	    break;
	case "C":
	    return "Borradores en producción";
	    break;
	case "E":
	    return "Borradores ap. a preprensa";
	    break;
	case "G":
	    return "Preprensa en proveedor";
	    break;
	case "H":
	    return "Confección de polímero";
	    break;
	case "I":
	    return "Polímero en calidad";
	    break;
	case "K":
	    return "Producción / impresión";
	    break;
	case "N":
	    return "Corrección (Prod./Imp.)";
	    break;
	case "F":
	    return "Corrección (Borr. en Prod.)";
	    break;
	case "J":
	    return "Corrección (Conf. de Pol.)";
	    break;
	case "L":
	    return "Rehacer (Pol. en Calidad)";
	    break;
	case "Z":
	    return "Polímero en StandBy";
	    break;
	case "X":
	    return "Polímero Reactivado (" + code + ")";
	    break;
	case "M":
	    return "Polímero Archivado";
	    break;
	case "Q":
	    return "Autorización Fact. Polímeros";
	    break;
	case "XX":
	    return "Facturación Autorizada";
	    break;
	case "MO":
	case "RV":
	    return "Borrador Correjido";
	    break;
	//--------------------------
	case "DI":
	    return "Ingreso en Preprensa";
	    break;
	case "CL":
	    return "Enviado aprob. de Cliente";
	    break;
	case "AC":
	    return "Aprobado por el Cliente";
	    break;
	case "NA":
	    return "NO Aprobado por el Cliente";
	    break;
	case "CR":
	    return "Generar Polímero";
	    break;
	case "RN":
	    return "Rehacer Pedido";
	    break;
	case "NO":
	    return "Borrador Rechazado";
	    break;
	//---------------------------
	default:
	    return "Op. no definida. ("+code+")";
    }
}
function setStatusBar(code)
{
    $("#status1").removeClass('label-warning');
    $("#status2").removeClass('label-warning');
    $("#status3").removeClass('label-warning');
    $("#status4").removeClass('label-warning');
    $("#status5").removeClass('label-warning');
    $("#status6").removeClass('label-warning');
    $("#status7").removeClass('label-warning');
    $("#status8").removeClass('label-warning');
    $("#status9").removeClass('label-warning');
    $("#status10").removeClass('label-warning');
    
    $("#status1").removeClass('label-success');
    $("#status2").removeClass('label-success');
    $("#status3").removeClass('label-success');
    $("#status4").removeClass('label-success');
    $("#status5").removeClass('label-success');
    $("#status6").removeClass('label-success');
    $("#status7").removeClass('label-success');
    $("#status8").removeClass('label-success');
    $("#status9").removeClass('label-success');
    $("#status10").removeClass('label-warning');
    
    switch (code) {
	case "N":
	
	case "DI":
	case "NA":
	    $("#status1").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Ingreso en Preprensa.");
	    break;
	case "C":
	    
	case "CL":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Enviado aprob. de Cliente.");
	    break;
	case "E":
	case "AC":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Aprobado por el Cliente.");
	    break;
	case "J":
	case "L":
	    
	case "RV":
	case "TP":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Enviado aprob. de Borradores.");
	    break;
	    
	case "CR":
	case "AP":
	case "MO":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Borrador Aprobado.");
	    break;
	    
	case "A":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Preprensa Empaque.");
	    break;
	    
	case "G":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Preprensa en Proveedor.");
	    break;
	
	case "H":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-warning');
	    $("#status8").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Confección de Polímeros.");
	    break;
	
	case "I":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-warning');
	    $("#status8").addClass('label-warning');
	    $("#status9").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Polímero en Calidad.");
	    break;
	
	case "K":
	    $("#status1").addClass('label-warning');
	    $("#status2").addClass('label-warning');
	    $("#status3").addClass('label-warning');
	    $("#status4").addClass('label-warning');
	    $("#status5").addClass('label-warning');
	    $("#status6").addClass('label-warning');
	    $("#status7").addClass('label-warning');
	    $("#status8").addClass('label-warning');
	    $("#status9").addClass('label-warning');
	    $("#status10").addClass('label-success');
	    $("#estadoActual").html("<strong>Estado Actual:</strong> Producción/Impresión.");
	    break;
	
	default:
	    $("#estadoActual").html("<strong>Estado Actual:</strong> -.");
    }
}

var reactivar = 0;
function ReactivarPedido(id) {
    reactivar = id;
    $("#modal_reactivar").modal('show');
}

function reactivarP() {
    var data_ajax={
		  type: 'POST',
		  url: "insertPedido.php",
		  data: {
			    id: reactivar,
			    action: 'RA'
			},
		  success: function( data ) {
				   $("#modal_reactivar").modal('hide');
				    location.reload();
			  },
		  error: function(){
				    alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	$.ajax(data_ajax);
}

var contraEntrega = 0;
function ContraEntrega(id) {
    contraEntrega = id;
    $("#modal_contraEntrega").modal('show');
}

function reactivarP_ce(){
    var data_ajax={
		  type: 'POST',
		  url: "insertPedido.php",
		  data: {
			    id: contraEntrega,
			    action: 'CE',
			    kg: $("#ce_tbkg").val(),
			    unidad: $("#ce_tbcantidad").val(),
			    bulto: $("#ce_tbbulto").val()
			},
		  success: function( data ) {
				   $("#modal_reactivar").modal('hide');
				    location.reload();
			  },
		  error: function(){
				    alert("Error de conexión.");
				    },
		  dataType: 'json'
		  };
	  
	$.ajax(data_ajax);
}


$(function(){
	console.log("LISTADO DE PEDIDOS ");

	var listadoPedidos_table=$("#listadoPedidos_table");
	$("#listadoPedidos_table").DataTable({
		 pageLength: 25,
		 "language": {
            "lengthMenu": "Ver _MENU_ filas por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrando de un total de _MAX_ registros)",
            "sSearch": "Buscar:  ",
            "oPaginate": {
                "sFirst":'Primera',
                "sLast":'Ultima',
                "sNext": "Sig.",
                "sPrevious": "Ant."
            }
        },
	});

	$("#listado_todos").DataTable({
		'pageLength': 25,
		'responsive': true,
		'processing': true,
		'serverSide': true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"language": {
            "lengthMenu": "Ver _MENU_ filas por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrando de un total de _MAX_ registros)",
            "sSearch": "Buscar:  ",
            "oPaginate": {
                "sFirst":'Primera',
                "sLast":'Ultima',
                "sNext": "Sig.",
                "sPrevious": "Ant."
            }
        },
		"pagingType": "full_numbers",
		 "columnDefs": [    
			{  className: "fcol", "targets": 0 } ,
			{  className: "lcol", "targets": 3 }  
		],
		ajax: {
            'dataType': 'json',
              "type": "POST",
            'url': 'services/ListadoPedidos.php',
			'data':{
				'accion':'TO',
			},
            'dataSrc': function(response) {
				console.log("=====> RESPONSE: %o",response);
				var Data_rows=[];
				$.each(response.data, function(index, item) {
					console.log("===> PEDIDO ITEM: %o",item);
					var t1=t2=t3=t4='';
					t1='<a onClick="Seguimiento(\''+item.npedido+'\', \''+item.codigo+'\')" style="cursor: pointer;">'+item.codigo+'</a>';;
					t2=item.clienteNombre;
					t3=item.Articulo;
					t4='<td style="text-align: center;" width="50px;"><img src="assest/plugins/buttons/icons/zoom.png" onClick="ImprimirReporte(\''+item.npedido+'\')" style="cursor: pointer;" ></td>';
					Data_rows.push([t1,t2,t3,t4]);
				});
				return Data_rows;
			},
            error: function(error) {
                console.log(error);
            }
		}
	});
});

</script>

<!-- Modal para reactivar pedido-->
<div class="modal hide fade" id="modal_reactivar">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><center>Reactivar Pedido</center></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" style="text-align: center;">
	    <strong>
	    ¿Esta seguro de reactivar el pedido seleccionado?
	    </strong>
	  </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" onclick="ClosePop('modal_reactivar')">Cancelar</a>
    <a href="#" class="btn btn-success" id="btn_reactivar" onclick="reactivarP()">Aceptar</a>
  </div>
</div>
<!-- ----------->

<!-- Modal para cargar contra-log-->
<div class="modal hide fade" id="modal_contraEntrega">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><center>Cargar Contra Entrega <b style="color:red">(-)</b></center></h3>
  </div>
  <div class="modal-body">
    <p>
      <div style="width: 100%;">
	  <div class="alert alert-error" style="text-align: justify;">
	    <strong>
	    Esta cargando una contraentrega para este pedido. Los valores ingresados se restaran a las entregas realizadas hasta el momento.
	    </strong>
	  </div>
	  <table style="width: 100%">
	    <tr>
		<td><b>Kilogramos</b></td>
		<td><input type="text" class="input-medium" id="ce_tbkg" placeholder="Kilogramos" onkeyup="decimal(ce_tbkg)"></td>
	    </tr>
	    <tr>
		<td><b>Unid./Cant.</b></td>
		<td><input type="text" class="input-medium" id="ce_tbcantidad" placeholder="Cantidad" onkeyup="decimal(ce_tbcantidad)"></td>
	    </tr>
	    <tr>
		<td><b>Bultos/Bob.</b></td>
		<td><input type="text" class="input-medium" id="ce_tbbulto" placeholder="Bultos" onkeyup="numerico(tbbulto)"></td>
	    </tr>
	  </table>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-danger" onclick="ClosePop('modal_contraEntrega')">Cancelar</a>
    <a href="#" class="btn btn-success" id="btn_reactivar" onclick="reactivarP_ce()">Aceptar</a>
  </div>
</div>
<!-- ----------->

<style>
    .bordeDiv{
	padding: 15px;
	border: 1px solid #d0d0d0;
	border-radius: 5px;
	padding-bottom: 5px;
    }
</style>