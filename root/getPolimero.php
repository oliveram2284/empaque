<?php

include("conexion.php");
		
$var = new conexion();
$var->conectarse();

$npId     = $_POST['ntpId'];


$polimero = array();
$calidades = array();
$sql = "Select * from polimeros Where idPedido = ".$npId;
$resu = mysql_query($sql);
while($row = mysql_fetch_assoc($resu))
    {
        $sql_2 = "Select razon_social from proveedores Where id_proveedor =".$row['id_proveedor'];
        $resu_2 = mysql_query($sql_2);
        while($row_2 = mysql_fetch_assoc($resu_2))
        {
            $proveedorName = $row_2['razon_social'];
        }
        
        $idCalidades = explode("/",$row['calidad']);       
        $sql_3 = "Select
                        t.idTipoPoli, t.descTipoPoli
                  From
                        tbl_proveedores_tipo as p
                  Join
                        tipo_polimero as t on t.idTipoPoli = p.idTipo
                  Where
                        p.idProveedor =".$row['id_proveedor'];
        $resu_3 = mysql_query($sql_3);
        while($row_3 = mysql_fetch_assoc($resu_3))
        {
            $checked = "";
            if (in_array($row_3['idTipoPoli'], $idCalidades)) {
                $checked = "checked";            
            }
            $tipo = array(
                    'id'       => $row_3['idTipoPoli'],
                    'name'     => $row_3['descTipoPoli'],
                    'checked'  => $checked
            );
            $calidades[] = $tipo;
        }
         
        $obj = array(
                        'AVT'           => $row['AVT'],
                        'EnFacturacion' => $row['EnFacturacion'],
                        'anchoSugerido' => $row['anchoSugerido'],
                        'calidad'       => $row['calidad'],
                        'camisa'        => $row['camisa'],
                        'cilindro'      => $row['cilindro'],
                        'colores'       => $row['colores'],
                        'detallaClien'  => $row['detallaClien'],
                        'detallaGeren'  => $row['detallaGeren'],
                        'detallaImp'    => $row['detallaImp'],
                        'detallaProd'   => $row['detallaProd'],
                        'detallaVend'   => $row['detallaVend'],
                        'disenio'       => $row['disenio'],
                        'disenioBase'   => $row['disenioBase'],
                        'estado'        => $row['estado'],
                        'estadoPolPlanta'  => $row['estadoPolPlanta'],
                        'fechaEnt'      => $row['fechaEnt'],
                        'idEspesor'     => $row['idEspesor'],
                        'idMaquina'     => $row['idMaquina'],
                        'idPedido'      => $row['idPedido'],
                        'id_polimero'   => $row['id_polimero'],
                        'proveedorName' => $proveedorName,
                        'id_proveedor'  => $row['id_proveedor'],
                        'lineatura'     => $row['lineatura'],
                        'medidas'       => $row['medidas'],
                        'muestra'       => $row['muestra'],
                        'observacion'   => $row['observacion'],
                        'pistas'        => $row['pistas'],
                        'presupuesto'   => $row['presupuesto'],
                        'reponer'       => $row['reponer'],
                        'reunion'       => $row['reunion'],
                        'standBy'       => $row['standBy'],
                        'trabajo'       => $row['trabajo'],
                        'calidades'     => $calidades,
                        'sentido'       => $row['sentido'],
                        'barra'         => $row['barra'],
                        'barcode'       => $row['barcode']
                    );
        
        $polimero[] = $obj;
    }
	
echo json_encode($polimero);

?>