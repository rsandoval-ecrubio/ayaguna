<?php
//session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
include('../clases/mygeneric_class.php');
seguridad();
$error = NULL;
?>
<?php
$error = NULL;
//Crear nuevo consignatario
if(isset($_POST['newconsig']) and $_POST['newconsig'] != ''){
	$nuevo = $_POST['newconsig'];
	$nvoconsig = new DBMySQL;
	$nvoconsig->nombreDB($_SESSION['variables']['db']);
	$qnvoconsig = sprintf("INSERT INTO consignatario(`nombre`) VALUES('%s');",$nuevo);
	$nvoconsig->registroDB($qnvoconsig);
	$nvoconsig->ultimoRegistro();
	if($nvoconsig->ultRegistro){ 
		$idnvo = $nvoconsig->ultRegistro;
		echo $idnvo;
	}else {
		echo "NO SE REGISTRO EL NUEVO CONSIGNATARIO";
		exit;
	}
}
?>
<?php
//Datos del Equipo

foreach ($_POST as $key => $value){
	if ($key<>'bl' AND $key<>'precinto' AND $key<>'fact' AND $key<>'paset' AND $key<>'validacion' AND $key<>'estatus'){
		if (empty($value)){
			echo "<strong>El campo $key esta vacío.:.</strong>";
			break;
		}
	}
}

$linea = $_POST['linea'];
$buque = $_POST['select2'];
$idviaje = $_POST['select3'];
if($_POST['consignatario'] == -1){
	$consignatario = $idnvo;
}else {
	$consignatario = $_POST['consignatario'];
}

$fdm = $_POST['fdm'];
$frd = $_POST['frd'];
$contenedor = $_POST['contenedor'];
$tipo = $_POST['tipo_cont'];
$estatus = $_POST['estatus'];
$eir_r = $_POST['eir'];
$condicion = $_POST['condicion'];
$ubicacion = $_POST['ubicacion'];
$bl = $_POST['bl'];
$precinto = $_POST['precinto'];
$obs = $_POST['obs'];
$auditoria = $_SESSION['auth'];

/*-------------------------------------------------------- 
Campos adicionales requeridos por ALMENFEL
Campo Factura y Campo PASE para el ingreso del contenedor
--------------------------------------------------------*/
$fact = $_POST['fact'];
$paset = $_POST['paset'];


/*Procedimiento para validar el contenedor a ingresar*/
$Valida = new DBMySQL();
$Valida->nombreDB($_SESSION['variables']['db']);
$Qvalida = sprintf("SELECT COUNT(contenedor) AS Validado FROM inventario WHERE c = 0 AND contenedor = '%s'",$contenedor);
$Valida->consultarDB($Qvalida);

if($Valida->resultado['Validado'] > 0){
	die("<h2>Equipo en inventario</h2>");

}else {
	#Consultar el viaje
	$viaje = new DBMySQL();
	$Qviaje = sprintf("SELECT ad FROM viajes WHERE id = %d",$idviaje);
	$viaje->nombreDB($_SESSION['variables']['db']);
	$viaje->consultarDB($Qviaje);
	
	if($viaje->resultado['ad'] <> NULL){
		$fdb = $viaje->resultado['ad'];
		$registrar = true;
	}else if($viaje->resultado['ad'] <> 0){
		$fdb = $viaje->resultado['ad'];
		$registrar = true;
	}else {
		$registrar = false;
		die("El viaje no tiene fecha de arribo registrada");
	}
	
	if($registrar == true){
		if($precinto = 0){
			$precinto = null;
		}
		
		//-INI-Registrar el contenedor en el inventario
		$gatein = new DBMySQL();
		$gatein->nombreDB($_SESSION['variables']['db']);
		$Qgatein = sprintf("INSERT INTO inventario (linea,buque,viaje,tcont,contenedor,fdb,fdm,frd,eir_r,fact,paset,`status`,condicion,precinto,bl,patio,consignatario,obs)
		VALUES (%d,%d,%d,%d,'%s','%s','%s','%s',%d,%d,%d,%d,%d,%d,'%s','%s',%d,'%s')",
		$linea,$buque,$idviaje,$tipo,$contenedor,$fdb,$fdm,$frd,$eir_r,$fact,$paset,$estatus,$condicion,$precinto,$bl,$ubicacion,$consignatario,$obs);
		
		//echo $Qgatein;
		$gatein->registroDB($Qgatein);
		//-FIN-Registrar el contenedor en el inventario
	}else {
		die("<h1>No se pudo procesar el movimiento de entrada</h1>");
	}
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