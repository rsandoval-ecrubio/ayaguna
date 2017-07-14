<?php
require('../config.php');
require('../clases/seguridad_class.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
seguridad();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA - Graficos</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php');?>
	<div id="content">&nbsp;
	  <h2>DEMO</h2>
	  <p>Graficas disponible:</p>
	  <ul>
	    <li><a href="ingresos.php" target="new">Ingresos 2012</a></li>
      </ul>
	</div>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>