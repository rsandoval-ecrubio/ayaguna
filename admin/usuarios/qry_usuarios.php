<?php 
require('../../config.php');
require('../../clases/mygeneric_class.php');

foreach ($_POST as $key => $value){
	if (empty($value)){
		die("<strong>El campo $key esta vacio.</strong><br>".ATRAS);
	}
}

//Validar Usuario
$validar = new DBMySQL;
$validar->nombreDB(MASTERTABLE);
$qtxt = sprintf("SELECT id, usuario FROM usuarios WHERE usuario = '%s'",$_POST['login']);
$validar->consultarDB($qtxt);
if($validar->total > 0){
	die("<strong>Ya existe el usuario</strong><br>".ATRAS);
}

//Variables
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$tlf = $_POST['tlf'];
$email = $_POST['email'];
$login = $_POST['login'];
$pass = md5($_POST['pass']);
$linea = $_POST['linea'];
$nivel = $_POST['nivel'];
$tipo = $_POST['tipo'];
$db = $_POST['db'];

//Construccion de consulta
$consulta = sprintf("INSERT INTO usuarios (nombre,apellido,email,telefono,usuario, clave, nivel, tipo, linea, datos) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
												$nombre,
												$apellido,
												$email,
												$tlf,
												$login,
												$pass,
												$nivel,
												$tipo,
												$linea,
												$db);
$usuario = new DBMySQL;
$usuario->nombreDB(MASTERTABLE);
$usuario->registroDB($consulta);

header("Location: listado_usuarios.php");
?>