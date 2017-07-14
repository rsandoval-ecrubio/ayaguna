<?php
//Arreglos
echo "<h2>Primer Arreglo</h2>";
$arreglo1 = array("A1","A2","A3");
echo "<pre>";
print_r($arreglo1);
echo "</pre>";
echo "<hr>";

echo "<h2>Segundo Arreglo</h2>";
$arreglo2 = array("B1","B2","B3");
echo "<pre>";
print_r($arreglo2);
echo "</pre>";
echo "<hr>";

echo "<h2>Tercer Arreglo</h2>";
$arreglo3 = array('Cantidad1', 'cantidad2','cantidad3');
echo "<pre>";
print_r($arreglo3);
echo "</pre>";
echo "<hr>";
//Cuenta de los arreglos
$cuenta_arreglo1 = count($arreglo1);
$cuenta_arreglo2 = count($arreglo3);
$cuenta_arreglo3 = count($arreglo3);

//Arreglo final
for($i=0;$i<=$cuenta_arreglo1-1;$i++){
	$final[] = array($arreglo1[$i],$arreglo2[$i],$arreglo3[$i]);
}
echo "<h2>Arreglo final</h2>";
echo "<pre>";
print_r($final);
echo "</pre>";
?>
