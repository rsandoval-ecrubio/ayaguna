<?php
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();


$mostrar = NULL;

include("../clases/mygeneric_class.php");

if(isset($_POST['contenedor'])){
	$contenedor = $_POST['contenedor'];
	$busqueda = new DBMySQL();
	$qtxt = sprintf("SELECT id, linea, buque, viaje, tcont, contenedor, fdb, fdm,frd, eir_r,condicion, patio, obs FROM inventario WHERE contenedor = '%s' AND c = 0",$contenedor);
	$busqueda->nombreDB($_SESSION['variables']['db']);
	$busqueda->consultarDB($qtxt);
	$mostrar = $busqueda->total;
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h2>Modulo de Reparaciones </h2>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="text-align:left">
  <label>Indique el numero de contenedor
    <input type="text" name="contenedor" id="contenedor">
  </label>
  <input type="submit" name="button" id="button" value="ir">
  <span class="thtrack">(Ahora puede incluir hasta cinco (5) imagenes del equipo)</span>
</form>
<p>&nbsp;</p>
<?php if($mostrar > 0){ ?>
<form action="repair2.php" method="post" enctype="multipart/form-data" name="reparacion" target="_self" id="reparacion">
  <table width="520" align="center" cellpadding="2" cellspacing="2">
    <caption>
      Reparaci&oacute;n / Cambio de condici&oacute;n
    </caption>
    <tr>
      <td width="182" scope="row">Contenedor</td>
      <td width="322"><input name="id" type="hidden" id="id" value="<?php echo $busqueda->resultado['id']; ?>">
      <input name="condicion" type="hidden" id="condicion" value="<?php echo $busqueda->resultado['condicion']; ?>" />        <h2><?php echo $busqueda->resultado['contenedor']; ?></h2></td>
    </tr>
    <tr>
      <td width="182" scope="row">Fecha de Recepci&oacute;n</td>
      <td><?php echo $busqueda->resultado['frd']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td scope="row">Condici&oacute;n</td>
      <td><?php condicion($busqueda->resultado['condicion']); ?>&nbsp;</td>
    </tr>
    <tr>
      <td scope="row">Observacion</td>
      <td><textarea name="obs" cols="45" rows="5" readonly="readonly" id="obs"><?php echo $busqueda->resultado['obs']; ?>
      </textarea></td>
    </tr>
    <tr>
      <td scope="row">Fecha Reparaci&oacute;n</td>
      <td><input name="frep" type="text" id="frep" value="<?php echo AHORAC; ?>" size="10" /></td>
    </tr>
    <tr>
      <td scope="row">Acci&oacute;n Correctiva</td>
      <td><textarea name="accion" id="accion" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td scope="row">Condici&oacute;n post correcci&oacute;n</td>
      <td><select name="accion2" id="accion2">
        <option selected>Seleccione</option>
        <option value="0">DMG</option>
        <option value="1">OPER1</option>
        <option value="2">OPER2</option>
        <option value="3">OPER3</option>
        <option value="4">NO-OPER</option>
      </select></td>
    </tr>
    <tr>
      <td scope="row">Monto / Reparaci&oacute;n</td>
      <td><input name="monto" type="text" id="monto" style="text-align:right" value="<?php echo number_format(0,2) ?>" size="10"></td>
    </tr>
    <tr>
      <td scope="row">&nbsp;</td>
      <td scope="row"><input name="incluir" type="checkbox" id="incluir" value="1" checked="checked" />
      Incluir imagenes | <span class="thtrack">Si no desea incluir imagenes quite la selecci&oacute;n</span></td>
    </tr>
    <tr>
      <td scope="row">Imagen/imagenes (5)</td>
      <td><input name="img[]" type="file" multiple="multiple" id="img[]" />
      <span class="tooltips"><a class="tooltips" href="#">Info
<span>Para agregar mas de una (1) imagen, haga click en examinar, seleccione la primera imagen y mantenga presionada la tecla Ctrl y continue la seleccion de imagenes. Solo se permiten hasta cinco (5) imagenes.</span></a></td>
    </tr>
    <tr>
      <td scope="row"><input type="submit" name="button2" id="button2" value="Actualizar"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form><?php  } ?>
<p>&nbsp;</p>
</body>
</html>