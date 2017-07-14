<?php
session_start();
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
/*
select1 linea
select2 buque
select3 viaje
*/
$listadoSelects=array(
"select1"=>"select_1",
"select2"=>"buques",
"select3"=>"viajes"
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
	//Include para la conexion
	include ('../Connections/conexion.php');
	mysql_select_db($database_conexion, $conexion);
	//conectar();
	if($tabla == "buques"){
		$consulta=mysql_query("SELECT id, nombre FROM $tabla WHERE linea='$opcionSeleccionada' AND buques.activo = 0") or die(mysql_error());
		//desconectar();
	}else if ($tabla == "viajes"){
		$consulta=mysql_query("SELECT id, viaje FROM $tabla WHERE buque='$opcionSeleccionada' AND viajes.activo = 0") or die(mysql_error());
		//desconectar();
	}	
	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	while($registro=mysql_fetch_row($consulta))
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registro[1]=htmlentities($registro[1]);
		// Imprimo las opciones del select
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}			
	echo "</select>";
}
?>