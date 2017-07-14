<?php
//Registrar
session_start();
//Registro de daños
$lado = $_POST['lado'];
$panel = $_POST['panel'];
$dano = $_POST['dano'];

//Registrar
if (!empty($_POST['lado']) and !empty($_POST['panel']) and !empty($_POST['dano'])){
	$array = $lado.$panel.$dano;
	$_SESSION['dmg'][] = $array;
}
header("Location: reporte.php");
?>