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
                                Configuración de Formato - Campos
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><strong>Formato</strong></th>
                                <th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM formatos Order by descripcion";
                                
                                $resu = mysql_query($sql);
				echo "<tbody>";
                                if(mysql_num_rows($resu) <= 0)
                                    {
                                     echo '<tr><td colspan="2" style="text-align: center;">No se encontraron resultados.</td></tr>';
                                    }
                                    else
                                    {
                                       while($row = mysql_fetch_array($resu))
                                       {
                                            echo "<tr>";
                                            
                                            echo "<td>".htmlentities($row['descripcion'])."</td>";
                                            echo "<td onClick=\"EditarFormato('".$row['idFormato']."', '".htmlentities($row['descripcion'])."')\" style=\"text-align: center;\">";
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
          <table style="width: 90%; alignment-adjust: central;">
            <tr>
                <td style="width: 30%"><input type="checkbox" id="ancho" name="ancho"><label>Ancho</label></td>
                <td style="width: 30%"><input type="checkbox" id="largo" name="largo"><label>Largo</label></td>
                <td style="width: 30%"><input type="checkbox" id="micronaje" name="micronaje"><label>Micronaje</label></td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
                <td style="width: 30%"><input type="checkbox" id="fuelle" name="fuelle"><label>Fuelle</label></td>
                <td style="width: 30%"><input type="checkbox" id="termo" name="termo"><label>Termo</label></td>
                <td style="width: 30%"><input type="checkbox" id="micro" name="micro"><label>Microp</label></td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
                <!--<td style="width: 30%"><input type="checkbox" id="precioPoli" name="precioPoli"><label>Precio Polimero</label></td>-->
		        <td style="width: 30%"><input type="checkbox" id="origen" name="origen"><label>Origen</label></td>
                <td style="width: 30%"><input type="checkbox" id="solapa" name="solapa"><label>Solapa</label></td>
                <td style="width: 30%"><input type="checkbox" id="troquelado" name="troquelado"><label>Troquelado</label></td>
            </tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
          </table>
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
    function EditarFormato(id, value)
    {
        $('#btnAceptar').removeAttr('disabled');
        var title = "Campos para " + value;
        $('#headerId').html(title);
        $('#modalFC').modal('show');
        $('#idFormat').val(id);
        
        var input = [];
        input.push(id);
         
        var chequeados = [];
        
        var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoFCampos.php",
                        data: { xinput: input },
                        success: function( data ) {
                                                    if(data != 0)
                                                    {
                                                        $.each(data, function(k,v)
									{
									    //Datos de cada usuario
									    $.each(v, function(i,j)
										       {
											if(i == "cmpId")
											    {
                                                                                                //id de campo chequeado
												chequeados.push(j);
											    }
										       }
										      );
									}
								       );
							//Sacar todo los check de los permisos
                                                        $("input[type=checkbox]").each(function()
                                                                 {
                                                                    $(this).removeAttr('checked');
                                                                 }
                                                                 );
                                                        
                                                        //chequear campos seleccionados
                                                        for(var i = 0; i < chequeados.length; i++)
                                                        {
                                                            var cId = '#'+chequeados[i];
                                                            $(cId).attr("checked", "checked");
                                                        }
                                                    }
                                                    else
                                                    {
                                                        //Sacar todo los check de los permisos
                                                        $("input[type=checkbox]").each(function()
                                                                 {
                                                                    $(this).removeAttr('checked');
                                                                 }
                                                                 );
                                                    }
                                                  },
                        error: function(){
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
        $.ajax(data_ajax);
    }
    
    function inicio()
    {
	location.href="principal.php";
    }
    
    $('#btnClose').click(function(){
	    $('#modalFC').modal('hide');			
	});
    
    $('#btnAceptar').click(function(){
            
            $('#btnAceptar').attr("disabled", "disabled");
            var input = [];
                        
	    //recolectar todos los campos seleccionados
            $("input[type=checkbox]").each(function()
                     {
                        if($(this).attr('checked') == 'checked')
                        {
                          input.push($(this).attr('id'));
                        }
                     }
                     );
            var id = $('#idFormat').val();
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoFCphp.php",
                        data: { xinput: input,  xid: id},
                        success: function( data ) {
                                                    if(data != 0)
                                                    {
                                                        alert("Ocurrio un error");
                                                    }
                                                    else
                                                    {
                                                        $('#modalFC').modal('hide');
                                                    }
                                                  },
                        error: function(){
                                            $('#btnAceptar').removeAttr('disabled');
                                            alert("Error de conexión.");
                                          },
                        dataType: 'json'
                        };
            $.ajax(data_ajax);
	});
</script>