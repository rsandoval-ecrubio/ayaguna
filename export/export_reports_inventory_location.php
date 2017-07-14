<?php
session_start();
require('../config.php');
seguridad();
function showAlmacen($var){
	switch ($var) {
    case "appstc_ayaguna_jmp":
        echo "JMP";
        break;
    case "appstc_ayaguna_menfel":
        echo "MENFEL";
        break;
	 case "appstc_ayaguna_conslg":
        echo "Consolidados La Guaira";
        break;
}
	
}
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

mysql_select_db($database_conexion, $conexion);
$query_patio = "SELECT * FROM patios ORDER BY patio ASC";
$patio = mysql_query($query_patio, $conexion) or die(mysql_error());
$row_patio = mysql_fetch_assoc($patio);
$totalRows_patio = mysql_num_rows($patio);

$colname_inv = "-1";
if (isset($_GET['patio'])) {
  $colname_inv = $_GET['patio'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM existenciagral WHERE patio = %s", GetSQLValueString($colname_inv, "text"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$colname_re20 = "-1";
if (isset($_GET['patio'])) {
  $colname_re20 = $_GET['patio'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad  FROM existenciagral  WHERE tipo LIKE '2%%' AND patio = %s GROUP BY tipo  ORDER BY tipo", GetSQLValueString($colname_re20, "text"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_GET['patio'])) {
  $colname_re40 = $_GET['patio'];
}
mysql_select_db($database_conexion, $conexion);
$query_re40 = sprintf("SELECT tipo, COUNT(*) AS cantidad  FROM existenciagral  WHERE tipo LIKE '4%%' AND patio = %s GROUP BY tipo  ORDER BY tipo", GetSQLValueString($colname_re40, "text"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

//exportar a excel

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=reporte_por_ubicacion.xls");
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
    <h2>INVENTARIO POR UBICACION -  <?php echo $_GET['patio']; ?> - <?php showAlmacen($_SESSION['variables']['db']);?></h2>
<p>&nbsp;</p>
<?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
  <table width="400" class="resumen" id="resumen">
    <caption>&nbsp;
    </caption>
    <tr>
      <td width="50%" valign="top"><?php if ($totalRows_re20 > 0) { // Show if recordset not empty ?>
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
            <th><div align="center"><?php echo $suma20; ?></div></th>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?></td>
      <td width="50%" valign="top"><?php if ($totalRows_re40 > 0) { // Show if recordset not empty ?>
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
            <th><div align="center"><?php echo $suma40; ?></div></th>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?></td>
    </tr>
  </table>
  <table align="left" cellpadding="0" id="listado" >
    <caption>
    Total equipos en Patio -&gt;<?php echo $_GET['patio'].": ".$totalRows_inv ?>
    </caption>
    <thead>
      <tr>
        <th axis="number">ID</th>
        <th axis="string">Equipo</th>
        <th axis="string">Tipo</th>
        <th axis="string">Estatus</th>
        <th axis="string">Condicion</th>
        <th axis="string">Buque</th>
        <th axis="string">Viaje</th>
        <th axis="date">Despacho/Muelle</th>
        <th axis="date">Entrada</th>
        <th axis="string">Precinto</th>
        <th axis="string">B/L</th>
        <th axis="number">EIR</th>
        <th axis="string">Observaciones</th>
        <th axis="string">Patio</th>
        <th axis="number">D-Pais</th>
        <th axis="number">D-Patio</th>
      </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td class="rightAlign"><?php echo $row_inv['id']; ?></td>
          <td><?php echo $row_inv['contenedor']; ?></td>
          <td><?php echo $row_inv['tipo']; ?></td>
          <td><?php estatus($row_inv['estatus']); ?></td>
          <td><?php condicion($row_inv['condicion']); ?></td>
          <td><?php echo $row_inv['buque']; ?></td>
          <td><?php echo $row_inv['viaje']; ?></td>
          <td width="5%" class="rightAlign"><?php echo $row_inv['fdm']; ?></td>
          <td width="5%" class="rightAlign"><?php echo $row_inv['frd']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['precinto']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['bl']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['eir_r']; ?></td>
          <td width="18%"><?php echo $row_inv['obs']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['patio']; ?></td>
          <td class="rightAlign"><?php alarmapais($row_inv['dpais']); ?></td>
          <td class="rightAlign"><?php alarma($row_inv['dpatio']); ?></td>
        </tr>
        <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
    </tbody>
    <tfoot>
    </tfoot>
  </table>
  <p><?php echo USERREPORT; ?></p>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysql_free_result($patio);

mysql_free_result($inv);

mysql_free_result($re20);

mysql_free_result($re40);
?>
