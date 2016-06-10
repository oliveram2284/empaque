<?php

include "class.db.php";

function _select_tipo_entrega()
{
	$odb= new db();
	$sql="select *  from tipo_entrega order by descripcion ";
	
	$res= $odb->query($sql);
		
	echo '	<select id="selecEntrega" name="selecEntrega" class="top"  >';
	echo"<option value='0'>Tipo de Entregas</option> ";
	while($row = mysql_fetch_array($res))
		{  
		echo"<option value=' ".$row[0]."'>".$row[1]."</option> ";
		}
	echo '</select>';
}

function _select_estado()
{
	$odb= new db();
	$sql="select *  from tipo_estado order by descripcion ";
	
	$res= $odb->query($sql);
		
	echo '	<select id="selectEstado" name="selectEstado" class="top"  >';
	echo"<option value='0'>Tipo de Estado</option> ";
	while($row = mysql_fetch_array($res))
		{  
		echo"<option value=' ".$row[0]."'>".$row[1]."</option> ";
		}
	echo '</select>';
}

function _select_destino()
{
	$odb= new db();
	$sql="select *  from destino order by descripcion	 ";
	
	$res= $odb->query($sql);
		
	echo '	<select id="selecDestino" name="selecDestino" class="top">';
	echo"<option value='0'>Destino de Entrega</option> ";
	while($row = mysql_fetch_array($res))
		{  
		echo"<option value=' ".$row[0]."'>".$row[1]."</option> ";
		}
	echo '</select>';
}
function _select_vendedor()
{
	$odb= new db();
	$sql="select *  from vendedor order by apellido asc, nombre ";
	
	$res= $odb->query($sql);
		
	echo '	<select id="selecvendedor" name="selecvendedor" class="top">';
	echo"<option value='0'>Vendedor</option> ";
	while($row = mysql_fetch_array($res))
		{  
		echo"<option value=' ".$row[0]."'>".$row[1]." </option> ";
		}
	echo '</select>';
}

function _select_transporte()
{
	$odb= new db();
	$sql="select *  from transportes order by codigo asc, razon_social asc ";
	
	$res= $odb->query($sql);
		
	echo '	<select id="selectransporte" name="selectransporte" class="top">';
	echo"<option value='0'>Transporte</option> ";
	while($row = mysql_fetch_array($res))
		{  
		echo"<option value=' ".$row[0]."'>".$row[2]." </option> ";
		}
	echo '</select>';
}

function _select_respo_exp()
{
  $odb= new db();
  $sql="select * from  usuarios order by nombre asc, nombre_real; ";
  
  $res= $odb->query($sql);
    
  echo '  <select id="selecrespexp" name="selecrespexp" class="top">';
  echo"<option value='0'>Responsables Expo...</option> ";
  while($row = mysql_fetch_array($res))
    {  
    echo"<option value=' ".$row[0]."'>".$row[2]." </option> ";
    }
  echo '</select>';
}



?>