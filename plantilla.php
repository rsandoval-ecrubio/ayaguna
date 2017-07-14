<?php 
require_once('../config.php');
//Nuevo modelo
require_once('../clases/seguridad_class.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
seguridad();
unset($_SESSION['linea']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ayaguna</title>
</head>
<body>
<header><?php include(INCLUDE_DIR.'menu_inc.php'); ?></header>
<div id="wrapper">
&nbsp;
</div>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>