<?php
session_start();
require('../config.php');
include('../clases/mygeneric_class.php');
mysql_select_db($database_conexion,$conexion);
//toma de variables
//ITEMS A ALMACENAR EN FACT_FACTURA
	$fecha = date("Y-m-d");
	$idcliente = $_SESSION['idcliente'];
	$correlativo = $_SESSION['correlativo'];
	$cant = $_POST['cant'];
	$articulo = $_POST['articulo'];
	$precio = $_POST['estados'];
	$cont = $_POST['contenedor'];
	$ptotal = $cant * $precio;
//////////////////////////////////////////
$ingresa = "INSERT INTO fact_facturas (correlativo, fecha, cliente, articulo, cant, contenedor, punitario, ttl_item) VALUES ('$correlativo', '$fecha', '$idcliente', '$articulo', '$cant', '$cont', '$precio', '$ptotal')";
$ejecuta = mysql_query($ingresa, $conexion) or die("ERROR AQUI");
header("location:facturar2.php");




?>