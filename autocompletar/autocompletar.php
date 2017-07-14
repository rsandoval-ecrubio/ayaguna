<?php
require_once('../config.php');
require_once('../clases/class.MySQL.php');

//cotejamos la variable criterio
if(isset($_GET['serial']) && $_GET['serial']!=""){
    
    $contenedor = $_GET['serial'];
	$listResult = new MySQL('appstc_ayaguna_conslg');
	$listResult->Consulta("SELECT contenedor, COUNT(contenedor) FROM inventario WHERE contenedor LIKE '".$contenedor."%' GROUP BY contenedor order by contenedor ASC"); 
    
	do{
		echo '<select>';
		echo '<option>'.$listResult->Resultado['contenedor'].'</option>';
		echo '</select>';		
	}while($listResult->Resultado = mysqli_fetch_assoc($listResult->Consulta));
    
}
?>