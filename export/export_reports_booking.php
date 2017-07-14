<?php 
session_start();
require('../config.php');
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

$colname_inv = "-1";
if (isset($_GET['linea'])) {
  $colname_inv = $_GET['linea'];
}
$colname1_inv = "-1";
if (isset($_GET['var'])) {
  $colname1_inv = $_GET['var'];
}
$colname2_inv = "-1";
if (isset($_GET['var2'])) {
  $colname2_inv = $_GET['var2'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM asignados WHERE linea = %s AND fdespims BETWEEN %s AND %s", GetSQLValueString($colname_inv, "int"),GetSQLValueString($colname1_inv, "date"),GetSQLValueString($colname2_inv, "date"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$colname_re20 = "-1";
if (isset($_GET['linea'])) {
  $colname_re20 = $_GET['linea'];
}
$colname1_re20 = "-1";
if (isset($_GET['var'])) {
  $colname1_re20 = $_GET['var'];
}
$colname2_re20 = "-1";
if (isset($_GET['var2'])) {
  $colname2_re20 = $_GET['var2'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad  FROM asignados WHERE linea = %s AND tipo LIKE '2%%' AND fdespims BETWEEN %s AND %s GROUP BY tipo", GetSQLValueString($colname_re20, "int"),GetSQLValueString($colname1_re20, "date"),GetSQLValueString($colname2_re20, "date"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_GET['linea'])) {
  $colname_re40 = $_GET['linea'];
}
$colname1_re40 = "-1";
if (isset($_GET['var'])) {
  $colname1_re40 = $_GET['var'];
}
$colname2_re40 = "-1";
if (isset($_GET['var2'])) {
  $colname2_re40 = $_GET['var2'];
}
mysql_select_db($database_conexion, $conexion);
$query_re40 = sprintf("SELECT tipo, COUNT(*) AS cantidad  FROM asignados WHERE linea = %s AND tipo LIKE '4%%' AND fdespims BETWEEN %s AND %s GROUP BY tipo", GetSQLValueString($colname_re40, "int"),GetSQLValueString($colname1_re40, "date"),GetSQLValueString($colname2_re40, "date"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

mysql_select_db($database_conexion, $conexion);
$query_linea = "SELECT id, nombre FROM lineas ORDER BY nombre ASC";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

//exportar a excel

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=asignaciones.xls");
header("Pragma: no-cache");
header("Expires: 0");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<style type="text/css">
body,td,th {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
}
#resumen {
	border: 1px solid #CCC;
	padding: 4px;
}
#resumen tr th {
	background-color: #EEE;
}
#resumen tr td #re20 {
	border: 1px solid #333;
}
#resumen tr td #re40 {
	border: 1px solid #333;
}
#listado {
}
#listado thead tr th {
	background-color: #EEE;
	padding: 2px;
	border: 1px solid #000;
}
#listado tbody tr td {
	border: 1px solid #CCC;
}
</style>
</head>
<body>
  <div id="content">
    <h2>REPORTE DE EQUIPOS ASIGNADOS | <?php echo $row_inv['nlinea']; ?></h2>
    <table width="400" align="center" id="resumen">
      <tr>
        <th width="50%">Equipos de 20'</th>
        <th width="50%">Equipos de  40'</th>
      </tr>
      <tr>
        <td valign="top"><?php if ($totalRows_re20 > 0) { // Show if recordset not empty ?>
            <table width="100%" id="re20">
              <tr>
                <th>Tipo</th>
                <th>Cantidad</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_re20['tipo']; ?></td>
                  <td><div align="right">
                    <?php $suma20 = $suma20 + $row_re20['cantidad']; echo $row_re20['cantidad']; ?>
                  </div></td>
                </tr>
                <?php } while ($row_re20 = mysql_fetch_assoc($re20)); ?>
              <tr>
                <th>Sub-Total:</th>
                <th><?php echo $suma20; ?>&nbsp;</th>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
        <td valign="top"><?php if ($totalRows_re40 > 0) { // Show if recordset not empty ?>
            <table width="100%" id="re40">
              <tr>
                <th>Tipo</th>
                <th>Cantidad</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_re40['tipo']; ?></td>
                  <td><div align="right">
                    <?php $suma40 = $suma40 + $row_re40['cantidad']; echo $row_re40['cantidad']; ?>
                  </div></td>
                </tr>
                <?php } while ($row_re40 = mysql_fetch_assoc($re40)); ?>
              <tr>
                <th>Sub-Total:</th>
                <th><?php echo $suma40; ?>&nbsp;</th>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
      </tr>
    </table>
    <table align="center" cellpadding="0" id="listado" >
    <caption>
        Total de Equipos:&nbsp; <?php echo $totalRows_inv ?>
      </caption>
      <thead>
        <tr>
          <th axis="number">#</th>
          <th axis="number">Buque</th>
          <th axis="number">Viaje</th>
          <th axis="string">Equipo</th>
          <th axis="string">Tipo</th>
          <th axis="string">Estatus</th>
          <th axis="string">Condicion</th>
          <th axis="date">Despacho/Muelle</th>
          <th axis="date">Despacho</th>
          <th axis="date">Recepcion</th>
          <th axis="number">EIR</th>
          <th axis="date">Despacho</th>
          <th axis="string">EIR</th>
          <th axis="string">Booking</th>
          <th axis="string">Cliente</th>
          <th axis="number">D-Pais</th>
          <th axis="number">D-Patio</th>
        </tr>
      </thead>
      <tbody>
        <?php do { ?>
          <tr>
            <td class="rightAlign"><?php echo $row_inv['id']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['buque']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['viaje']; ?></td>
            <td><?php echo $row_inv['contenedor']; ?></td>
            <td><?php echo $row_inv['tipo']; ?></td>
            <td><?php echo $row_inv['estatus']; ?></td>
            <td><?php echo $row_inv['condicion']; ?></td>
            <td align="center"><?php echo $row_inv['fdb']; ?></td>
            <td align="center"><?php echo $row_inv['fdm']; ?></td>
            <td align="center"><?php echo $row_inv['frd']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['eir_r']; ?></td>
            <td align="center"><?php echo $row_inv['fdespims']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['eir_d']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['booking']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['cliente']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['dpais']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['dpatio']; ?></td>
          </tr>
          <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="17">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
<p><?php echo USERREPORT; ?></p>
</div>
</body>
</html>
<?php
mysql_free_result($inv);

mysql_free_result($re20);

mysql_free_result($re40);

mysql_free_result($linea);
?>
