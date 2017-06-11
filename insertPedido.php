<?php
session_start();

include("conexion.php");
$var = new conexion();
$var->conectarse();

//-------------------------------------------------------------------------------------
//Variables necesarias

$nombre = substr($_SESSION['Nombre'], 0, 2);                //nombre del usuario logueado

$codigo = "";                   //codigo del pedido
$entrega = "Pendiente";         //fecha de entrega-
$clienteFact = "";              //codigo del cliente-
$clienteNombre = "";            //nombre del cliente-
$clienteDirecc = "";            //direccion del cliente-
$clienteTelef = "";             //telefono del cliente-
$clienteCUIT = "";              //cuit del cliente-
$femis = date("Y-m-d");         //fecha de generacion de la NP
$faprob = "Pendiente";          //fecha de aprobacion de la NP
$frecep = "Pendiente";          //fecha de recepcion de la NP
$feccurso = "Pendiente";        //fecha de curso de la NP
$fecdisenio = "Pendiente";      //fecha de diseño de la NP
$fecestadoap = "Pendiente";     //fecha de aprobado
$descrip3 = "";                 //codigo de producto-
$descripcion = "";              //descripcion del producto-
$codigoTango = "";              //codigo correspondiente en la base de datos de tango-
$prodHabitual = "";             //producto habitual-
$caras = "";                    //caras-
$centrada = "";                 //tipo de impresion-
$apaisada = "";                 //horientacion-
$estado = "I";                  //estado I => ingresado
$facturarA = "";                //codigo del cliente a facturar-
$facturarANombre = "";          //nombre del cliente a facturar-
$destino = "";                  //destino o lugar de entrega de la NP-
$cantidad_entregadas = 0;       //cantidad entregada
$kg_entregados = 0;             //kilogramos entregados
$bultos_entregados = 0;         //bultos entregados
$hojaruta = "";                 //numero de hoja de ruta
$version = 1;                   //version de la NP
$cantidadDeProductos = 0;       //cantidad de productos-
$termo = 100;                   //termo.-
$microp = 100;                  //microp.-
$unidades = 0;                  //cantidad pedida-
$precioPolimero = "";            //precio de polimero-
$tipoDeUnidad = 0;              //tipo de unidad de medida-
$idFormato = 0;                 //formato-
$idMaterial = 0;                //material-
$color  = "";                   //color-
$idMoneda = 0;                  //moneda-
$precio = "";                   //precio / importe final-
$idIVA = 0;                     //iva-
$sentido = 0;                   //sentido-
$tratado = 0;                   //tratado-
$distTaco = "";                 //distancia taco-
$diamBobina = "";               //diametro de bobina-
$diamCanuto = "";               //diametro de canuto-
$kgBobina = "";                 //kilogramos de bobina-
$mtsBobina = "";                //metros de bobina-
$ancho = "";                    //ancho-
$largo = "";                    //largo-
$micronaje = "";                //micronaje-
$fuelle = "";                   //fuelle-
$observaciones = "";            //observaciones
$B1 = 0;                        //Bilaminado1
$B2 = 0;                        //Bilaminado2
$B3 = 0;                        //Bilaminado3
$M1 = 0;                        //Material1
$M2 = 0;                        //Material2
$M3 = 0;                        //Material3
$Micro1 = 0;                    //Micronaje1
$Micro2 = 0;                    //Micronaje2
$Micro3 = 0;                    //Micronaje3
$estadistica = 0;               //Estadistica
$env = "";                      //Envasado
$ven = "";                      //Vencimiento
$lote = "";                     //Lote
$idProveedor    = 0;
$desc           = "";
$idMaquina      = 0;
$color          = "";
$idEspesor      = 0;
$tipo           = 0;
$medidas        = "";
$marcas         = "";
$CI             = "";
$solapa         = "";           //Solapa
$mail           = "";           //Mail para protocolo
$EnviaProtocolo = "";           //Indica si envia o no protocolo
$mail2           = "";           //Mail para protocolo
$mail3           = "";           //Mail para protocolo
$mail4           = "";           //Mail para protocolo
$mail5           = "";           //Mail para protocolo
$troquelado      = 'null';         //Tiene troquelado
//-------------------------------------------------------------------------------------
//Parametros recibidos
$idPedido = $_POST['id'];
$accion = $_POST['action'];
if($accion != "U" && $accion != "UA" && $accion != "EH" && $accion != "T" && $accion != "TP" && $accion != "R" && $accion != "RR" && $accion != "RN" && $accion != "NO" && $accion != "CA" && $accion != "PO" && $accion != "PA" && $accion != "PX" && $accion != "PR" && $accion != "P1" && $accion != "D" && $accion != 'C' && $accion != 'NC' && $accion != 'RA' && $accion != "CE")
{
    $valores = $_POST['valores'];
    $titulos = $_POST['titulos'];

    $indice = 0;
}
else
{
    if($accion == "U" || $accion == "UA" || $accion == "EH")
    {
        $hoja = $_POST['hoja'];
    }

    if($accion == "UA" || $accion == "EH")
    {
        $codigoP = $_POST['code'];
        $descripcionP = $_POST['desc'];
        $tangoP = $_POST['tango'];
    }
    
    if($accion == "T" || $accion == "TP")
    {
        $cantidad = (int)$_POST['cantidad'];
        $bultos =   $_POST['bulto'];
        $kg =       $_POST['kg'];
        $fecha =    $_POST['fecha'];
    }

    if($accion == "R" || $accion == "RR" || $accion == "RN" || $accion == "NO" || $accion == "D" || $accion == "C" || $accion == "NC")
    {
        $motive = $_POST['motive'];
        $statusNow = $_POST['status'];
        $mot = $_POST['mot'];
    }

    if($accion == "PA" || $accion == "PX")
    {
        $motive = $_POST["observation"];
    }

    if($accion == "P1")
    {
        $numero = $_POST["nume"];
    }

    if($accion == "CA")
    {
        $idProveedor    = $_POST['idProveedor'];
        $desc           = $_POST['desc'];
        $idMaquina      = $_POST['idMaquina'];
        $color          = $_POST['color'];
        $idEspesor      = $_POST['idEspesor'];
        $tipo           = $_POST['tipo'];
        $medidas        = $_POST['medidas'];
        $marcas         = $_POST['marcas'];
    }
}

if($accion == "RA" || $accion == "CE")
{
    $kg = $_POST["kg"];
    $unidad = $_POST["unidad"];
    $bulto = $_POST["bulto"];

    if($accion == "CE")
    {
        $consulta = "Insert Into tbl_log_entregas (idPedido, cantidad, kg, bultos, fecha, userId) Values ";
        $consulta.= "(".$idPedido.",".($unidad * -1).",".($kg * -1).",".($bulto * -1).",CURRENT_TIMESTAMP(),".$_SESSION['id_usuario'].")";
        $resu = mysql_query($consulta);

        $consulta = "Update pedidos Set cantidad_entregadas = (cantidad_entregadas - ".$unidad.") Where npedido=$idPedido";
        $resu = mysql_query($consulta);
    }

    else
    {
        $consulta = "Update pedidos Set estado ='RA' Where npedido=$idPedido";
        $resu = mysql_query($consulta);
        reg_log($idPedido, $accion);
    }

    //var_dump($consulta);


}

