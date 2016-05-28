<?php
function listausuarios($tabla){

echo "<table><tr>
		<th>CODIGO</th>
		<th>NOMBRE</th>
		<th>USUARIO</th>
		<th>EMPRESA</th>
		<th>CATEGORIA</th>
		<th>AREA</th>
		<th>Modificar</th>
		<th>Situaci&oacute;n</th>
		<th>Eliminar</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$usuario=$row["usuario"];
$empresa=$row["empresa"];
$categoria=$row["categoria"];
$area=$row["area"];



if ($usuario != "admin"){
$icono_modif="<a href=\"modifusuario.php?personal=$cod\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_situac="<a href=\"cambioseac.php?personal=$cod\"><img BORDER=\"0\"src=\"img/situac.png\"></a>";
$icono_borrar="<a href=\"modifusuario.php?personal=$cod&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";
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
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nombre, $usuario, $empresa, $categoria, $area, $icono_modif, $icono_situac, $icono_borrar
	);
}
}

function listausuariossimp($tabla){

echo "<table><tr>
		<th>CODIGO</th>
		<th>NOMBRE</th>
		<th>USUARIO</th>
		<th>EMPRESA</th>
		<th>CATEGORIA</th>
		<th>AREA</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$usuario=$row["usuario"];
$empresa=$row["empresa"];
$categoria=$row["categoria"];
$area=$row["area"];

printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
	</tr>",
	$cod, $nombre, $usuario, $empresa, $categoria, $area 
	);
}
}

function listacategorias($tabla){
echo '<tr>
		<th>CODIGO</th>
		<th>NOMBRE</th>
		<th>FACTOR</th>
		<th>Modificar</th>
		<th>Eliminar</th>
	</tr>';
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$factorconv=$row["factorconv"];
$icono_modif="<a href=\"modifcategoria.php?categoria=$cod\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_borrar="<a href=\"modifcategoria.php?categoria=$cod&nom=$nombre&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
	</tr>",
	$cod, $nombre, $factorconv, $icono_modif, $icono_borrar
	);
}
}
function listaareas($tabla){
echo '<tr>
		<th>CODIGO</td>
		<th>NOMBRE</td>
		<th>Modificar</td>
		<th>Eliminar</td>
	</tr>';
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$icono_modif="<a href=\"modifarea.php?area=$cod\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_borrar="<a href=\"modifarea.php?area=$cod&nom=$nombre&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>%s</td>
		<td>%s</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nombre, $icono_modif, $icono_borrar
	);
}

}
function listaempresas($tabla){
echo '<tr>
		<th>CODIGO</td>
		<th>NOMBRE</td>
		<th>Modificar</td>
		<th>Eliminar</td>
	</tr>';
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["codigo"];
$nombre=$row["nombre"];
$icono_modif="<a href=\"modifempresa.php?empresa=$cod\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_borrar="<a href=\"modifempresa.php?empresa=$cod&nom=$nombre&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>%s</td>
		<td>%s</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		
	</tr>",
	$cod, $nombre, $icono_modif, $icono_borrar
	);
}

}
function listaclientes($tabla){
echo "<tr>
		<th>CODIGO</th>
		<th>NOMBRE COMERCIAL</th>
		<th>RAZON SOCIAL</th>
		<th>DOMICILIO</th>
		<th>LOCALIDAD</th>
		<th>TELEFONO</th>
		<th>E-MAIL</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["cod_client"];
$nom_com=$row["nom_com"];
$razon_soci=$row["razon_soci"];
$domicilio=$row["domicilio"];
$localidad=$row["localidad"];
$telefono=$row["telefono"];
$e_mail=$row["e_mail"];

printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		
	</tr>",
	$cod, $nom_com, $razon_soci, $domicilio, $localidad, $telefono, $e_mail 
	);
}
}
function listaproductos($tabla){

echo "<tr>
		<th>CODIGO</th>
		<th>DESCRIPCION</th>
		<th>DESCRIPCION ADICIONAL</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["cod_articu"];
$desc_adic=$row["desc_adic"];
$descripcio=$row["descripcio"];

/*$icono_modif="<a href=\"modifusuario.php?personal=$cod\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";*/


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		
	</tr>",
	$cod, $descripcio, $desc_adic 
	);
}

}

