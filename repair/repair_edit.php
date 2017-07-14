<?php
require('../config.php');
require('../clases/mygeneric_class.php');

if(isset($_GET['id'])){
	$datos = new DBMySQL;
	$datos->nombreDB(USERDB);
	$sql = sprintf("SELECT reparaciones.*, inventario.contenedor FROM reparaciones, inventario WHERE reparaciones.id = %d AND reparaciones.idcontenedor = inventario.id;",$_GET['id']);
	$datos->consultarDB($sql);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reparaciones</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<style>
.edicion {
	margin-left: 10px;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 4px;
	width: 600px;
}

.edicion ul {
	list-style:none;
}

.edicion ul li {
	display: block;
	margin-top: 3px;
	margin-bottom: 3px;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 4px;
}

.edicion ul li label {
	display: block;
	float: left;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	width: 100px;
	font-weight: bold;
	font-size: medium;
}

.edicion input[type="number"] {
	text-align: right;
}
</style>
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');?>
<div id="content">
&nbsp;
<form action="repair_update.php" method="post" name="edicion" class="edicion" id="edicion">
<ul>
	<li>
	  <input type="hidden" name="id" id="id" value="<?php echo $datos->resultado['id']; ?>">
	  <label for="fecha">Fecha:</label>
      <input type="date" name="fecha" id="fecha" value="<?php echo $datos->resultado['fecha'];?>">
	</li>
	<li>
	  <label for="contenedor">Contenedor:</label>
      <input name="contenedor" type="text" id="contenedor" value="<?php echo $datos->resultado['contenedor']; ?>" readonly>
	</li>
	<li>
	  <label for="condicion">Condicion:</label>
      <select name="condicion" id="condicion">
        <option value="1" <?php if (!(strcmp(1, $datos->resultado['condicion']))) {echo "selected=\"selected\"";} ?>>OPR-1</option>
        <option value="2" <?php if (!(strcmp(2, $datos->resultado['condicion']))) {echo "selected=\"selected\"";} ?>>OPR-2</option>
        <option value="3" <?php if (!(strcmp(3, $datos->resultado['condicion']))) {echo "selected=\"selected\"";} ?>>OPR-3</option>
        <option value="0" <?php if (!(strcmp(0, $datos->resultado['condicion']))) {echo "selected=\"selected\"";} ?>>DMG</option>
        <option value="4" <?php if (!(strcmp(4, $datos->resultado['condicion']))) {echo "selected=\"selected\"";} ?>>N-OPR</option>
      </select>
	</li>
	<li>
	  <label for="antobs">Observación Anterior:</label>
      <textarea name="antobs" cols="40" rows="8" id="antobs"><?php echo $datos->resultado['antobs']; ?></textarea>
	</li>
	<li>
	  <label for="monto">Monto:</label>
      <input name="monto" type="number" id="monto" step="any" value="<?php echo $datos->resultado['monto']; ?>">
	</li>
	<li>
	  <input type="submit" name="submit" id="submit" value="Actualizar">
	</li>
</ul>
</form>
</div>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>