<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<?php
//CONSULTA PARA TIPO CONTENDOR
$qry_cont = "SELECT * from tipo_cont ORDER BY idtipo_cont ASC";
$exec_cont = mysql_query($qry_cont,$conexion) or die(mysql_error());
$fila_t_cont = mysql_fetch_assoc($exec_cont);

//CONSULTA CONSIGNATARIO
$qry_consig = "SELECT * from consignatario ORDER BY id ASC";
$exe_consig = mysql_query($qry_consig,$conexion) or die(mysql_error());
$fila_consig = mysql_fetch_assoc($exe_consig);

////////prueba de codigo de implementacion
$qry_linea = "select * from lineas order by nombre asc";
$exe_linea = mysql_query($qry_linea,$conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($exe_linea);

$lvl_auth = $_SESSION['nivel'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link rel="stylesheet" type="text/css" href="../css/estilo_general.css"/>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<!--ESTO ES DEL OTRO VINCULO PARA PROBAR -->
<script type="text/javascript" src="../select/select_dependientes_3_niveles.js"></script>
<script src="../js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="../js/ui.datepicker.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
<!--
#act_rec {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:225px;
	z-index:1;
	background-color: #FFFFFF;
}
#act_rec_cg {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:225px;
	z-index:1;
	background-color: #FFFFFF;
	
}
-->
</style>

</head>

<body>
<div class="info" id="info">
  <h2 align="center">Acta de recepción - Carga General </h2>
  <hr />
  <form id="form1" name="form1" method="post" action="qry_actas.php">
    <table width="80%" border="0" cellspacing="1" cellpadding="0" align="center">
    <tr>
      <td colspan="4">DATOS DEL CONDUCTOR
        <input name="fch_hora" type="hidden" id="fch_hora" value="<?php date("Y-m-d H:i:s"); ?>" /></td>
    </tr>
    <tr>
      <td valign="middle">Nombre(s) y apellido(s):<span id="sprytextfield19">
        <label>
          <input name="nom_ape_chfer" type="text" id="nom_ape_chfer" size="40" onkeyup="this.value=this.value.toUpperCase()" />
        </label>
        <span class="textfieldRequiredMsg">*</span></span></td>
      <td width="5%">C. I:</td>
      <td width="21%"><span id="sprytextfield20">
      <label>
        <input name="cedula" type="text" id="cedula" onblur="validarCedula(this.id)" onkeypress="return permite(event, 'num')" size="8" maxlength="8" />
      </label>
      <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span><span class="textfieldMaxCharsMsg">*</span></span></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="4">DATOS DEL TRANSPORTE</td>
    </tr>
    <tr>
      <td valign="middle">Transporte:<span id="sprytextfield21">
        <label>
          <input name="transporte" type="text" id="transporte" size="50" onkeyup="this.value=this.value.toUpperCase()" />
        </label>
        <span class="textfieldRequiredMsg">*</span></span></td>
      <td>Placa:</td>
      <td><span id="sprytextfield22">
        <label>
          <input type="text" name="placa" id="placa" onkeyup="this.value=this.value.toUpperCase()" />
        </label>
        <span class="textfieldRequiredMsg">*</span></span></td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">DATOS GENERALES DE LA CARGA</td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="12%">Consignatario:</td>
          <td colspan="5"><label>
            <select name="consignatario" id="consignatario">
              <option>Seleccione</option>
              <?php do { ?>
              <option value="<?php echo $fila_consig['id']; ?>"><?php echo $fila_consig['nombre']; ?></option>
              <?php } while($fila_consig = mysql_fetch_assoc($exe_consig)); ?>
            </select>
          </label></td>
          </tr>
        <tr>
          <td>Origen:</td>
          <td width="25%"><span id="sprytextfield24">
            <label>
              <input type="text" name="origen" id="origen" onkeyup="this.value=this.value.toUpperCase()" />
              </label>
            <span class="textfieldRequiredMsg">*</span></span></td>
          <td width="7%">Linea:</td>
          <td width="24%"><label>
            <select name="linea" id="linea" onchange="cargaContenido(this.id)">
              <option>Seleccione la Linea</option>
              <?php do { ?>
              <option value="<?php echo $row_linea['id']; ?>"><?php echo $row_linea['nombre']; ?></option>
              <?php } while($row_linea = mysql_fetch_assoc($exe_linea)); ?>
            </select>
          </label></td>
          <td width="7%">Buque:</td>
          <td width="25%"><label><select disabled="disabled" name="select2" id="select2" onchange="cargaContenido(this.id)"><option value="0">Selecciona opci&oacute;n...</option></select></label></td>
          </tr>
        <tr>
          <td>Viaje:</td>
          <td><label><select disabled="disabled" name="select3" id="select3" onchange="cargaContenido(this.id)"><option value="0">Selecciona opci&oacute;n...</option></select></label></td>
          <td>B/L</td>
          <td><span id="sprytextfield28">
            <label>
              <input type="text" name="BL" id="BL" onkeyup="this.value=this.value.toUpperCase()"/>
            </label>
            <span class="textfieldRequiredMsg">*</span></span></td>
          <td>&nbsp;</td>
          <td></td>
          </tr>
        <tr>
          <td colspan="6" valign="middle">Fact:<span id="sprytextfield30">
            <label>
              <input type="text" name="fact" id="fact" />
              </label>
            <span class="textfieldRequiredMsg">*</span></span>Expediente:<span id="sprytextfield1">
            <label for="expediente"></label>
            <input type="text" name="expediente" id="expediente" />
</span>Packing List: <span id="sprytextfield2">
            <label for="paking"></label>
            <input type="text" name="paking" id="paking" />
</span></td>
          </tr>
        <tr>
          <td valign="top">Observaciones:</td>
          <td colspan="5"><textarea name="observ" cols="70" rows="6" id="observ"></textarea></td>
        </tr>
        <tr>
          <td colspan="6">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="4" align="right"><label>
        <input type="submit" name="button2" id="button2" value="Continuar" />
      </label></td>
    </tr>
  </table>
  </form>
  <hr />
</div>
<script type="text/javascript">
var sprytextfield19 = new Spry.Widget.ValidationTextField("sprytextfield19", "none", {validateOn:["change"]});
var sprytextfield20 = new Spry.Widget.ValidationTextField("sprytextfield20", "integer", {validateOn:["change"], maxChars:8});
var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21", "none", {validateOn:["change"]});
var sprytextfield22 = new Spry.Widget.ValidationTextField("sprytextfield22", "none", {validateOn:["change"]});
var sprytextfield24 = new Spry.Widget.ValidationTextField("sprytextfield24", "none", {validateOn:["change"]});
var sprytextfield28 = new Spry.Widget.ValidationTextField("sprytextfield28", "none", {validateOn:["change"]});
var sprytextfield30 = new Spry.Widget.ValidationTextField("sprytextfield30", "none", {validateOn:["change"], isRequired:false});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {isRequired:false});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {isRequired:false});
</script>
</body>
</html>