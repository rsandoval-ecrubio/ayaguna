<?php 
session_start();
require('../../config.php');

mysql_select_db($database_conexion,$conexion);
$viaje = $_POST['viaje'];

//Datos del viaje
$SQLregistraviaje = sprintf("UPDATE precarga SET viaje = %d",$viaje);
$RUNregistraviaje = mysql_query($SQLregistraviaje,$conexion) or die(mysql_error()." Error: No se pudo actualizar la precarga");
mysql_query("CALL `precarga_limpia`()",$conexion);

header('Location: ../lista.php');
	
?>