function listahoraspropias($tabla){
include ("lib/functions.php");
echo "<tr>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=fecha'\">FECHA<br><a href=\"zlistahoraspropias.php?orden=fecha&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahoraspropias.php?orden=fecha&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
				
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=cliente'\">CLIENTE<br><a href=\"zlistahoraspropias.php?orden=cliente&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahoraspropias.php?orden=cliente&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th style=\"width:105px;\" onclick=\"parent.location='zlistahoraspropias.php?orden=cliente'\">CLIENTE_Nom<br><a href=\"zlistahoraspropias.php?orden=nom_com&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahoraspropias.php?orden=nom_com&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=horas'\">HORAS<br><a href=\"zlistahoraspropias.php?orden=horas&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahoraspropias.php?orden=horas&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=tarea'\">TAREA<br><a href=\"zlistahoraspropias.php?orden=tarea&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahoraspropias.php?orden=tarea&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		
		<th>OBSERVACIONES</th>
		
		<th onclick=\"parent.location='zlistahoraspropias.php?orden=aprobado'\">Aprobado<br><a href=\"zlistahoraspropias.php?orden=aprobado&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahoraspropias.php?orden=aprobado&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		
		<th>Modificar</th>
		<th>Eliminar</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$id =  $row["id"];
$fecha = fechademysql($row["fecha"]);
$cliente = $row["cliente"];
$nom_com = substr($row["nom_com"],0,15);
$horas = $row["horas"];
$acumulador = $acumulador + $horas;
$obs = $row["obs"];
$tarea = $row["tarea"];
$aprobado = $row["aprobado"];
if ($aprobado){
$icono_modif="<a href=\"zmodifhoraspropias.php?id=$id&aprobado=t\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_aprobado="<img BORDER=\"0\"src=\"img/check.png\">";
$icono_borrar="<img BORDER=\"0\"src=\"img/borrar-d.png\">";
}else{
$icono_modif="<a href=\"zmodifhoraspropias.php?id=$id\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_aprobado="<img BORDER=\"0\"src=\"img/enespera.gif\">";
$icono_borrar="<a href=\"zmodifhoraspropias.php?id=$id&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";
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
		<td id=\"columnagraf\">%s</td>
	</tr>",
	$fecha, $cliente, $nom_com, $horas, $tarea, $obs, $icono_aprobado, $icono_modif, $icono_borrar
	);

}
echo "<tr>
<th colspan='9'>&nbsp;</th></tr>
<tr>
<td colspan='3' bgcolor='#ffe0bb'><center>TOTAL DE HORAS</center></td><td colspan='6'>".$acumulador."</td></tr>";
}

