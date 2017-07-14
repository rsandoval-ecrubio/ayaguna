<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
//include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<legend align="center">FACTURAR</legend>
<form id="form1" name="form1" method="post" action="qry_facturar.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="9%" valign="top">&nbsp;</td>
      <td width="91%">&nbsp;</td>
    </tr>
    <tr>
      <td>CEDULA / RIF</td>
      <td><label for="rif"></label>
        <input type="text" name="rif" id="rif" onkeyup="this.value=this.value.toUpperCase()" />
        <input type="submit" name="button" id="button" value="Buscar" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?php if(!isset($_GET['noexiste'])) { } else { ?>CLIENTE NO EXISTE. AGREGUE EL CLIENTE NUEVO HACIENDO CLIC 
	  <a href="add_cliente.php">AQUI</a>
	  <?php } ?></td>
      </tr>
  </table>
</form>
</fieldset>
<hr />
</div>
</body>
</html>