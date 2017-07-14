<?php
session_start();
require('../config.php');
include('../clases/mygeneric_class.php');

//toma de variables
//$tipo = $_POST['tipocliente'];
$nombre_rsocial = $_POST['nombre_rsocial'];
$rif = $_POST['rif'];
$direccion = $_POST['direccion'];
$telefono1 = $_POST['telefono1'];
$telefono2 = $_POST['telefono2'];

$registra = new DBMySQL();
$registra->nombreDB("appstc_ayaguna_jmp");
$registra->registroDB("INSERT INTO fact_clientes (nombre_rsocial,rif,direccion,telefono1,telefono2) VALUES ('$nombre_rsocial','$rif','$direccion','$telefono1','$telefono2')");
$ultimoregistro = mysql_insert_id();

$consulta = "SELECT * FROM fact_clientes where id = '$ultimoregistro'";
$verifia = mysql_query($consulta, $conexion) or die(mysql_error());
$row = mysql_fetch_assoc($verifia);
$ttl = mysql_num_rows($verifia);

	$_SESSION['idcliente'] = $row['id'];
	$_SESSION['rifcliente'] = $rif;
	$_SESSION['nombre_rsocial'] = $row['nombre_rsocial'];
	$_SESSION['direccion'] = $row['direccion'];
	$_SESSION['telefono1'] = $row['telefono1'];
	$_SESSION['telefono2'] = $row['telefono2'];
	$ifiscal = "12345678910";
	$fecha = date("Y-m-d");
	$ingresa = "INSERT INTO fact_correlativos (ifiscal, fecha) VALUES ('$ifiscal', '$fecha')";
	$ejecuta = mysql_query($ingresa, $conexion) or die(mysql_error());
	$_SESSION['correlativo'] = mysql_insert_id();

header("location:facturar2.php");


?>