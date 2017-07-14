<?php
session_start();
require('../config.php');
include('../clases/mygeneric_class.php');
mysql_select_db($database_conexion,$conexion);
//toma de variables
//ITEMS A ALMACENAR EN FACT_FACTURA
	$correlativo = $_SESSION['correlativo'];
	$flcontrol = $_POST['flcontrol'];
	$depcheque = $_POST['depcheque'];
	$montodepcheque = $_POST['montodepcheque'];
	$banco = $_POST['banco'];
	$subtotal = $_POST['subtotal'];
	$iva = $_POST['iva'];
	$total = $_POST['total'];
	if($si_isrl == 1) { 
	$RETISRL = $_POST['retISRL'];
	} else {
		$RETISRL = 0; }
	if($si_iva == 1) {
		$RETIVA = $_POST['retIVA'];
	} else { 
		$RETIVA = 0; }
//////////////////////////////////////////
$ingresa = "INSERT INTO fact_facttotales (idfactura, flcontrol,  depcheque, montodepcheque, banco, subtotal, iva, total, retislr, retiva) VALUES ('$correlativo', '$flcontrol', '$depcheque', '$montodepcheque', '$banco', '$subtotal', '$iva', '$total', '$RETISRL', '$RETIVA')";
$ejecuta = mysql_query($ingresa, $conexion) or die(mysql_error());

$update = "UPDATE fact_facturas SET flcontrol = '$flcontrol' WHERE correlativo = '$correlativo'";
$doupdate = mysql_query($update, $conexion) or die(mysql_error());

header("location:impresion.php");




?>