<?php 
//session_start();
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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_conexion, $conexion);
$query_re20 = "SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '2%' GROUP BY tipo ORDER BY tipo";
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

mysql_select_db($database_conexion, $conexion);
$query_re40 = "SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '4%' GROUP BY tipo ORDER BY tipo";
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

$_pagi_sql = "select * from existenciagral";
$_pagi_cuantos = 25;
$_pagi_nav_num_enlaces = 5;
$_pagi_nav_anterior = "&lt;";
$_pagi_nav_siguiente = "&gt;";
include('../funciones/paginar.php');
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
<body><h2>INVENTARIO GENERAL</h2>
<table width="400" class="resumen" id="resumen">
  <tr>
        <th>Equipo de 20&quot;</th>
        <th>Equipos de 40&quot;</th>
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
              <td><div align="right">
                <?php $suma20 = 0; $suma20 = $suma20 + $row_re20['cantidad']; echo $row_re20['cantidad']; ?>
              </div></td>
            </tr>
<?php } while ($row_re20 = mysql_fetch_assoc($re20)); ?>
            <tr>
              <th>Sub-Total:</th>
              <th><div align="center"><?php echo $suma20; ?></div></th>
            </tr>
        </table></td>
        <td valign="top"><table width="100%">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_re40['tipo']; ?></td>
              <td><div align="right">
                <?php $suma40 = 0; $suma40 = $suma40 + $row_re40['cantidad']; echo $row_re40['cantidad']; ?>
              </div></td>
            </tr>
<?php } while ($row_re40 = mysql_fetch_assoc($re40)); ?>
            <tr>
              <th>Sub-Total:</th>
              <th><div align="center"><?php echo $suma40; ?></div></th>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo $_pagi_totalReg; ?></strong></td>
      </tr>
    </table>
<div id="export"><a href="../export/export_reports_inventory.php">exportar</a></div>
    <table align="left" cellpadding="0" id="pf_sortableTable1" ><caption>
    <?php echo $_pagi_navegacion; ?>
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
          <th axis="date">Descarga/Buque</th>
          <th axis="date">Despacho/Muelle</th>
          <th axis="date">Recepcion/Patio</th>
          <th axis="string">Precinto</th>
          <th axis="string">B/L</th>
          <th axis="number">EIR</th>
          <th axis="number">Fatc</th>
          <th axis="number">Pase(T)</th>
          <th axis="string">Observaciones</th>
          <th axis="string">Patio</th>
          <th axis="string">Consignatario</th>
          <th axis="number">D-Pais</th>
          <th axis="number">D-Patio</th>
        </tr>
      </thead>
      <tbody><?php while($row = mysql_fetch_array($_pagi_result)){ ?>
        <tr>
          <td class="rightAlign"><?php echo $row['id']; ?></td>
          <td><?php echo $row['contenedor']; ?></td>
          <td align="center"><?php echo $row['tipo']; ?></td>
          <td align="center"><?php estatus($row['estatus']); ?></td>
          <td align="center"><?php condicion($row['condicion']); ?></td>
          <td><?php echo $row['buque']; ?></td>
          <td><?php echo $row['viaje']; ?></td>
          <td align="center"><?php echo $row['fdb']; ?></td>
          <td align="center"><?php echo $row['fdm']; ?></td>
          <td align="center"><?php echo $row['frd']; ?></td>
          <td class="rightAlign"><?php echo $row['precinto']; ?></td>
          <td class="rightAlign"><?php echo $row['bl']; ?></td>
          <td class="rightAlign"><?php echo $row['eir_r']; ?></td>
          <td class="rightAlign"><?php echo $row['fact']; ?></td>
          <td class="rightAlign"><?php echo $row['paset']; ?></td>
          <td width="18%"><?php echo htmlentities($row['obs']); ?></td>
          <td align="center"><?php echo $row['patio']; ?></td>
          <td><?php echo $row['consignatario']; ?></td>
          <td class="rightAlign"><?php alarmapais($row['dpais']); ?></td>
          <td class="rightAlign"><?php alarma($row['dpatio']); ?></td>
        </tr><?php } ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <script type="text/javascript">
// BeginWebWidget phatfusion_sortableTable: pf_sortableTable1

		var pf_sortableTable1 = {};
		window.addEvent('domready', function(){
			pf_sortableTable1 = new sortableTable('pf_sortableTable1', {overCls: 'over'});
		});
	

// EndWebWidget phatfusion_sortableTable: pf_sortableTable1
    </script>
<p><strong><?php echo $_pagi_info;?></strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($re20);

mysql_free_result($re40);

?>
