<?php
require_once('../Connections/conexion.php');
require('ean13.php');
date_default_timezone_set('America/Caracas');
session_start();

//$pdf = new Cezpdf('letter');
$pdf = new PDF('letter');
//$pdf->selectFont('../pdfclass/fonts/Courier.afm');
$pdf->selectFont('./fonts/Courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
$print = $_SESSION['barcod'];
$pdf->EAN13(480,740,$print);

mysql_select_db($database_conexion, $conexion);

//Datos del Acta del Contenedor
$acta = $_GET['acta'];

//Datos del Contenedor
$equipo = $_GET['equipo'];

//Consulta Acta
$qrytxtActa = "SELECT idacta, fch_hora, nom_ape_chfer, cedula, transporte, placa, origen FROM acta_recepcion WHERE idacta = '$acta'";
$qryrunActa = mysql_query($qrytxtActa,$conexion) or die(mysql_error());
$rowActa = mysql_fetch_assoc($qryrunActa);
$totalRowActa = mysql_num_rows($qryrunActa);

//Consultar datos del Contenedor
$qrytxtEquipo = "SELECT
inventario.id, inventario.acta, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje,
inventario.contenedor,tequipos.tipo, inventario.fdb,inventario.frd, 
CASE inventario.`status`
WHEN 0 THEN 'DMG'
WHEN 1 THEN 'OPR-1'
WHEN 2 THEN 'OPR-2'
WHEN 3 THEN 'OPR-3'
END AS `status`,
CASE inventario.condicion
WHEN 0 THEN 'EMPTY'
WHEN 1 THEN 'FULL'
END AS condicion, 
inventario.precinto, inventario.bl, inventario.patio, consignatario.nombre AS `consignatario`,
inventario.obs
FROM inventario, lineas, buques, viajes, tequipos, consignatario
WHERE lineas.id = inventario.linea
AND buques.id = inventario.buque
AND viajes.id = inventario.viaje
AND tequipos.id = inventario.tcont
AND consignatario.id = inventario.`consignatario`
AND inventario.acta = '$acta'";
$qryrunEquipo = mysql_query($qrytxtEquipo,$conexion) or die(mysql_error());
$rowEquipo = mysql_fetch_assoc($qryrunEquipo);
$totalRowEquipo = mysql_num_rows($qryrunEquipo);

$txttit = "<b>ACTA DE RECEPCION </b>"."#".$rowActa['idacta']."\n";
$txttit.= "<b>OVERSEA</b>\n";

$pdf->ezText($txttit, 15);
$pdf->ezText("\n",8);
$pdf->ezText("<b>DATOS DEL CONDUCTOR</b>",13);
$pdf->setLineStyle(1);
$pdf->line(10,10,10,10);
$pdf->ezText("\n\n",1);
$pdf->ezText("<b>Conductor:</b> ".$rowActa['nom_ape_chfer']."                  "."<b>Cedula:</b> ".$rowActa['cedula'],12)."\n";
$pdf->ezText("\n\n",1);
$pdf->ezText("<b>Transporte:</b> ".$rowActa['transporte']."              "."<b>Placa:</b> ".$rowActa['placa'],12)."<br>";
$pdf->ezText("\n",8);
$pdf->ezText("<b>DATOS GENERALES</b>",14)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>Consignatario:</b> ".$rowEquipo['consignatario'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>Linea:</b> ".$rowEquipo['linea']."         "."<b>Buque:</b> ".$rowEquipo['buque']."         "."<b>Viaje:</b> ".$rowEquipo['viaje'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>B/L: </b>".$rowEquipo['bl'],12)."\n";
$pdf->ezText("\n\n",8);
$pdf->ezText("<b>DATOS DEL EQUIPO</b> ",14)."\n";
$pdf->ezText("\n",2);
$pdf->ezText("<b>EQUIPO: </b>".$rowEquipo['contenedor']."   "."<b>TIPO: </b>".$rowEquipo['tipo']."   "."<b>ESTATUS: </b>".$rowEquipo['status']."   "."<b>CONDICION: </b>".$rowEquipo['condicion'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>PRECINTO: </b>".$rowEquipo['precinto']."   "."<b>UBICACION: </b>".$rowEquipo['patio'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>FECHA DESPACHO DE MUELLE: </b>".$rowEquipo['fdb'],10)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>FECHA RECEPCION ALMACEN: </b>".$rowEquipo['frd'],10)."\n";
$pdf->ezText("\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>