<?php
session_start();
require('../config.php');
seguridad();


#Datos del Acta
$fecha = $_POST['fch_hora'];
$chofer = $_POST['nom_ape_chfer'];
$cedula = $_POST['cedula'];
$transporte = $_POST['transporte'];
$placa = $_POST['placa'];

$auditoria = $_SESSION['auth'];

#Datos del contenedor
$id = $_POST['idinv'];
$eir = $_POST['eir'];
$precinto = $_POST['precinto'];
$fdesp = $_POST['fdespims'];
$obs = $_POST['obs'];

if(isset($_POST)){
	
	mysql_select_db($database_conexion,$conexion);
	
	#Registrar Pase de Salida
	$qpasetxt = "INSERT INTO pase_salida_cont (fch_hora, nom_ape_chfer, cedula, transporte, placa, nula, auditoria) VALUE ('$fecha','$chofer','$cedula','$transporte','$placa',0,'$auditoria')";
	$qpaserun = mysql_query($qpasetxt,$conexion) or die(mysql_error()." No se pudo registrar el pase de salida");
	
	//Numero de Pase registrado
	$id_pase = $_SESSION['pasecont'] = mysql_insert_id();
	
	//CREO RANDOM, ALMACENO EN SESSION Y BD
		$random1 = mt_rand(1, 888);
		$random2 = mt_rand(1, 999);
		$random3 = (int)$_SESSION['pasecont'];
		$cod_gen = $_SESSION['codbarra_pc'] = $random1.$random3.$random2;
		$qry_pase2 = "UPDATE pase_salida_cont SET codigo_b_pases =  '$cod_gen' WHERE idpase = '$id_pase'";
		$exec_pase2 = mysql_query($qry_pase2,$conexion) or die(mysql_error());
	
	#Actualizar registro de contenedor
	$updatetxt = "UPDATE inventario SET pase = '$id_pase', fdespims = '$fdesp', eir_d = '$eir', precintodesp = '$precinto', obs = '$obs', c = 1 WHERE id = '$id'";
	$updaterun = mysql_query($updatetxt,$conexion)or die(mysql_error()." No se pudo actualizar el registro");
	
	//header('Location: pase_salida_cont.php');
	if($updaterun){
		header("location:finaliza_pase.php");
	}
	
}else {
	header('Location: pase_salida_cont.php?error=1');
}
?>