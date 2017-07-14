<?php
session_start();
require('../../../config.php');
///////////////////////////////////////////////////////
$rif = $_POST['rif'];
$nombre = $_POST['nombre'];
if(isset($rif) and isset($nombre) and isset($delete)) {
	$qry_lineas = "INSERT INTO lineas (rif, nombre) VALUES ('$rif', '$nombre')";
	$exe_lineas = mysql_query($qry_lineas,$conexion) or die(mysql_error());
} else {
	header("location:linea.php");
}
if($exe_lineas = true) { 
	header("location:linea.php");
}
?>