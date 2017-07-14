<?php
#Disable url fopen && url include
ini_set('allow_url_fopen', 0);
ini_set('allow_url_include', 0);

//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d H:i:s");
//define('AHORA',$ahora);


//Time Stamp
$timestamp = date("Y-m-d H:i:s");

//Validador de Session
$vSession = $_SESSION['autentificado'];

//Base de datos
$dbDatos = $_SESSION['variables']['db'];
//Nombre de Usuario
$nombreUsuarioCompleto = $_SESSION['variables']['nombreUsuario']." ".$_SESSION['variables']['apellidoUsuario'];
//Nivel de Usuario
$nivelUsuario = $_SESSION['variables']['nivel'];
//Tipo de Usuario
$tipoUsuario = $_SESSION['variables']['tipo'];

?>