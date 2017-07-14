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

$colname_rcp = "-1";
if (isset($_GET['date1'])) {
  $colname_rcp = $_GET['date1'];
}
$colname1_rcp = "-1";
if (isset($_GET['date2'])) {
  $colname1_rcp = $_GET['date2'];
}
mysql_select_db($database_conexion, $conexion);
$query_rcp = sprintf("SELECT contenedor, tipo, estatus, condicion, eirR, descarga, recepcion, devolucion,ubicacion, obs, linea, buque, viaje, DIC, DIY, c  FROM consulta_x_consignatario  WHERE consig_id = 134  AND recepcion BETWEEN %s AND %s ORDER BY descarga ASC", GetSQLValueString($colname_rcp, "date"),GetSQLValueString($colname1_rcp, "date"));
$rcp = mysql_query($query_rcp, $conexion) or die(mysql_error());
$row_rcp = mysql_fetch_assoc($rcp);
$totalRows_rcp = mysql_num_rows($rcp);

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Entradas_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consignatario</title>
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
.tachado {
	text-decoration: line-through;
}
</style>
</head>

<body>
<div id="ppal" class="ppal">
  <div id="der" class="colDer">
    <table width="100%"><caption>Rango de fecha: <?php echo $_GET['date1']." -> ".$_GET['date2']; ?></caption>
      <tr>
      <th scope="col">Contenedor</th>
      <th scope="col">Tipo</th>
      <th scope="col">Estatus</th>
      <th scope="col">Condicion</th>
      <th scope="col">EIR</th>
      <th scope="col">Descargado</th>
      <th scope="col">Rececpcion</th>
      <th scope="col">Devolucion</th>
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
        <td><?php echo $row_rcp['contenedor']; ?></td>
        <td><?php echo $row_rcp['tipo']; ?></td>
        <td><?php echo $row_rcp['estatus']; ?></td>
        <td><?php cdt($row_rcp['condicion']); ?></td>
        <td><?php echo $row_rcp['eirR']; ?></td>
        <td><?php echo $row_rcp['descarga']; ?></td>
        <td><?php echo $row_rcp['recepcion']; ?></td>
        <td><?php echo $row_rcp['devolucion']; ?></td>
        <td><?php echo $row_rcp['ubicacion']; ?></td>
        <td width="18%"><?php echo $row_rcp['obs']; ?></td>
        <td><?php echo $row_rcp['linea']; ?></td>
        <td><?php echo $row_rcp['buque']; ?></td>
        <td><?php echo $row_rcp['viaje']; ?></td>
        <td><?php alarmapais($row_rcp['DIC']); ?></td>
        <td><?php alarma($row_rcp['DIY']); ?></td>
      </tr>
      <?php } while ($row_rcp = mysql_fetch_assoc($rcp)); ?>
</table>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($rcp);
?>
