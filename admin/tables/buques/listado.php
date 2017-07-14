<?php 
session_start();
require('../../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');

//QRY LISTADO DE BUQUES PAGINADO
mysql_select_db($database_conexion, $conexion);
$_pagi_sql = "select buques.id, lineas.nombre as linea, buques.nombre, buques.obs from buques, lineas where buques.linea = lineas.id";

$_pagi_cuantos = 15;
$_pagi_nav_num_enlaces = 3;
$_pagi_nav_anterior = "&lt;";
$_pagi_nav_siguiente = "&gt;";
include('../../../funciones/paginar.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../../../css/estilo_general.css" rel="stylesheet" type="text/css" />
<!--////////////fin////////////////////// -->
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.info {
	width: 900px;
	padding: 4px;
}
#info {
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	margin-top: 0px;
}
#index {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
#index tr td {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
</style>
</head>
<body>
<div class="info" id="info">
<h2 align="center">Tablas - Buques</h2>
  <hr />
  <fieldset>
  <legend>Listado de Buques</legend>
  
  <table width="50%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="4" align="right"><?php echo $_pagi_navegacion; ?></td>
      </tr>
    <tr>
      <td width="7%">ID</td>
      <td width="47%">LINEA</td>
      <td width="47%">BUQUE</td>
      <td width="46%" align="center">OBSERVACIONES</td>
    </tr>
    <?php while($row = mysql_fetch_array($_pagi_result)){ ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['linea']; ?></td>
      <td><?php echo $row['nombre']; ?></td>
      <td><?php echo $row['observaciones']; ?></td>
    </tr>
    <?php } ?>
  </table>
  </fieldset>
  <hr />
  </div>
</body>
</html>