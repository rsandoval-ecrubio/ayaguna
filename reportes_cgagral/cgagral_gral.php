<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<?php
//CONSULTA PARA REPORTE GENERAL
$qry_general = "SELECT * FROM inventario_cg WHERE in_out ='0'";
$exe_general = mysql_query($qry_general, $conexion) or die(mysql_error());
$fila_general = mysql_fetch_assoc($exe_general);
$ttl_general = mysql_num_rows($exe_general);

$qry_suma = "SELECT SUM(m2) as TTL FROM inventario_cg WHERE in_out ='0'";
$exe_suma = mysql_query($qry_suma, $conexion) or die(mysql_error());
$fila_suma = mysql_fetch_assoc($exe_suma);

$qry_suma2 = "SELECT SUM(cantidad) as TTL2 FROM inventario_cg WHERE in_out ='1'";
$exe_suma2 = mysql_query($qry_suma2, $conexion) or die(mysql_error());
$fila_suma2 = mysql_fetch_assoc($exe_suma2);

//QUERYS DETALLE CARGA GENRAL NO DESPACHADA
$_pagi_sql = "select inventario_cg.idacta, inventario_cg.fecha_acta,inventario_cg.fact_pack, inventario_cg.BL, embalajes.descripcion, inventario_cg.estado, inventario_cg.peso, inventario_cg.m2, inventario_cg.m3 from inventario_cg, embalajes where inventario_cg.embalaje = embalajes.idembalajes and inventario_cg.anulado = '0' and inventario_cg.in_out = '0'";
//$mdo = mysql_query($_pagi_sql, $conexion) or die(mysql_error());
//$row_cga = mysql_fetch_assoc($mdo);

$_pagi_cuantos = 25;
$_pagi_nav_num_enlaces = 3;
$_pagi_nav_anterior = "&lt;";
$_pagi_nav_siguiente = "&gt;";
include('../funciones/paginar.php');
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
</style>
</head>

<body>
<div class="info" id="info">
  <h2 align="center">Reporte General - Carga General </h2>
  <hr />
  <fieldset>
<legend>Reporte - Carga general - Inventario General</legend>
<table width="40%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="43%">&nbsp;</td>
    <td width="19%">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2">TOTAL PIEZAS EN ALMACEN:</td>
    <td align="right"><?php if($ttl_general == 0) { echo "-"; } else { echo $ttl_general;  } ?></td>
    </tr>
  <tr>
    <td colspan="2">TOTAL M2 DE OCUPACIÓN</td>
    <td align="right"><?php if($fila_suma['TTL'] == 0) { echo "-"; } else { echo $fila_suma['TTL'];  } ?></td>
    </tr>
  <tr>
    <td colspan="2">TOTAL PIEZAS DESPACHADAS:</td>
    <td align="right"><?php if($fila_suma2['TTL2'] == 0) { echo "-"; } else { echo $fila_suma2['TTL2'];  } ?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
<br />
<h2 align="center">Detalle Carga General</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="10" align="right"><?php echo $_pagi_navegacion; ?></td>
    </tr>
  <tr>
    <td align="center">Acta</td>
    <td align="center">Fch Entrada</td>
    <td align="center">Fact/Exp/Pack.List</td>
    <td align="center">BL</td>
    <td align="center">Embalaje</td>
    <td align="center">Estado</td>
    <td align="center">Mtrs 2</td>
    <td align="center">Mtrs 3</td>
    <td align="center">Peso</td>
    <td align="center"></td>
  </tr>
  <?php while($row = mysql_fetch_array($_pagi_result)){ ?>
  <tr>
    <td align="center"><?php echo $row['idacta']; ?></td>
    <td align="center"><?php echo $row['fecha_acta']; ?></td>
    <td align="center"><?php echo $row['fact_pack']; ?></td>
    <td align="center"><?php echo $row['BL']; ?></td>
    <td align="center"><?php echo $row['descripcion']; ?></td>
    <td align="center"><?php echo $row['estado']; ?></td>
    <td align="center"><?php echo $row['m2']; ?></td>
    <td align="center"><?php echo $row['m3']; ?></td>
    <td align="center"><?php echo $row['peso']; ?></td>
    <td></td>
  </tr>
  <?php }  ?>
</table>
  </fieldset>
  <hr />
</div>
</body>
</html>