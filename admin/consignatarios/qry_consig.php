<?php
session_start();
require('../../config.php');
///////////////////////////////////////////////////////
$rif = $_POST['rif'];
$nombre = $_POST['nombre'];
$pcontacto = $_POST['pcontacto'];
$telef = $_POST['telf'];
$email = $_POST['email'];

mysql_select_db($database_conexion,$conexion);
if(isset($nombre) and isset($telef)) {
	$qry_buques = "INSERT INTO consignatario (rif, nombre, pcontacto, telf, email) VALUES ('$rif', '$nombre', '$pcontacto', '$telef', '$email')";
	$exe_buques = mysql_query($qry_buques,$conexion) or die(mysql_error());
} else {
	header("location:consignatarios.php?consigerror=true");
}
if($exe_lineas = true) { 
	header("location:consignatarios.php?consigok=true");
}
?>