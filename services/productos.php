<?php 
if(!isset($_REQUEST['action'])){
    return false;
}
$action= $_REQUEST['action'];

include '../classes/classProductos.php';
$producto=new Productos();


switch($action){
    case 1:{
        //datatable filtering
        $filter_data=$_REQUEST;
        $recordsTotal=$producto->getProductsFilteredTotal($filter_data);
        $result=$producto->getProductsFiltered($filter_data);
        
        $response=array('result'=>true,'data'=>$result);

        $response=array(
			'draw' => $_REQUEST['draw'],
			'recordsTotal' => $recordsTotal,
			'recordsFiltered' => $recordsTotal,
			'data' => $result
		);
        echo json_encode($response);

        break;
    }
    default: {
        echo false;
        break;
    }
}
