<?php
session_start();
require('../config.php');
//Includes
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php
//QUERY PARA EMBALAJES
$qry_emb = "SELECT * FROM embalajes ORDER BY idembalajes ASC";
$exec_emb = mysql_query($qry_emb,$conexion) or die(mysql_error());
$fila_emb = mysql_fetch_assoc($exec_emb);

//MUESTRA INVENTARIO INGRESADO ACTUAL
$acta_actual = $_SESSION['acta'];
$operador = $_SESSION['operador'];
$BL = $_SESSION['BL'];
$qry_inv = "SELECT * FROM inventario_cg WHERE idacta = '$acta_actual' and BL = '$BL' and operador = '$operador' ORDER BY idinventario_cs ASC";
$exec_inv = mysql_query($qry_inv,$conexion) or die(mysql_error());
$fila_inv = mysql_fetch_assoc($exec_inv);
$total_inv = mysql_num_rows($exec_inv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../css/clases.css" rel="stylesheet" type="text/css" />
<link href="../ccs/by_id.css" rel="stylesheet" type="text/css" />
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
<style type="text/css">
<!--
#fill_actas_cg {
	position:absolute;
	left:192px;
	top:121px;
	width:650px;
	height:64px;
	z-index:1;
}
-->
</style>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#fin_acta {
	position:absolute;
	left:36px;
	top:444px;
	width:507px;
	height:86px;
	z-index:2;
}
-->
</style>
</head>
<body>
<div class="info" id="info">
<h2 align="center">Acta de recepción - Carga General </h2>
  <hr />
<fieldset>
<legend>Movimientos - Carga General - Acta de recepción.</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="31%" align="center">Datos de la Carga.</td>
    <td width="69%" align="center">Detalle de la carga ingresada</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>        </tr>
      <tr>        </tr>
      <tr>        </tr>
    </table>
      <form id="form1" name="form1" method="post" action="qry_actas_2.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2">Acta#:<span class="txtImportante"><?php echo $_SESSION['acta']; ?></span></td>
          </tr>
          <tr>
            <td colspan="2">Fact/Exp:<span class="txtImportante"><?php echo strtoupper($_SESSION['fact']."/".$_SESSION['expediente']."/".$_SESSION['packing']); ?></span></td>
          </tr>
          <tr>
            <td colspan="2">Consig:<span class="txtImportante"><?php echo strtoupper($_SESSION['consignatario']); ?></span></td>
          </tr>
          <tr>
            <td colspan="2">B/L:<span class="txtImportante"><?php echo strtoupper($_SESSION['BL']); ?></span></td>
          </tr>
          <tr>
            <td width="36%" valign="middle">Embalaje:              </td>
            <td valign="middle"><select name="embalaje" id="embalaje">
              <option>Seleccione</option>
              <?php do { ?>
              <option value="<?php echo $fila_emb['idembalajes']; ?>"><?php echo htmlentities($fila_emb['descripcion']); ?></option>
              <?php } while($fila_emb = mysql_fetch_assoc($exec_emb)); ?>
            </select></td>
          </tr>
          <tr>
            <td>Estado:</td>
            <td><label>
              <select name="estado" id="estado">
                <option value="OPR">Operativa</option>
                <option value="DMG">Dañada</option>
              </select>
            </label></td>
          </tr>
          <tr>
            <td valign="middle">Cantidad:</td>
            <td valign="middle"><span id="sprytextfield2">
              <label>
                <input name="cantidad" type="text" id="cantidad" value="1" size="6" />
                </label>
              <span class="textfieldRequiredMsg">*</span></span></td>
          </tr>
          <?php if(CGA_X_LOTES == 1) { ?>
          <tr>
            <td valign="top">Lote:</td>
            <td valign="top"><input name="lote" type="text" id="lote" size="15" /></td>
          </tr>
          <?php } else { } ?>
          <tr>
            <td valign="top">Contenido:</td>
            <td valign="top"><label>
              <input name="cont_x_emb" type="text" id="cont_x_emb" size="15" />
            </label></td>
          </tr>
          <tr>
            <td colspan="2">Dimensiones (Mtrs / Kgrs):</td>
          </tr>
          <tr>
            <td>Alto:
              <label>&nbsp;</label></td>
            <td><input name="alto_emb" type="text" id="alto_emb" size="6" />
&nbsp;Mtrs</td>
          </tr>
          <tr>
            <td>Ancho:</td>
            <td><input name="ancho_emb" type="text" id="ancho_emb" size="6" />
              &nbsp;Mtrs</td>
          </tr>
          <tr>
            <td>Largo:</td>
            <td><input name="largo_emb" type="text" id="largo_emb" size="6" />
              &nbsp;Mtrs</td>
          </tr>
          <tr>
            <td>Peso:</td>
            <td><input name="peso" type="text" id="peso" size="6" />
              &nbsp;Kgrs</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center"><label>
              <input type="submit" name="button" id="button" value="Agregar" />
            </label></td>
          </tr>
          <tr>
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center"><a href="cgagral_end.php">Finalizar Acta de Recepción</a></td>
          </tr>
          </table>
      </form></td>
    <td valign="top"><div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Contenido del Acta #<?php echo $_SESSION['acta']; ?></div>
      <div class="CollapsiblePanelContent">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%" align="center">Acta</td>
            <td width="15%" align="center">B/L</td>
            <?php if(CGA_X_LOTES == 1) { ?>
            <td width="17%" align="center">Lote</td>
            <?php } else { } ?>
            <td width="11%" align="center">Embalaje</td>
            <td width="12%" align="center">Cant</td>
            <td width="14%" align="center">Peso</td>
            <td width="9%" align="center">Volumen</td>
            <td width="9%" align="center">M2</td>
            <td width="11%" align="center">M3</td>
          </tr>
		  <?php if($total_inv = 0) { echo "Acta vacia"; } else { ?>
          <?php do { ?>
          <tr>
            <td align="center"><?php echo $fila_inv['idacta']; ?></td>
            <td align="center"><?php echo $fila_inv['BL']; ?></td>
            <?php if(CGA_X_LOTES == 1) { ?>
            <td align="center"><?php echo $fila_inv['lote']; ?></td>
            <?php } else { } ?>
            <td align="center"><?php echo $fila_inv['embalaje']; ?></td>
            <td align="center"><?php echo $fila_inv['cantidad']; ?></td>
            <td align="center"><?php echo number_format($fila_inv['peso'],2,',','.'); ?></td>
            <td align="center"><?php echo $fila_inv['volumen']; ?></td>
            <td align="center"><?php echo $fila_inv['m2']; ?></td>
            <td align="center"><?php echo $fila_inv['m3']; ?></td>
          </tr>
          <?php } while ($fila_inv = mysql_fetch_assoc($exec_inv)) ?>
          <?php } ?>
          <tr>
            <td colspan="9">&nbsp;</td>
            </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    <?php
	if(!isset($_GET['error_insert'])) { } else { echo "Ocurrio un problema al insertar los datos. Verifique e intente nuevamente"; }	?>
    </td>
    </tr>
  </table>
</fieldset>
<hr />
</div>

<script type="text/javascript">
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
