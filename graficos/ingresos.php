<?php
require('../config.php');
require('../clases/mygeneric_class.php');
require('../jpgraph/src/jpgraph.php');
require('../jpgraph/src/jpgraph_bar.php');

$datos = new DBMySQL;
$datos->nombreDB(USERDB);
$datos->consultarDB("SELECT COUNT(*) AS cant FROM inventario group by MONTH(frd)");

do{
	$datay[]=$datos->resultado['cant'];
}while($datos->resultado = mysql_fetch_assoc($datos->consulta));


// Create the graph. These two calls are always required
$graph = new Graph(720,480,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->ClearTheme();

$graph->Set90AndMargin(50,40,40,40);
$graph->img->SetAngle(90); 

// set major and minor tick positions manually
$graph->SetBox(true);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->Show(true);
$graph->xgrid->Show(false);
$graph->xgrid->SetFill(false);
$graph->ygrid->SetFill(false);


$graph->xaxis->SetTickLabels(array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->title->Set("INGRESOS TOTAL 2012");
// Create the bar plots
$b1plot = new BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);

$b1plot->SetWeight(0);
$b1plot->SetFillGradient("#0099CC","#FFFFFF",GRAD_HOR);
$b1plot->SetWidth(20);

$graph->Stroke();
?>