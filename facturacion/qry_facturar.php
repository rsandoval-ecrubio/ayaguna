<?php
session_start();
require('../config.php');
include('../clases/mygeneric_class.php');

//toma de variables
//$tipocliente = $_POST['tipocliente'];
$rif = $_POST['rif'];
mysql_select_db($database_conexion,$conexion);
$consulta = "SELECT * FROM fact_clientes where rif = '$rif'";
$verifia = mysql_query($consulta, $conexion) or die(mysql_error());
$row = mysql_fetch_assoc($verifia);
$ttl = mysql_num_rows($verifia);

if($ttl == 0) {
	header("location:facturar.php?noexiste=true");
} else {
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
}

?>