<?php
session_start();
include('../includes/config.php');
require('../clases/seguridad_class.php');
//require('../funciones/funciones_poo.php');
require('../clases/mygeneric_class.php');
require('../clases/user_class.php');
//Seguridad
$seguridad = new Seguridad();
$seguridad->getDato();
$seguridad->valida();

//Variables del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$usuario = $_POST['usuario'];
$clave = $_POST['c1'];
$confirmacion = $_POST['c2'];
$bdatos = $_POST['db'];
$tipo = $_POST['tipo'];
$linea = $_POST['linea'];
$nivel = $_POST['nivel'];

//Nuevo Usuario
$NuevoUsuario = new Usuario();
$NuevoUsuario->datosUsuario($nombre,$apellido,$correo,$telefono,$usuario,$clave,$confirmacion,$bdatos,$tipo,$linea,$nivel);
$NuevoUsuario->crearUsurio();
?>