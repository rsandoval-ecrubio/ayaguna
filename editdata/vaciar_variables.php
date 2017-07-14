<?php
require('../config.php');
require('../clases/mygeneric_class.php');

//Ejecutar la actualizacion
if(isset($_POST['consulta']) and $_POST['consulta'] == 1){
	$reintegro = new DBMySQL();
	$reintegro->nombreDB($_SESSION['variables']['db']);
	$reintegro->registroDB($_SESSION['query']);
}

if($reintegro->afectados > 0){
	unset($_SESSION['error']);
	unset($_SESSION['fecha']);
	unset($_SESSION['seriales']);
	unset($_SESSION['query']);
}

header("Location: reintegro.php");
?>