<?php
require_once('config.php');
require_once('clases/class.MySQL.php');
//Track

$contenedor = $_GET['serial'];
$contenedorList = new MySQL(USERDB);
$contenedorList->Consultar("SELECT contenedor FROM inventario WHERE contenedor LIKE '".$contenedor."%';");
$n = $contenedorList->Total;

	echo '<label style="border:1px solid #333333">';
	echo '<select class=".selectResult" name="se" id="se" style="border:1px solid #cccccc" size="5" onclick="muestra()" onkeydown="muestra2()">';
	do {
		echo '<option value="'.$contenedorList->Resultado['contenedor'].'">'.$contenedorList->Resultado['contenedor'].'</option>';
	}while($contenedorList->Resultado = mysqli_fetch_assoc($contenedorList->Consulta));
	echo '</select>';
	echo '</label>';


?>