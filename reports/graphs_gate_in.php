<?php
require('../config.php');
include('../jpgraph/inc/jpgraph.php');
include('../jpgraph/inc/jpgraph_bar.php');

mysql_select_db($database_conexion, $conexion);
$sqlGraph = "SELECT MONTHNAME(inventario.frd) AS `month`, YEAR(inventario.frd) AS `year`, COUNT(*) AS cantidad FROM inventario WHERE inventario.`delete` = 0 AND YEAR(inventario.frd) = '2011' GROUP BY MONTH(inventario.frd) ORDER BY YEAR(inventario.frd)";
$sqlGraphRun = mysql_query($sqlGraph,$conexion) or die(mysql_error());
$row = mysql_fetch_assoc($sqlGraphRun);
$totalrow = mysql_num_rows($sqlGraphRun);

do{
	$dato[] = $row['cantidad'];
}while($row = mysql_fetch_assoc($sqlGraphRun));
	
$graph = new Graph(512, 384, "auto");    
$graph->SetScale("textlin");

$graph->img->SetMargin(40, 20, 20, 40);
$graph->title->Set("Entradas Mensuales");
$graph->xaxis->title->Set("Mes");
//$graph->xaxis->SetTickPositions($tickPositions,$minTickPositions);
$graph->yaxis->title->Set("Cantidad" );

$barplot =new BarPlot($dato);
$barplot->SetColor("black");

$graph->Add($barplot);
$graph->Stroke();

?> 