<?php
$id = $_POST['xId'];

include("conexion.php");
	
$var = new conexion();
$var->conectarse();

$consulta = "Select
                    polimeroEstado,
                    nombre_real as nombre,
                    logFecha,
                    observacion
            From
                    tbl_log_polimeros as p
            Join
                    usuarios as u
            On
                    p.usuarioId = u.id_usuario
            where
		    polimeroId = ".$id."
	    Order by
                    logFecha desc";
	    //Date_format( logFecha, '%d-%m-%Y %H:%i' ) as logFecha
            
$resu = mysql_query($consulta);

$rows = array();
while($r = mysql_fetch_assoc($resu)) {
  $rows[] = $r;
}

echo json_encode($rows);

//function ConvertFecha($fecha)
//{
//  $f = explode(' ', $fecha);
//  
//  $dia = explode('-',$f[0]);
//  
//  $hora = explode(':', $f[1]);
//  
//  return $dia[2].'-'.$dia[1].'-'.$dia[0].'  '.$hora[0].':'.$hora[1].':'.$hora[2];
//}
?>