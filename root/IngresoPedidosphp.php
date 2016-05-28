<?php
session_start();

include("conexion.php");
$var = new conexion();
$var->conectarse();

$values = $_POST['xid'];
$keys	= $_POST['xval'];

$indice  = 0;
foreach($keys as $k)
{
	switch($k)
	{
		case "codigoTango":
			$codCliente = $value[$indice];
			$indice++;
			break;
		
		case "nombreProducto"
	}
	echo $k."<br>";
}
///*
//if(!isset($_GET['hojaRuta']) && !isset($_GET['bulto']))
//{
//	$nombre = substr($_SESSION['Nombre'], 0, 2);
//	
//	//codigo
//	//$consulta = "SELECT Max( substr( codigo, 4, 4 ) ) from pedidos Where codigo like'%".$nombre."%'";
//	$consulta = "SELECT Max( substr( codigo, 4, 4 ) ) from pedidos Where codigo REGEXP '^".$nombre."'";
//	
//	$resu = mysql_query($consulta);
//	$canti = mysql_fetch_array($resu);
//	
//	$cantidad = str_pad($canti[0] + 1, 4, "0000", STR_PAD_LEFT);
//	$numPedido = $nombre."-".$cantidad."-".date("y");
//	
//	
//	//clienteFac
//	$codCliente = $_POST['codigoTango'];
//	
//	//facturarA
//	$facturar = $_POST['codigoTangoFacturar'];
//	
//	//caras
//	$cara = $_POST['caras'];
//	
//	//fecharecep
//	$fecha = date("Y-m-d");
//	
//	//fechaAp
//	$fAprob = "Pendiente";
//	
//	//entrega
//	$fEntreg = "Pendiente";
//	
//	//emision 
//	$fEmis = "Pendiente";
//	
//	//centrada
//	$centrada = $_POST['centrada'];
//	
//	//apaisada
//	$apaisada = $_POST['tipo'];
//	
//	//producto
//	$arti = $_POST['arti'];
//	
//		//descripcion
//		$descripcion = $_POST['nombreProducto'];
//		
//		//codigo mercedario
//		$codigoMercedario = $_POST['descripcionProducto'];
//		
//	if($arti == "si")
//		{
//			$consulta = "select numNumeracion from tbl_numeraciones Where numCodigo = 'ORP'";
//			$resu = mysql_query($consulta);
//			$canti = mysql_fetch_array($resu);
//			
//			$cantidad = str_pad($canti[0], 6, "n00000", STR_PAD_LEFT);
//			
//			$producto = $cantidad;
//			
//			$consulta = "Insert Into articulos (Id,Articulo) Values ('$cantidad','$descripcion')";
//			$resu = mysql_query($consulta) or die(mysql_error());
//			
//			$consulta = "Update tbl_numeraciones
//				     set numNumeracion = ".($canti[0] + 1)."
//				     Where numCodigo = 'ORP'";
//			$resu = mysql_query($consulta);
//		}
//		else
//			{
//			 $producto = $_POST['codigoProducto'];
//			}
//	
//	//accion 
//	$accion = $_POST['accionPedido'];
//	
//	//id pedido
//	$id = $_POST['idPedido'];
//	
//	//lugar entrega 
//	$destino = $_POST['lugarEntrega'];
//	
//	//--------------------------detalle de pedido------------------  
//	$cantidadTotal = $_POST['cantidad'];
//	$precioPolimeros = isset($_POST['precioPoli']) ? $_POST['precioPoli']:"";
//	$unidad = $_POST['unidades'];
//	$formato = $_POST['formato'];
//	$material = $_POST['material'];
//	if($material == 1 || $material == 2)
//		{
//			 $Bi1 = isset($_POST['Bilaminado1']) ? $_POST['Bilaminado1']:0;
//			 $Bi2 = isset($_POST['Bilaminado2']) ? $_POST['Bilaminado2']:0;
//			 $Ma1 = isset($_POST['Material1']) ? $_POST['Material1']:0;
//			 $Ma2 = isset($_POST['Material2']) ? $_POST['Material2']:0;
//			 $Mi1 = isset($_POST['Micronaje1']) ? $_POST['Micronaje1']:"-";
//			 $Mi2 = isset($_POST['Micronaje2']) ? $_POST['Micronaje2']:"-";
//			 
//			 if($material == 2)
//				{
//				 $Tri = isset($_POST['Trilaminado']) ? $_POST['Trilaminado']:0;
//				 $Ma3 = isset($_POST['Material3']) ? $_POST['Material3']:0;
//				 $Mi3 = isset($_POST['Micronaje3']) ? $_POST['Micronaje3']:"-";
//				}else
//					{
//						 $Tri = 0;
//						 $Ma3 = 0;
//						 $Mi3 = "";
//					}
//		}else
//			{
//			 $Bi1 = 0;
//			 $Bi2 = 0;
//			 $Tri = 0;
//			 $Ma1 = 0;
//			 $Ma2 = 0;
//			 $Ma3 = 0;
//			 $Mi1 = "";
//			 $Mi2 = "";
//			 $Mi3 = "";	
//			}
//	$colorMaterial = $_POST['color'];
//	$moneda = $_POST['moneda'];
//	$precioImporte = $_POST['precio'];
//	$IVA = $_POST['condicionPago'];
//	$bobinado = isset($_POST['bobinado']) ? $_POST['bobinado'] : "2"; //pie o cabeza
//	$bobinadoFuera = isset($_POST['fuera']) ? $_POST['fuera'] : "2"; //adentro o afuera
//	$termo = isset($_POST['termo']) ? 1 : 0;
//	$microp = isset($_POST['micro']) ? 1 : 0;
//	$fecha1 = $_POST['fecha1'];
//	$cantidad1 = $_POST['cantidad1'];
//	$distanciaTaco = isset($_POST['distancia']) ? $_POST['distancia']: "";
//	$diametroBobina = isset($_POST['bobina']) ? $_POST['bobina']: "";
//	$diametroCanuto = isset($_POST['canuto']) ? $_POST['canuto']: "";
//	$kgBobina = isset($_POST['kgBobina']) ? $_POST['kgBobina']: "";
//	$mtsBobina = isset($_POST['mtsBobina']) ? $_POST['mtsBobina']: "";
//	$ancho = $_POST['ancho'];
//	$largo = $_POST['largo'];
//	$micronaje = $_POST['micronaje'];
//	$fuelle = $_POST['fuelle'];
//	$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones']: "";
//	$vendedor = $_SESSION['id_usuario'];
//	
//	//determinar los valores para las columnas a sumar las cantidades
//	if($accion == "T" || $accion == "TP" || $accion == "ET")
//		{
//			//cantidad 
//			$cantidad = $_POST['ingresoCantidad'] + $_POST['actualCantidad'];
//			//Bultos
//			$bultos = $_POST['ingresoBultos'] + $_POST['actualBultos'];
//			//Kilos
//			$kilos = $_POST['ingresoKilos'] + $_POST['actualKilos'];
//		}
//}
//else
//{
//	$accion = $_GET['accion'];
//	$id = $_GET['id'];
//	$fecha = date("Y-m-d");
//	
//	if($accion != "T" && $accion != "TP")
//	{
//		$hoja = $_GET['hojaRuta'];
//	}
//	else
//	{
//		$cant = $_GET['cantidad'];
//		$bul = $_GET['bulto'];
//		$kg = $_GET['kg'];
//	}
//	
//	if($accion == "UA")
//	{
//		$articulo = $_GET['arti'];
//	}
//}
//
//switch($accion)
//	{
//	 case "I":
//			$consulta = "Insert Into pedidos (codigo, entrega, femis, faprob, frecep, descrip3, caras, centrada, apaisada, clientefact, facturarA, destino, descripcion, codigoTango) Values";
//			$consulta .= "('".$numPedido."','".$fEntreg."','".$fecha."','".$fAprob."','".$fEmis."','".$producto."','".$cara."',$centrada,$apaisada,'".$codCliente."','".$facturar."','".$destino."', '".$descripcion."', '".$codigoMercedario."')";
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			$consulta = "Select max(npedido) from pedidos";
//			$resu = mysql_query($consulta);
//			$row = mysql_fetch_array($resu);
//			
//			$idPedido = $row[0];
//
//			$consulta = "Insert Into pedidosdetalle (idPedido,CantidadTotal,PrecioPolimeros,Unidad,Formato,Material,ColorMaterial,";
//			$consulta .= "Moneda,PrecioImporte,IVA,Bobinado,BobinadoFuera,Termo,Micro,Fecha1,Cantidad1,";
//		    $consulta .= "DistanciaTaco,DiametroBobina,DiametroCanuto,KgBobina,MtsBobina,Ancho,Largo,Micronaje,Fuelle,Obseervaciones,";
//			$consulta .= "Bilaminado1,Bilaminado2,Trilaminado,Material1,Material2,Material3,Micronaje1,Micronaje2,Micronaje3, Vendedor)";
//			$consulta .= "Values(".$idPedido.",".$cantidadTotal.",'".$precioPolimeros."',".$unidad.",".$formato.",".$material.",'".$colorMaterial."',";
//			$consulta .= $moneda.",'".$precioImporte."',".$IVA.",".$bobinado.",".$bobinadoFuera.",".$termo.",".$microp.",'".$fecha1."',".$cantidad1.",";
//			$consulta .= "'".$distanciaTaco."','".$diametroBobina."','".$diametroCanuto."',";
//			$consulta .= "'".$kgBobina."','".$mtsBobina."','".$ancho."','".$largo."','".$micronaje."','".$fuelle."','".$observaciones."',";
//			$consulta .= "$Bi1,$Bi2,$Tri,$Ma1,$Ma2,$Ma3,'".$Mi1."','".$Mi2."','".$Mi3."',".$vendedor.")";
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($idPedido, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Ingresado.");location.href="principal.php";</script>';
//			break;
//	 case "A":
//	 		//modificar encabezado de pedido
//	        $consulta = "Update pedidos Set estado ='A',frecep='".$fecha."', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."' Where npedido=$id";
//			$resu = mysql_query($consulta)or die (mysql_error());
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= " DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."'Where idPedido=$id";
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Recibido.");location.href="principal.php";</script>';
//			break;
//	 case "P":
//	 		//modificar encabezado de pedido
//			if( $producto[0] == "n")
//			{
//				//Preguntar Si tiene impresion o No
//				if($cara == "0")
//				{
//					$estado = "P";
//					$consulta = "Update pedidos Set estado ='".$estado."',faprob='".$fecha."', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."',caras='".$cara."', centrada=$centrada,";
//				}
//				else
//				{
//					$estado = "N";
//					$consulta = "Update pedidos Set estado ='".$estado."',fecdisenio='".$fecha."', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."', caras='".$cara."', centrada=$centrada,";
//				}
//				
//			}
//			else
//			{
//				$estado = "P";
//				$consulta = "Update pedidos Set estado ='".$estado."',faprob='".$fecha."', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."', caras='".$cara."', centrada=$centrada,";
//			}
//			
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."' Where npedido=$id";
//			$resu = mysql_query($consulta)or die (mysql_error());
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= " DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."'Where idPedido=$id";
//			
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $estado);
//			
//			if( $estado == "N")
//			{
//				echo '<script>alert("Pedido pasado a estado de Diseño.");location.href="principal.php";</script>';
//			}
//			else
//			{
//				echo '<script>alert("Pedido pasado a estado de Producción.");location.href="principal.php";</script>';
//			}
//			break;
//	 case "V":
//	 		//modificar encabezado de pedido
//	        $consulta = "Update pedidos Set estado ='V',faprob= '".$fecha."', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."' Where npedido=$id";
//			$resu = mysql_query($consulta)or die (mysql_error());
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= "DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."'Where idPedido=$id";
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Aprobado.");location.href="principal.php";</script>';
//			break;
//	 case "T":
//			/*
//			$consulta = "Update pedidos Set estado ='T', clientefact='".$codCliente."', descrip3='".$producto."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."', cantidad_entregadas=".$cantidad." , kg_entregados=".$kilos.", bultos_entregados=".$bultos." Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= "DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."' Where idPedido=$id";
//			*/
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			
//			$consulta = "Update pedidos Set estado ='T',cantidad_entregadas = (cantidad_entregadas + ".$cant."), ";
//			$consulta.= "bultos_entregados = (bultos_entregados + ".$bul."), kg_entregados = (kg_entregados + ".$kg.")  Where npedido=$id";
//			$resu = mysql_query($consulta) or die(mysql_error());
//
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Terminado.");location.href="principal.php";</script>';
//			break;	
//	 case "TP":
//			/*
//			$consulta = "Update pedidos Set estado ='TP', clientefact='".$codCliente."', descrip3='".$producto."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."', cantidad_entregadas=".$cantidad." , kg_entregados=".$kilos.", bultos_entregados=".$bultos." Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= "DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."' Where idPedido=$id";
//			*/
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			$consulta = "Update pedidos Set estado ='TP',cantidad_entregadas = (cantidad_entregadas + ".$cant."), ";
//			$consulta.= "bultos_entregados = (bultos_entregados + ".$bul."), kg_entregados = (kg_entregados + ".$kg.")  Where npedido=$id";
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Terminado Parcialmente.");location.href="principal.php";</script>';
//			break;
//	 case "ET":
//	        $consulta = "Update pedidos Set estado ='ET', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."',cantidad_entregadas=".$cantidad." , kg_entregados=".$kilos.", bultos_entregados=".$bultos." Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= "DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."' Where idPedido=$id";
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Enteregado.");location.href="principal.php";</script>';
//			break;
//	 case "EP":
//	        $consulta = "Update pedidos Set estado ='EP', clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= "DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."'Where idPedido=$id";
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido pasado a estado Enteregado Parcialmente.");location.href="principal.php";</script>';
//			break;
//	 case "E":
//	        $consulta = "Update pedidos Set clientefact='".$codCliente."', descrip3='".$producto."', descripcion='".$descripcion."', codigoTango='".$codigoMercedario."',caras='".$cara."', centrada=$centrada,";
//			$consulta .= "apaisada=$apaisada, facturarA='".$facturar."', destino='".$destino."', estado='I' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			//modificar detalle del pedido
//			$consulta = "Update pedidosdetalle Set CantidadTotal=$cantidadTotal, PrecioPolimeros='".$precioPolimeros."',Unidad = $unidad, Formato = $formato,";
//			$consulta .= "Material = $material , ColorMaterial = '".$colorMaterial."', Moneda=$moneda, PrecioImporte='".$precioImporte."',IVA=$IVA,";
//			$consulta .= "Bobinado=$bobinado, BobinadoFuera=$bobinadoFuera, Termo=$termo, Micro=$microp, Fecha1='".$fecha1."',Cantidad1=$cantidad1,";
//			$consulta .= "DistanciaTaco='".$distanciaTaco."',";
//			$consulta .= "DiametroBobina='".$diametroBobina."',DiametroCanuto='".$diametroCanuto."', KgBobina='".$kgBobina."', MtsBobina='".$mtsBobina."',";
//			$consulta .= "Ancho='".$ancho."',Largo='".$largo."', Micronaje='".$micronaje."', Fuelle='".$fuelle."',Obseervaciones='".$observaciones."'Where idPedido=$id";
//			/*$consulta .= "Vendedor='".$vendedor."' Where idPedido=$id";*/
//			
//			$resu = mysql_query($consulta)or die(mysql_error());
//			
//			reg_log($id, $accion);
//			
//			echo '<script>alert("Pedido editado correctamente.");location.href="principal.php";</script>';
//			break;	
//	 case "C":
//			$consulta = "Update pedidos Set estado ='C' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado Cancelado.");location.href="principal.php";</script>';
//			break;
//	 case "R":
//			$consulta = "Update pedidos Set estado ='R' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado Rehacer.");location.href="principal.php";</script>';
//			break;
//	
//	case "D":
//			$consulta = "Update pedidos Set estado ='D', version=(version+1) Where npedido=$id"; // Aca agregar versión
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado Devuelto.");location.href="principal.php";</script>';
//			break;
//	
//	case "B":
//			$consulta = "Update pedidos Set estado ='B', faprob='".$fecha."' Where npedido=$id"; 
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado de Producción.");location.href="principal.php";</script>';
//			break;
//		
//	case "U":
//			$consulta = "Update pedidos Set estado ='U', hojaruta='".$hoja."', feccurso='".$fecha."' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado Curso.");location.href="principal.php";</script>';
//			break;
//	case "UA":
//			$consulta = "Update pedidos Set estado ='U', hojaruta='".$hoja."', descrip3='".$articulo."', feccurso='".$fecha."' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado Curso.");location.href="principal.php";</script>';
//			break;
//		
//	case "AP":
//			$consulta = "Update pedidos Set estado ='AP', fecestadoap = '".$fecha."' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido pasado a estado de Aprobaci\u00f3n.");location.href="principal.php";</script>';
//			break;
//	case "SI":
//			$consulta = "Update pedidos Set estado ='SI' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido aprobado.");location.href="principal.php";</script>';
//			break;
//	
//	case "NO":
//			$consulta = "Update pedidos Set estado ='NO' Where npedido=$id";
//			$resu = mysql_query($consulta);
//			
//			reg_log($id, $accion);
//				
//			echo '<script>alert("Pedido no aprobado.");location.href="principal.php";</script>';
//			break;
//	}
//
//function reg_log($idPedido, $estado )
//{
//	$idUsuario = $_SESSION['id_usuario'];
//	
//	$sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
//	$sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.")";
//	$resu = mysql_query($sql)or die(mysql_error());
//}

?>