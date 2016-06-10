<?php
include "conexion.php";

$var = new conexion();
$var->conectarse();

$valor = $_POST['variable'];

echo '<label>Productos: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>';

$sql = "SELECT ar.idProducto, ar.descProducto, pd.precio 
        FROM productosdepositos pd
		INNER JOIN articulosdeposito ar ON pd.id_articulo = ar. idProducto
        WHERE pd.id_deposito = $valor";
             
$resu = mysql_query($sql) or (die(mysql_error()));

echo "<select  style=\"width: 300;\" id=\"idProducto\" name=\"idProducto\" onChange=\"document.getElementById('Precio').value=this.options[this.selectedIndex].getAttribute('Precio')\">";
echo "<option value=\"0\" Precio=\"0.00\">Selecc. Producto</option>";

if(mysql_num_rows($resu) > 0)
    {
    while($row = mysql_fetch_array($resu))
        {
            echo '<option value="'.$row['idProducto'].'" Precio="'.$row['precio'].'">'.$row['descProducto'].'</option>';
        }
    }

echo "</select>";

?>