<?php
session_start();

echo '<center>';
include("class_impresion.php");

$TipoDeDocumento = $_GET['documento'];
$numeroDocumento = $_GET['id'];

$var = new impresion();
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="UTF-8" />
<head>
<title></title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<script   type="text/javascript" src="Js/Botones.js"></script>
<script language="javascript" src="abm_iniciador_js.js" type="text/javascript"></script>

</head>';

echo '<form name="reporte" action="">
          <div style="width:900; text-align: right">';
if($TipoDeDocumento != 6)
    echo 'VE.F. 01/02 - V.09/12';
echo    '</div>
	  <table width="900" style="border:1px solid black;font-family: sans-serif">
		<tr>
			<td>';
                            $var->Encabezado($TipoDeDocumento,$numeroDocumento);
echo 		'       <br>
                        </td>
		</tr>
		<tr>
			<td colspan="3">';
			$var->Cuerpo($TipoDeDocumento,$numeroDocumento);
echo 	   '            </td>
		</tr>
	  </table>';
echo '</center>
	  </form>';	  
?>