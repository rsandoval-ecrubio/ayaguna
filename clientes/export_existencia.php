<?php require_once('../Connections/conexion.php'); ?>
<?php require_once '../funciones/funciones.php'; ?>
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
if (isset($_SESSION['variables']['linea'])) {
  $colname_inv = $_SESSION['variables']['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM existencia WHERE linea = %s", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$colname_linea = "-1";
if (isset($_SESSION['variables']['linea'])) {
  $colname_linea = $_SESSION['variables']['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_linea = sprintf("SELECT id, nombre, agencia FROM lineas WHERE id = %s", GetSQLValueString($colname_linea, "int"));
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

$colname_res20 = "-1";
if (isset($_SESSION['variables']['linea'])) {
  $colname_res20 = $_SESSION['variables']['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_res20 = sprintf("SELECT tipo, COUNT(tipo) AS cantidad FROM existencia WHERE linea = %s AND tipo LIKE '2%%' GROUP BY tipo", GetSQLValueString($colname_res20, "int"));
$res20 = mysql_query($query_res20, $conexion) or die(mysql_error());
$row_res20 = mysql_fetch_assoc($res20);
$totalRows_res20 = mysql_num_rows($res20);

$colname_res40 = "-1";
if (isset($_SESSION['variables']['linea'])) {
  $colname_res40 = $_SESSION['variables']['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_res40 = sprintf("SELECT tipo, COUNT(tipo) AS cantidad FROM existencia WHERE linea = %s AND tipo LIKE '4%%' GROUP BY tipo", GetSQLValueString($colname_res40, "int"));
$res40 = mysql_query($query_res40, $conexion) or die(mysql_error());
$row_res40 = mysql_fetch_assoc($res40);
$totalRows_res40 = mysql_num_rows($res40);

//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d");

#Email->
$destinos = "fgonzalez@consolidadoslg2011.com,op.clg@consolidadoslg2011.com,jnavarro@consolidadoslg2011.com,support@tconnections.net";
$sujeto = "AYAGUNA v1.0 - Reporte de Uso";
$mensaje = "----------------------------------------------------"."\n";
$mensaje .= "                   Reporte                          "."\n";
$mensaje .= "---------------------------------------------------- "."\n";
$mensaje .= "Fecha: ".date("Y-m-d H:i:s")."\n";
$mensaje .= "El Usuario: ".$_SESSION['variables']['nombreUsuario']."\n";
$mensaje .= "Descargo el reporte: Existencia"."\n";
$mensaje .= "---------------------------------------------------- "."\n";
$mensaje .= "Mensaje generado automaticamente por AYAGUNA v1.0; por favor no responda este mensaje"."\n";
$header = "From: ayaguna@appstc.net"."\r\n";
mail($destinos,$sujeto,$mensaje,$header);
#<-Email

//exportar a excel
$nombreArchivo = "existencia".$ahora.".xls";
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$nombreArchivo");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<style type="text/css">
/* CSS Document */


body,td,th {
	font-family: Calibri;
	font-size: 12px;
}
h1 {
	font-size: 18px;
	color: #06C;
}
h2 {
	font-size: 16px;
	color: #036;
}
h3 {
	font-size: 14px;
	color: #333;
}
h4 {
	font-size: 12px;
	color: #000;
}
h5 {
	font-size: 10px;
	color: #333;
}
h6 {
	font-size: 9px;
	color: #F60;
}
caption {
	font-size: 18px;
	color: #039;
	text-align: left;
	background-color: #FFF;
}
th {
	color: #000;
	background-color: #C3D3FD;
}
#report {
	width: auto;
	float: left;
}
#resumen20 {
	width: 200px;
	float: left;
}
#resumen40 {
	width: 200px;
	float: right;
	clear: right;
}
#resumen {
	width: 400px;
	float: left;
}
#listado {
	float: left;
	width: auto;plazawer
	
	clear: both;
}
</style>
</head>
<body>
<div id="encabezado">
  <h1>Control de Equipos</h1>
  <h2>Reporte: Inventario | Existencia Actual</h2>
  <h2>Linea: <?php echo $row_linea['nombre']; ?></h2>
  <hr />
</div>
<div id="reporte">
  <table width="260" cellspacing="2" cellpadding="2">
    <tr>
      <td valign="top"><table width="100%" border="1" cellpadding="2" cellspacing="2">
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_res20['tipo']; ?></td>
            <td align="right"><?php echo $row_res20['cantidad']; $total20 = $total20 + $row_res20['cantidad']; ?></td>
          </tr>
          <?php } while ($row_res20 = mysql_fetch_assoc($res20)); ?>
<tr>
          <th>Sub-Total</th>
          <th><?php echo $total20; ?>&nbsp;</th>
    </tr>
      </table></td>
      <td valign="top"><table width="100%" border="1" cellpadding="2" cellspacing="2">
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_res40['tipo']; ?></td>
            <td align="right"><?php echo $row_res40['cantidad']; $total40 = $total40 + $row_res40['cantidad'];?></td>
          </tr>
          <?php } while ($row_res40 = mysql_fetch_assoc($res40)); ?>
<tr>
          <th>Sub-Total</th>
          <th><?php echo $total40; ?></th>
    </tr>
      </table></td>
    </tr>
  </table>
  <hr />
  <table width="90%" border="1" cellpadding="2" cellspacing="2" id="inv" ><caption>
    Total Equipos <?php echo $totalRows_inv ?>
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
        <th axis="date">Desp/Muelle</th>
        <th axis="date">Ingresp</th>
        <th axis="number">EIR</th>
        <th axis="string">Obs</th>
        <th axis="string">Patio</th>
        <th axis="number">D/Pais</th>
        <th axis="number">D/Patio</th>
      </tr>
    </thead>
    <tbody>
      <?php do { ?>
      <tr>
        <td ><?php $nbr = 1; echo $idnbr += $nbr;?></td>
        <td><?php echo $row_inv['contenedor']; ?></td>
        <td><div align="center"><?php echo $row_inv['tipo']; ?></div></td>
        <td><div align="center">
          <?php estatus($row_inv['status']); ?>
        </div></td>
        <td><div align="center">
          <?php condicion($row_inv['condicion']); ?>
        </div></td>
        <td><?php echo $row_inv['buque']; ?></td>
        <td align="left"><?php echo $row_inv['viaje']; ?></td>
        <td><div align="center"><?php echo $row_inv['fdm']; ?></div></td>
        <td><div align="center"><?php echo $row_inv['frd']; ?></div></td>
        <td><div align="right"><?php echo $row_inv['eir_r']; ?></div></td>
        <td><?php echo $row_inv['obs']; ?></td>
        <td><?php echo $row_inv['patio']; ?></td>
        <td><div align="right">
          <?php restafechas($ahora,$row_inv['fdb']); ?>
        </div></td>
        <td><div align="right">
          <?php restafechas($ahora,$row_inv['frd']); ?>
        </div></td>
      </tr>
      <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="14">Total Equipos: <?php echo $totalRows_inv ?></td>
      </tr>
    </tfoot>
  </table>
  <hr />
  <p>AYAGUNA v 1.0 | Usuario: <?php echo $_SESSION['variables']['nombreUsuario']; ?> | Linea: <?php echo $row_linea['nombre']; ?> | Fecha: <?php echo date("Y-m-d h:i:s"); ?></p>
</div>
</body>
</html>
<?php
mysql_free_result($inv);

mysql_free_result($linea);

mysql_free_result($res20);

mysql_free_result($res40);
?>
