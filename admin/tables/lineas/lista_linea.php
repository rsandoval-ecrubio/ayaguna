<?php 
session_start();
require('../../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');

//QRY LISTADO DE BUQUES PAGINADO
mysql_select_db($database_conexion, $conexion);
$qryL = "select * from lineas where activo = '0'";
$exeL = mysql_query($qryL, $conexion) or die(mysql_error());
$row = mysql_fetch_assoc($exeL);


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
<h2 align="center">Tablas - Lineas</h2>
  <hr />
<fieldset class="listado">
<legend>Listado de Lineas</legend>
<form id="form1" name="form1" method="post" action="disable_linea.php">
  <table width="50%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="3" align="right"></td>
    </tr>
    <tr>
      <td width="22%">RIF</td>
      <td width="68%">Linea</td>
      <td width="10%"><input type="submit" name="button" id="button" value="Disable" /></td>
    </tr>
    <?php do { ?>
    <tr>
      <td><?php echo $row['rif']; ?></td>
      <td><?php echo $row['nombre']; ?></td>
      <td align="center"><label>
                <input name="campos[<?php echo $row['id']; ?>]" type="checkbox" />
          </label></td>
    </tr>
    <?php } while ($row = mysql_fetch_assoc($exeL)); ?>
  </table>
</form>
</fieldset>
 <hr />
  </div>
</body>
</html>