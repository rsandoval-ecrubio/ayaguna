<?php 
require_once('../Connections/conexion.php');

function consulta($tabla){
	mysql_select_db($database_conexion, $conexion);
	$query = "SELECT * FROM ".$tabla;
	$Rquery = mysql_query($query, $conexion) or die(mysql_error());
	$row = mysql_fetch_assoc($Rquery);
	$totalRows = mysql_num_rows($Rquery);
	
	return $row;
	mysql_free_result($lineas);
	
}
?>
