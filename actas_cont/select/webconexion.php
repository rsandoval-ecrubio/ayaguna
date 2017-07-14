<?php
function conectar()
{
	//mysql_connect("localhost", "tconnect_imsi", "12215358");
	$hostname_conexion = "localhost";
	$database_conexion = "tconnect_imsis";
	$username_conexion = "tconnect_imsis";
	$password_conexion = "12215358";
	$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_conexion, $conexion);
}

function desconectar()
{
	mysql_close();
}
?>