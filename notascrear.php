<?php
session_start();
include("conexion.php");
$var = new conexion();
$var->conectarse();

$titulo = $_POST['xtitulo'];
$detalle = $_POST['xdetalle'];
$fecha1 = $_POST['xfecha'];
$todos = $_POST['xtodos'];
$tipo = $_POST['xtipo'];
$categoria = $_POST['xcategoria'];
$usuario = $_POST['xusuario'];

//$fecha1 = explode('-', $fecha1);
//$fecha1 = $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0];
$fecha1= date('Y-m-d',strtotime($fecha1));
var_dump($fecha1);
die();
if($todos == 'false'){
	
	if($categoria == 0 && $usuario == 0){
		$sql = "Insert Into Notas (titulo, descripcion, fecha, tipo, usrId) ";
		$sql.= "Values ('".$titulo."', '".$detalle."', '".$fecha1."', ".$tipo.", ".$_SESSION['id_usuario'].")";
		$resu = mysql_query($sql);
	}
	if($usuario != 0){
		$sql = "Insert Into Notas (titulo, descripcion, fecha, tipo, usrId) ";
		$sql.= "Values ('".$titulo."', '".$detalle."', '".$fecha1."', ".$tipo.", ".$usuario.")";
		$resu = mysql_query($sql);
	}
	if($categoria != 0){
		$sql = "Select id_usuario From usuarios Where catId = ".$categoria." ";
		$resu = mysql_query($sql);
	
	//echo $sql ;

		while($r = mysql_fetch_assoc($resu)) {
			
			$sql_ = "Insert Into Notas (titulo, descripcion, fecha, tipo, usrId) ";
			$sql_.= "Values ('".$titulo."', '".$detalle."', '".$fecha1."', ".$tipo.", ".$r['id_usuario'].")";
			
			$resu_ = mysql_query($sql_);
		}
	}
}else{
	
	$sql = "Select id_usuario from Usuarios";
	$resu = mysql_query($sql);
	
	while($r = mysql_fetch_assoc($resu)) {
		
		$sql_ = "Insert Into Notas (titulo, descripcion, fecha, tipo, usrId) ";
		$sql_.= "Values ('".$titulo."', '".$detalle."', '".$fecha1."', ".$tipo.", ".$r['id_usuario'].")";
		
		$resu_ = mysql_query($sql_);
	}
}

echo json_encode(1);
?>