<?php require_once('../Connections/conexion.php'); ?>
<?php
session_start();
require_once('../Connections/conexion.php');
require_once('../funciones/funciones.php');
//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d");

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
$query_cntg = "SELECT contenedor, tipo, estatus, condicion, eirR, descarga, recepcion,ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = 134 AND c = 0 ORDER BY descarga ASC";
$cntg = mysql_query($query_cntg, $conexion) or die(mysql_error());
$row_cntg = mysql_fetch_assoc($cntg);
$totalRows_cntg = mysql_num_rows($cntg);

$colname_track = "-1";
if (isset($_POST['number'])) {
  $colname_track = $_POST['number'];
}
mysql_select_db($database_conexion, $conexion);
$query_track = sprintf("SELECT contenedor, tipo, estatus, condicion, eirR, descarga, despacho, recepcion, devolucion, eirD, ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = 134 AND contenedor = %s", GetSQLValueString($colname_track, "text"));
$track = mysql_query($query_track, $conexion) or die(mysql_error());
$row_track = mysql_fetch_assoc($track);
$totalRows_track = mysql_num_rows($track);

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=General_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consignatario</title>
<script type="text/javascript" language="javascript" src="../js/validaciones.js"></script>
<style type="text/css">
.colIzq {
	float: left;
	width: 160px;
	padding: 6px;
	clear: both;
}
#track {
	padding: 2px;
	border: 1px solid #9BA5FF;
	margin-top: 20px;
	list-style-type: none;
}
#track li label {
	list-style-type: none;
}
.ul_list {
	list-style-type: none;
}
.ppal {
	float: none;
	width: auto;
	height: auto;
}
.colDer {
	float: left;
	width: 80%;
	padding: 6px;
	margin-left: 10px;
}
body,td,th {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
}
th {
	background-color: #9BA5FF;
	color: #FFF;
	padding: 2px;
}
td {
	border: 1px solid #CCC;
	padding: 2px;
}
.tachado {	text-decoration: line-through;
}
#temp {
	width: 400px;
	float: none;
	background-color: #F5F5F5;
}
#copyrigth {
	width: 100%;
	margin-bottom: 0px;
	margin-top: auto;
	margin-right: 0px;
	margin-left: 0px;
	float: left;
	background-color: #9BA5FF;
	color: #FFF;
	padding-top: 6px;
	padding-bottom: 6px;
	text-indent: 10px;
}
#tracking {
	background-color: #F8F8FF;
	border: 1px solid #9BA5FF;
}
#resultadoTrack {
	background-color: #FFF;
}
</style>
</head>

<body>
<div id="ppal" class="ppal">
<div id="nav"> </div>
<div id="der" class="colDer">
  <table width="100%">
    <tr>
      <th scope="col">Contenedor</th>
      <th scope="col">Tipo</th>
      <th scope="col">Estatus</th>
      <th scope="col">Condicion</th>
      <th scope="col">EIR</th>
      <th scope="col">Descargado</th>
      <th scope="col">Rececpcion</th>
      <th scope="col">Ubicacion</th>
      <th scope="col">Observacion</th>
      <th scope="col">Linea</th>
      <th scope="col">Buque</th>
      <th scope="col">Viaje</th>
      <th scope="col">D-Pais</th>
      <th scope="col">D-Patio</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_cntg['contenedor']; ?></td>
        <td><?php echo $row_cntg['tipo']; ?></td>
        <td><?php echo $row_cntg['estatus']; ?></td>
        <td><?php cdt($row_cntg['condicion']); ?></td>
        <td><?php echo $row_cntg['eirR']; ?></td>
        <td><?php echo $row_cntg['descarga']; ?></td>
        <td><?php echo $row_cntg['recepcion']; ?></td>
        <td><?php echo $row_cntg['ubicacion']; ?></td>
        <td width="18%"><?php echo $row_cntg['obs']; ?></td>
        <td><?php echo $row_cntg['linea']; ?></td>
        <td><?php echo $row_cntg['buque']; ?></td>
        <td><?php echo $row_cntg['viaje']; ?></td>
        <td align="right"><?php alarmapais($row_cntg['DIC']); ?></td>
        <td align="right"><?php alarma($row_cntg['DIY']); ?></td>
      </tr>
      <?php } while ($row_cntg = mysql_fetch_assoc($cntg)); ?>
</table>
</div>
  <div id="copyrigth">IMSSis | Real Time Network Solution | Modulo de Consignatario | G.M.V.</div>
</div>
</body>
</html>
<?php
mysql_free_result($cntg);

mysql_free_result($track);
?>
