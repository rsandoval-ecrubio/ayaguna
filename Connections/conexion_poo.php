<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "localhost";
$database_conexion = "appstc_ayaguna_master_tables";
$username_conexion = "appstc";
$password_conexion = "nVgXi3HT40";

$mysqli = new MySQLi;
$mysqli->connect($hostname_conexion,$username_conexion,$password_conexion,$database_conexion);
if($mysqli->error){
	echo "ERROR: imposible conectar";
}else{
	$conectado = true;
}

?>