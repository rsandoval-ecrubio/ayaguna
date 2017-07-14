<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php
#Consulta de busqueda de datos
$equipo = $_POST['equipo'];

mysql_select_db($database_conexion,$conexion);

$buscartxt = "SELECT inventario.id, acta_recepcion.idacta, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje AS viaje, consignatario.nombre AS `consignatario`, inventario.contenedor, tequipos.tipo, inventario.eir_r, inventario.bl, IF(inventario.`status`=1,'FULL','EMPTY') AS `status`, inventario.condicion, inventario.precinto, acta_recepcion.factpack, inventario.frd, inventario.patio, inventario.obs 
FROM acta_recepcion, lineas, buques, viajes, inventario, consignatario, tequipos
WHERE contenedor = '$equipo'
AND inventario.acta = acta_recepcion.idacta
AND inventario.linea = lineas.id
AND inventario.buque = buques.id
AND inventario.viaje = viajes.id
AND inventario.tcont = tequipos.id
AND inventario.`consignatario` = consignatario.id
AND inventario.c = 0";
$buscarrun = mysql_query($buscartxt,$conexion) or die(mysql_error()." No se pudo realizar la busqueda");
$resultado = mysql_fetch_assoc($buscarrun);
$resultadototal = mysql_num_rows($buscarrun);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../js/funciones.js" type="text/javascript"></script>
<script src="../js/validaciones.js" type="text/javascript"></script>
</head>
<body>
<div id="content">
      <h2>PASE DE SALIDA</h2>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" name="pase_paso1" class="width450px" id="pase_paso1">
      <fieldset>
        <legend>NUMERO DEL EQUIPO</legend>
        <ul>
        	<li>Equipo
        	  <input name="equipo" type="text" id="equipo" size="14" maxlength="11" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase();" />
        	  <input type="submit" name="button" id="button" value="Buscar" />
        	</li>
        </ul>
      </fieldset>
    </form><?php if($resultadototal > 0){ ?>
    <form action="procesar_pase.php" method="post" name="pase_paso2" class="width750px" id="pase_paso2">
      <fieldset>
        <legend>DATOS DEL PASE DE SALIDA</legend>
        <p class="mayuscula">Nro de Acta: <?php echo $resultado['idacta']; ?> - EIR de Recepcion: <?php echo $resultado['eir_r']; ?> - PRECINTO: <?php echo $resultado['precinto']; ?> - ID: <?php echo $resultado['id']; ?></p>
        <table width="600">
          <tr>
            <th colspan="6"><div align="left">DATOS DEL CONDUCTOR</div></th>
          </tr>
          <tr>
            <td width="8%">Nombre:</td>
            <td colspan="3"><input name="idinv" type="hidden" id="idinv" value="<?php echo $resultado['id']; ?>" />
              <input name="fch_hora" type="hidden" id="fch_hora" value="<?php echo date("Y-m-d H:i:s"); ?>" />
              <input name="nom_ape_chfer" type="text" id="nom_ape_chfer" size="36" onkeypress="return permite(event, 'car')" onkeyup="this.value=this.value.toUpperCase()" onblur="validarInputName(this.id)" /></td>
            <td width="12%"><div align="right">Cedula:</div></td>
            <td width="18%"><input name="cedula" type="text" id="cedula" size="8" maxlength="8" onkeypress="return permite(event, 'num')" onblur="validarCedula(this.id)"  /></td>
          </tr>
          <tr>
            <th colspan="6"><div align="left">DATOS DEL TRANSPORTE</div></th>
          </tr>
          <tr>
            <td>Nombre:</td>
            <td colspan="3"><input name="transporte" type="text" id="transporte" size="36" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" onblur="validarInputName(this.id)" /></td>
            <td><div align="right">Placa:</div></td>
            <td><input name="placa" type="text" id="placa" onblur="validarInputName(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase();" size="8" maxlength="7" /></td>
          </tr>
          <tr>
            <th colspan="6"><div align="left">DATOS GENERALES DEL EQUIPO</div></th>
          </tr>
          <tr>
            <td>Linea</td>
            <td width="25%"><input name="linea" type="text" id="linea" value="<?php echo $resultado['linea']; ?>" size="16" readonly="readonly" /></td>
            <td width="19%">Buque</td>
            <td width="18%"><input name="buque" type="text" id="buque" value="<?php echo $resultado['buque']; ?>" size="16" readonly="readonly" /></td>
            <td>Viaje</td>
            <td><input name="viaje" type="text" id="viaje" value="<?php echo $resultado['viaje']; ?>" size="4" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>Equipo</td>
            <td><input name="contenedor" type="text" id="contenedor" value="<?php echo $resultado['contenedor']; ?>" size="16" maxlength="11" readonly="readonly" /></td>
            <td>Tipo</td>
            <td><input name="tipo" type="text" id="tipo" value="<?php echo $resultado['tipo']; ?>" size="8" readonly="readonly" /></td>
            <td>EIR</td>
            <td><input name="eir" type="text" id="eir" onblur="validaeir(this.id)" onkeypress="return permite(event, 'num')" size="10" maxlength="6"/></td>
          </tr>
          <tr>
            <td>B/L</td>
            <td><input name="bl" type="text" id="bl" value="<?php echo $resultado['bl']; ?>" size="16" readonly="readonly" /></td>
            <td>Status</td>
            <td><input name="estatus" type="text" id="estatus" value="<?php echo $resultado['status']; ?>" size="8" readonly="readonly" /></td>
            <td>Condicion</td>
            <td><input name="condicion" type="text" id="condicion" value="<?php echo $resultado['condicion']; ?>" size="4" maxlength="6" readonly="readonly" /></td>
          </tr>
          <tr>
            <td>Precinto</td>
            <td><input name="precinto" type="text" id="precinto" size="14" onkeypress="return permite(event, 'num_car')" onblur="validaCampo(this.id)" /></td>
            <td>Fact/Exp/Pack-List</td>
            <td><input name="factpack" type="text" id="factpack" value="<?php echo $resultado['factpack']; ?>" size="16" readonly="readonly" /></td>
            <td>Fecha Desp.</td>
            <td><input name="fdespims" type="text" id="fdespims" value="<?php echo $ahora; ?>" size="10" maxlength="10" onblur="validaFecha(this.id)" /></td>
          </tr>
          <tr>
            <td>Ubicacion</td>
            <td><input name="ubicacion" type="text" id="ubicacion" value="<?php echo $resultado['patio']; ?>" size="14" readonly="readonly" /></td>
            <td>Observacion:</td>
            <td colspan="3" rowspan="2" valign="top"><textarea name="obs" id="obs" cols="40" rows="5"><?php echo $resultado['obs']; ?></textarea></td>
          </tr>
          <tr>
            <td colspan="2" valign="middle">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><input name="enviar" type="submit" id="enviar" value="Continuar" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </fieldset>
    </form><?php } ?>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</body>
</html>