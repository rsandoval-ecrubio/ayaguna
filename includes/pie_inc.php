<?php require_once(ROOT_DIR.'/funciones/funciones_poo.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<style type="text/css">
.pie {
	position: fixed;
	left: 0px;
	bottom: 0px;
	width: 100%;
	height: 40px;
	overflow: hidden;
	background-color: #FFF;
	border-top-width: 0.1em;
	border-top-style: solid;
	border-top-color: #F00;
	float: left;
	margin-bottom: 0px;
	margin-right: auto;
	margin-left: auto;
	margin-top: 0%;
	visibility: visible;
	right: 0px;
}
.pietxt {
	width: 90%;
	height: auto;
	padding: 4px;
	margin-top: 2px;
	margin-right: auto;
	margin-bottom: auto;
	margin-left: 2%;
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 11px;
}
body {
	margin-bottom: 0px;
	margin-top: auto;
	margin-right: auto;
	margin-left: auto;
}
</style>
</head>

<body>
<div class="pie" id="pie">
  <div class="pietxt" id="pietxt">True Connections - &nbsp; 2010 &copy; | Almacen: <?php showAlmacen($_SESSION['variables']['db']);?></div>
</div>
</body>
</html>