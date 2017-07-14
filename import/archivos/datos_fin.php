<?php 
# Transformar datos.
require '../../config.php';
require_once '../../clases/mygeneric_class.php';

if(!isset($_SESSION['up'])){
	$_SESSION['up'] = false;
}
$validate = 0;
	
# Linea
$lineaprecarga = new DBMySQL;
$lineaprecarga->consultarDBli(1,"SELECT linea FROM precarga LIMIT 1;");
$NomLinea = $lineaprecarga->resultadoli['linea'];

$linea = new DBMySQL;
$linea->consultarDBli(1,"SELECT id FROM lineas WHERE nombre ='".$NomLinea."';");
if($linea->totalli > 0){
	$idlinea = $linea->resultadoli['id'];
	$validate = $validate + 1;
}else {
	die("<h1>No se puede transformar los datos:|:Error-Linea</h1>Comuniquese con el Administrador del Sistema");
}

# Buque
$buqueprecarga = new DBMySQL;
$buqueprecarga->consultarDBli(1,"SELECT buque FROM precarga LIMIT 1;");
$NomBuque = $buqueprecarga->resultadoli['buque'];

$buque = new DBMySQL;
$buque->consultarDBli(1,"SELECT id FROM buques WHERE linea =".$idlinea." AND nombre ='".$NomBuque."';");
if($buque->totalli > 0){
	$idbuque = $buque->resultadoli['id'];
	$validate = $validate + 1;
}else {
	die("<h1>No se puede transformar los datos:|:Error-Buque</h1>Comuniquese con el Administrador del Sistema");
}

# Viaje
$viajeprecarga = new DBMySQL;
$viajeprecarga->consultarDBli(1,"SELECT buque, viaje FROM precarga LIMIT 1;");
$NomViaje = $viajeprecarga->resultadoli['viaje'];

$viaje = new DBMySQL;
$qviaje = sprintf("SELECT id FROM viajes WHERE buque = %d AND viaje = '%s'",$idbuque,$NomViaje);

$viaje->consultarDBli(1,$qviaje);
if($viaje->totalli > 0){
	$idviaje = $viaje->resultadoli['id'];
	$validate = $validate + 1;
}else {
	die("<h1>No se puede transformar los datos:|:Error-Viaje</h1>Comuniquese con el Administrador del Sistema");
}

if($validate == 3){
	$precarga = new DBMySQL;
	$Qprecarga = sprintf("UPDATE precarga SET linea = %d, buque = %d, viaje = %d",$idlinea,$idbuque,$idviaje);
	$precarga->insertarDBli(1,$Qprecarga);
	
	if($precarga->afectadosli > 0){
		$normaliza = new DBMySQL;
		$normaliza->insertarDBli(1,"CALL `normalizaPrecarga`()");
		
		$listar = new DBMySQL;
		$listar->insertarDBli(1,"CALL `precarga_limpia`()");
		
		$borrar = new DBMySQL;
		$borrar->insertarDBli(1,"TRUNCATE `precarga`;");
		
		$_SESSION['up'] = true;
		$vinculo = sprintf("Location: ../fin.php?b=%d&v=%d",$idbuque,$idviaje);
		header($vinculo);
		
	}else {
		die("<h1>No se pudo actualizar la precarga</h1>");
	}
}else {
	die("<h1>No se pudo actualizar la precarga</h1>");
}

?>