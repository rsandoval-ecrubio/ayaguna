<?php
session_start();
//require('../../../config.php');
require_once("../../../clases/mygeneric_class.php");

if(isset($_POST)){
	$buque = $_POST['buque'];
	$viaje = $_POST['viaje'];
	$eta = $_POST['eta'];
	$ad = $eta;
	
	$registrar = new DBMySQL;
	$registrar->nombreDB($_SESSION['variables']['db']);
	$qry_viajes = sprintf("INSERT INTO viajes (buque, viaje, eta, ad) VALUES ('%s', '%s', '%s', '%s')",$buque,$viaje,$eta,$ad);
	$registrar->registroDB($qry_viajes);
	if($registrar->afectados > 0){
		header("Location: lista_viaje.php");
	}else {
		die("No se pudo registrar el viaje");
	}
	
}else {
	die("No se recibieron los datos");
}
?>