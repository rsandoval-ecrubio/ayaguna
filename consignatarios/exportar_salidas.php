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

$colname_dsp = "-1";
if (isset($_GET['date1'])) {
  $colname_dsp = $_GET['date1'];
}
$colname1_dsp = "-1";
if (isset($_GET['date2'])) {
  $colname1_dsp = $_GET['date2'];
}
mysql_select_db($database_conexion, $conexion);
$query_dsp = sprintf("SELECT contenedor, tipo, estatus, condicion, eirR, descarga, recepcion, devolucion, eirD, ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = 134 AND c = 1 AND devolucion BETWEEN %s AND %s", GetSQLValueString($colname_dsp, "date"),GetSQLValueString($colname1_dsp, "date"));
$dsp = mysql_query($query_dsp, $conexion) or die(mysql_error());
$row_dsp = mysql_fetch_assoc($dsp);
$totalRows_dsp = mysql_num_rows($dsp);

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Salidas_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consignatario</title>
<script language="javascript">
function msjDiv(){
	document.getElementById('msj').style.visibility=visible;
}
</script>
<style type="text/css">
.colIzq {
	float: left;
	width: 160px;
	padding: 6px;
}
.ppal {
	float: none;
	width: auto;
}
.colDer {
	float: left;
	width: 75%;
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
</style>
</head>

<body>
<div id="ppal" class="ppal">
  <div id="der" class="colDer">
    <table width="100%"><caption>Rango de fecha: <?php echo $_GET['date1']." -> ".$_GET['date2']; ?></caption>
      <tr>
      <th scope="col">Contenedor</th>
      <th width="4%" scope="col">Tipo</th>
      <th scope="col">Estatus</th>
      <th width="3%" scope="col">Condicion</th>
      <th scope="col">EIR</th>
      <th width="6%" scope="col">Descargado</th>
      <th width="8%" scope="col">Rececpcion</th>
      <th width="8%" scope="col">Devolucion</th>
      <th scope="col">EIR</th>
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
        <td><?php echo $row_dsp['contenedor']; ?></td>
        <td><?php echo $row_dsp['tipo']; ?></td>
        <td><?php echo $row_dsp['estatus']; ?></td>
        <td><?php cdt($row_dsp['condicion']); ?></td>
        <td><?php echo $row_dsp['eirR']; ?></td>
        <td><?php echo $row_dsp['descarga']; ?></td>
        <td><?php echo $row_dsp['recepcion']; ?></td>
        <td><?php echo $row_dsp['devolucion']; ?></td>
        <td><?php echo $row_dsp['eirD']; ?></td>
        <td><?php echo $row_dsp['ubicacion']; ?></td>
        <td width="18%"><?php echo $row_dsp['obs']; ?></td>
        <td><?php echo $row_dsp['linea']; ?></td>
        <td><?php echo $row_dsp['buque']; ?></td>
        <td><?php echo $row_dsp['viaje']; ?></td>
        <td><?php alarmapais($row_dsp['DIC']); ?></td>
        <td><?php alarma($row_dsp['DIY']); ?></td>
      </tr>
      <?php } while ($row_dsp = mysql_fetch_assoc($dsp)); ?>
</table>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($dsp);
?>
