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
$query_consignatario = "SELECT id, nombre FROM consignatario ORDER BY nombre ASC";
$consignatario = mysql_query($query_consignatario, $conexion) or die(mysql_error());
$row_consignatario = mysql_fetch_assoc($consignatario);
$totalRows_consignatario = mysql_num_rows($consignatario);

$colname_inv = "-1";
if (isset($_POST['consig'])) {
  $colname_inv = $_POST['consig'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT *, DATEDIFF(CURRENT_DATE,fdb) AS dpais, DATEDIFF(frd,fdb) AS dpatio FROM existenciaconsig WHERE consignatario = %s", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

$colname_re20 = "-1";
if (isset($_POST['consig'])) {
  $colname_re20 = $_POST['consig'];
}
mysql_select_db($database_conexion, $conexion);
$query_re20 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciaconsig WHERE tipo LIKE '2%%' AND `consignatario` = %s GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re20, "int"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_POST['consig'])) {
  $colname_re40 = $_POST['consig'];
}
mysql_select_db($database_conexion, $conexion);
$query_re40 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciaconsig WHERE tipo LIKE '4%%' AND `consignatario` = %s GROUP BY tipo ORDER BY tipo", GetSQLValueString($colname_re40, "text"));
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
<div id="content">
  <form id="form1" name="form1" method="post" action="">
<table width="300%" class="resumen">
        <tr>
          <td>Consignatario</td>
          <td><label for="consig"></label>
            <select name="consig" id="consig">
              <option value="">Seleccione</option>
              <?php
do {  
?>
              <option value="<?php echo $row_consignatario['id']?>"><?php echo $row_consignatario['nombre']?></option>
              <?php
} while ($row_consignatario = mysql_fetch_assoc($consignatario));
  $rows = mysql_num_rows($consignatario);
  if($rows > 0) {
      mysql_data_seek($consignatario, 0);
	  $row_consignatario = mysql_fetch_assoc($consignatario);
  }
?>
            </select></td>
          <td><input type="submit" name="button" id="button" value="ver" /></td>
        </tr>
      </table>
    </form>
  <?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
  <table width="300%" class="resumen" id="resumen">
    <caption>&nbsp;
      </caption>
    <tr>
      <td width="50%" valign="top"><?php if ($totalRows_re20 > 0) { // Show if recordset not empty ?>
          <table width="100%">
            <tr>
              <th>Tipo</th>
              <th>Cant</th>
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
              <th><div align="center"><?php echo $suma20; ?></div></th>
            </tr>
          </table>
          <?php } // Show if recordset not empty ?></td>
      <td width="50%" valign="top"><?php if ($totalRows_re40 > 0) { // Show if recordset not empty ?>
          <table width="100%">
            <tr>
              <th>Tipo</th>
              <th>Cant</th>
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
              <th><div align="center"><?php echo $suma40; ?></div></th>
            </tr>
          </table>
          <?php } // Show if recordset not empty ?></td>
    </tr>
  </table>
  <div id="export"><a href="../export/export_reports_inventory_consignee.php?consig=<?php echo $_POST['consig'];?>">exportar</a></div>
    <table align="left" cellpadding="0" id="pf_sortableTable1" >
      <caption>
      <?php echo $row_inv['consignom']; ?> | Total equipos en inventario: <?php echo $totalRows_inv ?>
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
          <th axis="string">B/L</th>
          <th axis="number">EIR</th>
          <th axis="string">Observaciones</th>
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
            <td><?php echo $row_inv['estatus']; ?></td>
            <td><?php echo $row_inv['condicion']; ?></td>
            <td><?php echo $row_inv['buque']; ?></td>
            <td><?php echo $row_inv['viaje']; ?></td>
            <td width="5%" class="rightAlign"><?php echo $row_inv['fdb']; ?></td>
            <td width="5%" class="rightAlign"><?php echo $row_inv['frd']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['precinto']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['bl']; ?></td>
            <td class="rightAlign"><?php echo $row_inv['eir_r']; ?></td>
            <td width="18%"><?php echo $row_inv['obs']; ?></td>
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
<?php if(isset($_POST['consig']) and $totalRows_inv == 0){
	echo "<h2>No hay resultados que mostrar</h2>";
}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($consignatario);

mysql_free_result($inv);

mysql_free_result($re20);

mysql_free_result($re40);
?>