function listahorasterceros($tabla){
include ("lib/functions.php");

echo "<tr>
		<th onclick=\"parent.location='zlistahorasterceros.php?orden=fecha'\">FECHA<br><a href=\"zlistahorasterceros.php?orden=fecha&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahorasterceros.php?orden=fecha&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
				
		<th onclick=\"parent.location='zlistahorasterceros.php?orden=cliente'\">CLIENTE<br><a href=\"zlistahorasterceros.php?orden=cliente&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahorasterceros.php?orden=cliente&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th style=\"width:105px;\" onclick=\"parent.location='zlistahorasterceros.php?orden=cliente'\">CLIENTE_Nom<br><a href=\"zlistahorasterceros.php?orden=nom_com&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahorasterceros.php?orden=nom_com&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th onclick=\"parent.location='zlistahorasterceros.php?orden=horas'\">HORAS<br><a href=\"zlistahorasterceros.php?orden=horas&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahorasterceros.php?orden=horas&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th onclick=\"parent.location='zlistahorasterceros.php?orden=tarea'\">TAREA<br><a href=\"zlistahorasterceros.php?orden=tarea&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahorasterceros.php?orden=tarea&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		
		<th>OBSERVACIONES</th>
		
		<th onclick=\"parent.location='zlistahorasterceros.php?orden=aprobado'\">Aprobado<br><a href=\"zlistahorasterceros.php?orden=aprobado&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zlistahorasterceros.php?orden=aprobado&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th>Modificar</th>
		<th>Eliminar</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$id =  $row["id"];
$fecha = fechademysql($row["fecha"]);
$cliente = $row["cliente"];
$nom_com = substr($row["nom_com"],0,15);
$horas = $row["horas"];
$acumulador = $acumulador + $horas;
$obs = $row["obs"];
$tarea = $row["tarea"];
$aprobado = $row["aprobado"];
if ($aprobado){
$icono_aprobado="<img BORDER=\"0\"src=\"img/check.png\">";
$icono_borrar="<img BORDER=\"0\"src=\"img/borrar-d.png\">";
$icono_modif="<a href=\"zmodifhorasterceros.php?id=$id&aprobado=t\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
}else{
$icono_aprobado="<img BORDER=\"0\"src=\"img/enespera.gif\">";
$icono_borrar="<a href=\"zmodifhorasterceros.php?id=$id&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";
$icono_modif="<a href=\"zmodifhorasterceros.php?id=$id&\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
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
		<td id=\"columnagraf\">%s</td>
	</tr>",
	$fecha, $cliente, $nom_com, $horas, $tarea, $obs, $icono_aprobado, $icono_modif, $icono_borrar
	);
}
echo "<tr>
<th colspan='9'>&nbsp;</th></tr>
<tr>
<td colspan='3' bgcolor='#ffe0bb'><center>TOTAL DE HORAS</center></td><td colspan='6'>".$acumulador."</td></tr>";
}

function zaprobarhoras($tabla){
include ("lib/functions.php");

echo "<tr>
		<th onclick=\"parent.location='zaprobarhoras.php?orden=fecha'\">FECHA<br><a href=\"zaprobarhoras.php?orden=fecha&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zaprobarhoras.php?orden=fecha&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th onclick=\"parent.location='zaprobarhoras.php?orden=cliente'\">CLIENTE<br><a href=\"zaprobarhoras.php?orden=cliente&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zaprobarhoras.php?orden=cliente&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th style=\"width:135px;\" onclick=\"parent.location='zaprobarhoras.php?orden=cliente'\">CLIENTE_Nom<br><a href=\"zaprobarhoras.php?orden=nom_com&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zaprobarhoras.php?orden=nom_com&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th onclick=\"parent.location='zaprobarhoras.php?orden=horas'\">HORAS<br><a href=\"zaprobarhoras.php?orden=horas&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zaprobarhoras.php?orden=horas&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th>EQUIVAL.</th>
		<th onclick=\"parent.location='zaprobarhoras.php?orden=tarea'\">TAREA<br><a href=\"zaprobarhoras.php?orden=tarea&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zaprobarhoras.php?orden=tarea&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th>OBSERVACIONES</th>
		<th onclick=\"parent.location='zaprobarhoras.php?orden=aprobado'\">Aprobado<br><a href=\"zaprobarhoras.php?orden=aprobado&sent=DESC\"><img border=\"0\" src=\"img/downarrow-1.png\"></a><a href=\"zaprobarhoras.php?orden=aprobado&sent=ASC\"><img border=\"0\" src=\"img/uparrow-1.png\"></a></th>
		<th>Modificar</th>
		<th>Eliminar</th>
		<th>ACCION</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$id =  $row["id"];
$fecha = fechademysql($row["fecha"]);
$cliente = $row["cliente"];
$nom_com = substr($row["nom_com"],0,15);
$horas = $row["horas"];
$acumulador = $acumulador + $horas;
$equivalentes = $row["equivalentes"];
$tarea = $row["tarea"];
$obs = $row["obs"];
$aprobado = $row["aprobado"];
$icono_modif="<a href=\"zmodifhorasterceros.php?id=$id\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_borrar="<a href=\"zmodifhorasterceros.php?id=$id&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";
if ($aprobado){
$icono_aprobado="<img BORDER=\"0\"src=\"img/check.png\">";
$boton_aprobar ="<a href=\"zaprobarhoras.php?id=$id&anular=1\"><img BORDER=\"0\"src=\"img/anular.gif\"></a>";
}else{
$icono_aprobado="<img BORDER=\"0\"src=\"img/enespera.gif\">";
$boton_aprobar ="<a href=\"zaprobarhoras.php?id=$id&aprobar=1\"><img BORDER=\"0\"src=\"img/aprobar.gif\"></a>";
}


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
	</tr>",
	$fecha, $cliente, $nom_com, $horas, $equivalentes, $tarea, $obs, $icono_aprobado, $icono_modif, $icono_borrar, $boton_aprobar
	);
}
echo "<tr>
<th colspan='11'>&nbsp;</th></tr>
<tr>
<td colspan='3' bgcolor='#ffe0bb'><center>TOTAL DE HORAS</center></td><td colspan='8'>".$acumulador."</td></tr>";

}

