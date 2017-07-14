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
$query_iata = "SELECT codigo, nombre FROM cod_puertos WHERE activo = 0 ORDER BY codigo ASC";
$iata = mysql_query($query_iata, $conexion) or die(mysql_error());
$row_iata = mysql_fetch_assoc($iata);
$totalRows_iata = mysql_num_rows($iata);

$colname_pre = "-1";
if (isset($_GET['id'])) {
  $colname_pre = $_GET['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_pre = sprintf("SELECT * FROM precarga_move WHERE id = %s", GetSQLValueString($colname_pre, "int"));
$pre = mysql_query($query_pre, $conexion) or die(mysql_error());
$row_pre = mysql_fetch_assoc($pre);
$totalRows_pre = mysql_num_rows($pre);

$colname_move = "-1";
if (isset($_GET['id'])) {
  $colname_move = $_GET['id'];
}
mysql_select_db($database_conexion, $conexion);
$query_move = sprintf("SELECT * FROM precarga WHERE id = %s", GetSQLValueString($colname_move, "int"));
$move = mysql_query($query_move, $conexion) or die(mysql_error());
$row_move = mysql_fetch_assoc($move);
$totalRows_move = mysql_num_rows($move);
$_SESSION['idpre'] = $_GET['id'];
?>
<?php
$lvl_auth = $_SESSION['nivel'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="../js/funciones.js" type="text/javascript"></script>
<script src="../select/select_dependientes_3_niveles.js" type="text/javascript"></script>
<script src="../js/validaciones.js" type="text/javascript"></script>
<script src="verificarEQ.js" type="text/javascript"></script>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <div id="content">
  <h2>Movimientos - Recepción - Acta de recepción - <?php echo $time = date("Y-m-d H:i:s"); ?></h2>
    <form action="procesar_acta_gmv.php" method="post" name="formacta" id="formacta">
      <table width="500">
        <tr>
          <th colspan="6"><div align="left">DATOS DEL CONDUCTOR</div></th>
        </tr>
        <tr>
          <td width="8%">Nombre:</td>
          <td colspan="3"><input name="fch_hora" type="hidden" id="fch_hora" value="<?php echo date("Y-m-d H:i:s"); ?>" />
            <input name="nom_ape_chfer" type="text" id="nom_ape_chfer" size="60" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" onblur="validarInputName(this.id)" /></td>
          <td width="12%"><div align="right">Cedula:</div></td>
          <td width="18%"><input name="cedula" type="text" id="cedula" size="8" maxlength="8" onkeypress="return permite(event, 'num')" onblur="validarCedula(this.id)"  /></td>
        </tr>
        <tr>
          <th colspan="6"><div align="left">DATOS DEL TRANSPORTE</div></th>
        </tr>
        <tr>
          <td>Nombre:</td>
          <td colspan="3"><input name="transporte" type="text" id="transporte" size="60" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" onblur="validarInputName(this.id)" /></td>
          <td><div align="right">Placa:</div></td>
          <td><input name="placa" type="text" id="placa" onblur="validarInputName(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase();" size="8" maxlength="7" /></td>
        </tr>
        <tr>
          <th colspan="6"><div align="left">DATOS GENERALES DEL EQUIPO</div></th>
        </tr>
        <tr>
          <td><div align="right">Origen:</div></td>
          <td width="25%"><input name="origenA" type="text" id="origenA" onblur="validarInputName(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" value="BOLIPUERTO" />
            <label for="origenB"></label>
            <select name="origenB" id="origenB">
              <option value="">Seleccione</option>
              <?php
do {  
?>
              <option value="<?php echo $row_iata['codigo']?>"><?php echo $row_iata['nombre']?></option>
<?php
} while ($row_iata = mysql_fetch_assoc($iata));
  $rows = mysql_num_rows($iata);
  if($rows > 0) {
      mysql_data_seek($iata, 0);
	  $row_iata = mysql_fetch_assoc($iata);
  }
?>
          </select></td>
          <td width="19%"><div align="right">Consignatario:</div></td>
          <td width="18%"><label for="c"></label>
          <input name="c" type="text" id="c" value="G.M.V." size="10" readonly="readonly" />
          <input name="consignatario" type="hidden" id="consignatario" value="134" /></td>
          <td><div align="right">Fecha/Desp. Muelle:</div></td>
          <td><input name="fdm" type="text" id="fdm" size="10" maxlength="10" value="<?php echo date('Y-m-d');?>" onblur="validaFecha(this.id)" /></td>
        </tr>
        <tr>
          <td><div align="right">Linea:</div></td>
          <td><label for="l"></label>
          <input name="l" type="text" id="l" value="<?php echo $row_pre['linea']; ?>" readonly="readonly" />
          <input name="linea" type="hidden" id="linea" value="<?php echo $row_move['linea']; ?>" /></td>
          <td><div align="right">Buque:</div></td>
          <td><label for="s2"></label>
          <input name="s2" type="text" id="s2" value="<?php echo $row_pre['buque']; ?>" readonly="readonly" />
          <input name="select2" type="hidden" id="select2" value="<?php echo $row_move['buque']; ?>" /></td>
          <td><div align="right">Viaje:</div></td>
          <td><label for="s3"></label>
          <input name="s3" type="text" id="s3" value="<?php echo $row_pre['viaje']; ?>" readonly="readonly" />
          <input name="select3" type="hidden" id="select3" value="<?php echo $row_move['viaje']; ?>" /></td>
        </tr>
        <tr>
          <td><div align="right">Equipo:</div></td>
          <td><div>
            <input name="contenedor" type="text" id="contenedor" onmousemove="validarContenedor(this.id,this.value); verificaExistencia(this.id)" value="<?php echo $row_pre['equipo']; ?>" size="12" maxlength="11" readonly="readonly" />
            <input name="validacion" type="text" id="validacion" size="1" readonly="readonly" />
            <div class="errorBig" id="DivDestino"></div>
          </div></td>
          <td><div align="right">EIR:</div></td>
          <td><input name="eir" type="text" id="eir" onblur="validaeir(this.id)" onkeypress="return permite(event, 'num')" size="10" maxlength="6"/></td>
          <td><div align="right">B/L:</div></td>
          <td><input name="bl" type="text" id="bl" onblur="validarBL(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_pre['bl']; ?>" readonly="readonly" /></td>
        </tr>
        <tr>
          <td><div align="right">Tipo:</div></td>
          <td><label for="tc"></label>
          <input name="tc" type="text" id="tc" value="<?php echo $row_pre['tipo']; ?>" readonly="readonly" />
          <input name="tipo_cont" type="hidden" id="tipo_cont" value="<?php echo $row_move['tipo']; ?>" /></td>
          <td><div align="right">Estatus:</div></td>
          <td><label for="esta"></label>
          <input name="esta" type="text" id="esta" value="<?php echo $row_pre['estatus']; ?>" readonly="readonly" />
          <input name="estatus" type="hidden" id="estatus" value="<?php echo $row_move['estatus']; ?>" /></td>
          <td><div align="right">Condicion:</div></td>
          <td><select name="condicion" id="condicion">
            <option value="1">OPR-1</option>
            <option value="2">OPR-2</option>
            <option value="3">OPR-3</option>
            <option value="0">DMG</option>
          </select></td>
        </tr>
        <tr>
          <td>Ubicacion:</td>
          <td><label for="u"></label>
          <input name="u" type="text" id="u" value="G.M.V." />
          <input name="ubicacion" type="hidden" id="ubicacion" value="7" /></td>
          <td><div align="right">Precinto:</div></td>
          <td><input name="precinto" type="text" id="precinto" onblur="validaCampo(this.id)" onkeypress="return permite(event, 'num_car')" value="<?php echo $row_pre['precinto']; ?>" /></td>
          <td><div align="right">Fact/Exp./Packing List:</div></td>
          <td><input type="text" name="fact_pack" id="fact_pack" onkeypress="return permite(event, 'num_car')" onblur="validaCampo(this.id)" /></td>
        </tr>
        <tr>
          <td colspan="2" valign="middle"><div align="center">Lote:</div></td>
          <td colspan="4" valign="top"><label for="lote"></label>
          <textarea name="lote" cols="70" rows="3" readonly="readonly" id="lote"><?php echo $row_move['lote']; ?></textarea></td>
        </tr>
        <tr>
          <td colspan="2" valign="middle">&nbsp;</td>
          <td colspan="4" rowspan="3" valign="top"><textarea name="observ" cols="70" rows="6" id="observ" onkeypress="return permite(event, 'num_car')"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" valign="middle"><div align="center">Observaciones:</div></td>
        </tr>
        <tr>
          <td colspan="2" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6"><input name="enviar" type="submit" id="enviar" value="Continuar" />
            &nbsp;
            <script type="text/javascript">
			var ejemplo = new Date();
			document.write('fecha ' + fecha); 
            </script>
            &nbsp;</td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($iata);

mysql_free_result($pre);

mysql_free_result($move);
?>
