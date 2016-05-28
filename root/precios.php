<?php
session_start();
?>
<center>
<?php
if( !isset($_SESSION['id_usuario']))
	{
	 echo '<script>
	 			alert("Debes iniciar sesión para estar aca.");
				location.href = "principal.php";
	 	   </script>';	
	}
	
$idUsuario = $_SESSION['id_usuario'];

include "./layout/header2.php";
include "entrega_datos.php";

//---------------------------------------------


 ?>
 <form name="entrega" action="" method="post">
<div class="span-23 right"><!-- Cuerpo de Formulario -->
	<div class="span-23">
    
	<fieldset> 
        <legend> Dépositos / Productos / Precios </legend>
		<table>
			<tr>
				<td width="15%">
                    <label class="span-3">Depósito: </label>
                </td>
                <td width="355">
                    <select name="idDeposito" id="idDeposito" onchange="mostrar();document.getElementById('Precio').value='0.00'">
                        <option value="0">Selecc. Dépositos</option>
                        <?php
                        
                        $con = new conexion();
                        $con->conectarse();
                        
                            $consulta = "SELECT id_deposito, nombre FROM depositos";
                            $resultad = mysql_query($consulta)or(die(mysql_error()));
                            
                            
                            if( mysql_num_rows($resultad) > 0)
                                {
                                    while($fila = mysql_fetch_array($resultad))
                                    {
                                        echo "<option value='".$fila['id_deposito']."'>".$fila['nombre']."</option>";
                                    }
                                }
                        ?>
                    </select>
                </td>
                <td width="50%">
                    <div id="div_productos">
                        <label>Productos: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        
                        <select  style="width: 300;" id="idProducto" name="idProducto">
                            <option value="0">Selecc. Producto</option>
                        </select>
                    </div>
                </td>	
			</tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <label>Precio: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input type="text" id="Precio" name="Precio" size="30px" value="0.00" title="Precio del Producto" style="text-align: right;" onkeyup="decimal(Precio)" />
                </td>
            </tr>
						
	</table>
	
</div>
</div>
</form>

<div class="span-23"  >
      <input type="button" name="submitBot" id="submitBot" value="Aceptar" class="button" onclick="Guardar()" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="button" onclick="Principal()" />
                        
</div>
<?php include "./layout/footer.php"; ?>
</center>

<script type="text/javascript">
function mostrar()
    {
     ajax_pallet("div_productos","productosdepositos.php",document.getElementById('idDeposito').value);
    }
    
function Guardar()
    {
        if(document.getElementById('idDeposito').value == 0 )
            {
                alert("Debe seleccionar un depósito.");
                document.getElementById('idDeposito').focus();
                return false;
            }
            
        if(document.getElementById('idProducto').value == 0 )
            {
                alert("Debe seleccionar un producto.");
                document.getElementById('idProducto').focus();
                return false;
            }
            
        if(document.getElementById('Precio').value == "" )
            {
                alert("Indique un precio para el producto valido.");
                document.getElementById('Precio').focus();
                return false;
            }
            
        document.entrega.action = "preciosphp.php";
        document.entrega.submit();
    }    
    
function Principal()
	{
	 document.entrega.action="principal.php";
	 document.entrega.submit();
	}


function ajax_pallet(id_div,controller,vari)
{
	    // Obtendo la capa donde se muestran las respuestas del servidor
		var capa=document.getElementById(id_div);
		// Creo el objeto AJAX
		var ajax=nuevoAjax();
		// Coloco el mensaje "Cargando..." en la capa
		capa.innerHTML="Cargando...";
		// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
		ajax.open("POST", controller, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
		var variable=vari;
		//alert(variable);
		ajax.send("variable="+variable);
	
	    ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
		
}
//_________________________________________________________//	
//Solo se permiten flotantes
function decimal(campo)
	{ 
	var charpos = campo.value.search("[^0-9.]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value =  campo.value.slice(0, -1)
		campo.focus();
		return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//
</script>
