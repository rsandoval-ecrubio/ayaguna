<?php
require('../config.php');
require('../clases/mygeneric_class.php');

$query = NULL;

if(isset($_POST['in']) and $_POST['in'] == 1){
	//Variables
	$query = sprintf("UPDATE inventario SET viaje = %d,
							  tcont = %d,
							  frd = '%s',
							  eir_r = %d,
							  fact = %d,
							  `status` = %d,
							  condicion = %d,
							  precinto = '%s',
							  bl = '%s',
							  patio = %d,
							  consignatario = %d,
							  obs = '%s' WHERE id = %d",
							  $_POST['viaje'],
							  $_POST['tipo'],
							  $_POST['frd'],
							  $_POST['eir_r'],
							  $_POST['fact'],
							  $_POST['status'],
							  $_POST['condicion'],
							  $_POST['precinto'],
							  $_POST['bl'],
							  $_POST['patio'],
							  $_POST['consignatario'],
							  $_POST['obs'],
							  $_POST['id']);							  
}else if(isset($_POST['out']) and $_POST['out'] == 1){
	$query = sprintf("UPDATE inventario SET tcont = %d,
							   frd = '%s',
							   `status` = %d,
							   fact = %d,
							   precinto = '%s',
							   bl = '%s',
							   consignatario = %d,
							   buque = %d,
							   fdespims = '%s' WHERE id = %d",
							   $_POST['tipo2'],
							   $_POST['frd2'],
							   $_POST['status2'],
							   $_POST['fact2'],
							   $_POST['precinto2'],
							   $_POST['bl2'],
							   $_POST['consignatario2'],
							   $_POST['buqued'],
							   $_POST['fdespims'],
							   $_POST['id']);
}
if(!empty($query)){
	$actualiza = new DBMySQL;
	$actualiza->nombreDB(USERDB);
	$actualiza->registroDB($query);
	if($actualiza->afectados > 0){
		header("Location: container.php");
	}else{
		die("No se pudo actualizar el equipo");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>test</title>
</head>
<body>
<p><a href="container.php">Regresar</a></p>
<p>&nbsp;</p>
</body>
</html>