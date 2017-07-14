<?php
require('../../config.php');
require('../../clases/class.ImportXLSX.php');

if(isset($_GET['id'])){
	$importar = new ImportarXLSX;
	$importar->Leer($_GET['id']);
	$importar->Importar();
	$importar->Insertar();
	if($importar->Insertado == 1){
		unlink($_GET['id']);
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<title>AYAGUNA</title>
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php'); ?>
<div id="content">
<h1>IMPORTAR ARCHIVO</h1>
<p>&nbsp;<?php echo $importar->Linea; ?></p>
<p>&nbsp;<?php echo $importar->Buque; ?></p>
<p>&nbsp;<?php echo $importar->Viaje; ?></p>
<h2>Cantidad de Registros a Importados: <?php echo $importar->FilasExcel; ?></h2> 
<a href="../index.php">Regresar</a> </div>
<?php
echo "<pre>";
//print_r($importar->ColumnasExcel);
//echo $importar->aRegistrar;
//print_r($importar->DatosExcel);
echo "</pre>";
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>