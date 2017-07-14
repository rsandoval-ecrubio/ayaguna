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

mysql_select_db($database_conexion, $conexion);
$query_lineas = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$lineas = mysql_query($query_lineas, $conexion) or die(mysql_error());
$row_lineas = mysql_fetch_assoc($lineas);
$totalRows_lineas = mysql_num_rows($lineas);
?>
<?php
//Consulta procedimiento
if(isset($_POST['linea']) and !is_null($_POST['linea'])){
	$linea = (int) $_POST['linea'];
	mysqli_select_db($conexion_li,$database_conexion);
	#Consulta Asignacion
	$consulta = mysqli_query($conexion_li,"CALL `consulta_asignacion`('$linea')")or die(mysqli_error());
	$resultado = mysqli_fetch_assoc($consulta);
	$total = mysqli_num_rows($consulta);
	mysqli_close($conexion_li);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
</head>
<body>
<label for="linea"></label>
<div id="wrapper">
  <div id="content">
    <div id="modulo_title">
      <h2>ASIGNACION -&nbsp;para export</h2>
    </div>
    <form id="form1" name="form1" method="post" action="">
      <label for="linea">Linea:
        <select name="linea" id="linea">
          <option value="">Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $row_lineas['id']?>"><?php echo $row_lineas['nombre']?></option>
          <?php
} while ($row_lineas = mysql_fetch_assoc($lineas));
  $rows = mysql_num_rows($lineas);
  if($rows > 0) {
      mysql_data_seek($lineas, 0);
	  $row_lineas = mysql_fetch_assoc($lineas);
  }
?>
        </select>
      </label>
      <input type="submit" name="button" id="button" value="Enviar" />
    </form>
    <br />
    <?php if($total > 0){ ?>
    <div id="resultado_consulta">
      <form id="list_asig" name="list_asig" method="post" action="asignacion_paso2.php">
        <p class="msgRojo">Solo debera seleccionar un equipo para realizar la asignación de exportación</p><table width="600" id="pf_sortableTable1">
          <caption>
            Listado de Equipos | Linea: <?php echo $resultado['linea']; ?>
         &nbsp; 
         <input type="submit" name="button2" id="button2" value="Asignar" />
          </caption>
          <tr>
            <th axis="string">Sel</th>
            <th axis="string">Equipo</th>
            <th axis="string">Tipo</th>
            <th axis="string">Estatus</th>
            <th axis="string">Condicion</th>
            <th axis="date">Recepcion</th>
            <th axis="number">EIR</th>
            <th axis="number">DIC</th>
            <th axis="number">DIY</th>
          </tr><?php do { ?>
          <tr>
            <td><input name="id" type="checkbox" id="id" value="<?php echo $resultado['id']; ?>" />
            <label for="id"></label></td>
            <td><?php echo $resultado['contenedor']; ?></td>
            <td><?php echo $resultado['tipo']; ?></td>
            <td><?php echo $resultado['estatus']; ?></td>
            <td><?php echo $resultado['condicion']; ?></td>
            <td><?php echo $resultado['recepcion']; ?></td>
            <td><?php echo $resultado['eir']; ?></td>
            <td><?php alarmapais($resultado['DIC']); ?></td>
            <td><?php alarma($resultado['DIY']); ?></td>
          </tr><?php } while($resultado = mysqli_fetch_assoc($consulta));?>
        </table>
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
    <p>
      <?php } ?>
    </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($lineas);
?>
