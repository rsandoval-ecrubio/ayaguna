<?php
require_once('../../../config.php');
include('../../../clases/mygeneric_class.php');

if(isset($_POST['id']) and $_POST['id'] <> NULL){
	$idviaje = $_POST['id'];
	$viaje = $_POST['viaje'];
	$arribo = $_POST['eta'];
	$actualizar = new DBMySQL();
	$actualizar->nombreDB(USERDB);
	$qact = sprintf("UPDATE viajes SET viaje = '%s', eta = '%s', ad = '%s' WHERE id = %d",$viaje,$arribo,$arribo,$idviaje);
	$actualizar->consultarDB($qact);
	$vinculo = sprintf("Location: viaje_edit.php?id=%d",$idviaje);
	header($vinculo);
}

?>