<?php
session_start();
require('../config.php');
include('../clases/mygeneric_class.php');

//toma de variables
//$tipocliente = $_POST['tipocliente'];
$renglon = $_POST['renglon'];

$registra = new DBMySQL();
$registra->nombreDB("appstc_ayaguna_jmp");
$registra->registroDB("INSERT INTO fact_renglones (articulo) VALUES ('$renglon')");
$_SESSION['idrenglon'] = mysql_insert_id();

header("location:add_preciorenglon.php");


?>