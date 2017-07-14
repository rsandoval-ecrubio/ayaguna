<?php
$database_conexion = "appstc_ayaguna_jmp";
$username_conexion = "appstc";
$password_conexion = "nVgXi3HT40";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conexion, $conexion);

?>