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
                                Proveedores
			  </h2>
			  </div>
		</div>
	    </div>
	    <div class="row">
		<div class="span2">
		    <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger" onClick="inicio()">
		    <input type="button" value="&nbsp;Nuevo&nbsp;" class="btn btn-success" id="btn_nuevo">
		</div>
	    </div>
	    <div class="row">
		<div class="span10">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;"><strong>Razón Social</strong></th>
				<th style="text-align: center;"><strong>Teléfono</strong></th>
                                <th style="text-align: center;"><strong>Mail</strong></th>
				<th style="text-align: center;"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        
			    <?php
				$sql = "SELECT * FROM proveedores Order by razon_social";
                                
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
                                            
                                            echo "<td>".utf8_decode($row['razon_social'])."</td>";
					    echo "<td style=\"text-align: right\">".$row['telefono']."</td>";
					    echo "<td style=\"text-align: left\">".$row['mail']."</td>";
                                            echo "<td style=\"text-align: center\"onClick=\"editarProveedor(".$row['id_proveedor'].")\">";
                                            echo "<img src=\"./assest/plugins/buttons/icons/pencil.png\" onClick=\"editarProveedor(".$row['id_proveedor'].")\" width='20' heigth='20' title=\"Editar\" style=\"cursor:pointer\"/>";
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
    <input type="hidden" id="idMoneda" value="">

<?php

require("footer.php");

?>
<script>
    function editarProveedor(id)
    {
	$(location).attr('href','../empaque/listadoProveedoresSave.php?id='+id);
    }
    
    function inicio()
    {
	location.href="principal.php";
    }
    
    $('#btn_nuevo').click(function(){
        $(location).attr('href','../empaque/listadoProveedoresSave.php?id=0');
    });
</script>