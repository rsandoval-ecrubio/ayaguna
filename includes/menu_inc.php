<?php 
$realRoot = str_replace('\\\\', '/', realpath(dirname(__FILE__))).'/';
$dir = substr($realRoot,0,35);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
}
.col_izq {
	float: left;
	height: auto;
	width: 120px;
	margin-top: 0px;
}
.col_der {
	float: left;
	height: 5px;
	width: 900px;
	margin-left: 10px;
}
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenido">
  <div class="col_izq" id="colD">
    <ul id="MenuBar1" class="MenuBarVertical">
      <li><a class="MenuBarItemSubmenu" href="#">Movimientos</a>
        <ul>
          <li><a href="#" class="MenuBarItemSubmenu">Recepci&oacute;n</a>
            <ul>
              <li><a href="actas_cont/index_cont.php">Acta de recepci&oacute;n</a></li>
              <li><a href="gatein/gatein.php">Recepcion</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Despacho</a>
            <ul>
              <li><a href="pase_salida_cont/pase_salida_cont.php">Pase de Salida</a></li>
              <li><a href="gateout/gateout.php">Devolucion</a></li>
              <li><a href="asignacion/asignacion.php">Asignacion</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Carga General</a>
            <ul>
              <li><a href="cga_suelta/cgagral_index.php">Acta de recepci&oacute;n</a></li>
              <li><a href="pases_salida/pases.php">Pase de Salida</a></li>
            </ul>
          </li>
          <li><a href="vaciado">Vaciado</a></li>
        </ul>
      </li>
      <li><a href="#" class="MenuBarItemSubmenu">Reportes</a>
        <ul>
          <li><a href="#" class="MenuBarItemSubmenu">Inventario</a>
            <ul>
              <li><a href="reports/reports_inventory.php" title="General">General</a></li>
              <li><a href="reports/reports_inventory_full.php">Full</a></li>
              <li><a href="reports/reports_inventory_consignee.php" title="Consignatario"> Por Consignatario</a></li>
              <li><a href="reports/reports_inventory_line.php" title="By Line">Por Linea</a></li>
              <li><a href="reports/reports_inventory_line_20.php">Por Linea 20&quot;</a></li>
              <li><a href="reports/reports_inventory_line_40.php">Por Linea 40&quot;</a></li>
              <li><a href="reports/reports_inventory_line_dmg.php">Por Linea DMG</a></li>
              <li><a href="reports/reports_inventory_location.php">Ubicacion</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Inv. Carga Gral</a>
            <ul>
              <li><a href="reportes_cgagral/cgagral_gral.php">General</a></li>
              <li><a href="reportes_cgagral/cgagral_consig.php">Consignatario</a></li>
              <li><a href="reportes_cgagral/cgagral_BL.php">B/L</a></li>
              <li><a href="reportes_cgagral/cgagral_lote.php">Lote</a></li>
            </ul>
          </li>
          <li><a href="reports/reports_booking.php" title="Booking">Asignaciones</a></li>
          <li><a href="reports/reports_gatein.php" title="Gate In">Entradas</a></li>
          <li><a href="reports/reports_gateout.php">Salidas</a></li>
        </ul>
      </li>
      <li><a href="#" class="MenuBarItemSubmenu">Reparacion</a>
        <ul>
          <li><a href="repair/repair.php">Reparar</a></li>
          <li><a href="repair/list.php">Listado</a></li>
        </ul>
      </li>
      <li><a href="admin/index.php">Admin</a></li>
      <li><a href="salida.php">Salir</a></li>
    </ul>
  </div>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>