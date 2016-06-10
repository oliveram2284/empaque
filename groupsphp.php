<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();


$nombre = $_POST['gpoNombre'];
$permisos = explode('-',$_POST['permisos']);
$esAdmin = isset($_POST['esAdmin']) ? 1 : 0;
$id = $_POST['idgpo'];
$accion = $_POST['accion'];

if($accion == "I")
    {
        //Insert
        $sql = "Insert into tbl_grupos (descripcion, permisos, administrador) values";
        $sql .= "('".$nombre."','',".$esAdmin.")";
        
        $resu = mysql_query($sql)or die(mysql_error());
        
        $sql = "Select max(id_grupo) from tbl_grupos";
        $resu = mysql_query($sql);
        $row = mysql_fetch_array($resu);
        
        $idGpo = $row[0];
        
        foreach($permisos as $p)
        {
            if($p != "")
            {
                $sql = "Insert Into tbl_grupos_permisos (id_grupo, id_menu) Values ";
                $sql .= "(".$idGpo.",".$p.")";
                $resu = mysql_query($sql);
            }
        }
    }
    else
    {
        if($accion == "U")
        {
            $sql  = "Update tbl_grupos ";
            $sql .= "set descripcion = '".$nombre."', administrador = ".$esAdmin." ";
            $sql .= "Where id_grupo = ".$id;
            $resu = mysql_query($sql);
            
            $sql = "Delete from tbl_grupos_permisos Where id_grupo = ".$id;
            $resu = mysql_query($sql);
            
            foreach($permisos as $p)
            {
                if($p != "")
                {
                    $sql = "Insert Into tbl_grupos_permisos (id_grupo, id_menu) Values ";
                    $sql .= "(".$id.",".$p.")";
                    $resu = mysql_query($sql);
                }
            }
        
        }
        else
        {
            $sql = "Delete from tbl_grupos_permisos Where id_grupo = ".$id;
            $resu = mysql_query($sql);
            
            $sql = "Delete from tbl_grupos Where id_grupo = ".$id;
            $resu = mysql_query($sql);
        }
    }
    
header("Location: listado_grupos.php?tabla=tbl_grupos");
?>