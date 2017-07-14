<?php
session_start();
require('../../config.php');
///////////////////////////////////////////////////////
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];

if(isset($nombre) and isset($telef)) {
	$qry_puertos = "INSERT INTO cod_puertos (codigo, nombre) VALUES ('$codigo', '$nombre')";
	$exe_puertos = mysql_query($qry_puertos,$conexion) or die(mysql_error());
} else {
	header("location:puertos.php?puertoserror=true");
}
if($exe_lineas = true) { 
	header("location:puertos.php?puertosok=true");
}
?>