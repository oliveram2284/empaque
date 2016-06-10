<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$idEnt = $_POST['id'];

$fe__ = getdate();
$name = "protocolo".$fe__['year'].'-'.$fe__['mon'].'-'.$fe__['mday'].'-'.$fe__['hours'].'-'.$fe__['minutes'].'-'.$fe__['seconds'].'.pdf';

$sql = "Select idPedido from tbl_log_entregas_protocolos Where id = ".$idEnt;
$resu = mysql_query($sql);
$id = 0;
while($row = mysql_fetch_array($resu)){
    $id = $row['idPedido'];
}

//Actualizar la entrega -----------------
$ent = "Update tbl_log_entregas_protocolos set idPDF = '".$name."' Where id = ".$idEnt;
$resu = mysql_query($ent);
//---------------------------------------

$body = ArmarCuerpo($id, $idEnt, '');

require_once("HTMLtoPDF/dompdf/dompdf_config.inc.php");


//se crea una nueva instancia al DOMPDF
$dompdf = new DOMPDF();
//se carga el codigo html
$dompdf->load_html(utf8_decode($body));
//aumentamos memoria del servidor si es necesario
ini_set("memory_limit","300M"); 
//Tamaño de la página y orientación 
$dompdf->set_paper('a4', 'portrait');
//lanzamos a render
$dompdf->render();
//guardamos a PDF
//$dompdf->stream("ListadoDePolimeros.pdf");
$output = $dompdf->output();
//$fe__ = getdate();
//$name = "protocolo".$fe__['year'].'-'.$fe__['mon'].'-'.$fe__['mday'].'-'.$fe__['hours'].'-'.$fe__['minutes'].'-'.$fe__['seconds'].'.pdf';
file_put_contents('sistema/'.$name, $output);

//Aca ver que se hace
echo json_encode($name);

