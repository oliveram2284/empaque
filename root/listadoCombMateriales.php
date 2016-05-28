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

?>
<br>
    <div class="container">
    <center>
	<div id="menu" class="well">
	
	    <div class="row">
		<div class="span6 offset2">
			  <div class="page-header">
			  <h2>
                                Combinación de Materiales
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" value="&nbsp;Nuevo&nbsp;" class="btn btn-success" onClick="nuevo()">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><strong>Material 1</strong></th>
								<th style="text-align: center;"><strong>Material 2</strong></th>
								<th style="text-align: center;"><strong>Habilitación</strong></th>
                                <th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = 'SELECT 
							*,
							(Select m.descripcion from Materiales as m Where m.idMaterial = idMaterial1) as desc1,
							(Select m.descripcion from Materiales as m Where m.idMaterial = idMaterial2) as desc2
						FROM 
							materialescombo ';
                                
                                $resu = mysql_query($sql);
					echo "<tbody>";
                                if(mysql_num_rows($resu) <= 0)
                                    {
                                     echo '<tr><td colspan="4" style="text-align: center;">No se encontraron resultados.</td></tr>';
                                    }
                                    else
                                    {
                                       while($row = mysql_fetch_array($resu))
                                       {
                                            echo "<tr>";
                                            
                                            echo "<td>".$row['desc1']."</td>";
					    					echo "<td>".$row['desc2']."</td>";
					    					echo "<td style=\"text-align: center;\">". ($row['habilitacion'] == null ? "-": $row['habilitacion'])."</td>";
                                            echo '<td onClick="EditarFormato('.$row['idMaterial'].', '.$row['idMaterial1'].', '.$row['idMaterial2'].', \''.($row['habilitacion'] == null ? "": $row['habilitacion']).'\')" style="text-align: center;">';
                                            echo "<img src=\"./assest/plugins/buttons/icons/pencil.png\" width='20' heigth='20' title=\"Editar\" style=\"cursor:pointer\"/>";
                                            echo '</td>';
                                                                                            
                                            echo "</tr>";
                                       }
                                    }
                	echo "</tbody>";
			    ?>
                    </table>
                    
		</div>
	    </div>
	</div>    
    </center>
    </div>
    <input type="hidden" id="idFormat" value="">
	
    <!---------------------------------------------------->
    <div class="modal hide fade" id="modalFC">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 id="headerId"></h3>
        </div>
        <div class="modal-body">
	    <div class="form-horizontal">
		<div class="alert alert-error" id="box_error" style="display: none">
		    <strong id="msj_box_error"></strong>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputMat1">Material 1</label>
		    <div class="controls">
			<select id="inputMat1">
				<?php
					$sql = 'SELECT * FROM materiales ORDER BY descripcion ASC';
                                
                    $resu = mysql_query($sql);
                    if(mysql_num_rows($resu) <= 0)
                        {
                         echo '<option value="-1">No hay opciones</option>';
                        }
                        else
                        {
                        	echo '<option value="-1">Opciones</option>';
                           while($row = mysql_fetch_array($resu))
                           {
                                echo '<option value="'.$row['idMaterial'].'">'.$row['descripcion'].'</option>';
                           }
                        }
				?>
			</select>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="inputMat2">Material 2</label>
		    <div class="controls">
			<select id="inputMat2">
				<?php
					$sql = 'SELECT * FROM materiales ORDER BY descripcion ASC';
                                
                    $resu = mysql_query($sql);
                    if(mysql_num_rows($resu) <= 0)
                        {
                         echo '<option value="-1">No hay opciones</option>';
                        }
                        else
                        {
                           echo '<option value="-1">Opciones</option>';
                           while($row = mysql_fetch_array($resu))
                           {
                                echo '<option value="'.$row['idMaterial'].'">'.$row['descripcion'].'</option>';
                           }
                        }
				?>
			</select>
		    </div>
		</div>
	    <div class="control-group">
		    <label class="control-label" for="inputHabi">Habilitación</label>
		    <div class="controls">
			<input type="text" id="inputHabi" placeholder="Habilitación">
		    </div>
		</div>

	    </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" id="btnClose">Cerrar</a>
          <a href="#" class="btn btn-primary" id="btnAceptar">Guardar</a>
        </div>
    </div>
    <!---------------------------------------------------->

<?php

require("footer.php");

?>
<script>
    function EditarFormato(id, mat1, mat2, habi)
    {
	Limpiar();
    $('#btnAceptar').removeAttr('disabled');
    var title = "Editar combinación";
    $('#headerId').html(title);
    $('#idFormat').val(id);
	$('#inputMat1').val(mat1);
	$('#inputMat2').val(mat2);
	$('#inputHabi').val(habi);
	$('#modalFC').modal('show');
    }
    
    function inicio()
    {
	location.href="principal.php";
    }
    
    $('#btnClose').click(function(){
	    $('#modalFC').modal('hide');			
	});
    
    function validar()
    {
	$('#box_error').hide();
	$('#msj_box_error').html("");
		    
	if($('#inputMat1').val() == "-1" || $('#inputMat2').val() == "-1")
	{
	    $('#msj_box_error').html("Ingrese una combinación válida.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	if($('#inputHabi').val() == "")
	{
	    $('#msj_box_error').html("Ingrese el código de habilitación.");
	    $('#box_error').show();
	    $('#btnAceptar').removeAttr('disabled');
	    return false;
	}
	
	return true;
		
    }
    
    $('#btnAceptar').click(function(){
            
            $('#btnAceptar').attr("disabled", "disabled");
	    if(validar() == true)
	    {
		var input = [];
	    
	    input.push($('#idFormat').val());
	    input.push($('#inputMat1').val());
	    input.push($('#inputMat2').val());
	    input.push($('#inputHabi').val());
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoCombMaterialesphp.php",
                        data: { xinput: input},
                        success: function( data ) {
                                                    if(data != 0)
                                                    {
							$('#box_error').show();
							$('#msj_box_error').html("Ocurrio un error.");
                                                    }
                                                    else
                                                    {
							Limpiar();
							$('#btnAceptar').removeAttr('disabled');
                                                        $('#modalFC').modal('hide');
							location.reload();
                                                    }
                                                  },
                        error: function(){
                                            $('#btnAceptar').removeAttr('disabled');
                                            $('#box_error').show();
					    $('#msj_box_error').html("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
            $.ajax(data_ajax);
	    }
            
	});
    
    function Limpiar()
    {
	$('#idFormat').val('');
	$('#inputMat1').val('-1');
	$('#inputMat2').val('-1');
	$('#inputHabi').val('');
	$('#box_error').hide();
	$('#msj_box_error').html("");
    }
    
    function nuevo()
    {
	Limpiar();
	$('#idEstadistica').val('0');
	var title = "Nuevo Registro";
        $('#headerId').html(title);
	$('#modalFC').modal('show');
    }
</script>