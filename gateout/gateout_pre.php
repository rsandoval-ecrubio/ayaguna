<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php 
//Listado de equipos seleccionados
$ids = $_GET['lista']; //Listado de equipos seleccionados
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

mysql_select_db($database_conexion, $conexion);
$query_inv = "SELECT id, contenedor, tipo, estatus, condicion, fdb, fdm, frd, patio,eir_r,estatus,condicion FROM existenciadevolucion WHERE id IN($ids)";
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<script src="../js/validaciones.js" type="text/javascript"></script>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.centrar {
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	width: auto;
	float: left;
}
</style>
</head>
<body>
    <div id="despacho" class="centrar">
    	<form id="form1" name="form1" method="post" action="gateout_pre_save.php">
        <h2>PRE - ACARREO    	  
          <input type="submit" name="button" id="button" value="Guardar" />
        </h2>
        <table width="700">
        <tr>
    	      <th scope="col">Contenedor</th>
    	      <th scope="col">Tipo</th>
    	      <th scope="col">Arribo</th>
    	      <th scope="col">Despacho</th>
    	      <th scope="col">Ingreso</th>
    	      <th scope="col">EIR</th>
    	      <th scope="col">Estatus</th>
    	      <th scope="col">Condicion</th>
    	      <th scope="col">Patio</th>
   	        </tr>
    	    <?php do { ?>
   	        <tr>
   	          <td><input name="id[]" type="hidden" id="id[]" value="<?php echo $row_inv['id']; ?>" />
              <?php echo $row_inv['contenedor']; ?></td>
   	          <td><?php echo $row_inv['tipo']; ?></td>
   	          <td align="center"><?php echo $row_inv['fdb']; ?></td>
   	          <td align="center"><?php echo $row_inv['fdm']; ?></td>
   	          <td align="center"><?php echo $row_inv['frd']; ?></td>
   	          <td><?php echo $row_inv['eir_r']; ?></td>
   	          <td align="center"><?php echo $row_inv['estatus']; ?></td>
   	          <td align="center"><?php cdt($row_inv['condicion']); ?></td>
   	          <td><?php echo $row_inv['patio']; ?></td>
            </tr>
    	      <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
          </table>
   	  </form>
      <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($inv);
?>
