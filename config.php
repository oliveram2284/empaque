<?php

/*Desde aqu� se definen los valores globales del entorno de la aplicaci�n*/

// ** Configuracion de MySQL ** //

if(strrpos($_SERVER['REQUEST_URI'], 'empaque_demo')!==false){
	define('DB_NAME', 'mi000652_empaque_demo');     // el nombre de la base de datos
	define('DB_USER', 'root');     // el nombre de usuario de MySQL
	define('DB_PASSWORD', ''); // y la contrase�a
	define('DB_HOST', 'localhost');     // hay un 99% de probabilidades de que no sea necesario cambiar esto
	define('DB_CHARSET', 'utf8');
	define('APP_PATH', ''); // La URL debe terminar con una barra '/'
}else{
	define('DB_NAME', 'mi000652_empaque1');     // el nombre de la base de datos
	define('DB_USER', 'root');     // el nombre de usuario de MySQL
	define('DB_PASSWORD', ''); // y la contrase�a
	define('DB_HOST', 'localhost');     // hay un 99% de probabilidades de que no sea necesario cambiar esto
	define('DB_CHARSET', 'utf8');
	define('APP_PATH', ''); // La URL debe terminar con una barra '/'
}



// ** No edites desde aqui ** // ** // ** No edites desde aqui ** // ** // ** No edites desde aqui ** //


// ** Datos de la aplicaci�n ** //
define('APP_TITLE', 'CONTROL, PEDIDOS Y TRANSPORTE OnLine');
define('CLIENT_TITLE', 'EMPAQUE S.A.');
define('APP_VERSION', '0.6 (Beta1)');
define('APP_THEME', 'green');

// ** Definir la ruta absoluta de la aplicaci�n y los themes(TODO - Definir desde la BBDD?) ** //
define('ROOT', dirname(__FILE__).'/');
define('THEME_PATH', APP_PATH.'themes/'.APP_THEME.'/');
define('ABS_PATH', APP_PATH . THEME_PATH . '/');


include 'lib/rb.php';
//R::setup();

R::setup( 'mysql:host=localhost;dbname='.DB_NAME,DB_USER, DB_PASSWORD ); //for both mysql or mariaDB


?>
