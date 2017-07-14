<?php
require('../config.php');
require('../clases/mygeneric_class.php');

if(isset($_POST) && !empty($_POST)){

	$id = $_POST['id']; 
	$fecha = $_POST['fecha'];
	$condicion = $_POST['condicion'];
	$antobs = $_POST['antobs'];
	$monto = $_POST['monto'];
	
	$sql = sprintf("UPDATE reparaciones SET fecha = '%s', condicion = '%s', antobs = '%s', monto = %01.2f WHERE id = %d;",
					$fecha,$condicion,$antobs,$monto,$id);
	//echo $sql;
	$actualizar = new DBMySQL;
	$actualizar->nombreDB(USERDB);
	$actualizar->registroDB($sql);
	header("Location: list.php");
}
?>