//-------------------------------------------------------------------------------------
//Insertar un nuevo pedido
if($accion != "U" && $accion != "UA" && $accion != "EH" && $accion != "T" && $accion != "TP" && $accion != "R" && $accion != "RR" && $accion != "NO" && $accion != "RN" && $accion != "CA" && $accion != "PO" && $accion != "PA" && $accion != "PX" && $accion != "PR" && $accion != "P1")
{
    if($idPedido == 0 || ($accion == "E" && $idPedido != 0) || ($accion == "A" && $idPedido != 0) || ($accion == "P" && $idPedido != 0))
        {
            foreach($valores as $v)
            {
                switch($titulos[$indice])
                {
                    //Codigo del cliente
                    case "codTango":
                        $clienteFact = $v;
                        break;

                    //Nombre del cliente
                    case "nomCliente":
                        $clienteNombre = $v;
                        break;

                    //Direccion del cliente
                    case "dirCliente":
                        $clienteDirecc = $v;
                        break;

                    //Telefono del cliente
                    case "telCliente":
                        $clienteTelef = $v;
                        break;

                    //CUIT del cliente
                    case "cuit":
                        $clienteCUIT = $v;
                        break;

                    //Codigo del cliente a Facturar
                    case "codTangoCod":
                        $facturarA = $v;
                        break;

                    //Nombre del cliente a Facturar
                    case "codTangoFact":
                        $facturarANombre = $v;
                        break;

                    //Mail del cliente
                    case "mail_p":
                        $mail = $v;
                        break;

                    //Requiere envio de protocolo
                    case "envia_p":
                        $EnviaProtocolo = $v;
                        break;

                    //Lugar de entrega
                    case "lugarEnt":
                        $destino = $v;
                        break;

                    //El producto es nuevo (si => nuevo, no => viejo)
                    case "habitual":
                        if($v == "si")
                        {
                            $prodHabitual = 1;
                        }
                        else
                        {
                            if($codigoTango == "")
                                $prodHabitual = 1;
                                else
                                $prodHabitual = 0;
                        }
                        break;

                    //Descripcion de producto
                    case "nomProd":
                        $descripcion = $v;
                        break;

                    //Codigo de producto
                    case "codProd":
                        $descrip3 = $v;
                        break;

                    //Codigo de producto correspondiente a tango
                    case "codTangoProd":
                        $codigoTango = $v;
                        break;

                    //Fecha de entrega
                    case "fechaEnt":
                        $f = explode('-',$v);
                        $entrega = $f[2].'-'.$f[1].'-'.$f[0];
                        break;

                    //Cantidad de Producto:
                    case "cantProd":
                        $cantidadDeProductos = $v;
                        break;

                    //Caras
                    case "caras":
                        $caras = $v;
                        break;

                    //Tipo de Impresion
                    case "tipoImp":
                        $centrada = $v;
                        break;

                    //Horientacion
                    case "horientacion":
                        $apaisada = $v;
                        break;

                    //Termo
                    case "termo":
                        $termo = $v;
                        break;

                    //Microp.
                    case "micro":
                        $microp = $v;
                        break;

                    //cantidad
                    case "cantProd":
                        $unidades = $v;
                        break;

                    //precio de polimero
                    case "precioPoli":
                        $precioPolimero = $v;
                        break;

                    //tipo de unidad de medida
                    case "unidades":
                        $tipoDeUnidad = $v;
                        break;

                    //formato
                    case "formato":
                        $idFormato = $v;
                        break;

                    //material
                    case "material":
                        $idMaterial = $v;
                        break;

                    //color
                    case "color":
                        $color = $v;
                        break;

                    //moneda
                    case "moneda":
                        $idMoneda = $v;
                        break;

                    //precio
                    case "precio":
                        $precio = $v;
                        break;

                    //condicion de IVA
                    case "condIVA":
                        $idIVA = $v;
                        break;

                    //sentido
                    case "sentido":
                        $sentido = $v;
                        break;

                    //tratado
                    case "tratado":
                        $tratado = $v;
                        break;

                    //distancia taco
                    case "distTaco":
                        $distTaco = $v;
                        break;

                    //diametro bobina
                    case "diamBobina":
                        $diamBobina = $v;
                        break;

                    //diametro canuto
                    case "diamCanuto":
                        $diamCanuto = $v;
                        break;

                    //kg de bobina
                    case "kgBobina":
                        $kgBobina = $v;
                        break;

                    //metros de bobina
                    case "mtsBobina":
                        $mtsBobina = $v;
                        break;

                    //ancho
                    case "ancho":
                        $ancho = $v;
                        break;

                    //largo
                    case "largo":
                        $largo = $v;
                        break;

                    //micronaje
                    case "micronaje":
                        $micronaje = $v;
                        break;

                    //fuelle
                    case "fuelle":
                        $fuelle = $v;
                        break;

                    //Origen
                    case "origen":
                        $precioPolimero = $v;
                        break;

                    //solapa
                    case "solapa":
                        $solapa = $v;
                        break;

                    //observacione
                    case "observaciones":
                        $observaciones = $v;
                        break;

                    //Bilaminado1
                    case "Bilaminado1":
                        $B1 = $v;
                        break;

                    //Bilaminado2
                    case "Bilaminado2":
                        $B2 = $v;
                        break;

                    //Bilaminado3
                    case "Bilaminado3":
                        $B3 = $v;
                        break;

                    //Material1
                    case "Material1":
                        $M1 = $v;
                        break;

                    //Material2
                    case "Material2":
                        $M2 = $v;
                        break;

                    //Material3
                    case "Material3":
                        $M3 = $v;
                        break;

                    //Micronaje1
                    case "Micronaje1":
                        $Micro1 = $v;
                        break;

                    //Micronaje2
                    case "Micronaje2":
                        $Micro2 = $v;
                        break;

                    //Micronaje3
                    case "Micronaje3":
                        $Micro3 = $v;
                        break;

                    //codigo de estadistica
                    case "estadistica":
                        $estadistica = $v;
                        break;

                    //envasado
                    case "envasado":
                        $env = $v;
                        break;

                    //vencimiento
                    case "vencimiento":
                        $ven = $v;
                        break;

                    //lote
                    case "lote":
                        $lote = $v;
                        break;

                    //CI
                    case "CI_values":
                        $CI = $v;
                        break;

                    //Toquelado
                    case "troquelado":
                        $troquelado = $v;
                        break;
                }
                $indice++;
            }
            //-------------------------------------------------------------------------------------

            if($troquelado == -1){
                $troquelado = 'null';
            }
            switch($accion)
            {
                case "I":
                    {
                        //Número del pedido
                        $consulta = "SELECT Max( substr( codigo, 4, 4 ) ) from pedidos Where codigo REGEXP '^".$nombre."'";
                        $resu = mysql_query($consulta);
                        $canti = mysql_fetch_array($resu);
                        $cantidad = str_pad($canti[0] + 1, 4, "0000", STR_PAD_LEFT);
                        $numPedido = $nombre."-".$cantidad."-".date("y");
                        //-------------------------------------------------------------------------------------

                        //Evaluar si es nuevo y obtener el codigo en caso de ser positivo
                        if($prodHabitual == 1)
                        {
                            $descrip3 = get_new_code();
                        }
                        //-------------------------------------------------------------------------------------

                        //Insertar Ecabezado
                        $consulta = "Insert Into pedidos (";
                        $consulta .=                       "codigo, entrega, femis, faprob, frecep, descrip3, descripcion, codigoTango, caras, centrada, apaisada, clientefact, facturarA, destino, clienteNombre, clienteDirecc, clienteTelef, clienteCUIT, facturarANombre, prodHabitual, envasado, vencimiento, lote, estado, tieneToquelado) Values";
                        $consulta .=                       "('".$numPedido."','".$entrega."','".$femis."','".$faprob."','".$frecep."','".$descrip3."', '".$descripcion."', '".$codigoTango."', '".$caras."',$centrada, $apaisada,'".$clienteFact."','".$facturarA."','".$destino."', '".$clienteNombre."', '".$clienteDirecc."', '".$clienteTelef."', '".$clienteCUIT."', '".$facturarANombre."',$prodHabitual, '".$env."', '".$ven."', '".$lote."', 'I', ".$troquelado.")";
                        $resu = mysql_query($consulta)or die(mysql_error());

                        $consulta = "Select max(npedido) from pedidos";
                        $resu = mysql_query($consulta);
                        $row = mysql_fetch_array($resu);

                        $idPedido = $row[0];

                        //Insertar detalle del pedido
                        $detalle  = "Insert Into pedidosdetalle (";
                        $detalle .=                                 "idPedido, CantidadTotal, PrecioPolimeros, Unidad, Formato, ";
                        $detalle .=                                 "Material, ColorMaterial, Moneda, PrecioImporte, IVA, ";
                        $detalle .=                                 "Bobinado, BobinadoFuera, Termo, Micro, Fecha1, ";
                        $detalle .=                                 "Cantidad1, DistanciaTaco, DiametroBobina, DiametroCanuto, KgBobina, ";
                        $detalle .=                                 "MtsBobina, Ancho, Largo, Micronaje, Fuelle, ";
                        $detalle .=                                 "Obseervaciones, Vendedor, Bilaminado1, Bilaminado2, Trilaminado, ";
                        $detalle .=                                 "Material1, Material2, Material3, Micronaje1, Micronaje2, Micronaje3, ";
                        $detalle .=                                 "solapa";
                        $detalle .=                             ")";
                        $detalle .= " Values ";
                        $detalle .=             "(";
                        $detalle .=                 $idPedido.",".$cantidadDeProductos.",'".$precioPolimero."',".$tipoDeUnidad.",".$idFormato.",";
                        $detalle .=                 $idMaterial.",'".$color."',".$idMoneda.",'".$precio."',".$idIVA.",";
                        $detalle .=                 $sentido.",".$tratado.",".$termo.",".$microp.",'".$entrega."',";
                        $detalle .=                 $unidades.",'".$distTaco."','".$diamBobina."','".$diamCanuto."','".$kgBobina."','";
                        $detalle .=                 $mtsBobina."','".$ancho."','".$largo."','".$micronaje."','".$fuelle."','";
                        $detalle .=                 $observaciones."',".$_SESSION['id_usuario'].",".$B1.",".$B2.",".$B3.",";
                        $detalle .=                 $M1.",".$M2.",".$M3.",'".$Micro1."','".$Micro2."','".$Micro3."', '";
                        $detalle .=                 $solapa."' ";
                        $detalle .=             ")";

                                //echo $detalle;
                        $resu = mysql_query($detalle)or die(mysql_error());

                        reg_log($idPedido, $estado);

                        //Preguntar si envia protocolo

                        if (trim($EnviaProtocolo) == '100')
                        {

                            $sql  = "Insert into protocolos(idPedido, estado, email, email2, email3, email4, email5) ";
                            $sql .= "Values (".$idPedido.",'PN', '".$mail."', '', '', '', '')";

                            $resu = mysql_query($sql)or die(mysql_error());
                        }


                    }
                    break;

                case "E":
                    {
                        //Evaluar si es nuevo y obtener el codigo en caso de ser positivo
                        if($descrip3 == "")
                        {
                            $descrip3 = get_new_code();
                        }
                        //Modificar encabezado
                        $consulta = "Update pedidos Set ";
                        $consulta .=                 "entrega = '".$entrega."', ";
                        $consulta .=                 "descrip3 = '$descrip3', ";
                        $consulta .=                 "descripcion = '".$descripcion."', ";
                        $consulta .=                 "codigoTango = '".$codigoTango."', ";
                        $consulta .=                 "caras = '".$caras."', ";
                        $consulta .=                 "centrada = $centrada, ";
                        $consulta .=                 "apaisada = $apaisada, ";
                        $consulta .=                 "clientefact = '".$clienteFact."', ";
                        $consulta .=                 "facturarA = '".$facturarA."', ";
                        $consulta .=                 "destino = '".$destino."', ";
                        $consulta .=                 "clienteNombre = '".$clienteNombre."', ";
                        $consulta .=                 "clienteDirecc = '".$clienteDirecc."', ";
                        $consulta .=                 "clienteTelef = '".$clienteTelef."', ";
                        $consulta .=                 "clienteCUIT = '".$clienteCUIT."', ";
                        $consulta .=                 "facturarANombre = '".$facturarANombre."', ";
                        $consulta .=                 "prodHabitual = $prodHabitual, ";
                        $consulta .=                 "estado = 'E', ";
                        $consulta .=                 "envasado = '".$env."', ";
                        $consulta .=                 "vencimiento = '".$ven."', ";
                        $consulta .=                 "lote = '".$lote."' , ";
                        $consulta .=                 "tieneToquelado = ".$troquelado." ";
                        $consulta .= "Where npedido=$idPedido";

                        $resu = mysql_query($consulta);

                        //Insertar detalle del pedido
                        $detalle  = "Update pedidosdetalle set ";
                        $detalle .=                        "CantidadTotal   = ".$cantidadDeProductos.",
                                                            PrecioPolimeros = '".$precioPolimero."',
                                                            Unidad          = ".$tipoDeUnidad.",
                                                            Formato         = ".$idFormato.",
                                                            Material        = ".$idMaterial.",
                                                            ColorMaterial   = '".$color."',
                                                            Moneda          = ".$idMoneda.",
                                                            PrecioImporte   = '".$precio."',
                                                            IVA             = ".$idIVA.",
                                                            Bobinado        = ".$sentido.",
                                                            BobinadoFuera   = ".$tratado.",
                                                            Termo           = ".$termo.",
                                                            Micro           = ".$microp.",
                                                            Fecha1          = '".$entrega."',
                                                            Cantidad1       = ".$unidades.",
                                                            DistanciaTaco   = '".$distTaco."',
                                                            DiametroBobina  = '".$diamBobina."',
                                                            DiametroCanuto  = '".$diamCanuto."',
                                                            KgBobina        = '".$kgBobina."',
                                                            MtsBobina       = '".$mtsBobina."',
                                                            Ancho           = '".$ancho."',
                                                            Largo           = '".$largo."',
                                                            Micronaje       = '".$micronaje."',
                                                            Fuelle          = '".$fuelle."',
                                                            Obseervaciones  = '".$observaciones."',
                                                            Bilaminado1     = ".$B1.",
                                                            Bilaminado2     = ".$B2.",
                                                            Trilaminado     = ".$B3.",
                                                            Material1       = ".$M1.",
                                                            Material2       = ".$M2.",
                                                            Material3       = ".$M3.",
                                                            Micronaje1      = '".$Micro1."',
                                                            Micronaje2      = '".$Micro2."',
                                                            Micronaje3      = '".$Micro3."',
                                                            solapa          = '".$solapa."' ";
                        $detalle .= " Where idPedido=$idPedido";

                        $resu = mysql_query($detalle);

                        reg_log($idPedido, "E");
                    }
                    break;

                //el pedido fue aprobado
                case "A":
                    {
                        $indice = 0;
                        foreach($valores as $v)
                        {
                            switch($titulos[$indice])
                            {
                                //codigo de estadistica
                                case "estadistica":
                                    $estadistica = $v;
                                    break;
                            }
                            $indice++;
                        }

                        //Evaluar si es nuevo y obtener el codigo en caso de ser positivo
                        if($descrip3 == "")
                        {
                            $descrip3 = get_new_code();
                        }

                        //Modificar encabezado
                        $consulta = "Update pedidos Set ";
                        $consulta .=                 "entrega = '".$entrega."', ";
                        $consulta .=                 "descrip3 = '$descrip3', ";
                        $consulta .=                 "descripcion = '".$descripcion."', ";
                        $consulta .=                 "codigoTango = '".$codigoTango."', ";
                        $consulta .=                 "caras = '".$caras."', ";
                        $consulta .=                 "centrada = $centrada, ";
                        $consulta .=                 "apaisada = $apaisada, ";
                        $consulta .=                 "clientefact = '".$clienteFact."', ";
                        $consulta .=                 "facturarA = '".$facturarA."', ";
                        $consulta .=                 "destino = '".$destino."', ";
                        $consulta .=                 "clienteNombre = '".$clienteNombre."', ";
                        $consulta .=                 "clienteDirecc = '".$clienteDirecc."', ";
                        $consulta .=                 "clienteTelef = '".$clienteTelef."', ";
                        $consulta .=                 "clienteCUIT = '".$clienteCUIT."', ";
                        $consulta .=                 "facturarANombre = '".$facturarANombre."', ";
                        $consulta .=                 "prodHabitual = $prodHabitual, ";
                        $consulta .=                 "estado = 'A', ";
                        $consulta .=                 "envasado = '".$env."', ";
                        $consulta .=                 "vencimiento = '".$ven."', ";
                        $consulta .=                 "idEsta = ".$estadistica.", ";
                        $consulta .=                 "frecep = CURDATE(), ";
                        $consulta .=                 "lote = '".$lote."', ";
                        $consulta .=                 "tieneToquelado = ".$troquelado." ";
                        $consulta .= "Where npedido=$idPedido";

                        $resu = mysql_query($consulta);

                        //echo($consulta);

                        //Insertar detalle del pedido
                        $detalle  = "Update pedidosdetalle set ";
                        $detalle .=                        "CantidadTotal   = ".$cantidadDeProductos.",
                                                            PrecioPolimeros = '".$precioPolimero."',
                                                            Unidad          = ".$tipoDeUnidad.",
                                                            Formato         = ".$idFormato.",
                                                            Material        = ".$idMaterial.",
                                                            ColorMaterial   = '".$color."',
                                                            Moneda          = ".$idMoneda.",
                                                            PrecioImporte   = '".$precio."',
                                                            IVA             = ".$idIVA.",
                                                            Bobinado        = ".$sentido.",
                                                            BobinadoFuera   = ".$tratado.",
                                                            Termo           = ".$termo.",
                                                            Micro           = ".$microp.",
                                                            Fecha1          = '".$entrega."',
                                                            Cantidad1       = ".$unidades.",
                                                            DistanciaTaco   = '".$distTaco."',
                                                            DiametroBobina  = '".$diamBobina."',
                                                            DiametroCanuto  = '".$diamCanuto."',
                                                            KgBobina        = '".$kgBobina."',
                                                            MtsBobina       = '".$mtsBobina."',
                                                            Ancho           = '".$ancho."',
                                                            Largo           = '".$largo."',
                                                            Micronaje       = '".$micronaje."',
                                                            Fuelle          = '".$fuelle."',
                                                            Obseervaciones  = '".$observaciones."',
                                                            Bilaminado1     = ".$B1.",
                                                            Bilaminado2     = ".$B2.",
                                                            Trilaminado     = ".$B3.",
                                                            Material1       = ".$M1.",
                                                            Material2       = ".$M2.",
                                                            Material3       = ".$M3.",
                                                            Micronaje1      = '".$Micro1."',
                                                            Micronaje2      = '".$Micro2."',
                                                            Micronaje3      = '".$Micro3."' ,
                                                            solapa          = '".$solapa."' ";
                        $detalle .= " Where idPedido=$idPedido";

                        $resu = mysql_query($detalle);

                        reg_log($idPedido, $accion);

                    }
                    break;

                case "P":
                    {
                        if($prodHabitual == 1 && $descrip3 == '')
                        {
                            //Evaluar si es nuevo y obtener el codigo en caso de ser positivo
                            $descrip3 = get_new_code();
                        }

                        //Modificar encabezado
                        $consulta = "Update pedidos Set ";
                        $consulta .=                 "entrega = '".$entrega."', ";
                        $consulta .=                 "descrip3 = '$descrip3', ";
                        $consulta .=                 "descripcion = '".$descripcion."', ";
                        $consulta .=                 "codigoTango = '".$codigoTango."', ";
                        $consulta .=                 "caras = '".$caras."', ";
                        $consulta .=                 "centrada = $centrada, ";
                        $consulta .=                 "apaisada = $apaisada, ";
                        $consulta .=                 "clientefact = '".$clienteFact."', ";
                        $consulta .=                 "facturarA = '".$facturarA."', ";
                        $consulta .=                 "destino = '".$destino."', ";
                        $consulta .=                 "clienteNombre = '".$clienteNombre."', ";
                        $consulta .=                 "clienteDirecc = '".$clienteDirecc."', ";
                        $consulta .=                 "clienteTelef = '".$clienteTelef."', ";
                        $consulta .=                 "clienteCUIT = '".$clienteCUIT."', ";
                        $consulta .=                 "facturarANombre = '".$facturarANombre."', ";
                        $consulta .=                 "prodHabitual = $prodHabitual, ";
                        $consulta .=                 "estado = 'P', ";
                        $consulta .=                 "envasado = '".$env."', ";
                        $consulta .=                 "vencimiento = '".$ven."', ";
                        $consulta .=                 "lote = '".$lote."', ";
                        $consulta .=                 "esCI = '".$CI."', ";
                        $consulta .=                 "seDevolvio = NULL , ";
                        $consulta .=                 "tieneToquelado = ".$troquelado." ";
                        $consulta .= "Where npedido=$idPedido";

                        $resu = mysql_query($consulta);

                        //Insertar detalle del pedido
                        $detalle  = "Update pedidosdetalle set ";
                        $detalle .=                "CantidadTotal   = ".$cantidadDeProductos.",
                                                    PrecioPolimeros = '".$precioPolimero."',
                                                    Unidad          = ".$tipoDeUnidad.",
                                                    Formato         = ".$idFormato.",
                                                    Material        = ".$idMaterial.",
                                                    ColorMaterial   = '".$color."',
                                                    Moneda          = ".$idMoneda.",
                                                    PrecioImporte   = '".$precio."',
                                                    IVA             = ".$idIVA.",
                                                    Bobinado        = ".$sentido.",
                                                    BobinadoFuera   = ".$tratado.",
                                                    Termo           = ".$termo.",
                                                    Micro           = ".$microp.",
                                                    Fecha1          = '".$entrega."',
                                                    Cantidad1       = ".$unidades.",
                                                    DistanciaTaco   = '".$distTaco."',
                                                    DiametroBobina  = '".$diamBobina."',
                                                    DiametroCanuto  = '".$diamCanuto."',
                                                    KgBobina        = '".$kgBobina."',
                                                    MtsBobina       = '".$mtsBobina."',
                                                    Ancho           = '".$ancho."',
                                                    Largo           = '".$largo."',
                                                    Micronaje       = '".$micronaje."',
                                                    Fuelle          = '".$fuelle."',
                                                    Obseervaciones  = '".$observaciones."',
                                                    Bilaminado1     = ".$B1.",
                                                    Bilaminado2     = ".$B2.",
                                                    Trilaminado     = ".$B3.",
                                                    Material1       = ".$M1.",
                                                    Material2       = ".$M2.",
                                                    Material3       = ".$M3.",
                                                    Micronaje1      = '".$Micro1."',
                                                    Micronaje2      = '".$Micro2."',
                                                    Micronaje3      = '".$Micro3."' ,
                                                    solapa          = '".$solapa."' ";
                        $detalle .= " Where idPedido=$idPedido";

                        $resu = mysql_query($detalle);

                        $estado = "P";

                        if($CI != "")
                        {
                            $consulta = "Update pedidos Set estado ='U', faprob=CURDATE(), feccurso=CURDATE() Where npedido=$idPedido";
                            $estado = "U";
                        }
                        else
                        {
                            if( $descrip3[0] == "n")
                            {
                                    //Preguntar Si tiene impresion o No
                                    if($caras == "0")
                                    {
                                            $consulta = "Update pedidos Set estado ='P', faprob=CURDATE() Where npedido=$idPedido";
                                    }
                                    else
                                    {
                                            $xx_ = "Select version from pedidos Where npedido=$idPedido";
                                            $res_xx_ = mysql_query($xx_);

                                            $row_xx_ = mysql_fetch_array($res_xx_);
                                            $ver_ = $row_xx_[0];
                                            if($ver_ > 1)
                                            {
                                                $consulta = "Update pedidos Set estado ='P' Where npedido=$idPedido"; // Aca agregar versión
                                                $estado = "P";
                                            }
                                            else
                                            {
                                                $estado = "DI";
                                                $consulta = "Update pedidos Set estado ='DI', fecdisenio=CURDATE() Where npedido=$idPedido";

                                                //Crear polímero ---------------------
                                                //ver si el polimero no tiene otro polimero ya creado con anterioridad
                                                $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
                                                $resu = mysql_query($esta);
                                                $number = mysql_fetch_array($resu);

                                                if($number[0] == "")
                                                {
                                                    $insert = "INSERT INTO `polimeros` (`id_polimero`, `estado`,`trabajo`, `idPedido`,`standBy`, `EnFacturacion`) VALUES ";
                                                    $insert.= "(NULL, 'DI','".$descripcion."',".$idPedido.", '0', 'N')";

                                                    $resu = mysql_query($insert);

                                                    //Estado del polimero
                                                    $idPolimero = mysql_insert_id();
                                                    $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                                                    $_insert.= "(".$idPolimero.", 'DI', ".$_SESSION['id_usuario'].", 'Ingreso en preprensa', CURRENT_TIMESTAMP( ))";
                                                    $resu = mysql_query($_insert);

                                                    $consultaPolimero = "Update pedidos Set poliNumero = '".$idPolimero."' Where npedido=$idPedido";
                                                    $resu = mysql_query($consultaPolimero);
                                                }
                                                else
                                                {
                                                    //Update del Polimero ya creado antes
                                                    $update = "Update `polimeros` set ";
                                                    $update.= "`estado` = 'DI',`trabajo` = '".$descripcion."',`standBy` = '0', `EnFacturacion` = 'N'";
                                                    $update.= "Where id_Polimero = ".$number[0];

                                                    $resu = mysql_query($update);
                                                    //-----------------------------------

                                                    //Estado del polimero
                                                    $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                                                    $_insert.= "(".$number[0].", 'DI', ".$_SESSION['id_usuario'].", 'Ingreso en preprensa', CURRENT_TIMESTAMP( ))";
                                                    $resu = mysql_query($_insert);
                                                }

                                                //reg_log($idPedido, "AP");
                                                //------------------------------------
                                            }
                                    }
                            }
                            else
                            {
                                    $consulta = "Update pedidos Set estado ='P', faprob=CURDATE() Where npedido=$idPedido";
                            }
                        }

                        $resu = mysql_query($consulta);

                        reg_log($idPedido, $estado);
                    }
                    break;
            }

        }
        else
        {
            switch($accion)
            {

                //el pedido se tiene que rehacer
                case "R":
                    $indice = 0;

                    $consulta = "Update pedidos Set estado ='R' Where npedido=$idPedido";

                    $resu = mysql_query($consulta);

                    reg_log_cancel($idPedido, $accion);
                    break;

                    //El pedido fue cancelado
                case "C":
                    $consulta = "Update pedidos Set estado ='C' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log_2($idPedido, $accion, $motive, $statusNow, $mot);

                    //Cancelar protocolo ///////Revisar aca cuando se cancela un pedido
                    $consulta = "Update protocolos Set estado = 'C' Where idPedido=$idPedido";
                    $resu = mysql_query($consulta);

                    break;

                case "AP":
                    $consulta = "Update pedidos Set estado ='AP', fecestadoap = CURDATE() Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "AP");
                    break;

                case "SI":
                    $consulta = "Update pedidos Set estado ='SI' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "SI");
                    break;

                case "B":
                    $consulta = "Update pedidos Set estado ='B' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "B");
                    break;

                case "CA":
                    //insertar polimero nuevo.---------------------
                    //---------------------------------------------
                    $insert  = "Insert Into polimeros ( id_proveedor, idMaquina, colores, idEspesor)";//, idTipo, medidas, marcaRegistro, trabajo, observacion, idPedido) Values "
                    $insert .= "(".$idProveedor.", ".$idMaquina.", '".$color."', ".$idEspesor.")";//, ".$tipo.", '".$medidas."', '".$marcas."', '".$desc."', 'NUEVO', ".$idPedido.")";

                    $resu = mysql_query($insert);

                    $idPolimero = mysql_insert_id();

                    //Aca falta insertar el estado del polimero
                    $consulta = "Update pedidos Set estado ='CA' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "CA");
                    break;

                case "NO":
                    $consulta = "Update pedidos Set estado ='NO' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "NO");
                    break;

                case "D":

                    //var_dump($_POST);
                    $edit_hojaRuta=(isset($_POST['hojaruta']))?",hojaruta=".$_POST['hojaruta']:"";
                    $edit_estaImpreso=(isset($_POST['estaImpreso']))?",estaImpreso=".$_POST['estaImpreso']:"0";

                    $consulta = "Update pedidos Set estado ='D', version=(version+1), seDevolvio = 'P', marcarComoDevuelta = '1', estaImpreso = 0 $edit_hojaRuta $edit_estaImpreso Where npedido=$idPedido"; // Aca agregar versión


                    $resu = mysql_query($consulta);

                    //reg_log($idPedido, "D");

                    reg_log_2($idPedido, $accion, $motive, $statusNow, $mot);
                    break;

                case "CL":
                    $consulta = "Update pedidos Set estado ='CL' Where npedido=$idPedido"; // Aca agregar versión
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "CL");

                    $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
                    $resu = mysql_query($esta);
                    $number = mysql_fetch_array($resu);

                    if($number[0] != "")
                    {
                        //Update del Polimero ya creado antes
                        $update = "Update `polimeros` set ";
                        $update.= "`estado` = 'CL' ";
                        $update.= "Where id_Polimero = ".$number[0];

                        $resu = mysql_query($update);
                        //-----------------------------------

                        //Estado del polimero
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$number[0].", 'CL', ".$_SESSION['id_usuario'].", 'Aprobación de Cliente', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);
                    }
                    else
                    {
                        $ped = "Select descripcion from pedidos WHere npedido = ".$idPedido;
                        $row = mysql_query($ped);
                        $descripcion = mysql_fetch_array($row);

                        $insert = "INSERT INTO `polimeros` (`id_polimero`, `estado`,`trabajo`, `idPedido`,`standBy`, `EnFacturacion`) VALUES ";
                        $insert.= "(NULL, 'DI','".$descripcion[0]."',".$idPedido.", '0', 'CL')";

                        $resu = mysql_query($insert);

                        //Estado del polimero
                        $idPolimero = mysql_insert_id();
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$idPolimero.", 'CL', ".$_SESSION['id_usuario'].", 'Aprobación de Cliente', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);

                        $consultaPolimero = "Update pedidos Set poliNumero = '".$idPolimero."' Where npedido=$idPedido";
                        $resu = mysql_query($consultaPolimero);
                    }
                    break;

                case "N":
                    $consulta = "Update pedidos Set estado ='N' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "N");

                    $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
                    $resu = mysql_query($esta);
                    $number = mysql_fetch_array($resu);

                    if($number[0] != "")
                    {
                        //Update del Polimero ya creado antes
                        $update = "Update `polimeros` set ";
                        $update.= "`estado` = 'AC' ";
                        $update.= "Where id_Polimero = ".$number[0];

                        $resu = mysql_query($update);
                        //-----------------------------------

                        //Estado del polimero
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$number[0].", 'AC', ".$_SESSION['id_usuario'].", 'Aprobado por el Cliente', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);
                    }
                    else
                    {
                        $ped = "Select descripcion from pedidos WHere npedido = ".$idPedido;
                        $row = mysql_query($ped);
                        $descripcion = mysql_fetch_array($row);

                        $insert = "INSERT INTO `polimeros` (`id_polimero`, `estado`,`trabajo`, `idPedido`,`standBy`, `EnFacturacion`) VALUES ";
                        $insert.= "(NULL, 'DI','".$descripcion[0]."',".$idPedido.", '0', 'AC')";

                        $resu = mysql_query($insert);

                        //Estado del polimero
                        $idPolimero = mysql_insert_id();
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$idPolimero.", 'AC', ".$_SESSION['id_usuario'].", 'Aprobado por el Cliente', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);

                        $consultaPolimero = "Update pedidos Set poliNumero = '".$idPolimero."' Where npedido=$idPedido";
                        $resu = mysql_query($consultaPolimero);
                    }
                    break;

                case "NC":
                    $consulta = "Update pedidos Set estado ='NC' Where npedido=$idPedido";
                    $resu = mysql_query($consulta);

                    reg_log($idPedido, "NC");

                    $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
                    $resu = mysql_query($esta);
                    $number = mysql_fetch_array($resu);

                    if($number[0] != "")
                    {
                        //Update del Polimero ya creado antes
                        $update = "Update `polimeros` set ";
                        $update.= "`estado` = 'NA' ";
                        $update.= "Where id_Polimero = ".$number[0];

                        $resu = mysql_query($update);
                        //-----------------------------------

                        //Estado del polimero
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$number[0].", 'NA', ".$_SESSION['id_usuario'].", 'NO Aprobado por el Cliente', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);
                    }
                    else
                    {
                        $ped = "Select descripcion from pedidos WHere npedido = ".$idPedido;
                        $row = mysql_query($ped);
                        $descripcion = mysql_fetch_array($row);

                        $insert = "INSERT INTO `polimeros` (`id_polimero`, `estado`,`trabajo`, `idPedido`,`standBy`, `EnFacturacion`) VALUES ";
                        $insert.= "(NULL, 'DI','".$descripcion[0]."',".$idPedido.", '0', 'CL')";

                        $resu = mysql_query($insert);

                        //Estado del polimero
                        $idPolimero = mysql_insert_id();
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$idPolimero.", 'NA', ".$_SESSION['id_usuario'].", 'NO Aprobado por el Cliente', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);

                        $consultaPolimero = "Update pedidos Set poliNumero = '".$idPolimero."' Where npedido=$idPedido";
                        $resu = mysql_query($consultaPolimero);
                    }
                    break;
            }
        }
}
else
{
    if($accion == "U")
    {
        $consulta = "Update pedidos Set estado ='U', hojaruta='NN', feccurso= CURDATE() Where npedido=$idPedido";
        $resu = mysql_query($consulta);

        reg_log($idPedido, $accion);

        foreach ($hoja as $h)
        {
            $query = "Insert Into pedidoshojasderuta (idPedido, HojaDeRuta) Values ";
            $query.= "($idPedido, '".$h."')";

            $resu = mysql_query($query);
        }
    }

    if($accion == "UA")
    {
        $consulta = "Update pedidos Set estado ='U', hojaruta='NN', feccurso= CURDATE(), descrip3 = '".$codigoP."',
                            descripcion = '".$descripcionP."', codigoTango = '".$tangoP."' Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_log($idPedido, "UA");

        foreach ($hoja as $h)
        {
            $query = "Insert Into pedidoshojasderuta (idPedido, HojaDeRuta) Values ";
            $query.= "($idPedido, '".$h."')";

            $resu = mysql_query($query);
        }
    }

    if($accion == "EH")
    {
        if(count($hoja) > 0)
           {$ed = 1;}
           else
           {$ed = 0;}

        $consulta = "Update pedidos Set hojaruta='NN', descrip3 = '".$codigoP."', seCargoHRCI = '".$ed."',
                            descripcion = '".$descripcionP."', codigoTango = '".$tangoP."' Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_log($idPedido, "EH");

        $delete  = "Delete from pedidoshojasderuta where idPedido = ".$idPedido;
        $resu2 = mysql_query($delete) or die(mysql_error());

        foreach ($hoja as $h)
        {
            $query = "Insert Into pedidoshojasderuta (idPedido, HojaDeRuta) Values ";
            $query.= "($idPedido, '".$h."')";

            $resu = mysql_query($query);
        }
    }

    if($accion == "CA")
    {
        //insertar polimero nuevo.---------------------
        //---------------------------------------------
        $insert  = "Insert Into polimeros ( id_proveedor, idMaquina, colores, idEspesor, idTipo, medidas, marcaRegistro, trabajo, observacion, idPedido, estado) Values ";
        $insert .= "(".$idProveedor.", ".$idMaquina.", '".$color."', ".$idEspesor.", ".$tipo.", '".$medidas."', '".$marcas."', '".$desc."', 'NUEVO', $idPedido, 'A')";

        $resu = mysql_query($insert);

        $idPolimero = mysql_insert_id();
        //Estado del polimero
        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion) values";
        $_insert.= "(".$idPolimero.", 'A', ".$_SESSION['id_usuario'].", 'Creación de Polimero')";
        $resu = mysql_query($_insert);

        //obtener numeracion para la ot
        $otQuery = "select numNumeracion from tbl_numeraciones Where numCodigo = 'ORT'";
        $resu_ot = mysql_query($otQuery);
        $canti = mysql_fetch_array($resu_ot);

        $otNumber = str_pad($canti[0], 6, "000000", STR_PAD_LEFT);

        $co = "Update tbl_numeraciones set numNumeracion = ".($canti[0] + 1)." Where numCodigo = 'ORT'";
        $resu = mysql_query($co);

        //Set orden de trabajo
        $_ot = "Insert into ordendetrabajo (idPolimero, ordenNumero) Values ";
        $_ot.= "(".$idPolimero.", '".$otNumber."')";
        $q = mysql_query($_ot);

        $consulta = "Update pedidos Set estado ='CA', calidad = 'CA' , faprob=CURDATE(), poliNumero = $idPolimero Where npedido=$idPedido";
        $resu = mysql_query($consulta);

        reg_log($idPedido, $accion);

        echo json_encode($otNumber);

    }

    if($accion == "PO")
    {
        $consulta = "Update pedidos Set calidad ='PO'
                     Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_log($idPedido, $accion);
    }

    if($accion == "PR")
    {
        $consulta = "Update pedidos Set calidad ='PR'
                     Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_log($idPedido, $accion);
    }

    if($accion == "PA" || $accion == "PX")
    {
        $consulta = "Update pedidos Set calidad ='".$accion."'
                     Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        if($accion == "PA")
        {
            reg_log($idPedido, $accion);
        }
        else
        {
            reg_log_2($idPedido, $accion, $motive, "PO", '');
        }
    }

    if($accion == "T" || $accion == "TP")
    {
        $consulta = "Update
                            pedidos
                    Set
                            estado ='".$accion."',
                            cantidad_entregadas = (cantidad_entregadas + ".$cantidad."),
                            bultos_entregados = (bultos_entregados + ".$bultos."),
                            kg_entregados = (kg_entregados + ".$kg."),
                            seFacturoPolimero = 1
                    Where
                            npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_entregas_conFecha($idPedido, $cantidad, $bultos, $kg, $fecha);
        reg_log($idPedido, $accion);

        //Actualizar los protocolos para envio a clientes
        if($accion == 'T'){
            $update = "Update protocolos Set estado = '".$accion."' Where idPedido = ".$idPedido." ";
        }else{
        $update = "Update protocolos Set estado = '".$accion."' Where idPedido = ".$idPedido." And estado = 'PN'";
        }
        //var_dump($update);
        $resu = mysql_query($update);

        //Preguntar si esta en protocolos -------------------
        $get = "Select count(*) as cantidad from protocolos Where idPedido = ".$idPedido;
        $get_resu = mysql_query($get);
        $cant = 0;
        while($get_row = mysql_fetch_array($get_resu)){
            $cant = $get_row['cantidad'];
        }
        if($cantidad != 0){
            reg_entregas_conFecha_protocolo($idPedido, $cantidad, $bultos, $kg, $fecha);
        }
        //---------------------------------------------------
    }

    if($accion == "R" || $accion == "RR" || $accion == "RN" || $accion == "NO" || $accion == "N" || $accion == "DI" || $accion == "NC")
    {
        $consulta = "Update pedidos Set estado ='".$accion."' Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_log_2($idPedido, $accion, $motive, $statusNow, $mot);

        if($accion == "RN")
        {
            $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
            $resu = mysql_query($esta);
            $number = mysql_fetch_array($resu);

            if($number[0] != "")
                    {
                        //Update del Polimero ya creado antes
                        $update = "Update `polimeros` set ";
                        $update.= "`estado` = 'RN' ";
                        $update.= "Where id_Polimero = ".$number[0];

                        $resu = mysql_query($update);
                        //-----------------------------------

                        //Estado del polimero
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$number[0].", 'RN', ".$_SESSION['id_usuario'].", 'Rehacer pedido', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);
                    }
                    else
                    {
                        $ped = "Select descripcion from pedidos WHere npedido = ".$idPedido;
                        $row = mysql_query($ped);
                        $descripcion = mysql_fetch_array($row);

                        $insert = "INSERT INTO `polimeros` (`id_polimero`, `estado`,`trabajo`, `idPedido`,`standBy`, `EnFacturacion`) VALUES ";
                        $insert.= "(NULL, 'DI','".$descripcion[0]."',".$idPedido.", '0', 'CL')";

                        $resu = mysql_query($insert);

                        //Estado del polimero
                        $idPolimero = mysql_insert_id();
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$idPolimero.", 'RN', ".$_SESSION['id_usuario'].", 'Rehacer pedido', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);

                        $consultaPolimero = "Update pedidos Set poliNumero = '".$idPolimero."' Where npedido=$idPedido";
                        $resu = mysql_query($consultaPolimero);
                    }

            $consultaPedido = "Update pedidos Set seDevolvio = 'D', marcarComoDevuelta = '1', estaImpreso = 0  Where npedido=$idPedido";
            $resu = mysql_query($consultaPedido);
        }

        if($accion == "NO")
        {
            $esta = "Select poliNumero from pedidos Where npedido =$idPedido";
            $resu = mysql_query($esta);
            $number = mysql_fetch_array($resu);

            if($number[0] != "")
                    {
                        //Update del Polimero ya creado antes
                        $update = "Update `polimeros` set ";
                        $update.= "`estado` = 'NO' ";
                        $update.= "Where id_Polimero = ".$number[0];

                        $resu = mysql_query($update);
                        //-----------------------------------

                        //Estado del polimero
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$number[0].", 'NO', ".$_SESSION['id_usuario'].", 'Borrador rechazado', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);
                    }
                    else
                    {
                        $ped = "Select descripcion from pedidos WHere npedido = ".$idPedido;
                        $row = mysql_query($ped);
                        $descripcion = mysql_fetch_array($row);

                        $insert = "INSERT INTO `polimeros` (`id_polimero`, `estado`,`trabajo`, `idPedido`,`standBy`, `EnFacturacion`) VALUES ";
                        $insert.= "(NULL, 'DI','".$descripcion[0]."',".$idPedido.", '0', 'CL')";

                        $resu = mysql_query($insert);

                        //Estado del polimero
                        $idPolimero = mysql_insert_id();
                        $_insert = "Insert into tbl_log_polimeros (polimeroId, polimeroEstado, usuarioId, observacion, logFecha) values";
                        $_insert.= "(".$idPolimero.", 'RN', ".$_SESSION['id_usuario'].", 'Rehacer pedido', CURRENT_TIMESTAMP( ))";
                        $resu = mysql_query($_insert);

                        $consultaPolimero = "Update pedidos Set poliNumero = '".$idPolimero."' Where npedido=$idPedido";
                        $resu = mysql_query($consultaPolimero);
                    }
        }
    }

    if($accion == "P1")
    {
        $consulta = "Update pedidos Set poliNumero ='".$numero."' Where npedido=$idPedido";

        $resu = mysql_query($consulta);

        reg_log($idPedido, $accion);
    }

    if($accion == "CL")
    {
        //No es utilizado
        $consulta = "Update pedidos Set estado ='CL' Where npedido=$idPedido";
        $resu = mysql_query($consulta);

        reg_log($idPedido, "CL");
    }

    if($accion == "N")
    {
        $consulta = "Update pedidos Set estado ='N' Where npedido=$idPedido";
        $resu = mysql_query($consulta);

        reg_log($idPedido, "N");
    }
}

