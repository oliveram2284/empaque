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
                                Configuración de Temporada
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" value="&nbsp;Guardar&nbsp;" class="btn btn-success" id="btnAceptar">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover" id="temporadas">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><strong>Mes</strong></th>
                                <th style="text-align: center; width: 100px;"><strong>Temporada Baja</strong></th>
				<th style="text-align: center; width: 100px;"><strong>Temporada Media</strong></th>
                                <th style="text-align: center; width: 100px;"><strong>Temporada Alta</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM tbl_temporada Order by tmpId";
                                
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
                                            
                                            echo "<td>".$row['tmpNombre']."</td>";
                                            
                                            switch($row['tmpTipo'])
                                            {
                                                case 'B':
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"B\" checked=\"checked\"></td>";
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"M\"></td>";
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"A\"></td>";
                                                    break;
                                                case 'M':
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"B\"></td>";
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"M\" checked=\"checked\"></td>";
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"A\"></td>";
                                                    break;
                                                case 'A':
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"B\"></td>";
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"M\"></td>";
                                                    echo "<td style=\"text-align: center;\"><input type=\"radio\" name=\"".$row['tmpId']."\" id=\"".$row['tmpId']."\" value=\"A\" checked=\"checked\"></td>";
                                                    break;
                                            }
                                                                                            
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

<?php

require("footer.php");

?>
<script>
    
    function inicio()
    {
	location.href="principal.php";
    }   
    
    $('#btnAceptar').click(function(){
            
            $('#btnAceptar').attr("disabled", "disabled");
            
            var tempo=[];
            var value=[];
            
            $('#temporadas :checked').each(function() {
                         value.push($(this).val());
                         tempo.push($(this).attr('name'));
                 });
            
            //console.log(value);
            //console.log(tempo);
            
            var data_ajax={
                        type: 'POST',
                        url: "/empaque/listadoTemporadaphp.php",
                        data: { tmp: tempo, val: value},
                        success: function( data ) {
                                                    if(data != 0)
                                                    {
							alert("Ocurrio un error!!!!");
                                                        $('#btnAceptar').removeAttr('disabled');
                                                    }
                                                    else
                                                    {
							$('#btnAceptar').removeAttr('disabled');
							location.reload();
                                                    }
                                                  },
                        error: function(){
                                            alert("Ocurrio un error de conexion!!!!");
                                            $('#btnAceptar').removeAttr('disabled');
                                          },
                        dataType: 'json'
                        };
            $.ajax(data_ajax);
	    });
    
</script>