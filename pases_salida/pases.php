<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<?php
//QUERY PARA DESTINO FINAL
$q1 = "SELECT codigo, nombre FROM cod_puertos where activo = '0'";
$e1 = mysql_query($q1,$conexion) or die(mysql_error());
$r1 = mysql_fetch_assoc($e1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
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
<link rel="stylesheet" type="text/css" href="../css/estilo_general.css"/>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<!--ESTO ES DEL OTRO VINCULO PARA PROBAR -->
<script type="text/javascript" src="../select/select_dependientes_3_niveles.js"></script>
<script src="../js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="../js/ui.datepicker.js" type="text/javascript"></script>
<link href="../jquery.ui-1.5.2/themes/ui.datepicker.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<!--////////////fin////////////////////// -->

<style type="text/css">
<!--
#fill_pase {
	position:absolute;
	left:264px;
	top:108px;
	width:616px;
	height:153px;
	z-index:1;
}
-->
</style>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#fin_pase {
	position:absolute;
	left:935px;
	top:55px;
	width:428px;
	height:75px;
	z-index:2;
}

-->
</style>
</head>
<body>
<div class="info" id="info">
  <h2 align="center">Pase de salida - Carga General </h2>
  <hr />
<fieldset>
<form id="form3" name="form3" method="post" action="qry_pases.php">
  <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">DATOS DEL CONDUCTOR</td>
      </tr>
    <tr>
      <td width="22%">Nombre(s) y Apellido(s)</td>
      <td width="47%"><span id="sprytextfield29">
        <label>
          <input name="nom_ape_chfer" type="text" id="nom_ape_chfer" size="45" onkeyup="this.value=this.value.toUpperCase()"/>
        </label>
        <span class="textfieldRequiredMsg">*</span></span></td>
      <td width="7%">Cedula:</td>
      <td width="24%"><span id="sprytextfield31">
      <label>
        <input name="cedula" type="text" id="cedula" onblur="validarCedula(this.id)" onkeypress="return permite(event, 'num')" size="8" maxlength="8" />
      </label>
      <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">DATOS DEL TRANSPORTE</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Transporte:</td>
      <td><span id="sprytextfield32">
        <label>
          <input name="transporte" type="text" id="transporte" size="45" onkeyup="this.value=this.value.toUpperCase()" />
        </label>
        <span class="textfieldRequiredMsg">*</span></span></td>
      <td>Placa:</td>
      <td><span id="sprytextfield33">
        <label>
          <input name="placa" type="text" id="placa" size="8" onkeyup="this.value=this.value.toUpperCase()"/>
        </label>
        <span class="textfieldRequiredMsg">*</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Destino final</td>
      <td><label>
        <select name="destino" id="destino">
        <option>Seleccione un destino</option>
        <?php do { ?>
        <option value="<?php echo $r1['codigo']; ?>"><?php echo $r1['nombre']; ?></option>
        <?php } while ($r1 = mysql_fetch_assoc($e1)); ?>
        </select>
      </label></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">Observaciones:</td>
      <td colspan="3"><label>
        <textarea name="observ" cols="55" rows="5" id="observ"></textarea>
      </label></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button3" id="button3" value="Continuar" />
      </label></td>
    </tr>
  </table>
</form>
</fieldset>
  <hr />
</div>
<script type="text/javascript">
var sprytextfield29 = new Spry.Widget.ValidationTextField("sprytextfield29", "none", {validateOn:["change"]});
var sprytextfield31 = new Spry.Widget.ValidationTextField("sprytextfield31", "integer", {validateOn:["change"], maxChars:8});
var sprytextfield32 = new Spry.Widget.ValidationTextField("sprytextfield32", "none", {validateOn:["change"]});
var sprytextfield33 = new Spry.Widget.ValidationTextField("sprytextfield33", "none", {validateOn:["change"]});
</script>
</body>
</html>
