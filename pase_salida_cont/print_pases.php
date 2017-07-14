<?php
require_once('../config.php');
//Nuevo modelo
require_once('../clases/seguridad_class.php');
require_once('../clases/class.MySQL.php');
//require_once('/ayaguna/clases/mygeneric_class.php');
require_once('ean13.php');

date_default_timezone_set('America/Caracas');

#Nombre de almacen
$db = $_SESSION['variables']['db'];
if($db == "appstc_ayaguna_jmp"){
	$almacen = "CORPORACION JMP C.A.";
}else if($db == "appstc_ayaguna_menfel"){
	$almacen = "Almacenadora MENFEL Almenfelca C.A.";
}else if($db == "appstc_ayaguna_conslg"){
	$almacen = "Consolidados La Guaira 2011, C.A.";
}else if($db == "appstc_ayaguna_gonavi"){
	$almacen = "IMPORTADORA Y TRANSPORTE GONAVI, C.A.";
}else if($db == "appstc_ayaguna_multimenfel"){
	$almacen = "MULTISERVICIOS MENFEL C.A.";
}else if ($db == "appstc_ayaguna_multiorion"){
	$almacen = "MULTISERVICIOS ORION 3000 C.A.";
}else if($db == "appstc_ayaguna_daqui"){
	$almacen = "Corporacion DAQUI, C.A.";
}
#Nombre de almacen

$pdf = new PDF('letter','portrait');
$pdf->selectFont('./fonts/Courier');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$impresion = $_SESSION['codbarra_pc'];
$paseprint = $_SESSION['pasecont'];
$pdf->EAN13(480,740,$impresion);

$pase = $_GET['paseprint'];
$datospase = new MySQL(USERDB);
$Qdatospase = sprintf("SELECT idpase, nom_ape_chfer, cedula, transporte, placa FROM pase_salida_cont where idpase = %d;",$pase);
$datospase->Consultar($Qdatospase);

#Datos del contenedor
$qdatos = sprintf("SELECT inventario.id, inventario.acta, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje,
inventario.contenedor,tequipos.tipo, inventario.fdb,inventario.frd, CASE inventario.`status` WHEN 0 THEN 'DMG' WHEN 1 THEN 'OPR-1' WHEN 2 THEN 'OPR-2' WHEN 3 THEN 'OPR-3' END AS `status`, CASE inventario.condicion WHEN 0 THEN 'EMPTY' WHEN 1 THEN 'FULL' END AS condicion, 
inventario.precinto, inventario.bl, patios.patio, consignatario.nombre AS `consignatario`,
inventario.obs
FROM inventario, lineas, buques, viajes, tequipos, consignatario, patios
WHERE lineas.id = inventario.linea AND buques.id = inventario.buque AND viajes.id = inventario.viaje AND tequipos.id = inventario.tcont AND consignatario.id = inventario.`consignatario` AND patios.id = inventario.patio AND inventario.pase = %d", $pase);
$contenedor = new MySQL(USERDB);
$contenedor->Consultar($qdatos);

/////
/////
$txttit = "<b>PASE DE SALIDA</b>"."  #".$datospase->Resultado['idpase']."\n";
$txttit.= "<b>".$almacen."</b>\n";

/////
$pdf->ezText($txttit, 15);
$pdf->ezText("\n",8);
/////
$pdf->ezText("<b>DATOS DEL CONDUCTOR</b>",13);
$pdf->ezText("<b>Conductor:</b> ".$datospase->Resultado['nom_ape_chfer']."    "."<b>Cedula:</b> ".$datospase->Resultado['cedula'],12)."\n";
$pdf->ezText("<b>Transporte:</b> ".$datospase->Resultado['transporte']."    "."<b>Placa:</b> ".$datospase->Resultado['placa'],12)."<br>";
$pdf->ezText("\n",8);
$pdf->ezText("<b>CONTENIDO:</b> ",15)."\n";
$pdf->ezText("\n",8);
$pdf->ezText("<b>Consignatario:</b> ".$contenedor->Resultado['consignatario'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>Linea:</b> ".$contenedor->Resultado['linea']."         "."<b>Buque:</b> ".$contenedor->Resultado['buque']."         "."<b>Viaje:</b> ".$contenedor->Resultado['viaje'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>B/L: </b>".$contenedor->Resultado['bl'],12)."\n";
$pdf->ezText("\n\n",8);
$pdf->ezText("<b>DATOS DEL EQUIPO</b> ",14)."\n";
$pdf->ezText("\n",2);
$pdf->ezText("<b>EQUIPO: </b>".$contenedor->Resultado['contenedor']."   "."<b>TIPO: </b>".$contenedor->Resultado['tipo']."   "."<b>ESTATUS: </b>".$contenedor->Resultado['status']."   "."<b>CONDICION: </b>".$contenedor->Resultado['condicion'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>PRECINTO: </b>".$contenedor->Resultado['precinto']."   "."<b>UBICACION: </b>".$contenedor->Resultado['patio'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>FECHA DESPACHO DE MUELLE: </b>".$contenedor->Resultado['fdb'],10)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>FECHA RECEPCION ALMACEN: </b>".$contenedor->Resultado['frd'],10)."\n";
$pdf->ezText("\n\n", 10);


$pdf->ezText("\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
//////
$pdf->stream();
?>