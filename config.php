<?php
session_start();

#Disable url fopen && url include
//ini_set('allow_url_fopen', 0);
//ini_set('allow_url_include', 0);

//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d H:i:s");
$ahoraShort = date("Y-m-d");
define('AHORA',$ahora);
define('AHORAC',$ahoraShort);

//Datos de Usuarios
define('MASTERTABLE','appstc_ayaguna_mastertable');
if(isset($_SESSION['variables'])){
	define('USERDB',$_SESSION['variables']['db']);
	define('UDB',$_SESSION['variables']['udb']);
	define('PDB',12215358);
	define('UNOMBRE',$_SESSION['variables']['nombre'] . ' ' . $_SESSION['variables']['apellido']);
	define('EMPRE',$_SESSION['variables']['nomdb']);
	define('USERREPORT',"Usuario: ".$_SESSION['variables']['nombreUsuario']." ".$_SESSION['variables']['apellidoUsuario']." Fecha: ".AHORA." IP: ".$_SERVER['REMOTE_ADDR']);
}

//Datos de la Aplicacion
define('THIS_VERSION','2.0 Ayaguna'); //Version.
define('ROOT_PATH','./'); //Directorio Raiz
define('ROOT_DIR',str_replace('\\\\', '/', realpath(dirname(__FILE__))).'/'); #Direccion real del directorio en Linux o Windows

//Define Directorios
define('INCLUDE_DIR',ROOT_DIR.'includes/'); //Directorio de Includes.
define('STYLE_DIR',ROOT_DIR.'css/'); //Directorio de Includes.
define('SPRY_DIR',ROOT_DIR.'SpryAssets/'); //Directorio de Spry
define('INDEX',ROOT_DIR.'index.php'); //Pagina de Inicio
define('PRECARGA',ROOT_DIR.'preload/upload/'); //Lista de importacion
define('CLASES',ROOT_DIR.'clases/'); // Directorio de clases
define('JS',ROOT_DIR.'JS/'); //Directorio Javascripts

//Define Estilo
define('ESTILO',STYLE_DIR."estilo_general.css");

//echo get_include_path();

set_include_path(ROOT_DIR.'includes');
include_once('Connections/conexion.php');
include_once('funciones/funciones.php');


//Boton Atras
define('ATRASLink',"<a href='#' onclick='history.go(-1)'; >Atras</a>");
define('ATRAS',"<input type='button' value='Atras' onClick='history.go(-1);'>");

//Datos para la instancia de contenedor a carga general
define('ALMACEN','');
define('CEDULACG','00000001');
define('PLACACG','0000001');

//Datos para el proceso de Instalacion
define('CARGAGENERAL','1'); //SET 1: PARA HABILITAR SET 0: PARA DESHABILITAR
define('CGA_X_LOTES','1'); // SET 1: PARA HABILITAR SET 0: PARA DESHABILITAR
?>
