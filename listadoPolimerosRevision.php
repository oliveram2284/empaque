<?php
//session_start();

include("conexion.php");

$var = new conexion();
$var->conectarse();

$sql = "SELECT pol.id_polimero, pol.trabajo, pol.fecha_recepcion, pol.medidas, pol.precio_final, pr.razon_social, mr.descripcion, pol.id_motivo
		FROM polimeros pol
		INNER JOIN proveedores pr ON pr.id_proveedor = pol.id_proveedor
		INNER JOIN marca mr ON mr.idMarca = pol.id_etiqueta
		WHERE estado = 4";
$resu = mysql_query($sql) or (die(mysql_error()));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ASCII" />
<title>Empaque</title>

<link rel="shortcut icon" type="image/x-icon" href="logo.png">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
	<script   type="text/javascript" src="../Empaque10.0/Js/Botones.js"></script>
	
<script language="javascript" src="../Empaque10.0/abm_iniciador_js.js" type="text/javascript"></script>

<script   type="text/javascript" src="../Empaque10.0/Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="../Empaque10.0/Js/ajax.js"></script>
</head>

<body id="fondo"  >
	<div class="container  large"> <!-- Contenerdor margen de Pantalla standarizado -->

			<div class="span-24 " >
			<center>
				<div class="span-22  push-1"  id="titulo_main">
                    <center>
                        <label >
                        Polimeros
                        </label>
                    </center>
				</div>			
				<div class="span-24">
                        <div id="menu_top" class="span-24">
                        </div>
                        
                        <div class="span-22 push-1"> <!-- Cuerpo de Formulario -->
                        	<form name="listadoPolimerosEdit" method="post">
                            
                            <input type="hidden" name="idPolimero" />
                            <input type="hidden" name="Operacion" /> 
                            
                            <!-- buscador -->
                            <p><label>Buscar: &nbsp;&nbsp;</label>
							<input type="text" id="busc" name="busc" size="60" onkeyup="ajaxp(this.value,'div_find', 'buscarPolimerosRevision.php')" /></p>
                            <!--echo "<input type=\"text\" id=\"buscador\" name=\"buscador\" size=\"60\" onkeyup=\"ajax2(this.value,'div_find','buscarPedido.php','".$nombreTabla."~".$accion."');\"/>";							 -->
                            <!-- -->
                            
                            <!-- listado de polimeros a facturar-->
                            <div id="div_find">
                            	<table>
                                	<thead><tr>
                                    <td>Proveedor</td>
                                    <td>Marca</td>
                                    <td>Trabajo</td>
                                    <td>Motivo</td>
                                    <td>Fec. Recepcion</td>
                                    <td>Medidas</td>
                                    <td>Precio Final</td>
                                    <td>Editar</td>
                                    <td>Cancelar</td>
                                    </tr></thead>
                                    <?php 
									if(mysql_num_rows($resu) > 0)
										{
										while($row = mysql_fetch_array($resu))
											{	//reducir el campo trabajo 
												echo '
													<tr>
														<td>'.$row['razon_social'].'</td>
														<td>'.$row['descripcion'].'</td>
														<td>'.Recortar($row['trabajo']).'</td>
														<td>';
												echo ($row['id_motivo'] == 1) ? "Nuevo" : "Pedido Reposicion";
												echo 	'</td>
														<td>'.invertirFecha($row['fecha_recepcion']).'</td>
														<td>'.$row['medidas'].'</td>
														<td>'.$row['precio_final'].'</td>
														<td><img src="assest/plugins/buttons/icons/pencil.png" onClick="editarEliminar('.$row['id_polimero'].',\'E\')"></td>
                                                        <td><img src="assest/plugins/buttons/icons/cancel.png" onClick="editarEliminar('.$row['id_polimero'].',\'C\')"></td>
													 </tr>
											';
											}
										}else
										{
										echo '<tr><td colspan="8"><i>No hay polimeros en estado de revisi�n.</i></tr>';
										}
									?>
                                </table>
                            </div>
                            <!-- -->
                            </form>
                        </div>
                 </div>
             </center>
             </div>
       </div>
    </body>
 </html>
<script>

function editarEliminar(id,operacion)
	{
	    document.listadoPolimerosEdit.idPolimero.value = id;
        document.listadoPolimerosEdit.Operacion.value = operacion;
        document.listadoPolimerosEdit.action = "polimerosEdicion.php";//+"&operacionP="+operacion;
    	document.listadoPolimerosEdit.submit();
        //window.open("polimerosEdicion.php?id="+id+"&operacion="+operacion, "PopUp", 'width=1000,height=150'); return false;
	}
</script>
 
<?php 
function Recortar ($texto)
    {
        $largo = strlen($texto);
        if($largo > 20)
            {
                return  substr($texto,0,16)."....";
            }else
            {
                return $texto;
            }
    }

function invertirFecha($fecha)
	{
	$var = explode('-',$fecha);
	return $var[2].'-'.$var[1].'-'.$var[0];	
	}
?>