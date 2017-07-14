<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"articulo"=>"fact_renglones",
"estados"=>"fact_precios"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	
	$hostname_conexion = "localhost";
	$database_conexion = "appstc_ayaguna_jmp";
	$username_conexion = "appstc";
	$password_conexion = "nVgXi3HT40";
	$conexion = mysql_pconnect($hostname_conexion, $username_conexion,$password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);
	
	mysql_select_db($database_conexion,$conexion);
	
	$consulta=mysql_query("SELECT id, precio FROM $tabla WHERE articulo='$opcionSeleccionada'") or die(mysql_error());

	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registro[1]=htmlentities($registro[1]);
		// Imprimo las opciones del select
		echo "<option value='".$registro[1]."'>".$registro[1]."</option>";
	}			
	echo "</select>";
}
?>