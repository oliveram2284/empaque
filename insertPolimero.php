<?php
session_start();
include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$idProveedor     = $_POST['xidProveedor'];
$Lineatura       = $_POST['xLineatura'];
$calidad         = $_POST['xcalidad'];
$poliMedidas     = $_POST['xpoliMedidas'];
$poliColores     = $_POST['xpoliColores'];
$pistas          = $_POST['xpistas'];
$cilindro        = $_POST['xcilindro'];
$camisa          = $_POST['xcamisa'];
$anchoSugerido   = $_POST['xanchoSugerido'];
$AVT             = $_POST['xAVT'];
$diseno          = $_POST['xdiseno'];
$estadoPolPlanta = $_POST['xestadoPolPlanta'];
$reponer         = $_POST['xreponer'];
$muestra         = $_POST['xmuestra'];
$fechaEnt        = $_POST['xfechaEnt'];
$presupuesto     = $_POST['xpresupuesto'];
$disenoBase      = $_POST['xdisenoBase'];
$detallaVend     = $_POST['xdetallaVend'];
$detallaClien    = $_POST['xdetallaClien'];
$detallaGeren    = $_POST['xdetallaGeren'];
$detallaProd     = $_POST['xdetallaProd'];
$detallaImp      = $_POST['xdetallaImp'];
$reunion         = $_POST['xreunion'];
$observaciones   = $_POST['xobservaciones'];
$trabajo         = $_POST['xtrabajo'];
$idPedido        = $_POST['xidPedido'];
$accion          = "AP";
$maquina         = $_POST['xmaquina'];
$espesor         = $_POST['xespesor'];
$actionPolimer   = $_POST['xactionPoli'];
$idPoliNew       = $_POST['xidPolimero'];
$sentido         = $_POST['xsentido'];
$barra           = $_POST['xbarra'];
$codeBar         = $_POST['xcodeBar'];

//Estados
#TP: temporal => utilizado en el primer paso para crear el polímero
#AP: aprobado => utilizado para indicar que el polimero fue aprobado sin modificaciones
#MO: modificado => utilizado para indicar que el polimero fue modificado
#CR: crear  => crear definitivamente el polimer y asociarlo a una orden de trabajo
#RV: Rehacer o Revisar => devolver el pedido y el polimero a la instacia de aprobacion

