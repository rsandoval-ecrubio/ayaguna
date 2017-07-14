<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
require('../../../config.php');
require_once("../../../clases/mygeneric_class.php");
require_once('../../../Connections/conexion.php');


if(isset($_POST)){
	#Variables
	$linea = $_POST['linea'];
	$nombre = $_POST['nombre'];
	$observ = $_POST['observaciones'];
	
	#Verificar existencia de buque
	$validar = new DBMySQL();
	$sql = sprintf("SELECT id, nombre FROM buques WHERE activo = 0 AND linea = 29 AND nombre LIKE '%s';",$linea,$nombre);
	$validar->consultarDBli(1,$sql);
	if($validar->totalli > 0){
		die("<h1>ERROR</h1><p>El buque ya se encuentra registrado</p>");
	}else {
		#Consulta
		$registrar = new DBMySQL();
		//$registrar->consultarDBli(1,$qry_buques);
		//$registrar->nombreDB($_SESSION['variables']['db']);
		$qry_buques = sprintf("INSERT INTO buques (linea, nombre, obs) VALUES ('%d', '%s', '%s')",$linea,$nombre,$observ);
		$registrar->insertarDBli(1,$qry_buques);
		
		if($registrar->afectadosli > 0){
			header("Location: listado.php");
		}else {
			die("No se pudo registrar");
		}
	}
}else {
	die("No se recibieron los datos");
}

?>