<?php 

    session_start();
    if(!$_SESSION['Nombre'])
    {
        return false;
    }
    include ("../config.php");

    //var_dump($_REQUEST);
    $result=array();
    $total_rows=0;
    $fitered=false;
    switch($_REQUEST['accion']){
        case 'TO':{
            $sql="SELECT  count(*) as total From pedidos   Where  (estado!=-1)";
            $total=R::getRow($sql);
            //var_dump($total);
            $total_rows=$total['total'];
            $sql="SELECT
                    npedido, 
                    codigo,
                    clienteNombre,
                    descripcion as Articulo,
                    estado,
                    Date_format( femis, '%d-%m-%Y' ) as fecha,
                    prodHabitual,
                    poliNumero as polId,
                    caras
                    From
                        pedidos
                    Where
                        (estado!=-1) ";


            if($_REQUEST['search']['value']!=''){
                $fitered=true;
                $keyword=$_REQUEST['search']['value'];
                $sql.=" AND ( codigo like '%".$keyword."%' OR clienteNombre like '%".$keyword."%' OR descripcion like '%".$keyword."%')";
            }

            //ORDER QUERY
            switch($_REQUEST['order'][0]['column']){
                case 0:{
                  
                    $sql.=" ORDER BY codigo ".$_REQUEST['order'][0]['dir'];
                      break;
                }
                case 1:{
                    
                    $sql.=" ORDER BY clienteNombre ".$_REQUEST['order'][0]['dir'];
                    break;
                }
                case 2:{
                    
                    $sql.=" ORDER BY Articulo ".$_REQUEST['order'][0]['dir'];
                    break;
                }
                
                default:{
                    $sql.=" ORDER BY codigo ".$_REQUEST['order'][0]['dir'];
                    break;
                }

            }

            $sql.=" LIMIT ".$_REQUEST['start'].",".$_REQUEST['length']." ;";
            $result=R::getAll($sql);
            break;
        }
        default:{
            break;
        }
    }

    $response=array(
        'draw' => $_REQUEST['draw'],
        'recordsTotal' => $total_rows,
        'recordsFiltered' =>($fitered)?count($result):$total_rows,
        'data' => $result
    );

    /*$response=$_REQUEST;
    $response['draw']=$_REQUEST['draw'];
    $response['recordsTotal']= count($result);
    $response['recordsFiltered']= count($result);
    $response['data']=$result;*/



    echo json_encode($response);