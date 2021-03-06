<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();

#Para coregir
if(!isset($totalRows_inv)){
	$totalRows_inv = -1;
}
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_line = 50;
$pageNum_line = 0;
if (isset($_GET['pageNum_line'])) {
  $pageNum_line = $_GET['pageNum_line'];
}
$startRow_line = $pageNum_line * $maxRows_line;

mysql_select_db($database_conexion, $conexion);
$query_line = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$query_limit_line = sprintf("%s LIMIT %d, %d", $query_line, $startRow_line, $maxRows_line);
$line = mysql_query($query_limit_line, $conexion) or die(mysql_error());
$row_line = mysql_fetch_assoc($line);

if (isset($_GET['totalRows_line'])) {
  $totalRows_line = $_GET['totalRows_line'];
} else {
  $all_line = mysql_query($query_line);
  $totalRows_line = mysql_num_rows($all_line);
}
$totalPages_line = ceil($totalRows_line/$maxRows_line)-1;

$colname_re20 = "-1";
if (isset($_POST['linea'])) {
  $colname_re20 = $_POST['linea'];
}
$colname1_re20 = date("Y-m-d");
if (isset($_POST['var'])) {
  $colname1_re20 = $_POST['var'];
}
$colname2_re20 = date("Y-m-d");
if (isset($_POST['var2'])) {
  $colname2_re20 = $_POST['var2'];
}

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
$query_re20 = sprintf("SELECT tipo, COUNT(*) as cantidad FROM despachados WHERE linea = %s AND fdespims BETWEEN %s AND %s AND tipo LIKE '2%%' GROUP BY tipo", GetSQLValueString($colname_re20, "int"),GetSQLValueString($colname1_re20, "date"),GetSQLValueString($colname2_re20, "date"));
$re20 = mysql_query($query_re20, $conexion) or die(mysql_error());
$row_re20 = mysql_fetch_assoc($re20);
$totalRows_re20 = mysql_num_rows($re20);

$colname_re40 = "-1";
if (isset($_POST['linea'])) {
  $colname_re40 = $_POST['linea'];
}
$colname1_re40 = date('Y-m-d');
if (isset($_POST['var'])) {
  $colname1_re40 = $_POST['var'];
}
$colname2_re40 = date('Y-m-d');
if (isset($_POST['var2'])) {
  $colname2_re40 = $_POST['var2'];
}

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
$query_re40 = sprintf("SELECT tipo, COUNT(*) as cantidad FROM despachados WHERE linea = %s AND fdespims BETWEEN %s AND %s AND tipo LIKE '4%%' GROUP BY tipo", GetSQLValueString($colname_re40, "int"),GetSQLValueString($colname1_re40, "date"),GetSQLValueString($colname2_re40, "date"));
$re40 = mysql_query($query_re40, $conexion) or die(mysql_error());
$row_re40 = mysql_fetch_assoc($re40);
$totalRows_re40 = mysql_num_rows($re40);

$colname_re40 = "-1";
if (isset($_POST['linea'])) {
  $colname_re40 =$_POST['linea'];
}

$queryString_inv = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_inv") == false && 
        stristr($param, "totalRows_inv") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_inv = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_inv = sprintf("&totalRows_inv=%d%s", $totalRows_inv, $queryString_inv);

