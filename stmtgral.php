<?php
if(class_exists('MySQL')){
	return true;
}else {
	include('clases/class.MySQL.php');
}

//Datos Basicos
//Lineas
$lineas = new MySQL(USERDB);
$lineas->Consultar("SELECT id, nombre FROM lineas WHERE activo=0;");

//Buques
$buques = new MySQL(USERDB);
$buques->Consultar("SELECT id, nombre FROM buques WHERE activo=0;");

//Viajes
$viajes = new MySQL(USERDB);
$viajes->Consultar("SELECT id, viaje FROM viajes WHERE activo=0;");

//Tipos
$tipos = new MySQL(USERDB);
$tipos->Consultar("SELECT id, tipo FROM tequipos WHERE id NOT IN(13,14,16,17);");

//Consignatarios
$consignatarios = new MySQL(USERDB);
$consignatarios->Consultar("SELECT id, trim(nombre) as `nombre` FROM consignatario WHERE nombre IS NOT NULL AND nombre !='' ORDER BY nombre;");

//Patios
$patios = new MySQL(USERDB);
$patios->Consultar("SELECT id, patio FROM patios ORDER BY patio;");
?>
