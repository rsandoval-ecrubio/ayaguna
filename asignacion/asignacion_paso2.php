<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
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
if (isset($_POST['id'])) {
  $colname_inv = $_POST['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_inv = sprintf("SELECT id, contenedor, tipo, estatus, condicion, fdb, fdm, frd, eir_r, patio, DIC, DIY FROM existenciadevolucion WHERE id = %s", GetSQLValueString($colname_inv, "int"));
$inv = mysql_query($query_inv, $conexion) or die(mysql_error());
$row_inv = mysql_fetch_assoc($inv);
$totalRows_inv = mysql_num_rows($inv);

mysql_select_db($database_conexion, $conexion);
$query_consig = "SELECT id, nombre FROM consignatario ORDER BY nombre ASC";
$consig = mysql_query($query_consig, $conexion) or die(mysql_error());
$row_consig = mysql_fetch_assoc($consig);
$totalRows_consig = mysql_num_rows($consig);

//Actualizar Registro de contenedor
$auditoria = $_SESSION['auth'];
$actualizado = 0;
$asignado = 0;

if(isset($_POST['date1']) and isset($_POST['eir_d']) and isset($_POST['cliente']) and isset($_POST['booking'])){
	$id = $_POST['id'];
	$fdespacho = $_POST['date1'];
	$eir = $_POST['eir_d'];
	$consig = $_POST['cliente'];
	$booking = $_POST['booking'];
	
	mysql_select_db($database_conexion, $conexion);
	$sqlinv = "UPDATE inventario SET fdespims = '$fdespacho', eir_d = '$eir', c = 1, auditoria = '$auditoria' WHERE id = '$id'";
	$runsqlinv = mysql_query($sqlinv,$conexion) or die(mysql_error()."No se pudo actualizar el inventario");
	$actualizado = mysql_affected_rows();
	
	//Registrar la asignacion
	$sqlasig = "INSERT INTO asignaciones (equinv,booking,fecha,cliente,auditoria) VALUES('$id','$booking','$fdespacho','$consig','$auditoria')";
	$runsqlasig = mysql_query($sqlasig,$conexion) or die(mysql_error()."No se pudo registrar la asignacion");
	$asignado = mysql_affected_rows();
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../js/validaciones.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
<link href="../css/DatePicker.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
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
<label for="linea"></label>
<div id="wrapper">
  <div id="content">
    <?php if($actualizado == 0 and $asignado == 0){ ?>
    <form id="form1" name="form1" method="post" action="">
      <table width="700">
        <caption>
          Datos del Equipo para asignar
        </caption>
        <tr>
          <th width="86">ID</th>
          <th width="117">Equipo</th>
          <th width="161">Tipo</th>
          <th width="87">Estatus</th>
          <th width="105">Condicion</th>
        </tr>
        <tr>
          <td align="center"><input name="id" type="hidden" id="id" value="<?php echo $row_inv['id']; ?>" />
          <?php echo $row_inv['id']; ?></td>
          <td class="strongtext14bw" align="center"><?php echo $row_inv['contenedor']; ?></td>
          <td class="strongtext14bw" align="center"><?php echo $row_inv['tipo']; ?></td>
          <td align="center"><?php echo $row_inv['estatus']; ?></td>
          <td align="center"><?php echo $row_inv['condicion']; ?></td>
        </tr>
        <tr>
          <th>Arribo</th>
          <th>Despacho</th>
          <th>Recepcion</th>
          <th>EIR</th>
          <th>Patio</th>
        </tr>
        <tr>
          <td align="center"><?php echo $row_inv['fdb']; ?></td>
          <td align="center"><?php echo $row_inv['fdm']; ?></td>
          <td align="center"><?php echo $row_inv['frd']; ?></td>
          <td align="center"><?php echo $row_inv['eir_r']; ?></td>
          <td align="center"><?php echo $row_inv['patio']; ?></td>
        </tr>
        <tr>
          <th colspan="2">Despacho</th>
          <th colspan="3">Embarcador / Consignatario</th>
        </tr>
        <tr>
          <td colspan="2" align="center"><input name="date1" type="text" class="DatePicker" id="date1" value="<?php echo $ahora; ?>"/></td>
          <td colspan="3" align="center"><label for="textfield"></label>
            <label for="cliente"></label>
            <select name="cliente" required="required" id="cliente">
              <option value="">Seleccione</option>
              <?php
do {  
?>
              <option value="<?php echo $row_consig['id']?>"><?php echo $row_consig['nombre']?></option>
              <?php
} while ($row_consig = mysql_fetch_assoc($consig));
  $rows = mysql_num_rows($consig);
  if($rows > 0) {
      mysql_data_seek($consig, 0);
	  $row_consig = mysql_fetch_assoc($consig);
  }
?>
          </select></td>
        </tr>
        <tr>
          <th align="center">DIC</th>
          <th align="center">DIY</th>
          <th align="center">EIR Despacho</th>
          <th colspan="2">Booking</th>
        </tr>
        <tr>
          <td align="center"><?php alarmapais($row_inv['DIC']); ?></td>
          <td align="center"><?php alarma($row_inv['DIY']); ?></td>
          <td align="center"><label for="eir_d"></label>
          <input name="eir_d" type="text" required="required" id="eir_d" onkeypress="return permite(event, 'num')" /></td>
          <td align="center" colspan="2"><label for="booking"></label>
          <input name="booking" type="text" required="required" id="booking" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" /></td>
        </tr>
      </table>
      <p>
        <input type="submit" name="button" id="button" value="Asignar" />
      </p>
    </form>
      <?php } else { ?>
    <h2>Equipo Asignado</h2>
    <p><a href="asignacion.php">Asignar otro Equipo</a></p>
    <?php } ?>
    <div id="resultado_consulta"></div>
  </div>
</div>
</body>
</html>