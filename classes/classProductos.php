<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ("../config.php");

class Productos{

    function __construct() {
       
    }

    public function getProductsFiltered($data=null){
        //$sql= "SELECT DISTINCT(descrip3) AS codigo,descripcion,count(descrip3) AS total FROM pedidos GROUP BY descrip3  order by total desc;";
        $sql= "SELECT DISTINCT(descrip3) AS codigo,descripcion,count(descrip3) AS total FROM pedidos  where descrip3 !='' ";

        if(isset($data['search']['value']) && $data['search']['value']!=''){
            $sql.= " AND ( descrip3 LIKE '%".$data['search']['value']."%' OR descripcion LIKE '%".$data['search']['value']."%' )" ;
        }
        
        $sql.=" GROUP BY descrip3  " ; //Filtra sin repetir codigo(descrip3) de producto 

        switch($data['order'][0]['column']){
            case 0:{
                $sql.= " order by codigo ".$data['order'][0]['dir']." ";           
                break;
            }
            case 1:{
                $sql.= " order by descripcion ".$data['order'][0]['dir']." ";                    
                break;
            }case 2:{
                $sql.= " order by total ".$data['order'][0]['dir']." ";                    
                break;
            }   
            default:{
                $sql.= " order by codigo ".$data['order'][0]['dir']." ";     
                break;
            }     
        }

        if(isset($data['start']) && isset($data['length'])){
            $sql.= " LIMIT  ". $data['start'] .",".  $data['length']." " ;
        }

        //die($sql);
        $sql.=" ; ";
        $result= R::getAll($sql);
        return $result;
    }

    public function getProductsFilteredTotal($data=null){
        $sql= "SELECT DISTINCT(descrip3) AS codigo,descripcion,count(descrip3) AS total FROM pedidos  where descrip3 !='' ";

        if(isset($data['search']['value']) && $data['search']['value']!=''){
            $sql.= " AND ( descrip3 LIKE '%".$data['search']['value']."%' OR descripcion LIKE '%".$data['search']['value']."%' )" ;
        }
        
        $sql.=" GROUP BY descrip3  " ; //Filtra sin repetir codigo(descrip3) de producto 

        switch($data['order'][0]['column']){
            case 0:{
                $sql.= " order by codigo ".$data['order'][0]['dir']." ";           
                break;
            }
            case 1:{
                $sql.= " order by descripcion ".$data['order'][0]['dir']." ";                    
                break;
            }case 2:{
                $sql.= " order by total ".$data['order'][0]['dir']." ";                    
                break;
            }   
            default:{
                $sql.= " order by codigo ".$data['order'][0]['dir']." ";     
                break;
            }     
        }

        $sql.=" ; ";

        $result= R::getAll($sql);
        return count($result);
    }
    
}