<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<?php

//CONSULTA CONSIGNATARIO
$qry_consig = "SELECT * from consignatario ORDER BY id ASC";
$exe_consig = mysql_query($qry_consig,$conexion) or die(mysql_error());
$fila_consig = mysql_fetch_assoc($exe_consig);

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
<legend>Reporte - Carga general - Consignatario
</legend>
<form action="cgagral_lote.php?ver_result=true" method="post">
  <table width="80%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="7%">Lote:</td>
      <td width="93%"><label for="lote"></label>
        <input type="text" name="lote" id="lote" />
        <input type="submit" name="button" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<!-- /////////////////////////////RESULTADOS DE LA BUSQUEDA////////////////////////// -->
<?php if(!isset($_GET['ver_result'])) { } else { ?>
<?php

//QUERYS DETALLE CARGA GENRAL NO DESPACHADA
$busqueda = $_POST['lote']; 
$_pagi_sql = "SELECT inventario_cg.idacta, inventario_cg.fecha_acta,inventario_cg.fact, inventario_cg.expediente, inventario_cg.packing, inventario_cg.BL, embalajes.descripcion, inventario_cg.estado, inventario_cg.peso, inventario_cg.m2, inventario_cg.m3 FROM inventario_cg, embalajes where inventario_cg.embalaje = embalajes.idembalajes and inventario_cg.anulado = '0' and inventario_cg.in_out = '0' and inventario_cg.lote = '$busqueda'";

$_pagi_cuantos = 100;
$_pagi_nav_num_enlaces = 3;
$_pagi_nav_anterior = "&lt;";
$_pagi_nav_siguiente = "&gt;";
include('../funciones/paginar.php');
?>
<br />
<h2 align="center">Detalle Carga General - Lote</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="10" align="right"><?php echo $_pagi_navegacion; ?></td>
    </tr>
  <tr>
    <td align="center">Acta</td>
    <td align="center">Fch Entrada</td>
    <td align="center">Fact/Exp/Pack.List</td>
    <td align="center">Lote</td>
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
    <td align="center"><?php echo $row['fact']." / ".$row['expediente']." / ".$row['packing']; ?></td>
    <td align="center"><?php echo $row['lote']; ?></td>
    <td align="center"><?php echo $row['descripcion']; ?></td>
    <td align="center"><?php echo $row['estado']; ?></td>
    <td align="center"><?php echo $row['m2']; ?></td>
    <td align="center"><?php echo $row['m3']; ?></td>
    <td align="center"><?php echo $row['peso']; ?></td>
    <td></td>
  </tr>
  <?php }  ?>
</table>
<?php } ?>
  </fieldset>
  <hr />
</div>
</body>
</html>