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

header("location:facturar.php");


?>