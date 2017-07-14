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

$colname_viajes = "-1";
if (isset($_POST['buque'])) {
  $colname_viajes = $_POST['buque'];
}

mysql_select_db($database_conexion, $conexion);
$query_viajes = sprintf("SELECT id, viaje FROM viajes WHERE buque = %s", GetSQLValueString($colname_viajes, "int"));
$viajes = mysql_query($query_viajes, $conexion) or die(mysql_error());
$row_viajes = mysql_fetch_assoc($viajes);
$totalRows_viajes = mysql_num_rows($viajes);

mysql_select_db($database_conexion, $conexion);
$SQLregistrabuque = sprintf("UPDATE precarga SET buque = %d",$_POST['buque']);
$RUNregistrabuque = mysql_query($SQLregistrabuque,$conexion) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Importacion - Buque</title>
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Siguiente paso: Asignar el Viaje de los equipos ingresados. <?php echo $_GET['buque']; ?></h1>
<form action="actualiza_precarga.php" method="post" name="form1" id="form1">
  Viaje:
  <label for="viaje"></label>
  <select name="viaje" id="viaje">
    <option value="">Seleccion</option>
    <?php
do {  
?>
    <option value="<?php echo $row_viajes['id']?>"><?php echo $row_viajes['viaje']?></option>
    <?php
} while ($row_viajes = mysql_fetch_assoc($viajes));
  $rows = mysql_num_rows($viajes);
  if($rows > 0) {
      mysql_data_seek($viajes, 0);
	  $row_viajes = mysql_fetch_assoc($viajes);
  }
?>
  </select>
  <input type="submit" name="button" id="button" value="Actualizar" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($viajes);
?>
