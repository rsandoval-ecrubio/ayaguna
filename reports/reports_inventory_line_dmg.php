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

$colname_inv = "-1";
if (isset($_POST['linea'])) {
  $colname_inv = $_POST['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM existenciagral WHERE condicion = '0' OR condicion = '4' AND linea = %s", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

mysql_select_db($database_conexion, $conexion);
$query_linea = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

$colname_re20 = "-1";
if (isset($_POST['linea'])) {
  $colname_re20 = $_POST['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existencia WHERE condicion = 0 OR condicion = 4 AND linea = %s AND tipo LIKE '2%%' GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re20, "int"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_POST['linea'])) {
  $colname_re40 = $_POST['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_re40 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existencia WHERE condicion = 0 OR condicion = 4 AND linea = %s AND tipo LIKE '4%%' GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re40, "int"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);
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
    <h2>INVENTARIO DMG - LINEA</h2>
    <form id="form1" name="form1" method="post" action="">
      <label>Linea:
        <select name="linea" id="linea">
          <option value="-1" <?php if (!(strcmp(-1, $_POST['linea']))) {echo "selected=\"selected\"";} ?>>Seleccion</option>
          <?php
do {  
?>
          <option value="<?php echo $row_linea['id']?>"<?php if (!(strcmp($row_linea['id'], $_POST['linea']))) {echo "selected=\"selected\"";} ?>><?php echo $row_linea['nombre']?></option>
          <?php
} while ($row_linea = mysql_fetch_assoc($linea));
  $rows = mysql_num_rows($linea);
  if($rows > 0) {
      mysql_data_seek($linea, 0);
	  $row_linea = mysql_fetch_assoc($linea);
  }
?>
        </select>
      </label>
      <input type="submit" name="button" id="button" value="Mostrar" />
    </form>
    <?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
    <p>&nbsp;</p>
  <table width="68%" class="resumen" id="resumen">
    <tr>
      <th>Equipos de 20'</th>
      <th>Equipos de  40'</th>
    </tr>
    <tr>
      <td valign="top"><table width="100%">
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
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
      <td valign="top"><table width="100%">
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_re40['tipo']; ?></td>
            <td><div align="right">
              <?php $suma40 = $suma40 + $row_re40['cantidad']; echo $row_re40['cantidad']; ?>
            </div></td>
          </tr>
          <?php } while ($row_re40 = mysql_fetch_assoc($re40)); ?>
        <tr>
          <th>Sub-Total:</th>
          <th><?php echo $suma40; ?>&nbsp;</th>
        </tr>
      </table></td>
    </tr>
  </table>
  <div id="export"><a href="../export/export_reports_inventory_line_dmg.php?linea=<?php echo $_POST['linea'];?>">exportar</a></div>
      <table align="left" cellpadding="0" id="pf_sortableTable1" ><caption>
        Total de Equipos:&nbsp; <?php echo $totalRows_inv ?>
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
            <th axis="date">Despacho/Muelle</th>
            <th axis="date">Entrada</th>
            <th axis="string">Precinto</th>
            <th axis="string">Obs</th>
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
              <td><?php echo $row_inv['tipo']; ?></td>
              <td><?php estatus($row_inv['status']); ?></td>
              <td><?php condicion($row_inv['condicion']); ?></td>
              <td><?php echo $row_inv['buque']; ?></td>
              <td><?php echo $row_inv['viaje']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['fdm']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['frd']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['precinto']; ?></td>
              <td align="left"><?php echo $row_inv['obs']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['bl']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['eir_r']; ?></td>
              <td class="rightAlign"><?php echo $row_inv['patio']; ?></td>
              <td class="rightAlign"><?php alarmapais($row_inv['dpais']); ?></td>
              <td class="rightAlign"><?php alarma($row_inv['dpatio']); ?></td>
            </tr>
            <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="16">&nbsp;</td>
          </tr>
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

mysql_free_result($linea);

mysql_free_result($re20);

mysql_free_result($re40);
?>
