<?php
ini_set('display_errors', '1');
require_once ('../../config.php');
require_once ('../../clases/mygeneric_class.php');
require_once ('../Classes/PHPExcel/IOFactory.php');
if(isset($_GET['id'])){
	$archivo = $_GET['id'];
	$objPHPExcel = PHPExcel_IOFactory::load($archivo);
}else {
	die("Error identificando el archivo a importar");
}

//se obtienen las hojas, el nombre de las hojas y se pone activa la primera hoja
$total_sheets=$objPHPExcel->getSheetCount();
$allSheetName=$objPHPExcel->getSheetNames();
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

//Se obtiene el número máximo de filas
$highestRow = $objWorksheet->getHighestRow();

//Se obtiene el número máximo de columnas
$highestColumn = $objWorksheet->getHighestColumn();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

//$headingsArray contiene las cabeceras de la hoja excel. Llos titulos de columnas
$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
$headingsArray = $headingsArray[1];

//Se recorre toda la hoja excel desde la fila 2 y se almacenan los datos
$r = -1;
$namedDataArray = array();
for ($row = 2; $row <= $highestRow; ++$row) {
	$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
		  ++$r;
		  foreach($headingsArray as $columnKey => $columnHeading) {
				  $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
		  } //endforeach
	} //endif
}
		
$cabecera = implode(",",$headingsArray);

//Consulta SQL
$filas = count($namedDataArray) -1;
for($f=0;$f<=$filas;++$f){
	$datosFilasIni[$f] = implode("','",$namedDataArray[$f]);
	$datosFilasFin[$f] = "('".$datosFilasIni[$f]."')";
}

$insertarDatos = implode(",",$datosFilasFin);
$consulta = "INSERT INTO precarga(".$cabecera.") VALUES ".$insertarDatos;

/*
echo "<pre>";
echo $consulta;
echo "<pre>";
*/
/* Vaciar tabla precarga */
$vaciar = new DBMySQL;
$vaciar->insertarDBli(1,"TRUNCATE `precarga`;");


$importar = new DBMySQL();
$importar->insertarDBli(1,$consulta);
if($importar->afectadosli > 0){
	header("Location: datos_fin.php");
}else {
	echo "Error: No se pudo importar el archivo";
}

?>