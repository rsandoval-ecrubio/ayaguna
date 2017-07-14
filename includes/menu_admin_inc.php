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
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenido">
  <div class="col_izq" id="colD">
    <ul id="MenuBar1" class="MenuBarVertical">
      <li><a href="#" class="MenuBarItemSubmenu">Administrar</a>
        <ul>
          <li><a href="#" class="MenuBarItemSubmenu">Usuarios</a>
            <ul>
              <li><a href="../admin/usuarios/usuarios.php" title="General">Nuevo</a></li>
              <li><a href="../admin/usuarios/listado_usuarios.php">Listado</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Consignatarios</a>
            <ul>
              <li><a href="../admin/consignatarios/consignatarios.php">Nuevo</a></li>
              <li><a href="../admin/consignatarios/lista_consig.php">Listado</a></li>
            </ul>
          </li>
          <li><a href="#" title="Booking">Ubicaciones</a>
            <ul>
              <li><a href="reportes_cgagral/cgagral_gral.php">Nuevo</a></li>
              <li><a href="reportes_cgagral/cgagral_consig.php">Listado</a></li>
            </ul>
          </li>
          <li><a href="#" title="Gate In">Puertos</a>
            <ul>
              <li><a href="../admin/puertos/puertos.php">Nuevo</a></li>
              <li><a href="../admin/puertos/listado.php">Listado</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#" class="MenuBarItemSubmenu">Admon</a>
        <ul>
          <li><a href="../admin/acopio/index.php">Acopio</a></li>
        </ul>
      </li>
      <li><a href="#" class="MenuBarItemSubmenu">Equipos</a>
        <ul>
          <li><a href="../editdata/index.php">Editar</a></li>
          <li><a href="../editdata/reintegro.php">Reintegro</a></li>
        </ul>
      </li>
      <li><a class="MenuBarItemSubmenu" href="#">Tablas</a>
        <ul>
          <li><a href="#" class="MenuBarItemSubmenu">PreCarga</a>
            <ul>
              <li><a href="../import">Importar</a></li>
              <li><a href="../import/listado.php">Lista Importada</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Lineas</a>
            <ul>
              <li><a href="../admin/tables/lineas/linea.php">Nueva</a></li>
              <li><a href="../admin/tables/lineas/lista_linea.php">Listado</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Buques</a>
            <ul>
              <li><a href="../admin/tables/buques/buque.php">Nuevo</a></li>
              <li><a href="../admin/tables/buques/listado.php">Listado</a></li>
            </ul>
          </li>
          <li><a href="#" class="MenuBarItemSubmenu">Viajes</a>
            <ul>
              <li><a href="../admin/tables/viajes/viaje.php">Nuevo</a></li>
              <li><a href="../admin/tables/viajes/lista_viaje.php">Listado</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="../index.php">Volver</a></li>
    </ul>
  </div>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>