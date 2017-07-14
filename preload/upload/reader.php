<?php
session_start();
include('../../config.php');
require('../../Connections/conexion.php');
$linea = $_SESSION['intLinea'];

mysql_select_db($database_conexion,$conexion);


$fichero = fopen("lista.csv","r")or die("No se consigue el archivo");
while (!feof($fichero)){
	$campo = fgetcsv($fichero,4096,";");
	$hay = count($campo);
	
	//echo $linea."-".$campo[0]."-".$campo[1]."-".$campo[2]."-".$campo[3]."-".$campo[4]."-".$campo[5]."-".$campo[6]."-".$campo[7]."-".$campo[8]."<br>";
	
	$insert = "INSERT INTO precarga(linea,lote,equipo,tipo,precinto,peso,estatus,bl,consig,distribucion,ubicacion) VALUES ('$linea','$campo[0]','$campo[1]','$campo[2]','$campo[3]','$campo[4]','$campo[5]','$campo[6]','$campo[7]','$campo[8]','$campo[9]');";
	//echo $insert."<br />";
	$runInsert = mysql_query($insert,$conexion) or die(mysql_error()." Error: No se pudo registar la precarga");

}
fclose($fichero);

//mysqli_select_db($conexion_li,$database_conexion);
	#Normalizar los datos
	//$normaliza = mysqli_query($conexion_li,"CALL normalizaPrecarg();")or die(mysqli_error());
	//mysqli_close($conexion_li);
	mysql_query("CALL `normalizaPrecarga`()",$conexion);
	//mysql_query("CALL `precarga_limpia`()",$conexion);
header("Location: check_data.php");

?>
