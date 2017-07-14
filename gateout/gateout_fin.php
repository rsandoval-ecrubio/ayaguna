<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php 
mysql_select_db($database_conexion,$conexion);
$total_lista = count($_POST['id']);

$fecha = $_POST['fdespims'];
$buque = $_POST['buque'];
$viaje = $_POST['viaje'];
$auditoria = $_SESSION['auth'];

for($i=0;$i<=$total_lista -1;$i++){
	$SQL = "UPDATE inventario SET eir_d = %d, fdespims = '%s', buqued = %d, viajed = '%s', c = 1, auditoria = %d WHERE id = %d";
	$qtxt = sprintf($SQL,$_POST['eir_d'][$i],$fecha,$buque,$viaje,$auditoria,$_POST['id'][$i]);
	$rqtxt = mysql_query($qtxt,$conexion) or die(mysql_error()."No se pudo actualizar la salida del equipo");
	
	//Listado de equipos seleccionados
	$total_id = count($_POST['id']); //Total de equipos seleccionados
	$ids = implode(",",$_POST['id']); //Listado de equipos seleccionados
	$listadoSQL = mysql_query("SELECT * FROM existenciadevolucion WHERE id IN($ids)") or die(mysql_error()." - ERROR: no se pudo consultar la lista de acarreo");
	$filaListado = mysql_fetch_assoc($listadoSQL);
	$totalListado = mysql_num_rows($listadoSQL);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
<link href="../css/clases.css" rel="stylesheet" type="text/css" />
<link href="../ccs/by_id.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="modulo_title">
  <h2>DEVOLUCION - Equipos Actualizados</h2>
  <h3><a href="../reports/reports_gateout.php?date=<?php echo $_POST['fdespims']; ?>">Ir a reportes</a> <?php echo $_POST['fdespims']; ?></h3>
  <p>&nbsp;</p>
</div>
</body>
</html>