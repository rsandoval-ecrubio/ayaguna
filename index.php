<?php 
session_start();
require('config.php');
//Nuevo modelo
include('includes/config.php');
require('clases/seguridad_class.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
//Nuevo modelo
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'menu_inc.php');
include(INCLUDE_DIR.'track_inc.php');
include(INCLUDE_DIR.'ppal_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
unset($_SESSION['linea']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<title>AYAGUNA</title>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>

</body>
</html>