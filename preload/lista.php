<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php'); 
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
unset($_SESSION['intLinea']);
?>
<?php require_once('../Connections/conexion.php'); ?>
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
$query_precargar = "SELECT lista.id,lineas.nombre AS linea,buques.nombre AS buque,viajes.viaje,lista.equipo,tequipos.tipo,lista.precinto, IF(lista.estatus = 0,'EMPTY','FULL') AS estatus,
lista.bl,consignatario.nombre AS consig
FROM lista, lineas, buques, viajes, tequipos, consignatario
WHERE lineas.id = lista.linea AND buques.id = lista.buque AND viajes.id = lista.viaje AND tequipos.id = lista.tipo AND consignatario.id = lista.consig";
$precargar = mysql_query($query_precargar, $conexion) or die(mysql_error());
$row_precargar = mysql_fetch_assoc($precargar);
$totalRows_precargar = mysql_num_rows($precargar);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Datos Importados</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#espa {
	height: 70px;
	width: 98%;
}
</style>
</head>

<body>
<table width="75%" align="center">
  <caption>
    Datos Importados
    <?php echo $totalRows_precargar ?>
  </caption>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Linea</th>
    <th scope="col">Buque</th>
    <th scope="col">Viaje</th>
    <th scope="col">Equipo</th>
    <th scope="col">Tipo</th>
    <th scope="col">B/L</th>
    <th scope="col">Consignatario</th>
    <th scope="col">Dato</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_precargar['id']; ?></td>
      <td><?php echo $row_precargar['linea']; ?></td>
      <td><?php echo $row_precargar['buque']; ?></td>
      <td><?php echo $row_precargar['viaje']; ?></td>
      <td><a href="../gatein/gatein_precarga.php?id=<?php echo $row_precargar['id']; ?>"><?php echo $row_precargar['equipo']; ?></a></td>
      <td><?php echo $row_precargar['tipo']; ?></td>
      <td><?php echo htmlentities($row_precargar['bl']); ?></td>
      <td><?php echo htmlentities($row_precargar['consig']); ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } while ($row_precargar = mysql_fetch_assoc($precargar)); ?>
</table>
<div id="espa">&nbsp;</div>  
</body>
</html>
<?php
mysql_free_result($precargar);
?>
