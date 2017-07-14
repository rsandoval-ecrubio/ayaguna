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
$query_tipo = "SELECT id, tipo FROM tequipos ORDER BY tipo ASC";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error()."1");
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

mysql_select_db($database_conexion, $conexion);
$query_consig = "SELECT id, nombre FROM consignatario ORDER BY nombre ASC";
$consig = mysql_query($query_consig, $conexion) or die(mysql_error()."2");
$row_consig = mysql_fetch_assoc($consig);
$totalRows_consig = mysql_num_rows($consig);

mysql_select_db($database_conexion, $conexion);
$query_linea = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error()."3");
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

mysql_select_db($database_conexion, $conexion);
$query_iata = "SELECT codigo, nombre FROM cod_puertos WHERE activo = 0 ORDER BY codigo ASC";
$iata = mysql_query($query_iata, $conexion) or die(mysql_error()."4");
$row_iata = mysql_fetch_assoc($iata);
$totalRows_iata = mysql_num_rows($iata);

mysql_select_db($database_conexion, $conexion);
$query_patio = "SELECT * FROM patios ORDER BY patio ASC";
$patio = mysql_query($query_patio, $conexion) or die(mysql_error()."5");
$row_patio = mysql_fetch_assoc($patio);
$totalRows_patio = mysql_num_rows($patio);

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
    <form action="procesar_acta.php" method="post" name="formacta" id="formacta">
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
          <td colspan="6">Fecha de Recepcion: 
            <label for="frd"></label>
          <input name="frd" type="text" id="frd" value="<?php echo date("Y-m-d"); ?>" size="10" /> 
          <span class="error">*</span> <span class="txtImportante">Solo edite esta fecha si la recepcion no se hace el dia de hoy</span></td>
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
          <td width="18%"><select name="consignatario" id="consignatario" onblur="validaMenu(this.id)" >
            <option value="0">Seleccion</option>
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
          <td><div align="right">Fecha/Desp. Muelle:</div></td>
          <td><input name="fdm" type="text" id="fdm" size="10" maxlength="10" value="<?php echo date('Y-m-d');?>" onblur="validaFecha(this.id)" /></td>
        </tr>
        <tr>
          <td><div align="right">Linea:</div></td>
          <td><select name="linea" id="linea" onchange="cargaContenido(this.id)" onblur="validaMenu(this.id)" >
            <option value="-1">Select</option>
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
          </select></td>
          <td><div align="right">Buque:</div></td>
          <td><select name="select2" disabled="disabled" id="select2" onblur="validaMenu(this.id)" >
            <option value="-1">Select</option>
          </select></td>
          <td><div align="right">Viaje:</div></td>
          <td><select name="select3" id="select3" disabled="disabled" onblur="validaMenu(this.id)" >
            <option value="-1">Select</option>
          </select></td>
        </tr>
        <tr>
          <td><div align="right">Equipo:</div></td>
          <td><div>
            <input name="contenedor" type="text" id="contenedor" onblur="validarContenedor(this.id,this.value); verificaExistencia(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase(); compUsuario(event);" size="12" maxlength="11" />
            <input name="validacion" type="text" id="validacion" size="1" readonly="readonly" />
            <div class="errorBig" id="DivDestino"></div>
          </div></td>
          <td><div align="right">EIR:</div></td>
          <td><input name="eir" type="text" id="eir" onblur="validaeir(this.id)" onkeypress="return permite(event, 'num')" size="10" maxlength="6"/></td>
          <td><div align="right">B/L:</div></td>
          <td><input type="text" name="bl" id="bl" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" onblur="validarBL(this.id)" /></td>
        </tr>
        <tr>
          <td><div align="right">Tipo:</div></td>
          <td><select name="tipo_cont" id="tipo_cont" onblur="validaMenu(this.id)" >
            <option value="0">Seleccione el tipo </option>
            <?php
do {  
?>
            <option value="<?php echo $row_tipo['id']?>"><?php echo $row_tipo['tipo']?></option>
            <?php
} while ($row_tipo = mysql_fetch_assoc($tipo));
  $rows = mysql_num_rows($tipo);
  if($rows > 0) {
      mysql_data_seek($tipo, 0);
	  $row_tipo = mysql_fetch_assoc($tipo);
  }
?>
          </select></td>
          <td><div align="right">Estatus:</div></td>
          <td><select name="estatus" id="estatus">
            <option value="1">FULL</option>
            <option value="0">EMPTY</option>
          </select></td>
          <td><div align="right">Condicion:</div></td>
          <td><select name="condicion" id="condicion">
            <option value="1">OPR-1</option>
            <option value="2">OPR-2</option>
            <option value="3">OPR-3</option>
            <option value="4">N-OPR</option>
            <option value="0">DMG</option>
          </select></td>
        </tr>
        <tr>
          <td>Ubicacion:</td>
          <td><select name="ubicacion" id="ubicacion">
            <option value="">Seleccione</option>
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
          <td><div align="right">Precinto:</div></td>
          <td><input type="text" name="precinto" id="precinto" onkeypress="return permite(event, 'num_car')" onblur="validaCampo(this.id)" /></td>
          <td><div align="right">Fact/Exp./Packing List:</div></td>
          <td><input type="text" name="fact_pack" id="fact_pack" onkeypress="return permite(event, 'num_car')" onblur="validaCampo(this.id)" /></td>
        </tr>
        <tr>
          <td colspan="2" valign="middle"><div align="center">Observaciones:</div></td>
          <td colspan="4" valign="top"><textarea name="observ" cols="70" rows="6" id="observ" onkeypress="return permite(event, 'num_car')"></textarea></td>
        </tr>
        <tr>
          <td colspan="6"><input name="enviar" type="submit" disabled="disabled" id="enviar" value="Continuar" />
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
mysql_free_result($tipo);

mysql_free_result($consig);

mysql_free_result($linea);

mysql_free_result($iata);

mysql_free_result($patio);
?>
