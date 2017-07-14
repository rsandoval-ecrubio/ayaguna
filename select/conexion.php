<?php
//session_start();
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
if(isset($_SESSION['variables']['db']) and $_SESSION['variables']['db'] != NULL){
	$database_conexion = $_SESSION['variables']['db'];
}else {
	$database_conexion = NULL;
}
$hostname_conexion = "localhost";
/*
switch ($db){
	case 1:
	$database_conexion = "appstc_ayaguna_jmp";
	break;
	case 2:
	$database_conexion = "appstc_ayaguna_menfel";
	break;
	return $database_conexion;
}
*/
//echo $database_conexion;
$username_conexion = "appstc";
$password_conexion = "nVgXi3HT40";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
$conexion_li = mysqli_connect($hostname_conexion,$username_conexion,$password_conexion,$database_conexion) or trigger_error(mysqli_error(),E_USER_ERROR); 
?>