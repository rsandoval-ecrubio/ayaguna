<?php
session_start();
require_once('config.php');

mysql_select_db($_SESSION['variables']['db']);

$sql = "SELECT COUNT(*) AS cantidad, tequipos.tipo, MONTH(inventario.frd) AS mes
FROM inventario, tequipos, lineas
WHERE YEAR(frd) = YEAR(CURDATE()) AND inventario.tcont = tequipos.id AND inventario.linea = lineas.id AND inventario.linea = 26
GROUP BY inventario.tcont, MONTH(inventario.frd)
ORDER BY mes DESC, tipo ASC";

$consulta = mysql_query($sql,$conexion) or die(mysql_error());
$filas = mysql_fetch_assoc($consulta);

$datos = array();
do{
	$datos[] = $filas;
}while($filas = mysql_fetch_assoc($consulta));


echo "<pre>";
//print_r($datos);
echo "</pre>";

?>
<div style="width: 730px; margin: 20px auto; font-family:sans-serif;">
<?php
/** Include class */
include('clases/GoogChartclass.php');

/** Create chart */
$chart = new GoogChart();

// Set graph colors
$color = array(
			'#99C754',
			'#54C7C5',
			'#999999',
		);
/* prueb */


// Set multiple graph data

$prueba = array( 
		$filas['mes'] => array($filas['tipo']=> $filas['cantidad']),
);
	




/* # Chart 2 # */
echo '<h2>ALMACENADORA</h2>';
$chart->setChartAttrs( array(
	'type' => 'bar-vertical',
	'title' => 'INGRESOS 2012',
	'data' => $prueba,
	'size' => array( 550, 200 ),
	'color' => $color,
	'labelsXY' => true,
	));
// Print chart
echo $chart;

/*

		Example 3
		Timeline
		Multiple data

*/

?>
</div>