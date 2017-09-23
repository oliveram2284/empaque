<?php  
session_start();
if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}

include ("conexion.php");
require("header.php");


$vari = new conexion();
$vari->conectarse();

// insert row
if(!empty($_POST)){
	if( isset($_POST['id']) && $_POST['id']!=''){
		$sql_update="UPDATE tbl_materiales_formatos_dias SET 
			formato_id='".$_POST['formato_id']."',
			material_id='".$_POST['material_id']."',
			dias_alta='".$_POST['dias_alta']."',
			dias_media='".$_POST['dias_media']."',
			dias_baja='".$_POST['dias_baja']."'			
			where id=".$_POST['id'].";";

		$resu = mysql_query($sql_update) or die(mysql_error());
		
	}else{
		$sql_insert="INSERT INTO tbl_materiales_formatos_dias (formato_id,material_id,dias_alta,dias_media,dias_baja,created)
		VALUES ('".$_POST['formato_id']."','".$_POST['material_id']."','".$_POST['dias_alta']."','".$_POST['dias_media']."','".$_POST['dias_baja']."',NOW());";
		$resu = mysql_query($sql_insert);
	}

	
	
}



//get Materiales
$sql_material = "SELECT * FROM materiales ORDER BY descripcion asc";                              
$resu = mysql_query($sql_material);
if(mysql_num_rows($resu) <= 0){
	$materiales=array();
}
else{
	 while($row = mysql_fetch_array($resu)){
		$materiales[]=array('id'=>$row['idMaterial'],'name'=>$row['descripcion']);
	}                           
}
//get Formatos

$sql_material = "SELECT * FROM formatos ORDER BY descripcion asc";                              
$resu = mysql_query($sql_material);
if(mysql_num_rows($resu) <= 0){
	$formatos=array();
}
else{
	 while($row = mysql_fetch_array($resu)){
		$formatos[]=array('id'=>$row['idFormato'],'name'=>$row['descripcion']);
	}                           
}

?>
<style>
    .text-center{
        text-align: center !important;
       
    }
    .th_background{
        background-color:red;
    }
</style>
<br>
    <div class="container">
    <center>
	<div id="menu" class="well">
	
	    <div class="row">
		<div class="span6 offset2">
			  <div class="page-header">
			  <h2>Días de Producción de Materiales Y Formatos por Temporada</h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" id="btn_add" value="&nbsp;Nuevo&nbsp;" class="btn btn-success" >
		</div>
        </div>
        <br>
	    <div class="row">
		<div class="span10">
                    
            <table class="table table-bordered table-hover">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Material</th>
                        <th>Formato</th>
                        <th>Días en Termporada Alta</th>
                        <th>Días en Termporada Media</th>
                        <th>Días en Termporada Baja</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>    
                <?php 
                    $sql = "SELECT  *,(SELECT descripcion FROM materiales WHERE idMaterial=material_id ) as 'material',
                    (SELECT descripcion from formatos where idFormato=formato_id  ) as 'formato' 
                    from tbl_materiales_formatos_dias ORDER BY created desc;";                              
                    $resu = mysql_query($sql);				
                        
                        if(mysql_num_rows($resu) <= 0){
                            echo '<tr><td colspan="10" style="text-align: center;">No se encontraron resultados.</td></tr>';
                        }
                        else
                        {
                            while($row = mysql_fetch_array($resu)){
                            ?>
                            <tr class="text-center">
                                <td class="text-center"><?php echo $row['id']?></td>
                                <td class="text-center"><?php echo $row['material']?></td>
                                <td class="text-center"><?php echo $row['formato']?></td>
                                <td class="text-center"><?php echo $row['dias_alta']?></td>
                                <td class="text-center"><?php echo $row['dias_media']?></td>
                                <td class="text-center"><?php echo $row['dias_baja']?></td>
                                
                                <td class="text-center">
                                    <a href="#" class="btn btn-success btn_edit" data-id="<?php echo $row['id']?>">Edit</a> | 
                                    <a href="#" class="btn btn-danger btn_delete" data-id="<?php echo $row['id']?>">Eliminar</a>
                                </td>
                            </tr>
                            <?php
                            
                                   /*
					    echo "<td style='text-align: center;'>";
						echo '<img id="'.$row['idEsta'].'_edit" src="./assest/plugins/buttons/icons/pencil.png" width="15px" heigth="15px" title="Editar" style="cursor:pointer" onClick="Activar_Celdas('.$row['idEsta'].')"/>';
						echo '<img id="'.$row['idEsta'].'_save" src="./assest/plugins/buttons/icons/disk.png" width="15px" heigth="15px" title="Guardar" style="cursor:pointer; display:none;" onClick="Ocultar_Celdas('.$row['idEsta'].')"/>';
						echo '&nbsp;&nbsp;&nbsp;<img id="'.$row['idEsta'].'_cancel" src="./assest/plugins/buttons/icons/cancel.png" width="15px" heigth="15px" title="Cancelar" style="cursor:pointer; display:none;" onClick="Cancel_Celdas('.$row['idEsta'].')"/>';
                                            echo '</td>';
                                                                                            
                                            echo "</tr>";*/
                                       }
                                    }
                                echo "";
                ?>
                </tbody>
            </table>
                    
		</div>
	    </div>
	</div>    
    </center>
    </div>
	<input type="hidden" id="idFormat" value="">
		
    <!---------------------------------------------------->
	<div class="modal hide fade" id="modalDMF">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="headerId"></h3>
        </div>
        <div class="modal-body">
			<form action="" method="POST" id="form_ad" class="form-horizontal">
				<div class="alert alert-error" id="box_error" style="display: none">
					<strong id="msj_box_error"></strong>
				</div>
				
				<<input type="hidden" name="id" id="inputId" value="">
				
				<div class="control-group">
					<label class="control-label" for="inputFormato">Formato</label>
					<div class="controls">
						<select name="formato_id" id="inputFormato" >
							<option value="">Seleccione un Formato</option>
							<?php foreach($formatos as $key=>$item):?>
							<option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
							<?php endforeach;?>
						</select>					
					</div>				
				</div>
				<div class="control-group">
					<label class="control-label" for="inputMaterial">Material</label>
					<div class="controls">
						
						<select name="material_id" id="inputMaterial"  >
							<option value="">Seleccione un Material</option>
							<?php foreach($materiales as $key=>$item):?>
							<option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
							<?php endforeach;?>
						</select>					
					</div>				
				</div>
				<div class="control-group">
					<label class="control-label" for="inputDiasAlta">Días en Temporada Alta</label>
					<div class="controls">
						<input type="number" id="inputDiasAlta" name="dias_alta" placeholder="Días en Temporada Alta">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputDiasMedia">Días en Temporada Media</label>
					<div class="controls">
						<input type="number" id="inputDiasMedia" name="dias_media" placeholder="Días en Temporada Media">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputDiasBaja">Días en Temporada Baja</label>
					<div class="controls">
						<input type="number" id="inputDiasBaja" name="dias_baja" placeholder="Días en Temporada Baja">
					</div>
				</div>		
			</form>
	    
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" id="btnClose">Cerrar</a>
		  <!-- <a href="#" class="btn btn-primary" id="btnAceptar">Guardar</a> -->
		  <button type="submit"  class="btn btn-primary" id="btnAceptar">Guardar</button>
        </div>
    </div>								
