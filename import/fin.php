<?php 
ini_set('display_errors', '1');
require('../config.php');
require_once ('../clases/mygeneric_class.php');

#Resultados
$buque = $_GET['b'];
$viaje = $_GET['v'];

$importados = new DBMySQL;
$consulta = sprintf("SELECT lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, viajes.eta, lista.equipo, tequipos.tipo
FROM lista, lineas, buques, viajes, tequipos
WHERE lista.buque = %d AND lista.viaje = %d AND lista.linea = lineas.id AND lista.buque = buques.id AND lista.viaje = viajes.id AND lista.tipo = tequipos.id;",$buque,$viaje);
$importados->consultarDBli(1,$consulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Importar</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#espa {
	height: 70px;
	width: 98%;
}
</style>
</head>

<body>
<header><?php include(INCLUDE_DIR.'header_inc.php'); ?></header>
<?php if(isset($_SESSION['up']) and $_SESSION['up'] == true){ ?>
<article>
<h1>Datos Importados</h1>
<p><a href="/ayaguna/import/listado.php">Ir a listado </a></p>
<p><a href="../import/index.php">Regresar</a></p>
<table width="720" border="1" align="center" cellpadding="2" cellspacing="2">
  <caption>
    Registros <?php echo $importados->totalli; ?>
    </caption>
  <tr>
    <th width="76" scope="col">Linea</th>
    <th width="149" scope="col">Buque</th>
    <th width="86" scope="col">Viaje</th>
    <th width="90" scope="col">Fecha/Arribo</th>
    <th width="187" scope="col">Equipo</th>
    <th width="80" scope="col">Tipo</th>
    </tr><?php do { ?>
  <tr>
    <td align="center"><?php echo $importados->resultadoli['linea']; ?></td>
    <td align="center"><?php echo $importados->resultadoli['buque']; ?></td>
    <td align="center"><?php echo $importados->resultadoli['viaje']; ?></td>
    <td align="center"><?php echo $importados->resultadoli['eta']; ?></td>
    <td align="center"><?php echo $importados->resultadoli['equipo']; ?></td>
    <td align="center"><?php echo $importados->resultadoli['tipo']; ?></td>
    </tr><?php }while($importados->resultadoli = mysqli_fetch_assoc($importados->consultali)) ;?>
</table>
<p>&nbsp;</p>
</article>
<?php }else { ?>
<article>
<h1>Error!</h1>
<p>No se importo la data</p>
<p><a href="/ayaguna/import/index.php">Regresar</a></p>
</article>
<?php } ?>
<div id="espa">&nbsp;</div>  
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>