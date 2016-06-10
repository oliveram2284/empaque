<?php

include("conexion.php");
$var = new conexion();
$var->conectarse();

$idDeposito = $_POST['idDeposito'];
$idProducto = $_POST['idProducto'];
$precio = $_POST['Precio'];

$sql = "Update productosdepositos 
        Set precio = ".$precio."
        Where id_articulo = ".$idProducto." and id_deposito = ".$idDeposito."";

$resu = mysql_query($sql) or (die(mysql_error()));

if($resu == 1)
    {
     echo '<script>
 			alert("Modificación de precio exitosa.");
			location.href = "principal.php";
           </script>';    
    }

?>