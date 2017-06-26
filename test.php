<?php

var_dump($_REQUEST);

$multi=(int)$_REQUEST['multiplo'];
$decimal=(int)$_REQUEST['decimal'];

var_dump($multi);
var_dump($decimal);
$min=0;
$max=$multi;
$i=1;
$flag=false;
do{


  $min=$max;
  $max=$multi*$i;

  if($decimal>=$max){
    $i++;
  }else{
    $flag=true;
  }
  echo "==>   $i ==> $min  and $max <br>";
}while(!$flag);


echo " <br>";
$medio = $multi * 0.5;
$min_medio= $min + $medio;
echo "==> I= $i   <br>==> Min= $min  <br>==> Max $max <br>==> Medio: $medio <br>==> Min Medio: $min_medio <br>";



var_dump($decimal % $multi);
var_dump($decimal / $min);
var_dump($decimal / $medio);
var_dump($decimal / $medio);

if( $decimal == $min || $decimal == $min_medio || $decimal == $max){
  //echo "opcion validad: $decimal <br>";
  echo "opcion validad: $decimal <br>";
}else{
  if($decimal < $min){
    echo "menor min <br>";
    echo "opcion validad: $min <br>";
  }elseif ($decimal < $min_medio) {
    echo " mayor minimo y menor a min_medio  <br>";
    echo "opcion validad: $min <br>";
    echo "opcion validad: $min_medio <br>";
  }elseif ($decimal < $max) {
    echo " mayor min_medio y menor a Maximo  <br>";
    echo "opcion validad: $min_medio <br>";
    echo "opcion validad: $max <br>";
  }
}



/*
if( () < 1){
  echo "min <br>";
}elseif (()>1) {
  # code...
}*/

/*if($decimal == $min || $decimal == $min_medio || $decimal == $max){
  echo "ES IGUAL A UNA CANTIDAD";
}elseif (($decimal/$multi)) {
  # code...
}*/



/*
die();
function abc(){
  return __FUNCTION__;
}
function xyz(){
  return abc();
}
echo xyz();*/
