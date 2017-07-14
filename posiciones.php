<?php require_once('Connections/conexion.php'); ?>
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
$query_layout = "SELECT *,(x*y*z) AS capTeus FROM zonas";
$layout = mysql_query($query_layout, $conexion) or die(mysql_error());
$row_layout = mysql_fetch_assoc($layout);
$totalRows_layout = mysql_num_rows($layout);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Layout</title>
<link href="css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>&nbsp;</p>
<?php do { ?>
  <?php
$cantColumnas = $row_layout['y'];
$cantFilas = $row_layout['x'];
$profundidad = $row_layout['z'];
$columna = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
echo "Patio: ".$row_layout['patio']."<br/>";
echo "Zona: ".$row_layout['zona']."<br/>";
for($z=1;$z<=$row_layout['z'];$z++){
	for($y=0;$y<=$row_layout['y']-1;$y++){
		for($x=1;$x<=$row_layout['x'];$x++){
			echo $row_layout['patio'].$row_layout['zona'].$columna[$y].$z.$x."<br/>";
		}
	}
}
echo "<hr />";

?>
  <?php } while ($row_layout = mysql_fetch_assoc($layout)); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($layout);
?>
