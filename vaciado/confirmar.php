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

$colname_nacta = "-1";
if (isset($_POST['id'])) {
  $colname_nacta = $_POST['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_nacta = sprintf("SELECT acta FROM inventario WHERE id = %s", GetSQLValueString($colname_nacta, "int"));
$nacta = mysql_query($query_nacta, $conexion) or die(mysql_error()."<h1>Error:</h1><p>Consultar numero de acta</p>");
$row_nacta = mysql_fetch_assoc($nacta);
$totalRows_nacta = mysql_num_rows($nacta);

//acta
$acta = $row_nacta['acta'];
//Mostrar acta

$query_acta = "SELECT * FROM acta_recepcion WHERE idacta = $acta";
$acta = mysql_query($query_acta, $conexion) or die(mysql_error()."<h1>Error:</h1><p>Consultar registro del acta</p>");
$row_acta = mysql_fetch_assoc($acta);
$totalRows_acta = mysql_num_rows($acta);


$colname_equip = "-1";
if (isset($_POST['id'])) {
  $colname_equip = $_POST['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_equip = sprintf("SELECT id, acta, nlinea, idconsignatario, consignatario, contenedor, tipo, status, condicion, buque, viaje, fdb, bl, precinto, eir_r, patio, obs FROM existencia WHERE id = %s", GetSQLValueString($colname_equip, "int"));
$equip = mysql_query($query_equip, $conexion) or die(mysql_error()."<h1>Error:</h1><p>Consultar registro del contenedor</p>");
$row_equip = mysql_fetch_assoc($equip);
$totalRows_equip = mysql_num_rows($equip);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="instancia_cg.php">
  <table width="700" id="acta">
    <caption>
      Fecha del Acta: <?php echo $row_acta['fch_hora']; ?>
   &nbsp; | Reg-Equip: <?php echo $row_equip['id'];?>
    <input name="id" type="hidden" id="id" value="<?php echo $row_equip['id'];?>" />
    <input name="acta" type="hidden" id="acta" value="<?php echo $row_equip['acta'];?>" />
    | Acta # <?php echo $row_equip['acta'];?>
    </caption>
    <tr>
      <th colspan="6"><div align="left">DATOS DEL CONDUCTOR</div></th>
    </tr>
    <tr>
      <td width="8%">Nombre:</td>
      <td colspan="3"><label for="nombre"></label>
      <input name="nombre" type="text" id="nombre" value="<?php echo $row_acta['nom_ape_chfer']; ?>" size="50" readonly="readonly" /></td>
      <td width="12%"><div align="right">Cedula:</div></td>
      <td width="18%"><label for="cedula"></label>
      <input name="cedula" type="text" id="cedula" value="<?php echo $row_acta['cedula']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <th colspan="6"><div align="left">DATOS DEL TRANSPORTE</div></th>
    </tr>
    <tr>
      <td>Nombre:</td>
      <td colspan="3"><label for="transporte"></label>
      <input name="transporte" type="text" id="transporte" value="<?php echo $row_acta['transporte']; ?>" size="50" readonly="readonly" /></td>
      <td><div align="right">Placa:</div></td>
      <td><label for="placa"></label>
      <input name="placa" type="text" id="placa" value="<?php echo $row_acta['placa']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <th colspan="6"><div align="left">DATOS GENERALES DEL EQUIPO</div></th>
    </tr>
    <tr>
      <td><div align="right">Origen:</div></td>
      <td width="25%"><label for="origen"></label>
      <input name="origen" type="text" id="origen" value="<?php echo $row_acta['origen']; ?>" readonly="readonly" /></td>
      <td width="19%"><div align="right">Consignatario:</div></td>
      <td width="18%"><label for="consignatario"></label>
      <input name="consignatario" type="text" id="consignatario" value="<?php echo $row_equip['consignatario']; ?>" readonly="readonly" /></td>
      <td><div align="right">Fecha/Desp. Muelle:</div></td>
      <td><label for="fdb"></label>
      <input name="fdb" type="text" id="fdb" value="<?php echo $row_equip['fdb']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><div align="right">Linea:</div></td>
      <td><label for="linea"></label>
      <input name="linea" type="text" id="linea" value="<?php echo $row_equip['nlinea']; ?>" readonly="readonly" /></td>
      <td><div align="right">Buque:</div></td>
      <td><label for="buque"></label>
      <input name="buque" type="text" id="buque" value="<?php echo $row_equip['buque']; ?>" readonly="readonly" /></td>
      <td><div align="right">Viaje:</div></td>
      <td><label for="viaje"></label>
      <input name="viaje" type="text" id="viaje" value="<?php echo $row_equip['viaje']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><div align="right">Equipo:</div></td>
      <td><label for="equipo"></label>
      <input name="equipo" type="text" id="equipo" value="<?php echo $row_equip['contenedor']; ?>" readonly="readonly" /></td>
      <td><div align="right">EIR:</div></td>
      <td><label for="eir"></label>
      <input name="eir" type="text" id="eir" value="<?php echo $row_equip['eir_r']; ?>" readonly="readonly" /></td>
      <td><div align="right">B/L:</div></td>
      <td><label for="bl"></label>
      <input name="bl" type="text" id="bl" value="<?php echo $row_equip['bl']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><div align="right">Tipo:</div></td>
      <td><label for="tipo"></label>
      <input name="tipo" type="text" id="tipo" value="<?php echo $row_equip['tipo']; ?>" readonly="readonly" /></td>
      <td><div align="right">Estatus:</div></td>
      <td><label for="estatus"></label>
      <input name="estatus" type="text" id="estatus" value="<?php estatus($row_equip['status']); ?>" readonly="readonly" /></td>
      <td><div align="right">Condicion:</div></td>
      <td><label for="condicion"></label>
      <input name="condicion" type="text" id="condicion" value="<?php condicion($row_equip['condicion']); ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Ubicacion:</td>
      <td><label for="ubicacion"></label>
      <input name="ubicacion" type="text" id="ubicacion" value="<?php echo $row_equip['patio']; ?>" readonly="readonly" /></td>
      <td><div align="right">Precinto:</div></td>
      <td><label for="precinto"></label>
      <input name="precinto" type="text" id="precinto" value="<?php echo $row_equip['precinto']; ?>" readonly="readonly" /></td>
      <td><div align="right">Fact/Exp./Packing List:</div></td>
      <td><label for="fact"></label>
      <input name="fact" type="text" id="fact" value="<?php echo $row_acta['factpack']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td colspan="2" valign="middle"><div align="center">Observaciones:</div></td>
      <td colspan="4" valign="top"><label for="obs"></label>
      <textarea name="obs" cols="60" rows="5" readonly="readonly" id="obs"><?php echo $row_equip['obs']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="6"><input name="enviar" type="submit" id="enviar" value="Vaciar" /></td>
    </tr>
    <tr>
      <td colspan="6" class="txtImportante">Los datos generales del equipo se van a modificar</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($nacta);

mysql_free_result($acta);

mysql_free_result($equip);
?>
