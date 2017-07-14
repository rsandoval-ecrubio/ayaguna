<?php 
require('../../config.php');
require('../../clases/mygeneric_class.php');

if(isset($_POST) || !empty($_POST)){
	//Variables
	$id = $_POST['id'];
	$pass = md5($_POST['password']);
	
	$update = new DBMySQL;
	$update->nombreDB(MASTERTABLE);
	$consulta = sprintf("UPDATE usuarios SET clave = '%s' WHERE id = %d",$pass,$id);
	$update->registroDB($consulta);
	
	header("Location: listado_usuarios.php");
}

?>