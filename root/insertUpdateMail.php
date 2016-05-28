<?php
include("conexion.php");

$var = new conexion();
$var->conectarse();

$valores = $_POST['xid'];


//id
$id = $valores[0];
//mail
$mail = $valores[1];
//enviaProtocolo
$protocolo = $valores[2];
//accion
$act = $valores[3];

if($act == 'Del')
{
	//Delete
	$sql = 'Delete from mails Where idMail = '.$id;
	$resu = mysql_query($sql) or die(mysql_error());
}
else
{
	if($id == 0)
	{
	    //Insert
	    $sql  = "Insert Into mails (mail, protocolo) Values ";
	    $sql .= "('".$mail."',".$protocolo.")";
	    $resu = mysql_query($sql) or die(mysql_error());

	}
	else
	{
	    //Modificar
	    $sql = "Update mails ";
	    $sql.= "set mail = '".$mail."', protocolo = ".$protocolo." ";
	    $sql.= "Where idMail = ".$id;
	    $resu = mysql_query($sql) or die(mysql_error());
	    
	}
}

echo json_encode(0);
?>