if($actionPolimer == "TP") //Provisorio y mandar para la aprovacion
    {
        //ver si el polimero no tiene otro polimero ya creado con anterioridad
        $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
        $resu = mysql_query($esta);
        $number = mysql_fetch_array($resu);
        
        if($number[0] == "")
        {
            $insert = "INSERT INTO `polimeros` (`id_polimero`, `id_proveedor`, `colores`, `medidas`, `estado`,";
            $insert.= "`observacion`, `trabajo`, `idMaquina`, `idPedido`, `idEspesor`,";
            $insert.= "`standBy`, `EnFacturacion`, `lineatura`, `calidad`, `pistas`,";
            $insert.= "`cilindro`, `camisa`, `anchoSugerido`, `AVT`, `disenio`,";
            $insert.= "`estadoPolPlanta`, `reponer`, `muestra`, `fechaEnt`, `presupuesto`,";
            $insert.= "`disenioBase`, `detallaVend`, `detallaClien`, `detallaGeren`, `detallaProd`,";
            $insert.= "`detallaImp`, `reunion`, `sentido`, `barra`, `barcode`) VALUES ";
            $insert.= "(NULL, '".$idProveedor."', '".$poliColores."', '".$poliMedidas."', '".$actionPolimer."',";
            $insert.= "'".$observaciones."', '".$trabajo."', '".$maquina."', '".$idPedido."', '".$espesor."',";
            $insert.= "'0', 'N', '".$Lineatura."', '".$calidad."', '".$pistas."',";
            $insert.= "'".$cilindro."', '".$camisa."', '".$anchoSugerido."', '".$AVT."', '".$diseno."',";
            $insert.= "'".$estadoPolPlanta."', '".$reponer."', '".$muestra."', '".$fechaEnt."', '".$presupuesto."', ";
            $insert.= "'".$disenoBase."', '".$detallaVend."', '".$detallaClien."', '".$detallaGeren."', '".$detallaProd."', ";
            $insert.= "'".$detallaImp."', '".$reunion."', ".$sentido.", ".$barra.", ".$codeBar.")";
            
            $resu = mysql_query($insert);
        
            //Estado del polimero
            $idPolimero = mysql_insert_id();
            $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
            $_insert.= "(".$idPolimero.", '".$actionPolimer."', ".$_SESSION['id_usuario'].", 'Enviado para aprob. de borradores', CURRENT_TIMESTAMP( ))";
            $resu = mysql_query($_insert);
        
            $consulta = "Update pedidos Set estado ='AP', fecestadoap = CURDATE(), poliNumero = '".$idPolimero."' Where npedido=$idPedido";
            $resu = mysql_query($consulta);
        
            
        }
        else
        {
            //Update del Polimero ya creado antes
            $update = "Update `polimeros` set ";
            $update.= "`id_proveedor` = '".$idProveedor."', `colores` = '".$poliColores."', `medidas` = '".$poliMedidas."', `estado` = '".$actionPolimer."',";
            $update.= "`observacion` = '".$observaciones."', `trabajo` = '".$trabajo."', `idMaquina` = '".$maquina."', `idEspesor` = '".$espesor."',";
            $update.= "`standBy` = '0', `EnFacturacion` = 'N', `lineatura` = '".$Lineatura."', `calidad` = '".$calidad."', `pistas` = '".$pistas."',";
            $update.= "`cilindro` = '".$cilindro."', `camisa` = '".$camisa."', `anchoSugerido` = '".$anchoSugerido."', `AVT` = '".$AVT."', `disenio` = '".$diseno."',";
            $update.= "`estadoPolPlanta` = '".$estadoPolPlanta."', `reponer` = '".$reponer."', `muestra` = '".$muestra."', `fechaEnt` = '".$fechaEnt."', `presupuesto` = '".$presupuesto."',";
            $update.= "`disenioBase` = '".$disenoBase."', `detallaVend` = '".$detallaVend."', `detallaClien` = '".$detallaClien."', `detallaGeren` = '".$detallaGeren."', `detallaProd` = '".$detallaProd."',";
            $update.= "`detallaImp` = '".$detallaImp."', `reunion` = '".$reunion."', `sentido` = ".$sentido.", `barra` = ".$barra.", `barcode` = ".$codeBar." ";
            $update.= "Where id_Polimero = ".$number[0];
            
            $resu = mysql_query($update);
            //-----------------------------------
            
            //Estado del polimero
            $idPolimero = mysql_insert_id();
            $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
            $_insert.= "(".$number[0].", '".$actionPolimer."', ".$_SESSION['id_usuario'].", 'Enviado para aprob. de borradores', CURRENT_TIMESTAMP( ))";
            $resu = mysql_query($_insert);
            
            $consulta = "Update pedidos Set estado ='AP', fecestadoap = CURDATE(), poliNumero = '".$number[0]."' Where npedido=$idPedido";
            $resu = mysql_query($consulta);
        }
        
        reg_log($idPedido, "AP");
    }

if($actionPolimer == 'AP')
    {
        
        if($idPoliNew != 0)
        {
            //actualizar estado de polimero
            $update = "Update polimeros set estado = 'AP' Where id_Polimero = ".$idPoliNew;
            $resu = mysql_query($update);
            
            //reg log polimero sin modificar
            $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
            $_insert.= "(".$idPoliNew .", '".$actionPolimer."', ".$_SESSION['id_usuario'].", 'Aprobación Polimero Provisorio', CURRENT_TIMESTAMP( ))";
            $resu = mysql_query($_insert);
            
            //actualizar estado de pedido
            $consulta = "Update pedidos Set estado ='SI' Where npedido=$idPedido";
            $resu = mysql_query($consulta);
            
            //reg log pedido
            reg_log($idPedido, "SI");
        }
        
    }
    
