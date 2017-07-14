<?php
session_start();
require_once('../config.php');

mysql_select_db($_SESSION['variables']['db']);

$sql = "SELECT COUNT(*) AS cantidad, tequipos.tipo, MONTH(inventario.frd) AS mes
FROM inventario, tequipos, lineas
WHERE YEAR(frd) = YEAR(CURDATE()) AND inventario.tcont = tequipos.id AND inventario.linea = lineas.id AND inventario.linea = 26
GROUP BY inventario.tcont, MONTH(inventario.frd)
ORDER BY mes DESC, tipo ASC";

$consulta = mysql_query($sql,$conexion) or die(mysql_error());
$filas = mysql_fetch_assoc($consulta);
 
do{
	echo '['.$filas['mes'].',"'.$filas['tipo'].'",'.$filas['cantidad'].'],'; 
}while($filas = mysql_fetch_assoc($consulta));


?>
<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Mes')
		data.addColumn('string', 'Tipo');
        data.addColumn('number', 'Cantidad');
        data.addRows([
  		  [10,"20' DC",86],
		  [10,"40' DC",32],
		  [10,"40' FR",1],
		  [10,"40' HC",200],
		  [10,"40' OT",1],
		  [9,"20' DC",154],
		  [9,"20' OT",2],
		  [9,"40' DC",46],
		  [9,"40' FR",2],
		  [9,"40' HC",356],
		  [9,"40' OT",3]
        ]);

        // Set chart options
        var options = {'title':'Entradas',
                       'width':800,
                       'height':600};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>