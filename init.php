<?php
require_once RUTA_INCLUDES.'/phpMailer/PHPMailerAutoload.php';
require_once RUTA_INCLUDES.'/mpdf/mpdf.php';

function cargarClases($nombreClase) {
  $nombre_archivo = RUTA_FRONTEND . str_replace('_', '/', $nombreClase) . '.php';
  if (file_exists($nombre_archivo)) {
    include_once( $nombre_archivo );
  }
}

function cargarClasesLib($nombreClase) {
  $nombre_archivo = RUTA_INCLUDES . str_replace('_', '/', $nombreClase) . '.php';
  if (file_exists($nombre_archivo)) {
    include_once( $nombre_archivo );
  }
}

spl_autoload_register(null, false);
spl_autoload_register('cargarClases', false);
spl_autoload_register('cargarClasesLib', false);

$GLOBALS['db'] = new Database( DBSERVIDOR, DBUSUARIO, DBCLAVE, DBNOMBRE);
$GLOBALS['db']->connect();
//$GLOBALS['nivel_idioma_idioma'] = Modelo_NivelxIdioma::obtieneListado();

if(count($_POST) != 0 && $_GET["mostrar"] != "publicar" && $_GET["mostrar"] != "oferta"){ $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); }
if(count($_GET) != 0){ $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING); }
if(count($_COOKIE) != 0){ $_COOKIE = filter_input_array(INPUT_COOKIE, FILTER_SANITIZE_STRING); }

//foreach($_SERVER as $key=>$server){
//	$_SERVER[$key] = ($key != 'HTTP_HOST') ? filter_input(INPUT_SERVER,$key,FILTER_SANITIZE_STRING) : $server;
//}

$_SUBMIT = array_merge($_POST, $_GET);       

Utils::createSession(); 
?>