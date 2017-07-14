<?php
session_start();
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d H:i:s");
//INICIALIZA DB Y CONEXION/////////////////////////////
$server = "localhost";
$userDB = "imssisc";
$passDB = "%analema.";
$DB = "imssisc_desarrollo";
$cnx_string = mysql_connect($server,$userDB,$passDB);
mysql_select_db($DB,$cnx_string);
////////////////////////////////////////////////////////
$valores = $_SESSION['acta_pase'];
$pase = $_SESSION['pase'];
////////////////////////////////////////////////////////
	$qry_pase_act = "SELECT * FROM pase_salida WHERE idpase = '$pase' ORDER BY idpase DESC";
	$exec_pase_act = mysql_query($qry_pase_act,$cnx_string) or die(mysql_error());
	$fila_pase_act = mysql_fetch_assoc($exec_pase_act);
	$hora_pase = $fila_pase_act['fch_hora'];
//$SID = session_id();
if(!empty($_POST['reg'])){
$lista = array_keys($_POST['reg']);
$lista2 = implode("','",$lista); //enmascaro el array
$lista3 = "'".$lista2."'"; // le doy formato al array

$query_consulta = "SELECT * FROM inventario_cg where idinventario_cs IN($lista3)";
$consulta = mysql_query($query_consulta, $cnx_string) or die(mysql_error());
$lista_final = mysql_fetch_assoc($consulta);
}
?>
<?PHP //para actualizar los regiustros papa
foreach ($lista as $valor)
	{
		$qry = "update inventario_cg set idpase = '$pase', fecha_pase = '$hora_pase', in_out = '1' where idinventario_cs = $valor";
		mysql_query($qry,$cnx_string);
			}
	header("Location:index_pases.php?cont_pase=true");
?>