<?php 
session_start();
require('../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
/*
mysql_select_db($database_conexion,$conexion);
$query_lineas = "SELECT id, nombre FROM lineas ORDER BY nombre ASC";
$lineas = mysql_query($query_lineas, $conexion) or die(mysql_error());
$row_lineas = mysql_fetch_assoc($lineas);
$totalRows_lineas = mysql_num_rows($lineas);
////////CONEXION A BASE DE DATOS USERSYSTEM
$server_usersystem = "localhost";
$database_usersystem = "imssisc_usersystem";
$username_usersystem = "imssisc";
$password_usersystem = "%analema.";
$cnx_string_usersystem = mysql_connect($server_usersystem, $username_usersystem, $password_usersystem) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_usersystem, $cnx_string_usersystem);
$qry_usuarios_os = "SELECT * FROM usuarios where c_imssis = '002' and nivel <> '-1'";
$exe_usuarios_os = mysql_query($qry_usuarios_os, $cnx_string_usersystem) or die(mysql_error());
$fila_usuarios_os = mysql_fetch_assoc($exe_usuarios_os);
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
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
<h2 align="center">Tablas - Consignatarios</h2>
  <hr />
  <fieldset>
  <legend>Consignatarios</legend>
  <form id="form1" name="form1" method="post" action="qry_consig.php">
    <table width="60%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="21%">RIF</td>
        <td width="79%"><label for="rif"></label>
          <input name="rif" type="text" id="rif" value="J-0000000-0" /></td>
      </tr>
      <tr>
        <td>NOMBRE</td>
        <td><input type="text" name="nombre" id="nombre" /></td>
      </tr>
      <tr>
        <td>P. CONTACTO</td>
        <td><input type="text" name="pcontacto" id="pcontacto" /></td>
      </tr>
      <tr>
        <td>TELEFONO</td>
        <td><input type="text" name="telf" id="telf" /></td>
      </tr>
      <tr>
        <td>EMAIL</td>
        <td><input type="text" name="email" id="email" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center">
        <?php if(!isset($_GET['consigok'])) { } else { echo "registro insertado correctamente."; } ?>
        <?php if(!isset($_GET['consigerror'])) { } else { echo "Ocurrio un error verifique o comuniquese con un administrador del sistema."; } ?>
        </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Guardar" /></td>
      </tr>
    </table>
  </form>
  </fieldset>
  <hr />
  </div>
</body>
</html>