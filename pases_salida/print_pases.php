<?php
require('ean13.php');
date_default_timezone_set('America/Caracas');
session_start();

$pdf = new PDF('letter','portrait');
$pdf->selectFont('./fonts/Courier');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
/////
require('../config.php');
$impresion = $_SESSION['codbarra_p'];
$paseprint = $_SESSION['idpase'];
$pdf->EAN13(480,740,$impresion);
$queEmp = "SELECT idpase, nom_ape_chfer, cedula, transporte, placa FROM pase_salida where idpase = '$paseprint'";
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$row = mysql_fetch_assoc($resEmp);

$qry = "select BL, embalaje, cont_x_embalaje, estado from inventario_cg where idpase = '$paseprint' and in_out = '1'";
$exe = mysql_query($qry, $conexion) or die (mysql_error());
$tot = mysql_num_rows($exe);
/////
/////
$ixx = 0;
while($datatmp = mysql_fetch_assoc($exe)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}
$titles = array(
				'BL'=>'<b>B/L</b>',
				'embalaje'=>'<b>Embalaje</b>',
				'cont_x_embalaje'=>'<b>Contenido</b>',
				'estado'=>'<b>Estado</b>'
			);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
//$txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
$txttit = "<b>PASE DE SALIDA</b>"."\n";
$txttit.= "<b>OVERSEA</b>\n";
/////
$pdf->ezText($txttit, 15);
$pdf->ezText("\n",8);
/////
$pdf->ezText("<b>DATOS DEL CONDUCTOR</b>",13);
$pdf->ezText("<b>Conductor:</b> ".$row['nom_ape_chfer']."    "."<b>Cedula:</b> ".$row['cedula'],12)."\n";
$pdf->ezText("<b>Transporte:</b> ".$row['transporte']."    "."<b>Placa:</b> ".$row['placa'],12)."<br>";
$pdf->ezText("\n",8);
$pdf->ezText("<b>DATOS DE LA CARGA</b>",14)."\n";
$pdf->ezText("\n\n",8);
$pdf->ezText("<b>CONTENIDO:</b> ",15)."\n";
$pdf->ezText("\n",8);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
//////
$pdf->stream();
?>