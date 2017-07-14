<?php 
session_start();
require('../config.php');
seguridad();

$ids = implode(",",$_POST['id']); //Listado de equipos seleccionados
$fecha = date('Y-m-d');
mysql_select_db($database_conexion, $conexion);
$sqltxt = "INSERT INTO devtemp(fecha,acarreo) VALUES('$fecha','$ids')";
$sqlrun = mysql_query($sqltxt, $conexion) or die(mysql_error());
header("Location: gateout.php");
?>