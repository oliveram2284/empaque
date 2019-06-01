<?php
session_start();
if(!$_SESSION['Nombre'])
{
  header('Location: index.php');
}

include ("conexion.php");
$var = new conexion();
$var->conectarse();




if(!isset($_REQUEST['action'])){

	return false;


}

function get_menu($data){

	$new_orden=array();
	$level_3=array();
	$level_2=array();
	$level_1=array();
	foreach ($data as $key => $item) {
		//var_dump($item);
		if ($item[6]=='3') { //parent id=0
			$level_3[]=$item;
		}
		if ($item[6]=='2') { //parent id=0
			$level_2[]=$item;
		}
		if ($item[6]=='1') { //parent id=0
			$level_1[]=$item;
		}

	}


	foreach ($level_2 as $level_2_key => $level_2_item) {
		$level_2[$level_2_key][9]=array();
		foreach ($level_3 as $level_3_key => $level_3_item) {
			if($level_2_item[0] == $level_3_item[7]){
				$level_2[$level_2_key][9][]=$level_3_item;
			}
		}
	}


	foreach ($level_1 as $level_1_key => $level_1_item) {
		$level_1[$level_1_key][9]=array();
		foreach ($level_2 as $level_2_key => $level_2_item) {
			if($level_1_item[0] == $level_2_item[7]){
				$level_1[$level_1_key][9][]=$level_2_item;
			}
		}
	}

	return $level_1;
}


switch ($_REQUEST['action']) {
	case 1:{

		$sql  = "SELECT * FROM  tbl_menu_emp order by orden asc, id_menu asc ";


		$resultado = mysql_query($sql)or die(mysql_error());

		$menu_items=array();
		while ($fila = mysql_fetch_array($resultado, MYSQL_NUM)) {
			$menu_items[]=$fila;
		}
		$result=get_menu($menu_items);
		$menu_output="";
		foreach ($result as $key => $item) {

			$menu_output.='<li  id="list_'.$item[0].'" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">';
			if(empty($item[9])){
				$menu_output.='<div>'.utf8_encode($item[2]) .' <label class="pull-right" ><a href="#" class="span_edit" data-id="'.$item[0].'"  ><i class="fa fa-pencil" aria-hidden="true"></i></a>  <a class="span_remove" data-id="'.$item[0].'" ><i href="#" class="fa fa-times" aria-hidden="true"></i></a></label>       </div>';
			}else{
				$level_2=$item[9];
				//var_dump($level_2);

				$menu_output.='<div>'.utf8_encode($item[2]).' <label class="pull-right" ><a href="#" class="span_edit" data-id="'.$item[0].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>  <a class="span_remove" data-id="'.$item[0].'" ><i href="#" class="fa fa-times" aria-hidden="true"></i></a></label>       </div>';
				$sub_menu	='';
				$sub_menu.='<ol>';

				foreach ($level_2 as $skey => $level_2_item) {
					$sub_menu	.='<li  id="list_'.$level_2_item[0].'" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">';
					//var_dump($level_2_item[9]);
					if(empty($level_2_item[9])){
						$sub_menu	.='<div class="sub">'.utf8_encode($level_2_item[2]) .'  <label class="pull-right" ><a href="#" class="span_edit" data-id="'.$level_2_item[0].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>  <a href="#" class="span_remove" data-id="'.$item[0].'"><i class="fa fa-times" aria-hidden="true"></i></a></label>       </div>';
					}else{
						$sub_menu	.='<div class="sub">'.utf8_encode($level_2_item[2]) .' <label class="pull-right" ><a href="#" class="span_edit" data-id="'.$level_2_item[0].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>  <a href="#" class="span_remove" data-id="'.$item[0].'"><i class="fa fa-times" aria-hidden="true"></i></a></label>       </div>';

						$level_3= $level_2_item[9];

						$sub_menu_leve_3	='';
						$sub_menu_leve_3.='<ol>';
						foreach ($level_3 as $skey => $level_3_item){

							$sub_menu_leve_3	.='<li  id="list_'.utf8_encode($level_3_item[0]).'" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">';
							$sub_menu_leve_3	.='		<div class="sub2">'.utf8_encode($level_3_item[2]).'    <label class="pull-right" ><a href="#" class="span_edit" data-id="'.$level_3_item[0].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>  <a href="#" class="span_remove" data-id="'.$item[0].'"><i class="fa fa-times" aria-hidden="true"></i></a></label>       </div>  ';
							$sub_menu_leve_3	.='</li>';

						}

						$sub_menu_leve_3.='</ol>';
						//echo($sub_menu_leve_3);
						$sub_menu.=$sub_menu_leve_3;
					}
					$sub_menu	.='</li>';
				}
				$sub_menu.='</ol>';
				//echo $sub_menu;

				$menu_output.=$sub_menu;
			}
			$menu_output.='</li>';
		}

		echo $menu_output;
		break;
	}
	case 2:{

		$list = $_POST['list'];

		$temp=array();
		foreach ($list as $key => $item) {
			//var_dump($item['item_id']);
			if($item['item_id']!='null'){
				//var_dump($item);
				$temp[]=array(
					'id_menu'		=>	$item['item_id'],
					'orden'			=>	$key,
					'parent_id'	=>	($item['parent_id']!='null')?(int)$item['parent_id']:0,
					'level'			=>	(int)$item['depth']
				);
			}


		}

		foreach ($temp as $key => $item) {
			$sql  = "UPDATE tbl_menu_emp SET orden=".$item['orden'].", parent_id=".$item['parent_id'].",level=".$item['level']." WHERE id_menu=".$item['id_menu']." ;";
			//echo $sql."<br>";
			$resultado = mysql_query($sql)or die(mysql_error());
			//var_dump($resultado);
		}
		break;
	}

	case 3:{
		//var_dump($_POST);
	}

	default:
		return false;
		break;
}


?>
