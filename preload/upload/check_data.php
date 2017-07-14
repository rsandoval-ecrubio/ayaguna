<?php session_start(); ?>
<?php require_once('../../Connections/conexion.php'); ?>
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
$query_result = "SELECT COUNT(*) AS cantidad FROM precarga";
$result = mysql_query($query_result, $conexion) or die(mysql_error());
$row_result = mysql_fetch_assoc($result);
$totalRows_result = mysql_num_rows($result);

mysql_select_db($database_conexion, $conexion);
$query_linea = "SELECT precarga.linea, lineas.nombre FROM precarga, lineas WHERE lineas.id = precarga.linea";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

$colname_buques = "-1";
if (isset($_SESSION['intLinea'])) {
  $colname_buques = $_SESSION['intLinea'];
}
mysql_select_db($database_conexion, $conexion);
$query_buques = sprintf("SELECT id, nombre FROM buques WHERE linea = %s", GetSQLValueString($colname_buques, "int"));
$buques = mysql_query($query_buques, $conexion) or die(mysql_error());
$row_buques = mysql_fetch_assoc($buques);
$totalRows_buques = mysql_num_rows($buques);

if(isset($_POST['buque'])){
	
$colname_viajes = "-1";
if (isset($_POST['buque'])) {
  $colname_viajes = $_POST['buque'];
}
mysql_select_db($database_conexion, $conexion);
$query_viajes = sprintf("SELECT id, viaje FROM viajes WHERE buque = %s", GetSQLValueString($colname_viajes, "int"));
$viajes = mysql_query($query_viajes, $conexion) or die(mysql_error());
$row_viajes = mysql_fetch_assoc($viajes);
$totalRows_viajes = mysql_num_rows($viajes);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Chequeo</title>
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Cantidad de equipos importados: <?php echo $row_result['cantidad']; ?></h1>
<h2>Siguiente paso: Asignar el Buque y el Viaje de los equipos ingresados.</h2>
<form action="check_data2.php" method="post" name="form1" id="form1">
  Buque: 
  <select name="buque" id="buque">
    <option value="">Seleccion</option>
    <?php
do {  
?>
    <option value="<?php echo $row_buques['id']?>"><?php echo $row_buques['nombre']?></option>
    <?php
} while ($row_buques = mysql_fetch_assoc($buques));
  $rows = mysql_num_rows($buques);
  if($rows > 0) {
      mysql_data_seek($buques, 0);
	  $row_buques = mysql_fetch_assoc($buques);
  }
?>
  </select>
  <input type="submit" name="button" id="button" value="-&gt; Viaje" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($result);

mysql_free_result($buques);
if (isset($_POST['buque'])) {
	mysql_free_result($viajes);
}

mysql_free_result($linea);

?>
