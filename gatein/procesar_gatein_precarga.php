<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toprecarga_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
include(CLASES.'mygeneric_class.php');
//include('../clases/mygeneric_class.php');
seguridad();
?>
<?php
//Datos del Equipo
//Id precarga
$id = $_POST['id'];
$eir = $_POST['eir'];
$estatus = $_POST['estatus'];
$fdm = $_POST['fdm'];
$frd = $_POST['frd'];
$condicion = $_POST['condicion'];
$ubicacion = $_POST['ubicacion'];
$observacion = $_POST['obs'];

/*-------------------------------------------------------- 
Campos adicionales requeridos por ALMENFEL
Campo Factura y Campo PASE para el ingreso del contenedor
--------------------------------------------------------*/
$fact = $_POST['fact'];
$pase = $_POST['paset'];

/*-------------------------------------------------------- 
Campos adicionales requeridos por Consolidados LAG
Campo Factura y Campo PASE para el ingreso del contenedor
--------------------------------------------------------*/
$precinto = $_POST['precinto'];


/*
Procedimiento para validar el contenedor a ingresar
Contenedor precargado
Datos del contenedor
*/
$idContenedor = $_POST['id'];
$preContenedor = new DBMySQL();
$preContenedor->nombreDB($_SESSION['variables']['db']);
$Qprecontenedor = sprintf("SELECT * FROM lista WHERE id = %d",$idContenedor);
//echo $Qprecontenedor;
$preContenedor->consultarDB($Qprecontenedor);
if($preContenedor->total > 0){
	$linea = $preContenedor->resultado['linea'];
	$buque = $preContenedor->resultado['buque'];
	$viaje = $preContenedor->resultado['viaje'];
	$tipo = $preContenedor->resultado['tipo'];
	$contenedor = $preContenedor->resultado['equipo'];
	$consignatario = $preContenedor->resultado['consig'];
	/*Fecha de arribo del buque */
	$arribo = new DBMySQL();
	$arribo->nombreDB($_SESSION['variables']['db']);
	$Qarribo = sprintf("SELECT * FROM viajes WHERE id = %d",$viaje);
	//echo $Qarribo;
	$arribo->consultarDB($Qarribo);
	if($arribo->total > 0){
		//-INI-Verificar que no este registrado el contenedor
		$verificar = new DBMySQL();
		$verificar->nombreDB($_SESSION['variables']['db']);
		$Qverificar = sprintf("SELECT * FROM inventario WHERE contenedor = '%s' AND c = 0",$contenedor);
		//echo $Qverificar;
		$verificar->consultarDB($Qverificar);
		if($verificar->total == 0){
			//-FIN-Verificar que no este registrado el contenedor
			$fdb = $arribo->resultado['ad'];
			$fdm = $_POST['fdm'];
			$frd = $_POST['frd'];
			$eir_r = $_POST['eir'];
			$estatus = $_POST['estatus'];
			$condicion = $_POST['condicion'];
			$patio = $_POST['ubicacion'];
			$precinto = $_POST['precinto'];
			$observacion = $_POST['obs'];
			//-INI-Registrar el contenedor en el inventario
			$gatein = new DBMySQL();
			$gatein->nombreDB($_SESSION['variables']['db']);
			$Qgatein = sprintf("INSERT INTO inventario (linea,buque,viaje,tcont,contenedor,fdb,fdm,frd,eir_r,fact,paset,`status`,condicion,patio,precinto,consignatario,obs) 
			VALUES  (%d,%d,%d,%d,'%s','%s','%s','%s',%d,%d,%d,%d,%d,%d,'%s',%d,'%s')",
			$linea,$buque,$viaje,$tipo,$contenedor,$fdb,$fdm,$frd,$eir_r,$fact,$pase,$estatus,$condicion,$patio,$precinto,$consignatario,$observacion);
			//echo $Qgatein;
			$gatein->registroDB($Qgatein);
			//-FIN-Registrar el contenedor en el inventario
			if($gatein->afectados > 0){
				//-INI-Borrar contenedor de precarga
				$eliminarPrecarga = new DBMySQL();
				$eliminarPrecarga->nombreDB($_SESSION['variables']['db']);
				$QeliminarPrecarga = sprintf("DELETE FROM lista WHERE id = %d",$idContenedor);
				$eliminarPrecarga->registroDB($QeliminarPrecarga);
				//-FIN-Borrar contenedor de precarga
				$error = 0;
			}
		}else {
			$error = 1;
			exit;
		}
	}else {
		$error = 2;
		exit;
	}
}else {
	die("Contenedor no registrado en la precarga");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="content">
    <div id="act_rec">
      <fieldset id="acta">
      <h2>
        <legend>Movimientos - Recepcion  - <?php echo $time = date("Y-m-d H:i:s"); ?></legend>
      </h2>
      <!--fdm-->
      <?php //echo $_POST['fdm'];?>     
      <!--fdm-->
      <?php if($error == 0){ ?>
      <h1>Registro exitoso      </h1>
      <h1>
        <?php } ?>
        <?php if($error > 0){ ?>
      </h1>
      <h1>Error<?php echo "  ".$error; ?></h1>
      <?php if($error == 1){?><p class="errorBig">El equipo que esta intentado registrar ya se encuentra en el inventario.</p><?php }?>
      <?php if($error == 2){?><p class="errorBig">El viaje indicado no tiene fecha de arribo asignada</p><?php }?>
      <?php } ?>
      </fieldset>
</div>
  </div>
</div>
</body>
</html>