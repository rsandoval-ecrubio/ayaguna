<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_data = "-1";
if (isset($_POST['id'])) {
  $colname_data = $_POST['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_data = sprintf("SELECT * FROM existencia WHERE id = %s", GetSQLValueString($colname_data, "int"));
$data = mysql_query($query_data, $conexion) or die(mysql_error());
$row_data = mysql_fetch_assoc($data);
$totalRows_data = "-1";
if (isset($_POST['id'])) {
  $totalRows_data = $_POST['id'];
}

mysql_select_db($database_conexion, $conexion);
$query_data = sprintf("SELECT * FROM existencia WHERE id = %s", GetSQLValueString($colname_data, "int"));
$data = mysql_query($query_data, $conexion) or die(mysql_error());
$row_data = mysql_fetch_assoc($data);
$totalRows_data = mysql_num_rows($data);

$colname_inv = "-1";
if (isset($_POST['id'])) {
  $colname_inv = $_POST['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT acta, linea, buque, viaje FROM inventario WHERE id = %s", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$colname_acta = "-1";
if (isset($_POST['acta'])) {
  $colname_acta = $_POST['acta'];
}
mysql_select_db($database_conexion, $conexion);
$query_acta = sprintf("SELECT factpack FROM acta_recepcion WHERE idacta = %s", GetSQLValueString($colname_acta, "int"));
$acta = mysql_query($query_acta, $conexion) or die(mysql_error());
$row_acta = mysql_fetch_assoc($acta);
$totalRows_acta = mysql_num_rows($acta);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css">
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
<!--
#act_rec {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:225px;
	z-index:1;
	background-color: #FFFFFF;
}
#act_rec_cg {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:225px;
	z-index:1;
	background-color: #FFFFFF;
	
}
-->
</style>
</head>

<body>
<div class="info" id="info">
  <h2 align="center">Acta de recepción | Carga Contenerizada -&gt; Carga General </h2>
  <hr />
  <form id="form1" name="form1" method="post" action="../cga_suelta/qry_actas.php">
    <table width="80%" border="0" cellspacing="1" cellpadding="0" align="center">
      <tr>
        <td colspan="4">DATOS DEL CONDUCTOR
          <input name="fch_hora" type="hidden" id="fch_hora" value="<?php date("Y-m-d H:i:s"); ?>" /></td>
      </tr>
      <tr>
        <td valign="middle">Nombre(s) y apellido(s):
          <input name="nom_ape_chfer" type="text" class="txtImportante" id="nom_ape_chfer" value="<?php echo ALMACEN;?>" size="50" readonly="readonly" />
        </td>
        <td width="5%">C. I:</td>
        <td width="21%">
          <input name="cedula" type="text" class="txtImportante" id="cedula" value="<?php echo CEDULACG;?>" readonly="readonly" />
        </td>
</tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">DATOS DEL TRANSPORTE</td>
      </tr>
      <tr>
        <td valign="middle">Transporte:
          <input name="transporte" type="text" class="txtImportante" id="transporte" value="<?php echo ALMACEN;?>" size="50" readonly="readonly" />
        </td>
        <td>Placa:</td>
        <td>
          <input name="placa" type="text" class="txtImportante" id="placa" value="<?php echo PLACACG;?>" readonly="readonly" />
        </td>
        <td width="1%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">DATOS GENERALES DE LA CARGA</td>
      </tr>
      <tr>
        <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="12%">Consignatario:</td>
            <td colspan="5"><label for="Dconsignatario"></label>
              <label for="Dconsignatario">
              <input name="Dconsignatario" type="text" class="txtImportante" id="consignatario3" value="<?php echo $row_data['consignatario']; ?>" size="50" readonly="readonly" />
              <input name="consignatario" type="hidden" id="consignatario" value="<?php echo $row_data['idconsignatario']; ?>" />
              </label></td>
            </tr>
          <tr>
            <td>Origen:</td>
            <td width="25%">
              <input name="origen" type="text" class="txtImportante" id="origen" value="<?php echo ALMACEN;?>" size="40" readonly="readonly" /></td>
            <td width="7%">Linea:</td>
            <td width="24%">
              <input name="Dlinea" type="text" class="txtImportante" id="Dlinea" value="<?php echo $row_data['nlinea']; ?>" readonly="readonly" /></td>
            <td width="7%">Buque:</td>
            <td width="25%">
              <label for="Dbuque"></label>
              <input name="Dbuque" type="text" class="txtImportante" id="Dbuque" value="<?php echo $row_data['buque']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
            <td>Viaje:</td>
            <td><input name="Dviaje" type="text" class="txtImportante" id="Dviaje" value="<?php echo $row_data['viaje']; ?>" readonly="readonly" /></td>
            <td>B/L</td>
            <td>
              <input name="BL" type="text" class="txtImportante" id="BL" value="<?php echo $row_data['bl']; ?>" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td></td>
            </tr>
          <tr>
            <td colspan="6" valign="middle">Fact/Expedient/Packing List:
              <label for="fact_pack"></label>
              <input name="fact_pack" type="text" class="txtImportante" id="fact_pack" value="<?php echo $row_acta['factpack']; ?>" /></td>
  </tr>
          <tr>
            <td valign="top">Observaciones:</td>
            <td colspan="5"><textarea name="observ" cols="70" rows="6" class="txtImportante" id="observ"></textarea></td>
          </tr>
          <tr>
            <td colspan="6"><input name="linea" type="hidden" id="linea" value="<?php echo $row_inv['linea']; ?>" />
              <input name="select2" type="hidden" id="select2" value="<?php echo $row_inv['buque']; ?>" />
              <input name="select3" type="hidden" id="select3" value="<?php echo $row_inv['viaje']; ?>" />
              <input name="idInstancia" type="hidden" id="idInstancia" value="<?php echo $_POST['id']; ?>" />
              <input name="actainstancia" type="hidden" id="actainstancia" value="<?php echo $_POST['acta']; ?>" /></td>
          </tr>
        </table></td>
</tr>
      <tr>
        <td colspan="4" align="right"><label>
          <input type="submit" name="button2" id="button2" value="Continuar" />
        </label></td>
      </tr>
    </table>
</form>
  <hr />
</div>
</body>
</html>
<?php
mysql_free_result($data);

mysql_free_result($inv);

mysql_free_result($acta);
?>
