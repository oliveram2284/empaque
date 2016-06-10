<?php

include("ConexionSQL.php");
$var = new conexionSQL();
$cid = $var->conectarse();

$sql = "Select * from Articulo";

	
$cur = odbc_exec($cid,$sql)or die(exit("Error en odbc_exec || " . htmlspecialchars(odbc_errormsg())));
$Fields = odbc_num_rows($cur);
	
if($Fields > 0)
    {
        echo '<table class="table table-bordered" style="height: 300px !important; width: 100%;">';
        echo '<thead><tr>
                        <th></th>
                        <th style="text-align: center">C&oacutedigo</th>
                        <th style="text-align: center">Descripci&oacuten</th>
                        <th style="text-align: center">Precio</th>
              </tr></thead>';
        echo '<tbody>';
        
        while( $row = odbc_fetch_row( $cur ))
          {
            echo "<tr>";
            
            echo "<td>
                      <a class=\"btn btn-success\" style=\"margin-top: 5px;\"
                      onclick=\"addLine('".utf8_encode(odbc_result($cur[0]))."',
                                        '".utf8_encode(odbc_result($cur[1]))."' );\"
                      >
                        <i class=\"icon-plus-sign icon-white\" title=\"Buscar productos\"></i>
                      </a></td>";
            
            echo "</tr>";
          }
        
        echo '</tbody>';
        echo "</table>";
    }
    else
    {
      echo "No se encontraron coincidencias";
    }
?>