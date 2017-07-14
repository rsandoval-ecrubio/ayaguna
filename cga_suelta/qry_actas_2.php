<?php
session_start();
require('../config.php');
mysql_select_db($database_conexion,$conexion);
//REVISAMOS VARIABLES DE POST Y SESSION
$acta = $_SESSION['acta'];
$fecha_acta = $_SESSION['fecha_acta'];
$fact = $_SESSION['fact'];
$expediente = $_SESSION['expediente'];
$packing = $_SESSION['packing'];
$BL = $_SESSION['BL'];
$consignatario = $_SESSION['id_consignatario'];
$embalaje = $_POST['embalaje'];
$estado = $_POST['estado'];
$cont_x_embalaje = $_POST['cont_x_emb'];
$cantidad = $_POST['cantidad'];
$lote = $_POST['lote'];
$operador = $_SESSION['nombreusuario'];
$alto_emb = $_POST['alto_emb'];
$ancho_emb = $_POST['ancho_emb'];
$largo_emb = $_POST['largo_emb'];
$peso_emb = $_POST['peso'];
$volumen_emb = (float)$largo_emb * $ancho_emb * $alto_emb;
$m2 = (float)$largo_emb * $ancho_emb;
$m3 = (float)$largo_emb * $ancho_emb * $alto_emb;
$cod_barras = $_SESSION['codbarras'];

//CONSTRUIMOS QURY INSERTAMOS Y VOLVEMOS
$qry_insert_inv = "INSERT INTO inventario_cg (idacta, fecha_acta, fact, expediente, packing, lote, BL,consignatario, embalaje, estado, cont_x_embalaje, alto_emb, ancho_emb, largo_emb, peso, volumen, cantidad, operador, m2, m3, codigo_b_actas) VALUES ('$acta', '$fecha_acta', '$fact', '$expediente', '$packing', '$lote', '$BL','$consignatario', '$embalaje', '$estado', '$cont_x_embalaje', '$alto_emb', '$ancho_emb', '$largo_emb', '$peso_emb', '$volumen_emb', '$cantidad', '$operador', '$m2', '$m3','$cod_barras')";
$exec_insert_inv = mysql_query($qry_insert_inv, $conexion) or die(mysql_error());

if($exec_insert_inv = true) {
	header("location:cgagral_cont.php?cont=true");
} else {
	header("location:cgagral_cont.php?error_insert=true");
}
?>