<?php

require("footer.php");

?>
<script>
	$(function(){
		$(".btn_edit").on('click',function(){
			var id=$(this).data('id');
			var data_ajax={
				url:'services/DiasMaterialesFormatos.php',
				type:'POST',
				data:{action:1,id:id},
				success:function(data){
					console.debug("Registro: %o",data);
					//alert("hola Mundo");
					$("#modalDMF").find("#inputId").val(id);
					
					$("#modalDMF").find("#inputMaterial option[value='"+data.registro.material_id+"']").attr("selected", "selected");
					$("#modalDMF").find("#inputFormato option[value='"+data.registro.formato_id+"']").attr("selected", "selected");
					$("#modalDMF").find("#inputDiasAlta").val(data.registro.dias_alta);
					$("#modalDMF").find("#inputDiasMedia").val(data.registro.dias_media);
					$("#modalDMF").find("#inputDiasBaja").val(data.registro.dias_baja);
					$("#modalDMF").modal("show");
				},
				error:function(){

				},
				dataType:'json'
				
			};
			$.ajax(data_ajax);
			return false;
		});
		$(".btn_delete").on('click',function(){
			var id=$(this).data("id");
			console.debug("===> btn_delete: %o",id);
			var data_ajax={
				url:'services/DiasMaterialesFormatos.php',
				type:'POST',
				data:{action:4,id:id},
				success:function(data){
					console.debug("Registro: %o",data);
					 location.reload();
				},
				error:function(){

				},
				dataType:'json'
				
			};
			$.ajax(data_ajax);
			return false;
		});

		$("#btn_add").on("click",function(){
			console.debug("===> #btn_add");
			var _modal=$("#modalDMF");
			_modal.find("h3").text("Agregar Dias de Producción por Temporada");
			_modal.modal("show");//show();
			return false;	
		});

		$("#btnAceptar").on('click',function(){
			
			if($("#inputFormato").val()==''){
				alert("Debe Seleccionar un Formato. Vuelva a intentarlos.");
				$("#inputFormato").focus();
				return false;
			}

			if($("#inputMaterial").val()==''){
				alert("Debe Seleccionar un Formato. Vuelva a intentarlos.");
				$("#inputMaterial").focus();
				return false;
			}

			if($("#inputDiasAlta").val()==''){
				alert("Debe Completar el campo Dias en Temporada Alta. Vuelva a intentarlos.");
				$("#inputMaterial").focus();
				return false;
			}

			if($("#inputDiasMedia").val()==''){
				alert("Debe Completar el campo Dias en Temporada Media. Vuelva a intentarlos.");
				$("#inputMaterial").focus();
				return false;
			}
			if($("#inputDiasBaja").val()==''){
				alert("Debe Completar el campo Dias en Temporada Baja. Vuelva a intentarlos.");
				$("#inputMaterial").focus();
				return false;
			}

			$("#form_ad").submit();
			
			
		});
	});
</script>