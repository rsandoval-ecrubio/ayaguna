<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
//include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');

$database_conexion = "appstc_ayaguna_jmp";
$username_conexion = "appstc";
$password_conexion = "nVgXi3HT40";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conexion,$conexion);

$renglones = "SELECT * FROM fact_renglones";
$ejecutar = mysql_query($renglones,$conexion) or die(mysql_error());
$filareng = mysql_fetch_assoc($ejecutar);

?>
<?php
function generaArticulos()
{
	$hostname_conexion = "localhost";
	$database_conexion = "appstc_ayaguna_jmp";
$username_conexion = "appstc";
$password_conexion = "nVgXi3HT40";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conexion,$conexion);
	$consulta=mysql_query("SELECT id, articulo FROM fact_renglones");


	// Voy imprimiendo el primer select compuesto por los paises
	echo "<select name='articulo' id='articulo' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}
	echo "</select>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../js/validaciones.js" type="text/javascript"></script>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="select_dependientes.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<!--////////////fin////////////////////// -->
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.info {
	width: 900px;
	padding: 4px;
}
#info {
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	margin-top: 0px;
}
#index {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
#index tr td {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="info" id="info">
  <hr />
<fieldset>
<legend align="center">FACTURA #<?php echo $_SESSION['correlativo']; ?></legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" valign="top">RIF:<?php echo $_SESSION['rifcliente']; ?></td>
    </tr>
  <tr>
    <td colspan="2">RAZON SOCIAL:<?php echo $_SESSION['nombre_rsocial']; ?></td>
    </tr>
  <tr>
    <td colspan="2">DIRECCION:<?php echo $_SESSION['direccion']; ?></td>
    </tr>
  <tr>
    <td colspan="2">TELEFONOS:<?php echo $_SESSION['telefono1']." / ".$_SESSION['telefono2']; ?></td>
    </tr>
  <tr>
    <td width="12%">&nbsp;</td>
    <td width="88%">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><form id="form1" name="form1" method="post" action="qry_facturar2.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="7%" align="center"><strong>CANT</strong></td>
          <td width="55%" align="center"><strong>ARTICULO</strong></td>
          <td width="9%" align="center"><strong>PRECIO</strong></td>
          <td width="21%" align="center"><strong>CONTENEDOR</strong></td>
          <td width="8%" align="center"><strong>AGREGAR</strong></td>
        </tr>
        <tr>
          <td align="center"><label for="cant"></label>
            <span id="sprytextfield1">
            <input name="cant" type="text" id="cant" size="2" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
          <td><?php generaArticulos(); ?></td>
          <td><select disabled="disabled" name="estados" id="estados">
            <option value="0">Precio</option>
          </select></td>
          <td align="center"><div>
            <input name="contenedor" type="text" id="contenedor" onblur="validarContenedor(this.id,this.value); verificaExistencia(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase(); compUsuario(event);" size="12" maxlength="11" />
            <input name="validacion" type="text" id="validacion" size="1" readonly="readonly" />
            <div class="errorBig" id="DivDestino"></div>
          </div></td>
          <td align="center"><input type="submit" name="button" id="button" value="Enviar" /></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><table width="60%" border="0" cellspacing="0" cellpadding="0">
    <?php
	$valor = $_SESSION['correlativo'];
    $buscart = "SELECT fact_facturas.cant, fact_renglones.articulo, fact_facturas.punitario, fact_facturas.ttl_item,  fact_facturas.contenedor FROM fact_facturas, fact_renglones where fact_facturas.correlativo = '$valor' and fact_renglones.id = fact_facturas.articulo";
	$buscar = mysql_query($buscart, $conexion) or die(mysql_error());
	$fila = mysql_fetch_assoc($buscar);
    
    ?>
      <tr>
        <td colspan="5">ARTICULOS A FACTURAR</td>
        </tr>
      <tr>
        <td width="5%">CANT</td>
        <td width="46%">ARTICULO</td>
        <td width="14%">P. UNITARIO</td>
        <td width="14%" align="center">P. TOTAL</td>
        <td width="21%">CONTENEDOR</td>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $fila['cant']; ?></td>
        <td><?php echo $fila['articulo']; ?></td>
        <td><?php echo $fila['punitario']; ?></td>
        <td><?php echo $fila['ttl_item']; ?></td>
        <td><?php echo $fila['contenedor']; ?></td>
      </tr>
      <?php } while ($fila = mysql_fetch_assoc($buscar)); ?>
    </table></td>
    </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><a href="facturar3.php" class="botones">CONTINUAR</a></td>
  </tr>
</table>
</fieldset>
<hr />
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
</script>
</body>
</html>