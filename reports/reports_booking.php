<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
$suma20 = NULL;
$suma40 = NULL;
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
$colname1_inv = "-1";
if (isset($_POST['var'])) {
  $colname1_inv = $_POST['var'];
}
$colname2_inv = "-1";
if (isset($_POST['var2'])) {
  $colname2_inv = $_POST['var2'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM asignados WHERE linea = %s AND fdespims BETWEEN %s AND %s", GetSQLValueString($colname_inv, "int"),GetSQLValueString($colname1_inv, "date"),GetSQLValueString($colname2_inv, "date"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$colname_re20 = "-1";
if (isset($_POST['linea'])) {
  $colname_re20 = $_POST['linea'];
}
$colname1_re20 = "-1";
if (isset($_POST['var'])) {
  $colname1_re20 = $_POST['var'];
}
$colname2_re20 = "-1";
if (isset($_POST['var2'])) {
  $colname2_re20 = $_POST['var2'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad  FROM asignados WHERE linea = %s AND tipo LIKE '2%%' AND fdespims BETWEEN %s AND %s GROUP BY tipo", GetSQLValueString($colname_re20, "int"),GetSQLValueString($colname1_re20, "date"),GetSQLValueString($colname2_re20, "date"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_POST['linea'])) {
  $colname_re40 = $_POST['linea'];
}
$colname1_re40 = "-1";
if (isset($_POST['var'])) {
  $colname1_re40 = $_POST['var'];
}
$colname2_re40 = "-1";
if (isset($_POST['var2'])) {
  $colname2_re40 = $_POST['var2'];
}
mysql_select_db($database_conexion, $conexion);
$query_re40 = sprintf("SELECT tipo, COUNT(*) AS cantidad  FROM asignados WHERE linea = %s AND tipo LIKE '4%%' AND fdespims BETWEEN %s AND %s GROUP BY tipo", GetSQLValueString($colname_re40, "int"),GetSQLValueString($colname1_re40, "date"),GetSQLValueString($colname2_re40, "date"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

mysql_select_db($database_conexion, $conexion);
$query_linea = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<link href="../css/DatePicker.css" rel="stylesheet" type="text/css" />
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<script src="../js/DatePicker.js" type="text/javascript"></script>
<script type="text/javascript">  
// The following should be put in your external js file,
// with the rest of your ondomready actions.
 
window.addEvent('domready', function(){
	$$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});
});
</script>
</head>
<body>
<div id="content">
<h2>REPORTE DE EQUIPOS ASIGNADOS </h2>
<form id="form1" name="form1" method="post" action="">
    <table width="300" class="resumen" id="between">
        <tr>
          <td><label>Linea: </label>
            <select name="linea" class="select" id="linea">
              <option value="" <?php if (!(strcmp("", $_POST['linea']))) {echo "selected=\"selected\"";} ?>>Select</option>
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
            </select></td>
          <td><label>Fecha entre: </label>
            <input name="var" type="text" id="var" size="16" class="DatePicker" value="<?php if(isset($_POST['var'])){ echo $_POST['var']; } else { echo date("Y-m-d");}?>" /></td>
          <td><label>Y: </label>
            <input name="var2" type="text" id="var2" size="16" class="DatePicker" value="<?php if(isset($_POST['var2'])){ echo $_POST['var2']; } else { echo date("Y-m-d");}?>" /></td>
          <td><input type="submit" name="button" id="button" value="Mostrar" /></td>
        </tr>
    </table>
  </form>
    <?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
    <p>&nbsp;</p>
  <table width="68%" align="center" class="resumen" id="resumen">
    <tr>
      <th>Equipos de 20'</th>
      <th>Equipos de  40'</th>
    </tr>
    <tr>
      <td valign="top"><?php if ($totalRows_re20 > 0) { // Show if recordset not empty ?>
        <table width="100%">
          <tr>
            <th>Tipo</th>
            <th>Cantidad</th>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_re20['tipo']; ?></td>
              <td><div align="right">
                <?php $suma20 = $suma20 + $row_re20['cantidad']; echo $row_re20['cantidad']; ?>
              </div></td>
            </tr>
            <?php } while ($row_re20 = mysql_fetch_assoc($re20)); ?>
          <tr>
            <th>Sub-Total:</th>
            <th><?php echo $suma20; ?>&nbsp;</th>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?></td>
      <td valign="top"><?php if ($totalRows_re40 > 0) { // Show if recordset not empty ?>
        <table width="100%">
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
        </table>
        <?php } // Show if recordset not empty ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
    <p><span><a href="../export/export_reports_booking.php?linea=<?php echo $_POST['linea'];?>&amp;var=<?php echo $_POST['var'];?>&amp;var2=<?php echo $_POST['var2'];?>">Exportar</a></span></p>
  <table id="pf_sortableTable1" cellpadding="0" >
    <caption>
      Total de Equipos:&nbsp;
      <?php echo $totalRows_inv ?>
      </caption>
    <thead>
      <tr>
        <th axis="number">#</th>
        <th axis="number">Buque</th>
        <th axis="number">Viaje</th>
        <th axis="string">Equipo</th>
        <th axis="string">Tipo</th>
        <th axis="string">Estatus</th>
        <th axis="string">Condicion</th>
        <th axis="date">Despacho/Muelle</th>
        <th axis="date">Despacho</th>
        <th axis="date">Recepcion</th>
        <th axis="number">EIR</th>
        <th axis="date">Despacho</th>
        <th axis="string">EIR</th>
        <th axis="string">Booking</th>
        <th axis="string">Cliente</th>
        <th axis="number">DIC</th>
        <th axis="number">DIY</th>
        </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td class="rightAlign"><?php echo $row_inv['id']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['buque']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['viaje']; ?></td>
          <td><?php echo $row_inv['contenedor']; ?></td>
          <td><?php echo $row_inv['tipo']; ?></td>
          <td><?php echo $row_inv['estatus']; ?></td>
          <td><?php cdt($row_inv['condicion']); ?></td>
          <td align="center"><?php echo $row_inv['fdb']; ?></td>
          <td align="center"><?php echo $row_inv['fdm']; ?></td>
          <td align="center"><?php echo $row_inv['frd']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['eir_r']; ?></td>
          <td align="center"><?php echo $row_inv['fdespims']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['eir_d']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['booking']; ?></td>
          <td class="rightAlign"><?php echo $row_inv['cliente']; ?></td>
          <td class="rightAlign"><?php alarmapais($row_inv['dpais']); ?></td>
          <td class="rightAlign"><?php alarma($row_inv['dpatio']); ?></td>
        </tr>
        <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="17">&nbsp;</td>
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
<?php if ($totalRows_inv == 0) { // Show if recordset empty ?>
  <h2>Sin resultados</h2>
  <?php } // Show if recordset empty ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($inv);

mysql_free_result($re20);

mysql_free_result($re40);

mysql_free_result($linea);
?>
