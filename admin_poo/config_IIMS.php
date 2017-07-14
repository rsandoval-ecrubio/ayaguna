<?php
session_start();
#Disable url fopen && url include
ini_set('allow_url_fopen', 0);
ini_set('allow_url_include', 0);

define('THIS_VERSION','1.1 ECS'); //Version.
define('ROOT_PATH','./'); //Directorio Raiz
define('ROOT_DIR',str_replace('\\\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])).'/'); #Direccion real del directorio en Linux o Windows

echo ROOT_DIR."ayaguna";


set_include_path(ROOT_DIR.'includes');
include('../Connections/conexion_poo.php');
include('../funciones/funciones_poo.php');
?>