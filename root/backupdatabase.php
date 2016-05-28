<?php  
session_start();

$nombre = substr($_SESSION['Nombre'], 0, 2);

if(!$_SESSION['Nombre'])
{
    header('Location: index.php'); 
}
include("conexion.php");

$var = new conexion();
$var->conectarse();

include("class_sesion.php");

require("header.php");

?>

<br>
<div class="well"> 
    <div class="row">
        <div class="span6 offset2">
            <div class="page-header">
                <h2>Backup de Base de Batos</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span10">
            <a href="javascript:history.back()" class="btn btn-danger">Atrás </a>
            <input type="button" id="nuevo_bck" name="nuevo_bck" value="Generar Backup"  class="btn btn-success" onclick="generaBackUp()">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="span10">
            <b style="color: red">Backup's disponibles para descargar</b>
            <div style="width: 70%; height: 600px; max-height: 600px; border: 1px solid; border-color: green; border-radius: 5px; background-color: white; overflow-x: scroll;" id="pathFiles">
                <?php
                $dir = 'backs/';
                $files = scandir($dir, 0);
                arsort($files);
                $files_ = array();
                
                print '<br>';
                for($i = 2; $i < count($files); $i++)
                {   $files_[] = $files[$i];
                }
                //Ordenar descendenete
                for($i = count($files_) - 1 ; $i >= 0;  $i--){
                    print '<a href="../empaque/backs/'.$files_[$i].'" download>'.$files_[$i].'</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" onClick="Eliminar(\'../empaque/backs/'.$files_[$i].'\')"><img src="./assest/plugins/buttons/icons/delete.png" title="Borrar"></a><br>';
                    print '<hr>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php

require("footer.php");

?>
<script>
function generaBackUp(){
    $("#nuevo_bck").attr('disabled', 'disabled');
    var data_ajax={
                        type: 'POST',
                        url: "/empaque/backupdatabasephp.php",
                        data: { },
                        success: function( data ) {
					location.reload();
                                },
                        error: function(){
                                            alert("Error al generar el backup.");
                                          },
                        dataType: 'json'
                        };
		$.ajax(data_ajax);
}

function Eliminar(path_) {
    $("#nuevo_bck").attr('disabled', 'disabled');
    var data_ajax={
                        type: 'POST',
                        url: "/empaque/backupdatabasedeletephp.php",
                        data: { path: path_},
                        success: function( data ) {
					location.reload();
                                },
                        error: function(){
                                            alert("Error al eliminar el backup.");
                                          },
                        dataType: 'json'
                        };
		$.ajax(data_ajax);
}
</script>
<?php
//

//?>