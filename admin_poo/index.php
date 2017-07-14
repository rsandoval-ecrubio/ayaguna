<?php
session_start();
include('../includes/config.php');
require('../clases/seguridad_class.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IMSSis - LOGIN</title>
<link href="../css/front_adm_user.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Sistema de Administracion de Acceso.</h1>
<p>Usuario: <?php echo $nombreUsuarioCompleto; ?></p>
<p><a href="niveles.php">Niveles</a> | <a href="../salida.php">Salir</a></p>
<hr />
<p><a href="usuarios_lista.php">Usuarios</a> | <a href="usuario_nuevo.php">Nuevo</a> | Editar | Inhabilitar | Eliminar</p>
<hr />
<p><a href="origen_datos.php">Bases de Datos</a> | Nueva | Inhabilitar</p>
<hr />
<p>&nbsp;</p>
</body>
</html>