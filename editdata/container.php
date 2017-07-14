<?php
require('../config.php');
require('../clases/class.EditContenedor.php');

$aparicion = NULL;
$propiedadC = NULL;

if(isset($_POST['numero']) and !empty($_POST['numero'])){
	$contenedor = new Contenedor;
	$contenedor->Datos($_POST['numero']);
	
	$viaje = new DBMySQL;
	$viaje->nombreDB(USERDB);
	$qviaje = sprintf("SELECT id, viaje FROM viajes WHERE buque = %d",$contenedor->Propiedades['buque']);
	$viaje->consultarDB($qviaje);
	
	$tipo = new DBMySQL;
	$tipo->nombreDB(USERDB);
	$tipo->consultarDB("SELECT id, tipo FROM tequipos WHERE id NOT IN(13,14,16,17)");
	
	$patio = new DBMySQL;
	$patio->nombreDB(USERDB);
	$patio->consultarDB("SELECT id, patio FROM patios");
	
	$consig = new DBMySQL;
	$consig->nombreDB(USERDB);
	$consig->consultarDB("SELECT id, nombre FROM consignatario WHERE nombre IS NOT NULL AND nombre <> '' ORDER BY nombre ASC");
	
	if($contenedor->Propiedades['c'] == 1){
		$buqued = new DBMySQL;
		$buqued->nombreDB(USERDB);
		$buqued->consultarDB(sprintf("SELECT id, nombre FROM buques WHERE linea = %d",$contenedor->Propiedades['linea']));
	}
	$aparicion = $contenedor->Tapariaciones;
	$propiedadC = $contenedor->Propiedades['c'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editar Contenedor</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php'); ?>
<p><a href="../admin/index.php">Regresar</a> </p>
<form id="form1" name="form1" method="post" action="">
  Numero de contenedor 
  <input type="text" name="numero" id="numero" />
  <input type="submit" name="button" id="button" value="Ver" />
</form>
<?php if($aparicion > 0 and $propiedadC == 0 and isset($_POST['numero'])){ ?>
<!--Contenedor con una sola aparicion en inventario -->
<form id="apa1" name="apa1" method="post" action="mod.php">
<h2>Contenedor en Inventario</h2>
    <p>
      <input type="hidden" name="id" id="id" value="<?php echo $contenedor->Editables['id'];?>" />
      <label>Contenedor</label>
      <input name="contenedor" type="text" disabled="disabled" id="contenedor" value="<?php echo $contenedor->Editables['contenedor']; ?>" />
      <span> <a href="editarserial.php?serial=<?php echo $contenedor->Editables['contenedor']; ?>">editar</a></span>
      <label>Viaje</label>
      <select name="viaje" id="viaje">
        <?php do{ ?>
        <option value="<?php echo $viaje->resultado['id'];?>" <?php if (!(strcmp($viaje->resultado['id'], $contenedor->Propiedades['viaje']))) {echo "selected=\"selected\"";} ?>><?php echo $viaje->resultado['viaje'];?></option>
        <?php }while($viaje->resultado = mysql_fetch_assoc($viaje->consulta));?>
      </select>
      <label>Tipo</label>
      <select name="tipo" id="tipo">
        <?php do{ ?>
        <option value="<?php echo $tipo->resultado['id']; ?>" <?php if (!(strcmp($tipo->resultado['id'], $contenedor->Propiedades['tcont']))) {echo "selected=\"selected\"";} ?>><?php echo $tipo->resultado['tipo']; ?></option>
        <?php }while($tipo->resultado = mysql_fetch_assoc($tipo->consulta));?>
      </select>    
      <label>Ingreso</label>
      <input name="frd" type="text" id="frd" value="<?php echo $contenedor->Editables['frd']; ?>" />
      <label>EIR</label>
      <input name="eir_r" type="text" id="eir_r" value="<?php echo $contenedor->Editables['eir_r']; ?>" />
      <label>Factura</label>
      <input name="fact" type="text" id="fact" value="<?php echo $contenedor->Editables['fact']; ?>" />   
      <label>Estatus</label>
      <select name="status" id="status">
        <option value="1"<?php if (!(strcmp(1, $contenedor->Propiedades['status']))) {echo "selected=\"selected\"";} ?>>FULL</option>
        <option value="0" <?php if (!(strcmp(0, $contenedor->Propiedades['status']))) {echo "selected=\"selected\"";} ?>>EMPTY</option>
      </select>
      <label>Condicion</label>
      <select name="condicion" id="condicion">
        <option value="1" <?php if (!(strcmp(1, $contenedor->Propiedades['condicion']))) {echo "selected=\"selected\"";} ?>>OPR-1</option>
        <option value="2" <?php if (!(strcmp(2, $contenedor->Propiedades['condicion']))) {echo "selected=\"selected\"";} ?>>OPR-2</option>
        <option value="3" <?php if (!(strcmp(3, $contenedor->Propiedades['condicion']))) {echo "selected=\"selected\"";} ?>>OPR-3</option>
        <option value="0" <?php if (!(strcmp(0, $contenedor->Propiedades['condicion']))) {echo "selected=\"selected\"";} ?>>DMG</option>
        <option value="4" <?php if (!(strcmp(4, $contenedor->Propiedades['condicion']))) {echo "selected=\"selected\"";} ?>>N-OPR</option>
      </select>
      <label>Precinto</label>
      <input name="precinto" type="text" id="precinto" value="<?php echo $contenedor->Editables['precinto']; ?>" />   
      <label>B/L</label>
      <input name="bl" type="text" id="bl" value="<?php echo $contenedor->Editables['bl']; ?>" />    
      <label>Patio</label>
      <select name="patio" id="patio">
        <?php do{ ?>
        <option value="<?php echo $patio->resultado['id'];?>" <?php if (!(strcmp($patio->resultado['id'], $contenedor->Propiedades['patio']))) {echo "selected=\"selected\"";} ?>><?php echo $patio->resultado['patio'];?></option>
        <?php }while($patio->resultado = mysql_fetch_assoc($patio->consulta));?>
      </select>
      <label>Consignatario</label>
      <select name="consignatario" id="consignatario" style="width:400px;">
        <?php do{ ?>
        <option value="<?php echo $consig->resultado['id'];?>" <?php if (!(strcmp($consig->resultado['id'], $contenedor->Propiedades['consignatario']))) {echo "selected=\"selected\"";} ?>><?php echo $consig->resultado['nombre'];?></option>
        <?php }while($consig->resultado = mysql_fetch_assoc($consig->consulta));?>
      </select>    
      <label>Observaciones</label>
      <textarea name="obs" id="obs" cols="45" rows="5"><?php echo $contenedor->Editables['obs']; ?>
      </textarea> 
      <input name="in" type="hidden" id="in" value="1" />
    </p>
    <p>
      <input type="submit" name="button2" id="button2" value="Enviar" />
    </p>
</form>
<!--Contenedor con una sola aparicion en inventario -->
<?php }else if($aparicion > 0 and $propiedadC == 1 and isset($_POST['numero'])){ ?> 
<!--Contenedor con una sola aparicion fuera de inventario -->
<form id="apa0" name="apa0" method="post" action="mod.php">
<h2>Contenedor fuera de inventario</h2>
    <input name="id" type="hidden" id="id" value="<?php echo $contenedor->Editables['id']; ?>" />
    <label>Contenedor</label>
    <input name="contenedor2" type="text" disabled="disabled" id="contenedor2" value="<?php echo $contenedor->Editables['contenedor']; ?>" />
    <label>Tipo</label>
    <select name="tipo2" id="tipo2">
      <?php do{ ?>
      <option value="<?php echo $tipo->resultado['id']; ?>" <?php if (!(strcmp($tipo->resultado['id'], $contenedor->Propiedades['tcont']))) {echo "selected=\"selected\"";} ?>><?php echo $tipo->resultado['tipo']; ?></option>
      <?php }while($tipo->resultado = mysql_fetch_assoc($tipo->consulta));?>
    </select>
    <label>Ingreso</label>
    <input name="frd2" type="text" id="frd2" value="<?php echo $contenedor->Editables['frd']; ?>" />
    <label>Factura</label>
    <input name="fact2" type="text" id="fact2" value="<?php echo $contenedor->Editables['fact']; ?>" />
    <label>Estatus</label>
    <select name="status2" id="status2">
      <option value="1"<?php if (!(strcmp(1, $contenedor->Propiedades['status']))) {echo "selected=\"selected\"";} ?>>FULL</option>
      <option value="0" <?php if (!(strcmp(0, $contenedor->Propiedades['status']))) {echo "selected=\"selected\"";} ?>>EMPTY</option>
    </select>
    <label>Precinto</label>
    <input name="precinto2" type="text" id="precinto2" value="<?php echo $contenedor->Editables['precinto']; ?>" />
    <label>B/L</label>
    <input name="bl2" type="text" id="bl2" value="<?php echo $contenedor->Editables['bl']; ?>" />
    <label>Consignatario</label>
    <select name="consignatario2" id="consignatario2" style="width:400px;">
      <?php do{ ?>
      <option value="<?php echo $consig->resultado['id'];?>" <?php if (!(strcmp($consig->resultado['id'], $contenedor->Propiedades['consignatario']))) {echo "selected=\"selected\"";} ?>><?php echo $consig->resultado['nombre'];?></option>
      <?php }while($consig->resultado = mysql_fetch_assoc($consig->consulta));?>
    </select>
    <label>Buque</label>
    <select name="buqued" id="buqued">
    <?php do{ ?>
    <option value="<?php echo $buqued->resultado['id'];?>" <?php if (!(strcmp($buqued->resultado['id'], $contenedor->Propiedades['buqued']))) {echo "selected=\"selected\"";} ?>><?php echo $buqued->resultado['nombre'];?></option>
    <?php }while($buqued->resultado = mysql_fetch_assoc($buqued->consulta)); ?>
    </select>
    <label>Salida</label>
    <input name="fdespims" type="text" id="fdespims" value="<?php echo $contenedor->Editables['fdespims']; ?>" />
  </p>
  <input name="out" type="hidden" id="out" value="1" />
  <p>
    <input type="submit" name="button3" id="button3" value="Enviar" />
  </p>
</form>
<!--Contenedor con una sola aparicion fuera de inventario -->

<?php }else if($aparicion == 0 and isset($_POST['numero'])){ ?> 
<!--Contenedor con mas de una aparicion -->
<h2>No se encuentra el contenedor en la base de datos</h2>
<!--Contenedor con mas de una aparicion -->
<?php } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>