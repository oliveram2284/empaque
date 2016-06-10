<?php

session_start();

include("conexion.php");
$var = new conexion();
$var->conectarse();

$id              = $_POST['inid'];
$razonSocial     = $_POST['inrazonSocial'];
$direccion       = $_POST['indireccion'];
$envios          = $_POST['inenvios'];
$telefono1       = $_POST['intelefono1'];
$telefono2       = $_POST['intelefono2'];
$telefono3       = $_POST['intelefono3'];
$mail            = $_POST['inmail'];
$web             = $_POST['inweb'];
$observaciones   = $_POST['inobservaciones'];
$nombreRV        = $_POST['innombreRV'];
$telefonoRV      = $_POST['intelefonoRV'];
$mailRV          = $_POST['inmailRV'];
$nombrePR1       = $_POST['innombrePR1'];
$telefonoPR1     = $_POST['intelefonoPR1'];
$mailPR1         = $_POST['inmailPR1'];
$nombrePR2       = $_POST['innombrePR2'];
$telefonoPR2     = $_POST['intelefonoPR2'];
$mailPR2         = $_POST['inmailPR2'];
$nombrePR3       = $_POST['innombrePR3'];
$telefonoPR3     = $_POST['intelefonoPR3'];
$mailPR3         = $_POST['inmailPR3'];
$ids             = explode("~", $_POST['invarId']);
$precios         = explode("~", $_POST['inPrecios']);

if($id > 0)
{
    #update
    $sql = "Update proveedores";
    $sql .= " Set 
                `razon_social` = '".$razonSocial."', `direccion` = '".$direccion."',
                `telefono` = '".$telefono1."', `mail` = '".$mail."',
                `web` = '".$web."', `observacion` = '".$observaciones."',
                `telefono2` = '".$telefono2."', `telefono3` = '".$telefono3."',
                `envios` = '".$envios."', `rv_Nombre` = '".$nombreRV."',
                `rv_telefono` = '".$telefonoRV."', `rv_mail` = '".$mailRV."',
                `rp1_nombre` = '".$nombrePR1."', `rp2_nombre` = '".$nombrePR2."',
                `rp3_nombre` = '".$nombrePR3."', `rp1_telefono` = '".$telefonoPR1."',
                `rp2_telefono` = '".$telefonoPR2."',`rp3_telefono` = '".$telefonoPR3."',
                `rp1_mail` = '".$mailPR1."', `rp2_mail` = '".$mailPR2."',
                `rp3_mail` = '".$mailPR3."'";
    $sql .= " Where id_proveedor =".$id;
    
    $resu = mysql_query($sql);
    
    $delete = "delete from tbl_proveedores_tipo where idProveedor =".$id;
    mysql_query($delete);
    
    $indice = 0;
    foreach ($ids as $valor) {
        
        if($valor != "")
        {
            $sql = "Insert into tbl_proveedores_tipo(
                        idProveedor, idTipo, precio)
                    Values(".$id.",".$valor.",".$precios[$indice].")";
                    
            $v = mysql_query($sql);
        }
        $indice++;
    }
}
else
{
    #insert
   $sql =  "INSERT INTO proveedores (
                                    `razon_social`, `direccion`, `telefono`, `mail`, `web`, `observacion`, `telefono2`, `telefono3`, `envios`,
                                    `rv_Nombre`, `rv_telefono`, `rv_mail`, `rp1_nombre`, `rp2_nombre`, `rp3_nombre`,
                                    `rp1_telefono`, `rp2_telefono`, `rp3_telefono`, `rp1_mail`, `rp2_mail`, `rp3_mail`)
            VALUES (
                    '".$razonSocial."', '".$direccion."', '".$telefono1."', '".$mail."', '".$web."', '".$observaciones."', '".$telefono2."', '".$telefono3."',
                    '".$envios."', '".$nombreRV."', '".$telefonoRV."', '".$mailRV."', '".$nombrePR1."', '".$nombrePR2."', '".$nombrePR3."',
                    '".$telefonoPR1."', '".$telefonoPR2."', '".$telefonoPR3."', '".$mailPR1."', '".$mailPR2."', '".$mailPR3."')";
                    
    $resu = mysql_query($sql);
    
    $id=mysql_insert_id();
    
    $indice = 0;
    foreach ($ids as $valor) {
        
        if($valor != "")
        {
            $sql = "Insert into tbl_proveedores_tipo(
                        idProveedor, idTipo, precio)
                    Values(".$id.",".$valor.",".$precios[$indice].")";
                    
            $v = mysql_query($sql);
        }
        $indice++;
    }
    
}

return json_encode($resu);
?>