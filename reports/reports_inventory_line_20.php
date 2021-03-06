<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
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
$query_line = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$line = mysql_query($query_line, $conexion) or die(mysql_error());
$row_line = mysql_fetch_assoc($line);
$totalRows_line = mysql_num_rows($line);

$colname_re40 = "-1";
if (isset($_POST['linea'])) {
  $colname_re40 =$_POST['linea'];
}

$colname_re20 = "-1";
if (isset($_POST['linea'])) {
  $colname_re20 = $_POST['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '2%%' AND linea = %s GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re20, "int"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_inv = "-1";
if (isset($_POST['linea'])) {
  $colname_inv = $_POST['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM existenciagral WHERE linea = %s AND tipo LIKE '2%%'", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
</head>
<body>
      <h2>INVENTARIO DE 20&quot; POR LINEA</h2>
    <form id="form1" name="form1" method="post" action="">
      <p>
        <label>Linea:
          <select name="linea" id="linea">
            <option value="-1" <?php if (!(strcmp(-1, $_POST['linea']))) {echo "selected=\"selected\"";} ?>>Seleccion</option>
            <?php
do {  
?>
            <option value="<?php echo $row_line['id']?>"<?php if (!(strcmp($row_line['id'], $_POST['linea']))) {echo "selected=\"selected\"";} ?>><?php echo $row_line['nombre']?></option>
            <?php
} while ($row_line = mysql_fetch_assoc($line));
  $rows = mysql_num_rows($line);
  if($rows > 0) {
      mysql_data_seek($line, 0);
	  $row_line = mysql_fetch_assoc($line);
  }
?>
          </select>
        </label>
        <input type="submit" name="button" id="button" value="Mostrar" />
      </p>
  </form>
    <?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
    <p>&nbsp;</p>
  <table width="200" class="resumen" id="resumen">
    <tr>
      <th width="50%">Equipos de 20&quot;</th>
      <th width="50%">&nbsp;</th>
    </tr>
    <tr>
      <td valign="top"><table width="100%">
        <tr>
          <th>Tipo</th>
          <th>Cant</th>
          </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_re20['tipo']; ?></td>
            <td><div align="right"><?php $suma20 = $suma20 + $row_re20['cantidad']; echo $row_re20['cantidad']; ?></div></td>
            </tr>
          <?php } while ($row_re20 = mysql_fetch_assoc($re20)); ?>
        <tr>
          <th>Sub-Total:</th>
          <th><?php echo $suma20; ?>&nbsp;</th>
          </tr>
      </table></td>
      <td valign="top">&nbsp;</td>
    </tr>
  </table>
<div id="export"><a href="../export/export_reports_inventory_line_20.php?linea=<?php echo $_POST['linea'];?>">exportar</a></div>
      <table align="left" cellpadding="0" id="pf_sortableTable1" ><caption>
        Total de Equipos:&nbsp; <?php echo $totalRows_inv ?>
        </caption>
        <thead>
          <tr>
            <th axis="number">ID</th>
            <th axis="string">Equipos</th>
            <th axis="string">Tipo</th>
            <th axis="string">Estatus</th>
            <th axis="string">Condicion</th>
            <th axis="string">Buque</th>
            <th axis="string">Viaje</th>
            <th axis="date">Despacho/Muelle</th>
            <th axis="date">Entrada</th>
            <th axis="string">Precinto</th>
            <th axis="string">B/L</th>
            <th axis="number">EIR</th>
            <th axis="string">Patio</th>
            <th axis="number">D-Pais</th>
            <th axis="number">D-Patio</th>
          </tr>
        </thead>
        <tbody>
          <?php do { ?>
            <tr>
              <td class="rightAlign"><?php echo $row_inv['id']; ?></td>
              <td><?php echo $row_inv['contenedor']; ?></td>
              <td align="center"><?php echo $row_inv['tipo']; ?></td>
              <td align="center"><?php estatus($row_inv['estatus']); ?></td>
              <td align="center"><?php condicion($row_inv['condicion']); ?></td>
              <td><?php echo $row_inv['buque']; ?></td>
              <td><?php echo $row_inv['viaje']; ?></td>
              <td align="center"><?php echo $row_inv['fdm']; ?></td>
              <td align="center"><?php echo $row_inv['frd']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['precinto']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['bl']; ?></td>
              <td align="center"><?php echo $row_inv['eir_r']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['patio']; ?></td>
              <td class="rightAlign"><?php alarmapais($row_inv['dpais']); ?></td>
              <td class="rightAlign"><?php alarma($row_inv['dpatio']); ?></td>
            </tr>
            <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
      <?php } // Show if recordset not empty ?>
<script type="text/javascript">
// BeginWebWidget phatfusion_sortableTable: pf_sortableTable1

		var pf_sortableTable1 = {};
		window.addEvent('domready', function(){
			pf_sortableTable1 = new sortableTable('pf_sortableTable1', {overCls: 'over'});
		});
	

// EndWebWidget phatfusion_sortableTable: pf_sortableTable1
    </script>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($inv);

mysql_free_result($line);

mysql_free_result($re20);

?>
