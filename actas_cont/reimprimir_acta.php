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

#Datos del Acta del Contenedor
$nacta = decodificar($_GET['id']);

$DatosActa = new MySQL(USERDB);
$ConsultaActas = sprintf("SELECT * FROM acta_recepcion WHERE idacta = %d",$nacta);
$DatosActa->Consultar($ConsultaActas);

#Datos del Contenedor
#Consultar datos del Contenedor
$inventario = new MySQL(USERDB);
$qinventario = sprintf("SELECT inventario.id,inventario.acta,lineas.nombre AS linea,inventario.contenedor,tequipos.tipo, CASE inventario.`status` WHEN 0 THEN 'EMPTY' WHEN 1 THEN 'FULL' END AS `status`, CASE inventario.condicion WHEN 0 THEN 'DMG' WHEN 1 THEN 'OPR1' WHEN 2 THEN 'OPR2' WHEN 3 THEN 'OPR3' WHEN 4 THEN 'N-OPR' END AS `condicion`,
buques.nombre AS buque,viajes.viaje,viajes.eta AS arribo, inventario.fdm,inventario.frd,inventario.eir_r,inventario.precinto,inventario.bl,consignatario.nombre AS `consignatario`,inventario.obs, patios.patio, TO_DAYS(CURDATE()) - TO_DAYS(viajes.eta) AS dpais, TO_DAYS(CURDATE()) - TO_DAYS(inventario.frd) AS dalm
FROM inventario, tequipos, buques, viajes, consignatario, patios, lineas
WHERE lineas.id = inventario.linea AND inventario.c = 0 AND inventario.`status` = 1 AND tequipos.id = inventario.tcont AND buques.id = inventario.buque AND viajes.id = inventario.viaje AND consignatario.id = inventario.`consignatario` AND patios.id = inventario.patio AND inventario.acta = %d",$nacta);

$inventario->Consultar($qinventario);


//$pdf = new Cezpdf('letter');
$pdf = new PDF('letter');
//$pdf->selectFont('../pdfclass/fonts/Courier.afm');
$pdf->selectFont('./fonts/Courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$print = $DatosActa->Resultado['codigo_b_actas'];

$pdf->EAN13(480,740,$print);


$txttit = "<b>ACTA DE RECEPCION </b>"."#".$DatosActa->Resultado['idacta']."\n";
$txttit.= "<b>".$almacen."</b>\n";

$pdf->ezText($txttit, 15);
$pdf->ezText("\n",8);
$pdf->ezText("<b>DATOS DEL CONDUCTOR</b>",13);
$pdf->setLineStyle(1);
$pdf->line(10,10,10,10);
$pdf->ezText("\n\n",1);
$pdf->ezText("<b>Conductor:</b> ".$DatosActa->Resultado['nom_ape_chfer']."  <b>Cedula:</b>  ".$DatosActa->Resultado['cedula']."</b>",12)."\n";
$pdf->ezText("\n\n",1);
$pdf->ezText("<b>Transporte:</b> ".$DatosActa->Resultado['transporte']."   <b>Placa:</b> ".$DatosActa->Resultado['placa']."</b>",12)."<br>";
$pdf->ezText("\n",8);
$pdf->ezText("<b>DATOS GENERALES</b>",14)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>Consignatario:</b>".$inventario->Resultado['consignatario'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>Linea:</b> ".$inventario->Resultado['linea']." <b>Buque:  </b>".$inventario->Resultado['buque']."  <b>Viaje:  </b>".$inventario->Resultado['viaje'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>B/L: </b>".$inventario->Resultado['bl'],12)."\n";
$pdf->ezText("\n\n",8);
$pdf->ezText("<b>DATOS DEL EQUIPO</b> ",14)."\n";
$pdf->ezText("\n",2);
$pdf->ezText("<b>EQUIPO: </b> ".$inventario->Resultado['contenedor']." <b>TIPO: </b> ".$inventario->Resultado['tipo']." <b>ESTATUS: </b> ".$inventario->Resultado['status']." <b>CONDICION: </b>".$inventario->Resultado['condicion'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>PRECINTO: </b>".$inventario->Resultado['precinto']." <b>UBICACION: </b> ".$inventario->Resultado['patio'],12)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>FECHA DESPACHO DE MUELLE: </b>".$inventario->Resultado['fdm'],10)."\n";
$pdf->ezText("\n\n",2);
$pdf->ezText("<b>FECHA RECEPCION ALMACEN: </b>".$inventario->Resultado['frd'],10)."\n";
$pdf->ezText("\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>