//-------------------------------------------------------------------------------------

function reg_log($idPedido, $estado )
{
	$idUsuario = $_SESSION['id_usuario'];

	$sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId) values ";
	$sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.")";
	$resu = mysql_query($sql)or die(mysql_error());
}

function reg_log_2($idPedido, $estado , $motivo, $statusNow, $mot)
{
	$idUsuario = $_SESSION['id_usuario'];

	$sql  = "Insert into  tbl_log_pedidos (pedidoId, pedidoEstado, usuarioId, observacion, logCancel, motives) values ";
	$sql .= "('".$idPedido."', '".$estado."', ".$idUsuario.", '".$motivo."', '".$statusNow."', '".$mot."')";
	$resu = mysql_query($sql)or die(mysql_error());
}

function reg_entregas($idPedido, $cantidad, $bultos, $kg)
{
        $idUsuario = $_SESSION['id_usuario'];

        $sql = "Insert into tbl_log_entregas (idPedido, cantidad, kg, bultos, userId) values ";
        $sql.= "(".$idPedido.",".$cantidad.",".$kg.",".$bultos.", ".$idUsuario.")";
        $resu = mysql_query($sql) or die(mysql_error());
}

function reg_entregas_conFecha($idPedido, $cantidad, $bultos, $kg, $fecha)
{
        $fe = explode('-',$fecha);
        $idUsuario = $_SESSION['id_usuario'];
        $fecha = explode('-', $fecha);

        $sql = "Insert into tbl_log_entregas (idPedido, cantidad, kg, bultos, userId, fecha) values ";
        $sql.= "(".$idPedido.",".$cantidad.",".$kg.",".$bultos.", ".$idUsuario.", '".$fecha[2].'-'.$fecha[1].'-'.$fecha[0]."')";
        $resu = mysql_query($sql) or die(mysql_error());
}

