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
$query_invtp20 = "SELECT contenedor, tipo, estatus, condicion, eirR, descarga, recepcion,ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = 134 AND c = 0 AND tipo LIKE '2%' ORDER BY descarga ASC";
$invtp20 = mysql_query($query_invtp20, $conexion) or die(mysql_error());
$row_invtp20 = mysql_fetch_assoc($invtp20);
$totalRows_invtp20 = mysql_num_rows($invtp20);

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Tipo20_Report.xls");
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
.tachado {	text-decoration: line-through;
}
</style>
</head>

<body>
<div id="ppal" class="ppal">
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
          <td><?php echo $row_invtp20['contenedor']; ?></td>
          <td><?php echo $row_invtp20['tipo']; ?></td>
          <td><?php echo $row_invtp20['estatus']; ?></td>
          <td><?php cdt($row_invtp20['condicion']); ?></td>
          <td><?php echo $row_invtp20['eirR']; ?></td>
          <td><?php echo $row_invtp20['descarga']; ?></td>
          <td><?php echo $row_invtp20['recepcion']; ?></td>
          <td><?php echo $row_invtp20['ubicacion']; ?></td>
          <td width="18%"><?php echo $row_invtp20['obs']; ?></td>
          <td><?php echo $row_invtp20['linea']; ?></td>
          <td><?php echo $row_invtp20['buque']; ?></td>
          <td><?php echo $row_invtp20['viaje']; ?></td>
          <td><?php alarmapais($row_invtp20['DIC']); ?></td>
          <td><?php alarma($row_invtp20['DIY']); ?></td>
        </tr>
          <?php } while ($row_invtp20 = mysql_fetch_assoc($invtp20)); ?>
      </table>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($invtp20);
?>
