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
?>
<?php
//QUERYS NECESARIOS PARA PASE DE SALIDA
if(!isset($_POST['BL'])) { } else {
	$_SESSION['bl_actual'] = $_POST['BL'];
	$BL_pase = $_SESSION['bl_actual'];
		$qry_inventario = "SELECT * from inventario_cg WHERE BL = '$BL_pase' and in_out ='0'";
		$exec_inventario = mysql_query($qry_inventario, $conexion) or die(mysql_error());
		$fila_inventario = mysql_fetch_assoc($exec_inventario);
		$_SESSION['acta_pase'] = $fila_inventario['idacta'];
}
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
	left:192px;
	top:121px;
	width:616px;
	height:153px;
	z-index:1;
}
-->
</style>
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="info" id="info">
  <h2 align="center">Pase de salida - Carga General </h2>
  <hr />
<fieldset>
<legend>Movimientos - Carga general - Pase de salida</legend>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>CONTENIDO DEL PASE DE SALIDA</td>
  </tr>
  <tr>
    <td>Transporte:<strong><?php echo strtoupper($_SESSION['transp']); ?></strong>&nbsp;&nbsp;&nbsp;Placa:<strong><?php echo strtoupper($_SESSION['placa']); ?></strong></td>
    </tr>
  <tr>
    <td>Nombre(s) y Apellido(s) del conductor:<strong><?php echo strtoupper($_SESSION['chofer']); ?></strong>&nbsp;&nbsp;&nbsp;Cedula:<strong><?php echo strtoupper($_SESSION['cedula']); ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Contenido del B/L: <?php echo $_SESSION['bl_actual']; ?></div>
      <div class="CollapsiblePanelContent">
        <form id="form1" name="form1" method="post" action="qry_pases_2.php">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center">Acta</td>
              <td align="center">B/L</td>
              <td align="center">Embalaje</td>
              <td align="center">Contenido</td>
              <td align="center">Cantidad</td>
              <td align="center">M2</td>
              <td align="center"><label>
                <input type="submit" name="button2" id="button2" value="Agregar" />
              </label></td>
            </tr>
            <?php do { ?>
            <tr>
              <td align="center"><?php echo $fila_inventario['idacta']; ?></td>
              <td align="center"><?php echo $fila_inventario['BL']; ?></td>
              <td align="center"><?php echo $fila_inventario['embalaje']; ?></td>
              <td align="center"><?php echo $fila_inventario['cont_x_embalaje']; ?></td>
              <td align="center"><?php echo $fila_inventario['cantidad']; ?></td>
              <td align="center"><?php echo $fila_inventario['m2']; ?></td>
              <td align="center"><label>
                <input name="campos[<?php echo $fila_inventario['idinventario_cs']; ?>]" type="checkbox" checked="checked" />
              </label></td>
            </tr>
            <?php } while($fila_inventario = mysql_fetch_assoc($exec_inventario)); ?>
          </table>
        </form>
      </div>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
</div>
<script type="text/javascript">
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
</script>
</body>
</html>