function imputables($tabla){

echo "<tr>
		<th>CODIGO</th>
		<th>NOMBRE COMERCIAL</th>
		<th>RAZON SOCIAL</th>
		<th>OBSERVACIONES</th>
		<th>Imputable</th>
		<th>Modificar</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod_client =  $row["cod_client"];
$nom_com = $row["nom_com"];
$razon_soci = $row["razon_soci"];
$observacio = $row["observacio"];
$obs = $row["obs"];
$close = $row["close"];
$icono_modif="<a href=\"imputables.php?id=$id\"><img BORDER=\"0\"src=\"img/modificar.png\"></a>";
$icono_borrar="<a href=\"imputables.php?id=$id&borrar=1\"><img BORDER=\"0\"src=\"img/borrar.png\"></a>";
if ($close==1){
$icono_aprobado="<img BORDER=\"0\"src=\"img/aprobar2.gif\">";
$boton_aprobar ="<a href=\"imputables.php?cod_client=$cod_client&anular=1\"><img BORDER=\"0\"src=\"img/anular.gif\"></a>";
}else{
$icono_aprobado="<img BORDER=\"0\"src=\"img/anular2.gif\">";
$boton_aprobar ="<a href=\"imputables.php?cod_client=$cod_client&aprobar=1\"><img BORDER=\"0\"src=\"img/aprobar.gif\"></a>";
}


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td id=\"columnagraf\">%s</td>
		<td id=\"columnagraf\">%s</td>
	</tr>",
	$cod_client, $nom_com, $razon_soci, $observacio, $icono_aprobado, $boton_aprobar
	);
}
}
function listahistorico($tabla){

echo "<table><tr>
		<th>FDCARGO</th>
		<th>EMPRESA</th>
		<th>CATEGORIA</th>
		<th>AREA</th>
		<th>FHCARGO</th>
	</tr>";
while($row = mysql_fetch_array($tabla)){
$web="./usuarios=";
//$reimp=".reimprimir_ingreso.php?service=$ID";
$cod=$row["codigo"];
$fdcargo=fechademysql($row["fdcargo"]);
$fhcargo=fechademysql($row["fhcargo"]);
$empresa=$row["empresa"];
$categoria=$row["categoria"];
$area=$row["area"];


printf("<tr onMouseOver=\"this.bgColor = '#C0C0C0'\" onMouseOut =\"this.bgColor = '#FFFFFF'\" bgcolor=\"#FFFFFF\">
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		<td>&nbsp;%s &nbsp</td>
		
	</tr>",
	$fdcargo, $empresa, $categoria, $area, $fhcargo
	);
}
}

?>