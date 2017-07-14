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

$maxRows_line = 50;
$pageNum_line = 0;
if (isset($_GET['pageNum_line'])) {
  $pageNum_line = $_GET['pageNum_line'];
}
$startRow_line = $pageNum_line * $maxRows_line;

mysql_select_db($database_conexion, $conexion);
$query_line = "SELECT id, nombre FROM lineas ORDER BY nombre ASC";
$query_limit_line = sprintf("%s LIMIT %d, %d", $query_line, $startRow_line, $maxRows_line);
$line = mysql_query($query_limit_line, $conexion) or die(mysql_error());
$row_line = mysql_fetch_assoc($line);

if (isset($_GET['totalRows_line'])) {
  $totalRows_line = $_GET['totalRows_line'];
} else {
  $all_line = mysql_query($query_line);
  $totalRows_line = mysql_num_rows($all_line);
}
$totalPages_line = ceil($totalRows_line/$maxRows_line)-1;

$colname_re20 = "-1";
if (isset($_GET['linea'])) {
  $colname_re20 = $_GET['linea'];
}
$colname1_re20 = date("Y-m-d");
if (isset($_GET['var'])) {
  $colname1_re20 = $_GET['var'];
}
$colname2_re20 = date("Y-m-d");
if (isset($_GET['var2'])) {
  $colname2_re20 = $_GET['var2'];
}

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
$query_re20 = sprintf("SELECT tipo, COUNT(*) as cantidad FROM despachados WHERE linea = %s AND fdespims BETWEEN %s AND %s AND tipo LIKE '2%%' GROUP BY tipo", GetSQLValueString($colname_re20, "int"),GetSQLValueString($colname1_re20, "date"),GetSQLValueString($colname2_re20, "date"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_GET['linea'])) {
  $colname_re40 = $_GET['linea'];
}
$colname1_re40 = date('Y-m-d');
if (isset($_GET['var'])) {
  $colname1_re40 = $_GET['var'];
}
$colname2_re40 = date('Y-m-d');
if (isset($_GET['var2'])) {
  $colname2_re40 = $_GET['var2'];
}

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
$query_re40 = sprintf("SELECT tipo, COUNT(*) as cantidad FROM despachados WHERE linea = %s AND fdespims BETWEEN %s AND %s AND tipo LIKE '4%%' GROUP BY tipo", GetSQLValueString($colname_re40, "int"),GetSQLValueString($colname1_re40, "date"),GetSQLValueString($colname2_re40, "date"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

$colname_re40 = "-1";
if (isset($_GET['linea'])) {
  $colname_re40 =$_GET['linea'];
}

$queryString_inv = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_inv") == false && 
        stristr($param, "totalRows_inv") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_inv = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_inv = sprintf("&totalRows_inv=%d%s", $totalRows_inv, $queryString_inv);

//GateIn Procedimiento
if(isset($_GET['linea']) and isset($_GET['var']) and isset($_GET['var2'])){
	$linea = $_GET['linea'];
	$fini = $_GET['var'];
	$ffin = $_GET['var2'];
	mysqli_select_db($conexion_li,$database_conexion);
	#Gate Out CALL 
	$GateOut = mysqli_query($conexion_li,"CALL `GateOut`('$linea', '$fini', '$ffin')")or die(mysqli_error());
	$invGateOut = mysqli_fetch_assoc($GateOut);
	$totalGateOut = mysqli_num_rows($GateOut);
	mysqli_close($conexion_li);
}

//exportar a excel

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=reporte_egresos.xls");
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
<h2>MOVIMIENTOS DE SALIDA <?php echo $invGateOut['nombre'];  ?></h2>
<?php if($totalGateOut > 0){ ?>
<table width="400" align="center" class="resumen" id="resumen">
<caption>
      Resumen
    </caption>
      <tr>
        <th>Equipos de 20&quot;</th>
        <th>Equipos de 40&quot;</th>
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
    </table>
    <table align="center" cellpadding="0" id="listado" >
      <caption>
        Total de Equipos:&nbsp;
      <?php echo $suma20 + $suma40 ?>
      </caption>
      <thead>
        <tr>
          <th axis="number">ID</th>
          <th axis="string">Equipo</th>
          <th axis="string">Tipo</th>
          <th axis="string">Estatus</th>
          <th axis="string">Condicion</th>
          <th axis="date">Despacho/Muelle</th>
          <th axis="date">Entrada</th>
          <th axis="string">Precinto</th>
          <th axis="string">B/L</th>
          <th axis="date">Salida</th>
          <th axis="number">EIR</th>
          <th axis="string">Estatus</th>
          <th axis="string">Consignatario</th>
          <th axis="number">D-Pais</th>
          <th axis="number">D-Patio</th>
          <th axis="number">Acopio</th>
        </tr>
      </thead>
      <tbody>
      <?php do { ?>
        <tr>
          <td class="rightAlign"><?php echo $invGateOut['id'];  ?>&nbsp;</td>
          <td><?php echo $invGateOut['contenedor'];  ?></td>
          <td align="center"><?php echo $invGateOut['tipo'];  ?></td>
          <td align="center"><?php echo $invGateOut['estatus'];?></td>
          <td align="center"><?php echo $invGateOut['condicion']; ?></td>
          <td align="center"><?php echo $invGateOut['fdb'];  ?></td>
          <td align="center"><?php echo $invGateOut['frd'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['precinto'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['bl'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['fdespims'];  ?></td>
          <td align="center"><?php echo $invGateOut['eir_d'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['status_d'];  ?></td>
          <td><?php echo $invGateOut['consignatario'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['dpais'];  ?>&nbsp;</td>
          <td class="rightAlign"><?php echo $invGateOut['dpatio'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['acopio'];  ?></td>
        </tr>
        <?php } while($invGateOut = mysqli_fetch_assoc($GateOut)); ?>
      </tbody>
      <tfoot>
      </tfoot>
</table>
<p><?php echo USERREPORT; ?></p>
      <?php } ?>
</body>
</html>
<?php
mysql_free_result($line);

mysql_free_result($re20);

mysql_free_result($re40);
?>
