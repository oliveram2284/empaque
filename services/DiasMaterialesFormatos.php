<?php
session_start();
if(!$_SESSION['Nombre'])
{
    return false;
}
include ("../config.php");

if(!isset($_REQUEST['action'])){
    echo json_encode(null);
}else{
    $action=$_REQUEST['action'];
    switch($action){
        case '1':{
            // Retorna tbl_materiales_formatos_dias por ID
            $id=$_REQUEST['id'];
            $sql="SELECT * FROM tbl_materiales_formatos_dias where id=$id";
            $temp = R::getRow($sql);
            //var_dump($temp);
            $result=array('registro'=>$temp);
            echo json_encode($result);
            break;
        }
        case '4':{
            R::exec( 'DELETE FROM tbl_materiales_formatos_dias  WHERE id='.$_REQUEST['id'].'; ' );
            //$id = R::getInsertID();
            echo json_encode(array('result'=>true));
            break;
        }
        case '5':{
            
            $month=Date('m');
            $sql_temporada="SELECT * FROM tbl_temporada where tmpId=".(int)$month.";";
            $temp = R::getRow($sql_temporada);
            $sql_dias_temporada="SELECT * FROM tbl_materiales_formatos_dias WHERE formato_id=".$_REQUEST['formato_id']." and material_id=".$_REQUEST['material_id'].";";
            $dias_temp = R::getRow($sql_dias_temporada);

            if(is_null($dias_temp)){
               echo  json_encode(array('result'=>false,'date'=>array('year'=>Date('Y'),'month'=>Date('m'),'day'=>Date('d'))));
            }else{
                $dias=0;
                switch($temp['tmpTipo']){
                    case 'B':{
                        $dias=(int)$dias_temp['dias_baja'];
                    break;  
                    }
                    case 'M':{
                        $dias=(int)$dias_temp['dias_media'];
                    break;  
                    }
                    case 'A':{
                        $dias=(int)$dias_temp['dias_alta'];
                    break;  
                    }
                    default:{
                        $dias=0;
                        break;
                    }
                }

                $date_temp=date('d-m-Y',strtotime("+ ".$dias." days"));
                
                $final_date=null;
                $check_date=date('w',strtotime($date_temp));
                if($check_date=='6'){
                   $dias+=2;
                    $date_temp=date('d-m-Y',strtotime("+ ".$dias." days"));
                    $final_date = $date_temp;
                }elseif($check_date=='0'){
                    $dias+=1;
                    $date_temp=date('d-m-Y',strtotime("+ ".$dias." days"));
                    $final_date = $date_temp;               
                }else{
                    $final_date = $date_temp;
                }
               
                $result=array(
                    'year'=>Date('Y',strtotime($final_date)),
                    'month'=>Date('m',strtotime($final_date)),
                    'day'=>Date('d',strtotime($final_date))
                );
                echo  json_encode(array('result'=>true,'date'=>$result));
                
            }
            
            break;
        }
        default:{
            break;
        }
    }
}
