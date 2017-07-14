<?php 
session_start();
require('../../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
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
<h2 align="center">Tablas - Linea</h2>
  <hr />
<fieldset>
<legend>Linea nueva</legend>
<form id="form1" name="form1" method="post" action="qry_linea.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="9%">Rif:</td>
      <td width="91%"><label>
        <input type="text" name="rif" id="rif" />
      </label></td>
    </tr>
    <tr>
      <td>Nombre:</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button2" id="button2" value="Agregar" />
      </label></td>
    </tr>
  </table>
</form>
</fieldset>
<hr />
</div>
</body>
</html>
