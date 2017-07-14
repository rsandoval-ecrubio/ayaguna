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
$query_linea = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

$colname_inv = "-1";
if (isset($_POST['linea'])) {
  $colname_inv = $_POST['linea'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT * FROM existenciadevolucion WHERE linea = %s", GetSQLValueString($colname_inv, "int"));
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
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<script type="text/javascript">
function seleccionar_todo(){ 
   for (i=0;i<document.devolucion.elements.length;i++) 
      if(document.devolucion.elements[i].type == "checkbox")	
         document.devolucion.elements[i].checked=1 
}

function deseleccionar_todo(){ 
   for (i=0;i<document.devolucion.elements.length;i++) 
      if(document.devolucion.elements[i].type == "checkbox")	
         document.devolucion.elements[i].checked=0 
} 
</script>
</head>
<body>
<div id="wrapper">
  <div id="content">
    <div id="modulo_title">
      <h2>DEVOLUCION - Creacion del listado</h2>
    </div>
    <form id="form1" name="form1" method="post" action="">
      <label for="linea">Linea: </label>
      <select name="linea" id="linea">
        <option value="-1">Seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_linea['id']?>"><?php echo $row_linea['nombre']?></option>
        <?php
} while ($row_linea = mysql_fetch_assoc($linea));
  $rows = mysql_num_rows($linea);
  if($rows > 0) {
      mysql_data_seek($linea, 0);
	  $row_linea = mysql_fetch_assoc($linea);
  }
?>
      </select>
      <input type="submit" name="button" id="button" value="Enviar" />
   &nbsp; - [<a href="gateout_pre_view_save.php">Ver Guardados</a>]
    - | <a href="storage.php">Reporte de Acopio |</a>
    </form>
    <form id="devolucion" name="devolucion" method="post" action="gateout_form.php">
      <?php if ($totalRows_inv > 0) { // Show if recordset not empty ?>
      <input type="submit" name="button2" id="button2" value="Devolver" />
  <table id="pf_sortableTable1">
    <thead>
      <tr>
        <th><a href="javascript:seleccionar_todo()">C </a>| <a href="javascript:deseleccionar_todo()">U</a></th>
        <th axis="string">Equipo</th>
        <th axis="string">Tipo</th>
        <th axis="string">Estatus</th>
        <th axis="string">Condicion</th>
        <th axis="string">Buque</th>
        <th axis="string">Viaje</th>
        <th axis="date">Arribo</th>
        <th axis="date">Entrada</th>
        <th axis="number">EIR</th>
        <th axis="string">Patio</th>
        <th axis="string">Obs.</th>
        <th axis="number">D-Pais</th>
        <th axis="number">D-Patio</th>
        </tr>
    </thead>
    <?php do { ?>
      <tr>
        <td><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row_inv['id']; ?>" />
          <label for="id[]"></label></td>
        <td><?php echo $row_inv['contenedor']; ?></td>
        <td><?php echo $row_inv['tipo']; ?></td>
        <td><?php echo $row_inv['estatus']; ?></td>
        <td><?php echo $row_inv['condicion']; ?></td>
        <td><?php echo $row_inv['buque']; ?></td>
        <td><?php echo $row_inv['viaje']; ?></td>
        <td><?php echo $row_inv['fdb']; ?></td>
        <td><?php echo $row_inv['frd']; ?></td>
        <td><?php echo $row_inv['eir_r']; ?></td>
        <td><?php echo $row_inv['patio']; ?></td>
        <td><?php echo $row_inv['obs']; ?></td>
        <td><?php echo $row_inv['DIC']; ?></td>
        <td><?php echo $row_inv['DIY']; ?></td>
      </tr>
      <?php } while ($row_inv = mysql_fetch_assoc($inv)); ?>
  </table>
  <input type="submit" name="button3" id="button3" value="Devolver" />
  <?php } // Show if recordset not empty ?>
<script type="text/javascript">
// BeginWebWidget phatfusion_sortableTable: pf_sortableTable1
		var pf_sortableTable1 = {};
		window.addEvent('domready', function(){
			pf_sortableTable1 = new sortableTable('pf_sortableTable1', {overCls: 'over'});
		});
// EndWebWidget phatfusion_sortableTable: pf_sortableTable1
      </script>
    </form>

  </div>
</div>
</body>
</html>
<?php
mysql_free_result($linea);

mysql_free_result($inv);
?>
