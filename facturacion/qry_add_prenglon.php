<?php
session_start();
require('../config.php');
include('../clases/mygeneric_class.php');

//toma de variables
//$tipocliente = $_POST['tipocliente'];
$articulo = $_POST['articulo'];
$precio = $_POST['precio'];

$registra = new DBMySQL();
$registra->nombreDB("appstc_ayaguna_jmp");
$registra->registroDB("INSERT INTO fact_precios (articulo, precio) VALUES ('$articulo', '$precio')");

header("location:add_renglon.php?addok=true");

?>