//GateIn Procedimiento
if(isset($_POST['linea']) and isset($_POST['var']) and isset($_POST['var2'])){
	$linea = $_POST['linea'];
	$fini = $_POST['var'];
	$ffin = $_POST['var2'];
	mysqli_select_db($conexion_li,$database_conexion);
	#Gate Out CALL 
	$GateOut = mysqli_query($conexion_li,"CALL `GateOut`('$linea', '$fini', '$ffin')")or die(mysqli_error());
	$invGateOut = mysqli_fetch_assoc($GateOut);
	$totalGateOut = mysqli_num_rows($GateOut);
	mysqli_close($conexion_li);
}
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
<h2>MOVIMIENTOS DE SALIDA </h2>
<h2><a href="reports_gateout_plusbuque.php">Devoluciones (Reporte de devoluciones con indicacion del buque y viaje donde fueron cargados)</a> </h2>
<form id="form1" name="form1" method="post" action="">
    <table width="300" align="left" class="resumen" id="between">
        <tr>
          <td><label>Linea: </label>
            <select name="linea" class="select" id="linea">
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
          </select></td>
          <td><label>Fecha entre: </label>
          <input name="var" type="text" id="var" size="16" class="DatePicker" value="<?php if(isset($_POST['var'])){ echo $_POST['var']; } else { echo date("Y-m-d");}?>" /></td>
          <td><label>Y: </label>
          <input name="var2" type="text" id="var2" size="16" class="DatePicker" value="<?php if(isset($_POST['var2'])){ echo $_POST['var2']; } else { echo date("Y-m-d");}?>" /></td>
          <td><input type="submit" name="button" id="button" value="Mostrar" /></td>
        </tr>
    </table>
    </form>
      <?php if($totalGateOut > 0){ ?>
    <p>&nbsp;</p>
    <table width="68%" align="left" class="resumen" id="resumen">
    <caption>
      Resumen
    </caption>
      <tr>
        <th>Equipos de 20&quot;</th>
        <th>Equipos de 40&quot;</th>
      </tr>
      <tr>
        <td valign="top"><?php if ($totalRows_re20 > 0) { // Show if recordset not empty ?>
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
                <th><?php echo $suma20; ?>&nbsp;</th>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
        <td valign="top"><?php if ($totalRows_re40 > 0) { // Show if recordset not empty ?>
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
      <th><?php echo $suma40; ?>&nbsp;</th>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?></td>
      </tr>
    </table>
    <div id="export"><a href="../export/export_reports_gateout.php?linea=<?php echo $_POST['linea'];?>&var=<?php echo $_POST['var'];?>&var2=<?php echo $_POST['var2'];?>">exportar</a></div>
    <table align="left" cellpadding="0" id="pf_sortableTable1" >
      <caption>
        Total de Equipos:&nbsp;
      <?php echo $suma20 + $suma40 ?>
      </caption>
      <thead>
        <tr>
          <th axis="number">ID</th>
          <th axis="string">Equipo</th>
          <th axis="string">Tipo</th>
          <th axis="string">Estatus</th>
          <th axis="string">Condicion</th>
          <th axis="date">Despacho/Muelle</th>
          <th axis="date">Entrada</th>
          <th axis="string">Precinto</th>
          <th axis="string">B/L</th>
          <th axis="date">Salida</th>
          <th axis="number">EIR</th>
          <th axis="string">Estatus</th>
          <th axis="string">Consignatario</th>
          <th axis="number">D-Pais</th>
          <th axis="number">D-Patio</th>
          <th axis="number">Acopio</th>
        </tr>
      </thead>
      <tbody>
      <?php do { ?>
        <tr>
          <td class="rightAlign"><?php echo $invGateOut['id'];  ?>&nbsp;</td>
          <td><?php echo $invGateOut['contenedor'];  ?></td>
          <td align="center"><?php echo $invGateOut['tipo'];  ?></td>
          <td align="center"><?php echo $invGateOut['estatus'];?></td>
          <td align="center"><?php echo $invGateOut['condicion']; ?></td>
          <td align="center"><?php echo $invGateOut['fdb'];  ?></td>
          <td align="center"><?php echo $invGateOut['frd'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['precinto'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['bl'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['fdespims'];  ?></td>
          <td align="center"><?php echo $invGateOut['eir_d'];  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['status_d'];  ?></td>
          <td><?php echo $invGateOut['consignatario'];  ?></td>
          <td class="rightAlign"><?php alarmapais($invGateOut['dpais']);  ?>&nbsp;</td>
          <td class="rightAlign"><?php alarma($invGateOut['dpatio']);  ?></td>
          <td class="rightAlign"><?php echo $invGateOut['acopio'];  ?></td>
        </tr>
        <?php } while($invGateOut = mysqli_fetch_assoc($GateOut)); ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <p>
      <?php } ?>
<script type="text/javascript">
// BeginWebWidget phatfusion_sortableTable: pf_sortableTable1

		var pf_sortableTable1 = {};
		window.addEvent('domready', function(){
			pf_sortableTable1 = new sortableTable('pf_sortableTable1', {overCls: 'over'});
		});
	

// EndWebWidget phatfusion_sortableTable: pf_sortableTable1
      </script></p>
    <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($line);

mysql_free_result($re20);

mysql_free_result($re40);
?>
