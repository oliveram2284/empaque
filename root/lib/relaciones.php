<?php

function cuasignados($tabla,$cliente,$sino,$modo){
echo "<table><tr>
		<th>CODIGO</th>
		<th>NOMBRE</th>
		<th>USUARIO</th>
		<th>EMPRESA</th>
		<th>CATEGORIA</th>
		<th>AREA</th>
		<th>Asignado</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$usuario=$row['codigo'];
$empresa=$row["empresa"];
$categoria=$row["categoria"];
$area=$row["area"];

if ($sino==true){
	$icono_asignado="<img BORDER=\"0\"src=\"img/relacionado.gif\">";
	
	if ($cliente <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=break&cli=$cliente&us=$cod&modo=$modo\"><img BORDER=\"0\" src=\"img/norelacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}else{
	$icono_asignado="<img BORDER=\"0\"src=\"img/norelacionado.gif\">";
	
	if ($cliente <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=build&cli=$cliente&us=$cod&modo=$modo\"><img BORDER=\"0\" src=\"img/relacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}
printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nombre, $usuario, $empresa, $categoria, $area, $icono_asignado, $icono_accion
	);
}
}

function ucasignados($tabla,$usuario,$sino,$modo){
echo "<table><tr>
		<th>CODIGO</th>
		<th>NOMBRE COMERCIAL</th>
		<th>RAZON SOCIAL</th>
		<th>DOMICILIO</th>
		<th>Asignado</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
$cod=$row["cod_client"];
$nom_com=$row["nom_com"];
$razon_soci=$row["razon_soci"];
$domicilio=$row["domicilio"];
$localidad=$row["localidad"];
$telefono=$row["telefono"];

if ($sino == true){
	$icono_asignado="<img BORDER=\"0\"src=\"img/relacionado.gif\">";
	
	if ($usuario <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=break&cli=$cod&us=$usuario&modo=$modo\"><img BORDER=\"0\" src=\"img/norelacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}else{
	$icono_asignado="<img BORDER=\"0\"src=\"img/norelacionado.gif\">";
	
	if ($usuario <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=build&cli=$cod&us=$usuario&modo=$modo\"><img BORDER=\"0\" src=\"img/relacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}

printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nom_com, $razon_soci, $domicilio, $icono_asignado, $icono_accion
	);
}
}
function tuasignados($tabla,$tarea,$sino,$modo){
echo "<table><tr>
		<th>CODIGO</th>
		<th>NOMBRE</th>
		<th>USUARIO</th>
		<th>EMPRESA</th>
		<th>CATEGORIA</th>
		<th>AREA</th>
		<th>Asignado</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$usuario=$row['codigo'];
$empresa=$row["empresa"];
$categoria=$row["categoria"];
$area=$row["area"];

if ($sino==true){
	$icono_asignado="<img BORDER=\"0\"src=\"img/relacionado.gif\">";
	
	if ($tarea <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=break&tar=$tarea&us=$cod&modo=$modo\"><img BORDER=\"0\" src=\"img/norelacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}else{
	$icono_asignado="<img BORDER=\"0\"src=\"img/norelacionado.gif\">";
	
	if ($tarea <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=build&tar=$tarea&us=$cod&modo=$modo\"><img BORDER=\"0\" src=\"img/relacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}
printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nombre, $usuario, $empresa, $categoria, $area, $icono_asignado, $icono_accion
	);
}
}

function utasignados($tabla,$usuario,$sino,$modo){
echo "<table><tr>
		<th>CODIGO</th>
		<th>DESCRIPCION</th>
		<th>DESC. ADICIONAL</th>
		<th>Asignado</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
$cod=$row["cod_articu"];
$nom_com=$row["descripcio"];
$razon_soci=$row["desc_adic"];

if ($sino == true){
	$icono_asignado="<img BORDER=\"0\"src=\"img/relacionado.gif\">";
	
	if ($usuario <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=break&tar=$cod&us=$usuario&modo=$modo\"><img BORDER=\"0\" src=\"img/norelacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}else{
	$icono_asignado="<img BORDER=\"0\"src=\"img/norelacionado.gif\">";
	
	if ($usuario <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=build&tar=$cod&us=$usuario&modo=$modo\"><img BORDER=\"0\" src=\"img/relacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}

printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nom_com, $razon_soci, $icono_asignado, $icono_accion
	);
}
}







function tcasignados($tabla,$tarea,$sino,$modo){
echo "<table><tr>
		<th>CODIGO</th>
		<th>NOMBRE COMERCIAL</th>
		<th>RAZON SOCIAL</th>
		<th>DOMICILIO</th>
		<th>Asignado</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
$cod=$row["cod_client"];
$nom_com=$row["nom_com"];
$razon_soci=$row["razon_soci"];
$domicilio=$row["domicilio"];
$localidad=$row["localidad"];
$telefono=$row["telefono"];

if ($sino==true){
	$icono_asignado="<img BORDER=\"0\"src=\"img/relacionado.gif\">";
	
	if ($tarea <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=break&tar=$tarea&cli=$cod&modo=$modo\"><img BORDER=\"0\" src=\"img/norelacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}else{
	$icono_asignado="<img BORDER=\"0\"src=\"img/norelacionado.gif\">";
	
	if ($tarea <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=build&tar=$tarea&cli=$cod&modo=$modo\"><img BORDER=\"0\" src=\"img/relacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}
printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nom_com, $razon_soci, $domicilio, $icono_asignado, $icono_accion
	);
}
}

function ctasignados($tabla,$usuario,$sino,$modo){
echo "<table><tr>
		<th>CODIGO</th>
		<th>DESCRIPCION</th>
		<th>DESC. ADICIONAL</th>
		<th>Asignado</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
$cod=$row["cod_articu"];
$nom_com=$row["descripcio"];
$razon_soci=$row["desc_adic"];

if ($sino == true){
	$icono_asignado="<img BORDER=\"0\"src=\"img/relacionado.gif\">";
	
	if ($usuario <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=break&tar=$cod&cli=$usuario&modo=$modo\"><img BORDER=\"0\" src=\"img/norelacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}else{
	$icono_asignado="<img BORDER=\"0\"src=\"img/norelacionado.gif\">";
	
	if ($usuario <> "TODOS"){
		$icono_accion="<a href=\"".basename($_SERVER['PHP_SELF'])."?relacion=build&tar=$cod&cli=$usuario&modo=$modo\"><img BORDER=\"0\" src=\"img/relacionar.gif\"></a>";
	}else{
		$icono_accion="N/A";
	}
}

printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nom_com, $razon_soci, $icono_asignado, $icono_accion
	);
}
}
?>