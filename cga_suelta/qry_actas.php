<?php
session_start();
require('../config.php');
mysql_select_db($database_conexion,$conexion);

//CAPTURA DE DATOS PRINCIPALES DEL ACTA.
$chofer = $_SESSION['chofer'] = $_POST['nom_ape_chfer'];
$cedula = $_SESSION['cedula'] = $_POST['cedula'];
$transporte = $_SESSION['transporte'] = $_POST['transporte'];
$placa = $_SESSION['placa'] = $_POST['placa'];
$consignatario = $_SESSION['consignatario'] = $_POST['consignatario'];
$origen = $_SESSION['origen'] = $_POST['origen'];
$linea = $_SESSION['linea'] = $_POST['linea'];
$buque = $_SESSION['buque'] = $_POST['select2'];
$viaje = $_SESSION['viaje'] = $_POST['select3'];
$BL = $_SESSION['BL'] = $_POST['BL'];
$fact = $_SESSION['fact'] = $_POST['fact'];
$expediente = $_SESSION['expediente'] = $_POST['expediente'];
$packing = $_SESSION['packing'] = $_POST['packing'];
$observ = $_SESSION['observ'] = $_POST['observ'];
$operador = $_SESSION['nombreusuario'];
//INICIALIZAMOS EL ACTA DE RECPCION PARA RESERVAR EL NUEMRO Y MANTENER EL CONSECUTIVO.
$qry_acta = "INSERT INTO acta_recepcion_cg (nom_ape_chfer, cedula, transporte, placa, consignatario, origen, linea, buque, viaje, BL, fact, expediente, packing, fch_hora, observ, operador) VALUES ('$chofer', '$cedula', '$transporte', '$placa', '$consignatario', '$origen', '$linea', '$buque', '$viaje', '$BL', '$fact', '$expediente', '$packing', '$ahora', '$observ', '$operador')";
$exec_actas = mysql_query($qry_acta,$conexion) or die(mysql_error());
//VERIFICAMOS EL ESTATUS DEL INSERT Y TOMAMOS LOS DATOS PARA LLENAR INVENTARIO.
if($exec_actas = true) {
	$qry_get_acta = "SELECT * FROM acta_recepcion_cg WHERE operador = '$operador' ORDER BY idacta DESC";
	$exec_qry_get = mysql_query($qry_get_acta,$conexion) or die(mysql_error());
	$fila_qry_get = mysql_fetch_assoc($exec_qry_get);
	$_SESSION['acta'] = $fila_qry_get['idacta'];
	$acta_creada = 	$_SESSION['acta'];
	$_SESSION['operador'] = $fila_qry_get['operador'];
	$_SESSION['BL'] = $fila_qry_get['BL'];
	$_SESSION['fact'] = $fila_qry_get['fact'];
	$_SESSION['expediente'] = $fila_qry_get['expediente'];
	$_SESSION['packing'] = $fila_qry_get['packing'];
	
	//Mostrar el nombre del Consignatario
	$consigSQL = mysql_query("SELECT id, nombre FROM consignatario WHERE id=".$fila_qry_get['consignatario']) or die(mysql_error());
	$consigResultado = mysql_fetch_assoc($consigSQL);
	//Mostrar el nombre del Consignatario
	
	$_SESSION['consignatario'] = $consigResultado['nombre'];
	$_SESSION['id_consignatario'] = $consigResultado['id'];
	$_SESSION['fecha_acta'] = $fila_qry_get['fch_hora'];
	//CREO RANDOM, ALMACENO EN SESSION Y BD
		$random1 = mt_rand(1, 999);
		$random2 = mt_rand(1, 888);
		$random3 = (int)$_SESSION['acta'];
		$cod_gen = $_SESSION['codbarras'] = $random1.$random3.$random2;
		$qry_acta2 = "UPDATE acta_recepcion_cg SET codigo_b_actas =  '$cod_gen' WHERE idacta = '$acta_creada'";
		$exec_acta2 = mysql_query($qry_acta2,$conexion) or die(mysql_error());
	
	//Creacion del registro de vaciado - tabla vaciado
	if(isset($_POST['idInstancia']) and !empty($_POST['idInstancia'])){
		$idCont = $_POST['idInstancia'];
		$idActacont = $_POST['actainstancia'];
		$idActacg = $_SESSION['acta'];
		$auditoria = $_SESSION['auth'];
		$fecha = date('Y-m-d');
		$registrar = mysql_query("INSERT INTO vaciado(actacont,actacg,fecha,auditoria) VALUES('$idActacont','$idActacg','$fecha','$auditoria')") or die(mysql_error()." - ERROR: No se pudo realizar el registro en la tabla de vaciado");
		$idVaciado = mysql_insert_id();
		
		$actualizacion_cont = mysql_query("UPDATE inventario SET vaciado = '$idVaciado', `status` = 0 WHERE id = '$idCont'") or die(mysql_error());
	}
	//Creacion del registro de vaciado - tabla vaciado
	
	header("location:cgagral_cont.php?cont=true");
}
?>
