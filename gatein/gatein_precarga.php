<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php require_once('../Connections/conexion.php'); ?>
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

$colname_pretoinv = "-1";
if (isset($_GET['id'])) {
  $colname_pretoinv = $_GET['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_pretoinv = sprintf("SELECT * FROM precarga_lista WHERE id = %s", GetSQLValueString($colname_pretoinv, "int"));
$pretoinv = mysql_query($query_pretoinv, $conexion) or die(mysql_error());
$row_pretoinv = mysql_fetch_assoc($pretoinv);
$totalRows_pretoinv = mysql_num_rows($pretoinv);

mysql_select_db($database_conexion, $conexion);
$query_patio = "SELECT * FROM patios ORDER BY patio ASC";
$patio = mysql_query($query_patio, $conexion) or die(mysql_error());
$row_patio = mysql_fetch_assoc($patio);
$totalRows_patio = mysql_num_rows($patio);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<script src="../js/funciones.js" type="text/javascript"></script>
<script src="../select/select_dependientes_3_niveles.js" type="text/javascript"></script>
<script src="../js/validaciones.js" type="text/javascript"></script>
<script src="verificarEQ.js" type="text/javascript"></script>
<script type="text/javascript">

function FdmFrd(){
	
	var fdm = gatein.fdm.value;
	var fdmano = fdm.substring(0,4);
	var fdmmes = fdm.substring(5,7) - 1;
	var fdmdia = fdm.substring(8,10);
	var fechafdm = new Date(fdmano, fdmmes,fdmdia);
	
	var frd = gatein.frd.value;
	var frdano = frd.substring(0,4);
	var frdmes = frd.substring(5,7) - 1;
	var frddia = frd.substring(8,10);
	var fechafrd = new Date(frdano, frdmes, frddia);
	
	if(fdm > frd){
		gatein.fdm.focus();
		alert("La fecha de recepcion no puede ser menor a la del despacho");
	}
}
</script>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="content">
    <div id="modulo_title">
      <h2>MOVIMIENTO DE ENTRADA</h2>
    </div>
    <form action="procesar_gatein_precarga.php" method="post" id="gatein">
      <table width="620">
        <tr>
          <th colspan="6"><div align="left">DATOS GENERALES DEL INGRESO</div></th>
        </tr>
        <tr>
          <td><div align="right">EIR:</div></td>
          <td><input name="eir" type="text" class="txtImportante" id="eir" onblur="validaeir(this.id)" onkeypress="return permite(event, 'num')" size="8" maxlength="6"/>
          <input name="id" type="hidden" id="id" value="<?php echo $row_pretoinv['id']; ?>" /></td>
          <td><div align="right">Factura</div></td>
          <td><label for="fact"></label>
          <input name="fact" type="text" id="fact" size="12" /></td>
          <td><div align="right">Pase</div></td>
          <td><label for="paset"></label>
          <input name="paset" type="text" id="paset" size="12" /></td>
        </tr>
        <tr>
          <td><div align="right">Linea:</div></td>
          <td class="txt14bold"><?php echo $row_pretoinv['linea']; ?></td>
          <td><div align="right">Buque:</div></td>
          <td class="txt14bold"><?php echo $row_pretoinv['buque']; ?></td>
          <td><div align="right">Viaje:</div></td>
          <td class="txt14bold"><?php echo $row_pretoinv['viaje']; ?></td>
        </tr>
        <tr>
          <td><div align="right">Equipo:</div></td>
          <td class="txt14bold"><?php echo $row_pretoinv['equipo']; ?></td>
          <td><div align="right">Tipo:</div></td>
          <td class="txt14bold"><?php echo $row_pretoinv['tipo']; ?></td>
          <td><div align="right">Estatus:</div></td>
          <td><select name="estatus" id="estatus">
            <option value="1">FULL</option>
            <option value="0" selected="selected">EMPTY</option>
          </select></td>
        </tr>
        <tr>
          <td><div align="right">F. Muelle:</div></td>
          <td><input name="fdm" type="text" id="fdm" onblur="validaFecha(this.id)" value="<?php echo date('Y-m-d');?>" size="10" maxlength="10" /></td>
          <td><div align="right">F. Recep.:</div></td>
          <td><input name="frd" type="text" id="frd" onblur="validaFecha(this.id); FdmFrd()" value="<?php echo date('Y-m-d');?>" size="10" maxlength="10" /></td>
          <td><div align="right">Condicion:</div></td>
          <td><select name="condicion" id="condicion">
            <option value="1" selected="selected">OPR-1</option>
            <option value="2">OPR-2</option>
            <option value="3">OPR-3</option>
            <option value="4">N-OPR</option>
            <option value="0">DMG</option>
</select></td>
        </tr>
        <tr>
          <td><div align="right">Consignatario:</div></td>
          <td colspan="3" class="txt14bold"><?php echo $row_pretoinv['consig']; ?></td>
          <td><div align="right">B/L:</div></td>
          <td class="txt14bold"><?php echo $row_pretoinv['bl']; ?></td>
        </tr>
        <tr>
          <td><div align="right">Ubicacion:</div></td>
          <td><select name="ubicacion" id="ubicacion">
            <option value="">Seleccion</option>
            <?php
do {  
?>
            <option value="<?php echo $row_patio['id']?>"><?php echo $row_patio['patio']?></option>
            <?php
} while ($row_patio = mysql_fetch_assoc($patio));
  $rows = mysql_num_rows($patio);
  if($rows > 0) {
      mysql_data_seek($patio, 0);
	  $row_patio = mysql_fetch_assoc($patio);
  }
?>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="right">Precinto:</div></td>
          <td><input name="precinto" type="text" id="precinto" value="<?php echo $row_pretoinv['precinto']; ?>" size="12" /></td>
        </tr>
        <tr>
          <td><div align="right">Observaciones</div></td>
          <td colspan="5"><textarea name="obs" id="obs" cols="40" rows="3"></textarea></td>
        </tr>
        <tr>
          <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6"><input name="enviar" type="submit" id="enviar" value="Continuar" />            
		  <script type="text/javascript">
			var ejemplo = new Date();
			document.write('fecha ' + fecha); 
            </script>
          &nbsp;</td>
        </tr>
      </table>
    </form>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($pretoinv);

mysql_free_result($patio);
?>
