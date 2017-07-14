<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
//include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
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
  <hr />
<fieldset>
<legend>Agregar Renglon</legend>
<form id="form1" name="form1" method="post" action="qry_add_renglon.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="9%">Renglon:</td>
      <td width="91%"><label>
        <input name="renglon" type="text" id="renglon" size="70" />
      </label></td>
    </tr>
    <tr>
      <td>Precio#1:</td>
      <td><input name="precio1" type="text" id="precio1" size="12" /></td>
    </tr>
    <tr>
      <td>Precio#2:</td>
      <td><input name="precio2" type="text" id="precio2" size="12" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?php if(!isset($_GET['addok'])) { } else { echo "REGISTRO INSERTADO CON EXITO"; } ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><label>
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