if($actionPolimer == 'MO' || $actionPolimer == 'RV')
    {
        if($idPoliNew != 0)
        {
            $update = "Update
                            polimeros
                       set
                            id_proveedor    = '".$idProveedor."',
                            colores         = '".$poliColores."',
                            medidas         = '".$poliMedidas."',
                            estado          = '".$actionPolimer."',
                            observacion     = '".$observaciones."',
                            trabajo         = '".$trabajo."',
                            idMaquina       = '".$maquina."',
                            idPedido        = '".$idPedido."',
                            idEspesor       = '".$espesor."',
                            standBy         = '0',
                            EnFacturacion   = 'N',
                            lineatura       = '".$Lineatura."',
                            calidad         = '".$calidad."',
                            pistas          = '".$pistas."',
                            cilindro        = '".$cilindro."',
                            camisa          = '".$camisa."',
                            anchoSugerido   = '".$anchoSugerido."',
                            AVT             = '".$AVT."',
                            disenio         = '".$diseno."',
                            estadoPolPlanta = '".$estadoPolPlanta."',
                            reponer         = '".$reponer."',
                            muestra         = '".$muestra."',
                            fechaEnt        = '".$fechaEnt."',
                            presupuesto     = '".$presupuesto."',
                            disenioBase     = '".$disenoBase."',
                            detallaVend     = '".$detallaVend."',
                            detallaClien    = '".$detallaClien."',
                            detallaGeren    = '".$detallaGeren."',
                            detallaProd     = '".$detallaProd."',
                            detallaImp      = '".$detallaImp."',
                            reunion         = '".$reunion."',
                            sentido         = ".$sentido.",
                            barra           = ".$barra.",
                            barcode         = ".$codeBar." 
                       Where
                            id_Polimero = ".$idPoliNew;
            $resu = mysql_query($update);
            
            //reg log polimero sin modificar
            $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
            $_insert.= "(".$idPoliNew .", '".$actionPolimer."', ".$_SESSION['id_usuario'].", 'Modificación Polimero Provisorio', CURRENT_TIMESTAMP( ))";
            $resu = mysql_query($_insert);
            
            //actualizar estado de pedido
            $consulta = "Update pedidos Set estado = '".$actionPolimer."' Where npedido = $idPedido";
            $resu = mysql_query($consulta);
            
            //reg log pedido
            reg_log($idPedido, "".$actionPolimer."");
        }
    }
    
    if( $actionPolimer == 'CR')
    {
        //obtener numeracion para la ot
        $otQuery = "select numNumeracion from tbl_numeraciones Where numCodigo = 'ORT'";
        $resu_ot = mysql_query($otQuery);
        $canti = mysql_fetch_array($resu_ot);
        
        $otNumber = str_pad($canti[0], 6, "000000", STR_PAD_LEFT);
        
        $co = "Update tbl_numeraciones set numNumeracion = ".($canti[0] + 1)." Where numCodigo = 'ORT'";
        $resu = mysql_query($co);
        
        //actualizar estado de polimero
        $update = "Update polimeros set estado = 'A', ordenDeTrabajo = '".$otNumber."', enFacturacion = 'F' Where id_Polimero = ".$idPoliNew;
        $resu = mysql_query($update);
        
        //Estado del polimero
        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
        $_insert.= "(".$idPoliNew.", 'A', ".$_SESSION['id_usuario'].", 'Creación de Polimero', CURRENT_TIMESTAMP( ))";
        $resu = mysql_query($_insert);
        
        //-------------
        $consulta = "Update pedidos Set estado ='CA', calidad = 'CA' , faprob=CURDATE(), poliNumero = $idPoliNew Where npedido = $idPedido";
        $resu = mysql_query($consulta);
        //-------------
        
        $st = "";
	$get  = "Select seCargoHRCI From pedidos Where npedido = ".$idPedido;
	$getR = mysql_query($get) or die(mysql_error());
	
	if(mysql_num_rows($getR) >= 0)
	{
	    while($getRow= mysql_fetch_array($getR))
	    {
		if($getRow[0] == 1)
		{ $st = "U"; }
		else
		{ $st = "P"; }
	    }
	}
	else{ $st = "P"; }
	
	$update = "Update pedidos Set estado = '".$st."' Where  npedido = ".$idPedido;
        $resu = mysql_query($update);
	
        reg_log($idPedido, $st);
        
        //reg_log($idPedido, 'CA');
        
        echo json_encode($otNumber);
    }

    
    function reg_log($idPedido, $estado )
    {
        $idUsuario = $_SESSION['id_usuario'];
        
        $sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
        $sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.")";
        $resu = mysql_query($sql)or die(mysql_error());
    }

?>