<?php
#session_start();
require_once('../config.php');
//Nuevo modelo
require_once('../clases/seguridad_class.php');
require_once('../clases/class.MySQL.php');
require_once('../clases/class.preliquidacion.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
seguridad();

#Datos para la preliquidacion
$acta = decodificar($_GET['var1']);
$contenedor = decodificar($_GET['var2']);

#Nombre de almacen
$db = $_SESSION['variables']['db'];
if($db == "appstc_ayaguna_jmp"){
	$almacen = "CORPORACION JMP C.A.";
}else if($db == "appstc_ayaguna_menfel"){
	$almacen = "Almacenadora MENFEL Almenfelca C.A.";
}else if($db == "appstc_ayaguna_conslg"){
	$almacen = "Consolidados La Guaira 2011, C.A.";
}else if($db == "appstc_ayaguna_gonavi"){
	$almacen = "IMPORTADORA Y TRANSPORTE GONAVI, C.A.";
}else if($db == "appstc_ayaguna_multimenfel"){
	$almacen = "MULTISERVICIOS MENFEL C.A.";
}else if ($db == "appstc_ayaguna_multiorion"){
	$almacen = "MULTISERVICIOS ORION 3000 C.A.";
}else if($db == "appstc_ayaguna_daqui"){
	$almacen = "Corporacion DAQUI, C.A.";
}

$preliquida = new Preliquidar;
$preliquida->DatosEquipo($acta,$contenedor);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pre-Liquidacion</title>
<style>
.descripcion{
	width: 300px;
	height: 30px;
	margin-top: 0px;
	margin-bottom: 0px;
	margin-right: 100px;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	float: left;
	clear: left;
	display: block;
}
.totales{
	width: 300px;
	height: 30px;
	margin-top: 0px;
	margin-bottom: 0px;
	margin-right: 0px;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	display: block;
	float: left;
	text-align: right;
}
</style>
</head>

<body>
<h1>Pre-Liquidacion <br><?php echo $almacen; ?></h1>
<p>--------------------------------------------------------------------------------------------------------------------------------------<br>
</p>
<p>Linea: <strong><?php echo $preliquida->resultados['linea']; ?></strong>  | Buque: <strong><?php echo $preliquida->resultados['buque']; ?></strong>  | Viaje: <strong><?php echo $preliquida->resultados['viaje']; ?></strong>  | Atraque: <strong><?php echo $preliquida->resultados['eta']; ?></strong>  <br>
  Contenedor: <strong><?php echo $preliquida->resultados['contenedor'];?></strong>  | Tipo: <strong><?php echo $preliquida->resultados['tipo'];?></strong>
  <br>
  Consignatario: <?php $preliquida->resultados['consig']; ?>
</p>
<p>--------------------------------------------------------------------------------------------------------------------------------------<br>
Fecha de Recepción: <strong><?php echo $preliquida->resultados['frd']; ?></strong> | Dias en el Almacen <strong><?php echo $preliquida->dias; ?></strong><br>
--------------------------------------------------------------------------------------------------------------------------------------</p>
<div id="totales">
<span class="descripcion">Tarifa hasta diez (10) diez dias</span><span class="totales">Bs.<?php echo number_format($preliquida->tarifabase,2); ?></span>
<span class="descripcion">Tarifa despues de diez (10) dias</span><span class="totales">Bs.<?php echo number_format($preliquida->aM10,2); ?></span>
<span class="descripcion">Tarifa despues de veinte (20) dias</span><span class="totales">Bs.<?php echo number_format($preliquida->aM20,2); ?></span>
<span class="descripcion">Tarifa despues de treinta (30) dias</span><span class="totales">Bs. <?php echo number_format($preliquida->aM30,2); ?></span>
<span class="descripcion">Tarifa despues de cuarenta y cinco (45) dias</span><span class="totales">Bs. <?php echo number_format($preliquida->aM45,2); ?></span>
<span class="descripcion">Costo de Elevadora</span><span class="totales">Bs. <?php echo number_format($preliquida->elevadora,2); ?></span>
<span class="descripcion">Total</span><span class="totales">Bs. <strong><?php $total = $preliquida->tarifabase + $preliquida->aM10 + $preliquida->aM20 + $preliquida->aM30 + $preliquida->aM45 + $preliquida->elevadora; echo number_format($total,2);?></strong></span>
</div>
</body>
</html>