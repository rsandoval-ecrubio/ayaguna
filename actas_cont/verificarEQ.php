<?php 
// En el caso probable de trabajar
//con una base de datos se haria una consulta
//para averiguar si el nombre esta libre o no
require_once('../Connections/conexion.php');

if(isset($_GET['q'])){
	$contenedor = $_GET['q'];
	mysql_select_db($database_conexion,$conexion);
	$qrytxt = "SELECT c FROM inventario WHERE contenedor = '$contenedor'";
	$qryrun = mysql_query($qrytxt,$conexion) or die(mysql_error());
	$result = mysql_fetch_assoc($qryrun);
	$totalResult = mysql_num_rows($qryrun);
}

if ($totalResult > 0){
	echo "Equipo Registrado";
}
?>