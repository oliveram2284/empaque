<?php
function fechaamysql($fecha){
	if (strlen($fecha) == 10){
		$nfecha = substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2);
		return $nfecha;
	}
	else
	{
		$informacion = "SOLO SE ACEPTAN FECHAS CON FORMATO dd/mm/aaaa";
	}
}
function fechademysql($fecha){
	$nfecha = substr($fecha,8,2).'/'.substr($fecha,5,2).'/'.substr($fecha,0,4);
	return $nfecha;
}
function calcularequiv($codigo, $fecha ,$horas){
	$link = Conectarse();
	$consulta = "SELECT categoria FROM historico WHERE codigo='".$codigo."' AND (fdcargo<='".fechaamysql($fecha)."' AND (fhcargo>='".fechaamysql($fecha)."' OR fhcargo IS NULL))";
	$resultado = mysql_fetch_array(mysql_query($consulta, $link));
	if ($resultado){
		$categoria = $resultado['categoria'];
		$resultado = mysql_fetch_array(mysql_query("SELECT factorconv FROM categoria WHERE nombre='".$categoria."'", $link));
		$factorconv = $resultado['factorconv'];
		$equivalentes= $horas * $factorconv;
		$entero = intval($equivalentes);
		$fraccion = explode(".",$equivalentes);
		if (substr($fraccion['1'],0,1) < 5){
		$fraccion = ".0";
		}else{
		$fraccion = ".5";
		}
		$equivalentes = $entero.$fraccion;
	}else{
		$equivalentes = false;
	}
	
	return $equivalentes;
}
?>
