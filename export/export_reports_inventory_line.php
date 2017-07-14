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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_conexion, $conexion);
$query_line = "SELECT id, nombre FROM lineas ORDER BY nombre ASC";
$line = mysql_query($query_line, $conexion) or die(mysql_error());
$row_line = mysql_fetch_assoc($line);
$totalRows_line = mysql_num_rows($line);


$colname_re40 = "-1";
if (isset($_GET['linea'])) {
  $colname_re40 =$_GET['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_re40 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '4%%' AND linea = %s GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re40, "int"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

$colname_re20 = "-1";
if (isset($_GET['linea'])) {
  $colname_re20 = $_GET['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '2%%' AND linea = %s GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re20, "int"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_inv = "-1";
if (isset($_GET['linea'])) {
  $colname_inv = $_GET['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM existenciagral WHERE linea = %s ORDER BY id ASC", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

//exportar a excel
$varL = $row_inv['nlinea'];

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Inventario_$varL.xls");
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
	width: auto;
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
      <h2>INVENTARIO GENERAL - LINEA: <?php echo $row_inv['nlinea']; ?> - <?php echo ALMACEN;?></h2>
    <br />
<table width="400" align="center" class="resumen" id="resumen">
      <tr>
        <th width="50%">Equipos de 20&quot;</th>
        <th width="50%">Equipos de 40&quot;</th>
      </tr>
      <tr>
        <td valign="top"><?php if ($totalRows_re20 > 0) { // Show if recordset not empty ?>
            <table width="100%" id="re20">
              <tr>
                <th>Tipo</th>
                <th>Cant</th>
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
      <th>Cant</th>
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
      <tr>
        <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo $totalRows_inv ?></strong></td>
      </tr>
    </table>
<table align="center" cellpadding="0" id="listado" >
<caption>&nbsp;
</caption>
      <thead>
        <tr>
          <th>ID</th>
          <th>Equipos</th>
          <th>Tipo</th>
          <th>Estatus</th>
          <th>Condicion</th>
          <th>Buque</th>
          <th>Viaje</th>
          <th>Arribo</th>
          <th>Despacho/Muelle</th>
          <th>Entrada</th>
          <th>Precinto</th>
          <th>B/L</th>
          <th>EIR</th>
          <th>Patio</th>
          <th>D-Pais</th>
          <th>D-Patio</th>
        </tr>
      </thead>
      <tbody>
        <?php do { ?>
        <tr>
          <td class="rightAlign"><?php echo $row_inv['id']; ?></td>
          <td><?php echo $row_inv['contenedor']; ?></td>
          <td><?php echo $row_inv['tipo']; ?></td>
          <td><?php estatus($row_inv['status']); ?></td>
          <td><?php condicion($row_inv['condicion']); ?></td>
          <td><?php echo $row_inv['buque']; ?></td>
          <td><?php echo $row_inv['viaje']; ?></td>
          <td align="center"><?php echo $row_inv['fda']; ?></td>
          <td align="center"><?php echo $row_inv['fdm']; ?></td>
          <td align="center"><?php echo $row_inv['frd']; ?></td>
          <td><?php echo $row_inv['precinto']; ?></td>
          <td><?php echo $row_inv['bl']; ?></td>
          <td><?php echo $row_inv['eir_r']; ?></td>
          <td><?php echo $row_inv['patio']; ?></td>
          <td><?php alarmapais($row_inv['dpais']); ?></td>
          <td><?php alarma($row_inv['dpatio']); ?></td>
        </tr>
          <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <p><?php echo USERREPORT; ?></p>
</body>
</html>
<?php
mysql_free_result($line);

mysql_free_result($re40);

mysql_free_result($re20);

mysql_free_result($inv);
?>