function ArmarCuerpo($id, $idEntrega, $observacion){
    $body = '<table style="border: 1px solid #aaa; width: 700px;">';
    //Logo 
    $body .= '<tr>
                <td align="center" width="200px">
                    <img src="imag/logo-V2.png" width="100" height="100" style="margin-left: 40px;" />
                </td>
                <td align="center">
                        <h2>EMPAQUE S.A.</h2><br>
                        <h3>
                            Aseguramiento de la Calidad<br>
                            Protocólo de Análisis
                        </h3>
                </td>
             </tr>';
    //Datos del Pedido
    $idPedido = 0;  $hr = "";
    $producto = ""; $cantidad = 0;
    $cliente = "";  $fecha = '';
    $tipoUnidad = "";

    //$sql = "Select idPedido from protocolos Where prtId = ".$id;
    //$resu = mysql_query($sql);
    //while($row = mysql_fetch_array($resu)){
    //    $idPedido = $row['idPedido'];
    //}
    $idPedido = $id;

    $det = "Select ColorMaterial, Material, Ancho, Largo, Fuelle, Micronaje, solapa, Formato, Unidad from pedidosdetalle Where idPedido = ".$idPedido;
    $resu3 = mysql_query($det) or (die(mysql_error()));
    $resu3 = mysql_fetch_array($resu3);

    $sql = 'Select descripcion, clienteNombre, esCI from pedidos where npedido = '.$idPedido;
    $resu = mysql_query($sql);
    while($row = mysql_fetch_array($resu)){
        $producto = $row['descripcion'];
        $cliente = $row['clienteNombre'];
        if($row['esCI'] != null){
            $items = explode("-", $row['esCI']);
            foreach ($items as $valor) {
                    if($hr == ""){
                        $hr = utf8_encode($valor);
                    } else {
                        $hr .= "-".utf8_encode($valor);
                    }
                }
        } else {
            $sql2 = "Select HojaDeRuta from pedidoshojasderuta where idPedido = ".$idPedido;
            $resu2 = mysql_query($sql2) or die(mysql_error());
            
            if(mysql_num_rows($resu2) >= 0)
            {
                while($row2 = mysql_fetch_array($resu2))
                {
                    if($hr == ""){
                        $hr = utf8_encode($row2[0]);
                    } else {
                        $hr .= "-".utf8_encode($row2[0]);
                    }
                }
            }
        }
    }

    $tipoUnidad = obtenerDato($resu3['Unidad'],'Unidades','idUnidad','descripcion');

    $sql = 'Select cantidad, fecha from tbl_log_entregas_protocolos where id = '.$idEntrega;
    $resu = mysql_query($sql);
    while($row = mysql_fetch_array($resu)){
        $cantidad = $row['cantidad'];
        $fecha = $row['fecha'];
    }

    $fecha = explode(' ', $fecha);
    $fecha = explode('-', $fecha[0]);
    if($tipoUnidad == "Unidades.")
    {
        $cantidad = str_replace(".00", "", $cantidad);
    }
    else
    {
        $cantidad = str_replace(".", ",", $cantidad);
    }
    $body .= '<tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td width="70%">
                                Proveedor: <b>Empaque S.A.</b>
                            </td>
                            <td width="30%">
                                Hoja de Ruta: <b>'.$hr.'</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Producto: <b>'.$producto.'</b>
                            </td>
                            <td>
                                Cantidad: <b>'.$cantidad.' '.$tipoUnidad.'</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Cliente: <b>'.$cliente.'</b>
                            </td>
                            <td>
                                Fecha De Entrega: <b>'.$fecha[2].'-'.$fecha[1].'-'.$fecha[0].'</b>
                            </td>
                        </tr>
                    </table>
                </td>
             </tr>';
    //Divisor
    $body .= '<tr><td colspan="2"><hr></td></tr>';
    $body .= '<tr><td colspan="2" style="text-align: center">Detalle de la Inspección</td></tr>';
    $body .= '<tr><td colspan="2"><hr></td></tr>';
    //Detalle
    $formato = "";
    $for = "Select 
                descripcionFormatoProtocologo as descripcion
            From 
                tiposProtocologos tp 
            Join 
                formatos as f on f.idFormatoProtocologo = tp.idFormatoProtocologo
            Where 
                f.idFormato = ".$resu3['Formato'];
    $resu4 = mysql_query($for) or (die(mysql_error()));
    $resu4 = mysql_fetch_array($resu4);
    $formato = $resu4['descripcion'];

    if($formato == "Bolsas Wick")
    {
        $body .= '<tr>
                    <td colspan="2">
                        <table width="100%">';
        $body .= '          <tr>
                                <td coslpan="3">Tipo de Material: </td><td style="text-align: left;"><b>'.obtenerDato($resu3['Material'],'Materiales','idMaterial','descripcion').'</b></td>
                            </tr>';
        $body .= '          <tr>
                                <td width="40%" colspan="2"><b>Controles</b></td>
                                <td width="30%"><b>Mediciones</b></td>
                                <td width="30%"><b>Elementos Utilizados</b></td>
                            </tr>
                            <tr>
                                <td>Color del Material: </td><td style="text-align: left;"><b>'.$resu3['ColorMaterial'].'</b></td>
                                <td></td>
                                <td>Visual</td>
                            </tr>
                            <tr>
                                <td>Ancho de la Bolsa: </td><td style="text-align: right;"><b>'.$resu3['Ancho'].' cm</b></td>
                                <td> (+/-5mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Largo de la Bolsa: </td><td style="text-align: right;"><b>'.$resu3['Largo'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Fuelle: </td><td style="text-align: right;"><b>'.$resu3['Fuelle'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Solapa: </td><td style="text-align: right;"><b>'.$resu3['solapa'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td colspan="4">Espesor del material (Promedio de 10 mediciones a lo largo de la lamina):</td>
                            </tr>
                            <tr>
                                <td></td><td style="text-align: right;"><b>'.$resu3['Micronaje'].'µ</b></td>
                                <td> (+/-5µm)</td>
                                <td>Especimetro</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Paquetes sujetados por ganchos plasticos en troqueles wiketeros <br>
                                    Tipo de Tintas: Ecológicas orgánicas aptas para impresión flexográfica.
                                    <br>
                                    Ensayo de Soldabilidad:             <b>Aprobado</b><br>
                                    Observaciones: '.($observacion == '' ? "Sin Observacion": $observacion).' <br>
                                    Aprobado por: <br>
                                    <img src="imag/firmaprotocolo.png" style="margin-left: 400px;" />
                                    <br>
                                    <i>"Es responsabilidad del cliente, realizar sus propios controles de calidad al producto recibido. Cualquier observación respecto a la calidad
                                     del producto debe ser declarada en periodo de hasta 7 días corridos de recepción de la mercadería; no existiendo observación alguna se interpreta 
                                     como aceptación total de la calidad del producto y de conformidad a los requerimientos del cliente."
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>';
    }
    
    if($formato == "Etiquetas Envolvente")
    {
        $body .= '<tr>
                    <td colspan="2">
                        <table width="100%">';
        $body .= '          <tr>
                                <td coslpan="3">Tipo de Material: </td><td style="text-align: left;"><b>'.obtenerDato($resu3['Material'],'Materiales','idMaterial','descripcion').'</b></td>
                            </tr>';
        $body .= '          <tr>
                                <td width="40%" colspan="2"><b>Controles</b></td>
                                <td width="30%"><b>Mediciones</b></td>
                                <td width="30%"><b>Elementos Utilizados</b></td>
                            </tr>
                            <tr>
                                <td>Color del Material: </td><td style="text-align: left;"><b>'.$resu3['ColorMaterial'].'</b></td>
                                <td></td>
                                <td>Visual</td>
                            </tr>
                            <tr>
                                <td>Espesor: </td><td style="text-align: right;"><b>'.$resu3['Micronaje'].'</b></td>
                                <td> (+/-5mic)</td>
                                <td>Especimetro</td>
                            </tr>
                            <tr>
                                <td>Ancho de la Etiqueta: </td><td style="text-align: right;"><b>'.$resu3['Ancho'].' cm</b></td>
                                <td> (+/-5mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Distancia Taco a Taco: </td><td style="text-align: right;"><b>'.$resu3['Largo'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Observaciones: '.($observacion == '' ? "Sin Observacion": $observacion).' <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Aprobado por: <br>
                                    <img src="imag/firmaprotocolo.png" style="margin-left: 400px;" />
                                    <br>
                                    <i>"Es responsabilidad del cliente, realizar sus propios controles de calidad al producto recibido. Cualquier observación respecto a la calidad
                                     del producto debe ser declarada en periodo de hasta 7 días corridos de recepción de la mercadería; no existiendo observación alguna se interpreta 
                                     como aceptación total de la calidad del producto y de conformidad a los requerimientos del cliente."
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>';
    }

    if($formato == "Lamina")
    {
        $body .= '<tr>
                    <td colspan="2">
                        <table width="100%">';
        $body .= '          <tr>
                                <td coslpan="3">Tipo de Material: </td><td style="text-align: left;"><b>'.obtenerDato($resu3['Material'],'Materiales','idMaterial','descripcion').'</b></td>
                            </tr>';
        $body .= '          <tr>
                                <td width="40%" colspan="2"><b>Controles</b></td>
                                <td width="30%"><b>Mediciones</b></td>
                                <td width="30%"><b>Elementos Utilizados</b></td>
                            </tr>
                            <tr>
                                <td>Color del Material: </td><td style="text-align: left;"><b>'.$resu3['ColorMaterial'].'</b></td>
                                <td></td>
                                <td>Visual</td>
                            </tr>
                            <tr>
                                <td>Ancho de la Lámina: </td><td style="text-align: right;"><b>'.$resu3['Ancho'].' cm</b></td>
                                <td> (+/-5mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Largo de la Lámina: </td><td style="text-align: right;"><b>'.$resu3['Largo'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td colspan="4">Espesor del material (Promedio de 10 mediciones a lo largo de la lamina):</td>
                            </tr>
                            <tr>
                                <td></td><td style="text-align: right;"><b>'.$resu3['Micronaje'].'µ</b></td>
                                <td> (+/-5µm)</td>
                                <td>Especimetro</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Observaciones: '.($observacion == '' ? "Sin Observacion": $observacion).' <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Aprobado por: <br>
                                    <img src="imag/firmaprotocolo.png" style="margin-left: 400px;" />
                                    <br>
                                    <i>"Es responsabilidad del cliente, realizar sus propios controles de calidad al producto recibido. Cualquier observación respecto a la calidad
                                     del producto debe ser declarada en periodo de hasta 7 días corridos de recepción de la mercadería; no existiendo observación alguna se interpreta 
                                     como aceptación total de la calidad del producto y de conformidad a los requerimientos del cliente."
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>';
    }

    if($formato == "Bolsas Normal/Trans.")
    {
        $body .= '<tr>
                    <td colspan="2">
                        <table width="100%">';
        $body .= '          <tr>
                                <td coslpan="3">Tipo de Material: </td><td style="text-align: left;"><b>'.obtenerDato($resu3['Material'],'Materiales','idMaterial','descripcion').'</b></td>
                            </tr>';
        $body .= '          <tr>
                                <td width="40%" colspan="2"><b>Controles</b></td>
                                <td width="30%"><b>Mediciones</b></td>
                                <td width="30%"><b>Elementos Utilizados</b></td>
                            </tr>
                            <tr>
                                <td>Color del Material: </td><td style="text-align: left;"><b>'.$resu3['ColorMaterial'].'</b></td>
                                <td></td>
                                <td>Visual</td>
                            </tr>
                            <tr>
                                <td>Ancho de la Bolsa: </td><td style="text-align: right;"><b>'.$resu3['Ancho'].' cm</b></td>
                                <td> (+/-5mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Largo de la Bolsa: </td><td style="text-align: right;"><b>'.$resu3['Largo'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td colspan="4">Espesor del material (Promedio de 10 mediciones a lo largo de la lamina):</td>
                            </tr>
                            <tr>
                                <td></td><td style="text-align: right;"><b>'.$resu3['Micronaje'].' µ</b></td>
                                <td> (+/-5µm)</td>
                                <td>Especimetro</td>
                            </tr>
                            <tr>
                                <td>Fuelle: </td><td style="text-align: right;"><b>'.$resu3['Fuelle'].' cm</b></td>
                                <td> (+5/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>                            
                            <tr>
                                <td colspan="4">
                                    Ensayo de Soldabilidad:             <b>Aprobado</b><br>
                                    Observaciones: '.($observacion == '' ? "Sin Observacion": $observacion).' <br>
                                    Aprobado por: <br>
                                    <img src="imag/firmaprotocolo.png" style="margin-left: 400px;" />
                                    <br>
                                    <i>"Es responsabilidad del cliente, realizar sus propios controles de calidad al producto recibido. Cualquier observación respecto a la calidad
                                     del producto debe ser declarada en periodo de hasta 7 días corridos de recepción de la mercadería; no existiendo observación alguna se interpreta 
                                     como aceptación total de la calidad del producto y de conformidad a los requerimientos del cliente."
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>';
    }

    if($formato == "Etiquetas Sleeve")
    {
        $body .= '<tr>
                    <td colspan="2">
                        <table width="100%">';
        $body .= '          <tr>
                                <td coslpan="3">Tipo de Material: </td><td style="text-align: left;"><b>'.obtenerDato($resu3['Material'],'Materiales','idMaterial','descripcion').'</b></td>
                            </tr>';
        $body .= '          <tr>
                                <td width="40%" colspan="2"><b>Controles</b></td>
                                <td width="30%"><b>Mediciones</b></td>
                                <td width="30%"><b>Elementos Utilizados</b></td>
                            </tr>
                            <tr>
                                <td>Color del Material: </td><td style="text-align: left;"><b>'.$resu3['ColorMaterial'].'</b></td>
                                <td></td>
                                <td>Visual</td>
                            </tr>
                            <tr>
                                <td colspan="4">Espesor del material (Promedio de 10 mediciones a lo largo de la lamina):</td>
                            </tr>
                            <tr>
                                <td>Ancho de la Etiqueta: </td><td style="text-align: right;"><b>'.$resu3['Ancho'].' cm</b></td>
                                <td> (+/-5mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td>Largo de la Etiqueta: </td><td style="text-align: right;"><b>'.$resu3['Largo'].' cm</b></td>
                                <td> (+/-10mm)</td>
                                <td>Regla Metalica</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Observaciones: '.($observacion == '' ? "Sin Observacion": $observacion).' <br>
                                    Aprobado por: <br>
                                    <img src="imag/firmaprotocolo.png" style="margin-left: 400px;" />
                                    <br>
                                    <i>"Es responsabilidad del cliente, realizar sus propios controles de calidad al producto recibido. Cualquier observación respecto a la calidad
                                     del producto debe ser declarada en periodo de hasta 7 días corridos de recepción de la mercadería; no existiendo observación alguna se interpreta 
                                     como aceptación total de la calidad del producto y de conformidad a los requerimientos del cliente."
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>';
    }

    $body .= '</table>';

    return $body;
}

function obtenerDato($id,$tabla,$campo,$campoRetorno)
        {
         if($id != 0)
            {
             $consulta = 'Select '.$campoRetorno.' From '.$tabla.' Where '.$campo.' = '.$id;
             $resu = mysql_query($consulta);
             $row = mysql_fetch_array($resu);
             return $row[0];
             }else
                {
                 return '-';
                }
        }

?>