function get_new_code()
{
        $consulta = "select numNumeracion from tbl_numeraciones Where numCodigo = 'ORP'";
        $resu = mysql_query($consulta);
        $canti = mysql_fetch_array($resu);

        $descrip3 = str_pad($canti[0], 6, "n00000", STR_PAD_LEFT);

        $consulta = "Update tbl_numeraciones set numNumeracion = ".($canti[0] + 1)." Where numCodigo = 'ORP'";
        $resu = mysql_query($consulta);

        return $descrip3;
}

function reg_entregas_conFecha_protocolo($idPedido, $cantidad, $bultos, $kg, $fecha)
{
        $fe = explode('-',$fecha);
        $idUsuario = $_SESSION['id_usuario'];
        $fecha = explode('-', $fecha);

        if($cantidad != 1 && $kg != 1 && $bultos != 1){
            $sql = "Insert into tbl_log_entregas_protocolos (idPedido, cantidad, kg, bultos, usrId, fecha, estado) values ";
            $sql.= "(".$idPedido.",".$cantidad.",".$kg.",".$bultos.", ".$idUsuario.", '".$fecha[2].'-'.$fecha[1].'-'.$fecha[0]."', 'PN')";
            $resu = mysql_query($sql) or die(mysql_error());
        }
}
?>
