<?php 
session_start();
require('../config.php');
require_once('../Connections/conexion.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php 
//Listado de equipos seleccionados
if(isset($_GET['ids'])){
	$ids = $_GET['ids'];
}else {
	$total_id = count($_POST['id']); //Total de equipos seleccionados
	$ids = implode(",",$_POST['id']); //Listado de equipos seleccionados
}
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
$query_inv = "SELECT id, linea, contenedor, tipo, estatus, condicion, fdb, fdm, frd, patio,eir_r,estatus,condicion FROM existenciadevolucion WHERE id IN($ids)";
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$linea = $row_inv['linea'];

mysql_select_db($database_conexion, $conexion);
$query_buques = "SELECT * FROM buques WHERE linea = $linea";
$buques = mysql_query($query_buques, $conexion) or die(mysql_error());
$row_buques = mysql_fetch_assoc($buques);
$totalRows_buques = mysql_num_rows($buques);

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
    	<form id="form1" name="form1" method="post" action="gateout_fin.php">
        <h2>DEVOLUCION - Lista de Acarreo</h2>
        <p>
          <label for="fdespims">
        Fecha</label>
          <input name="fdespims" type="text" id="fdespims" value="<?php echo date("Y-m-d",strtotime(AHORA)); ?>" size="8" maxlength="10" />
          <input type="submit" name="button" id="button" value="Crear lista" />
          <?php if(!isset($_GET['ids'])){?>
          | <a href="gateout_pre.php?lista=<?php echo $ids; ?>">Crear lista de Pre-Acarreo</a><?php } else { ?> 
          <a href="gateout_pre_view_save.php">Regresar al listado guardado</a>
          <?php }?>
        </p>
        <p>
          <label for="buque">Buque: </label>
          <select name="buque" id="buque">
            <option value="0">Seleccione</option>
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
          <label for="viaje">Viaje:</label>
          <input type="text" name="viaje" id="viaje" />
* Buque y Viaje donde se cargaran los equipos</p>
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
    	      <th scope="col">EIR-Salida</th>
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
   	          <td align="center"><input name="eir_d[]" type="text" id="eir_d[]" value="0" size="8" maxlength="10" /></td>
            </tr>
    	      <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
          </table>
   	  </form>
      <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($inv);

mysql_free_result($buques);
?>
