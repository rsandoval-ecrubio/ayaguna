<?php
session_start();
require('../config.php');
mysql_select_db($database_conexion,$conexion);
//REWCIBIMOS LOS DATOS DEL FORMULARIO
$chofer = $_POST['nom_ape_chfer'];
$cedula = $_POST['cedula'];
$transporte = $_POST['transporte'];
$placa = $_POST['placa'];
$destino = $_POST['destino'];
$fecha = AHORA;
//hacemos el insert de los datos para el pase
$qry = "INSERT INTO pase_salida (nom_ape_chfer, cedula, transporte,fch_hora, placa, destino) VALUES ('$chofer','$cedula','$trasnporte','$fecha','$placa','$destino')";
$exe = mysql_query($qry, $conexion) or die(mysql_error());

if($exe == true) {
	$_SESSION['idpase'] = mysql_insert_id();
	$_SESSION['chofer'] = $_POST['nom_ape_chfer'];
	$_SESSION['cedula'] = $_POST['cedula'];
	$_SESSION['transp'] = $_POST['transporte'];
	$_SESSION['placa'] = $_POST['placa'];
	$_SESSION['destino'] = $_POST['destino'];
		//CREO RANDOM, ALMACENO EN SESSION Y BD
		$pase_creado = $_SESSION['idpase'];
		$random1 = mt_rand(1, 888);
		$random2 = mt_rand(1, 999);
		$random3 = (int)$_SESSION['idpase'];
		$cod_gen = $_SESSION['codbarra_p'] = $random1.$random3.$random2;
		$qry_pase2 = "UPDATE pase_salida SET codigo_b_pases =  '$cod_gen' WHERE idpase = '$pase_creado'";
		$exec_pase2 = mysql_query($qry_pase2,$conexion) or die(mysql_error());
	header("location:index_pases.php");
}

?>