<?php
session_start();
include("../clases/mygeneric_class.php");


if(isset($_POST['incluir']) and $_POST['incluir'] == 1){
	#Carga de Imagene
	$ruta = "fotosequipos/";
	$max = 1000000;
	$tipo = "image/jpeg";
	$nombres = array();
	$registros = array();
	
	if(isset($_POST['id']) and !empty($_FILES['img']['name'][0])){
		if(count($_FILES['img']['name']) > 5){
			die("<h1>Error</h1><p>Solo esta permitido cargar cinco (5) imagenes</p>");
		}
		#Si se recibieron los datos
		//Validar el tamaño
		for($i=0;$i<=count($_FILES['img']['name'])-1;$i++){
			if($_FILES['img']['size'][$i] > $max){
				die("<h1>Error</h1><p>El o los archivos exceden el limite del tamaño (1MB). <a href='index.php'>Regresar</a></p>");
			}else {
				//Si no excede el tamaño
				if($_FILES['img']['type'][$i] != $tipo){
					//Si no es JPG
					die("<h1>Error</h1><p>Solo se permiten archivos JPEG/JPG. <a href='index.php'>Regresar</a></p>");
				}else {
					$prefijo = $_POST['id'];
					$num = mt_rand(000000,999999);
					$fin = $i;
					array_push($nombres,$prefijo.$num.$fin);
					$extension = substr($_FILES['img']['name'][$i],-4);
					
					$subida = move_uploaded_file($_FILES['img']['tmp_name'][$i],$ruta.$nombres[$i].$extension);
					if(!$subida){
						die("<h1>Error</h1>");
					}
					array_push($registros,$nombres[$i].$extension);
				}
			}
		}
		$registrar = new DBMySQL();  //new DBs;
		$registrar->nombreDB($_SESSION['variables']['db']);
		
		for($i=0;$i<=count($registros)-1;$i++){
			$sql = sprintf("INSERT INTO imagephp(idcontenedor,nombrefoto) VALUES(%d,'%s');",$_POST['id'],$registros[$i]);
			$registrar->registroDB($sql);
		}
	}else {
		#Si se no recibieron los datos
		die("<h1>Error</h1><p>No se recibieron los datos del formulario (Imagenes). <a href='repair.php'>Regresar</a></p>");
	}
	#Carga de Imagenes
}

if(isset($_POST)){
	$id = $_POST['id'];
	$idcontenedor = $id;
	$condicion = $_POST['condicion'];
	$obs = $_POST['obs'];
	$frep = $_POST['frep'];
	$accion = "Reparado: ".$_POST['accion']; //Descripcion de la accion para actualizar inventario
	$accion2 = $_POST['accion2']; //Condicion final para actualizar inventario
	$monto = $_POST['monto']; 
	
	//Registro en la tabla reparaciones
	$reparar = new DBMySQL();
	$qtxt = sprintf("INSERT INTO reparaciones(idcontenedor,fecha,condicion,antobs,monto) VALUES(%d,'%s',%d,'%s',%d)",$id,$frep,$condicion,$obs,$monto);
	$reparar->nombreDB($_SESSION['variables']['db']);
	$reparar->registroDB($qtxt);
	$ultid = mysql_insert_id();
	
	//Actualizacion en la tabla inventario
	$actualiza = new DBMySQL();
	$q2txt = sprintf("UPDATE inventario SET condicion = %d, rep_dano = %d, obs = '%s' WHERE id = %d",$accion2,$ultid,$accion,$id);
	$actualiza->nombreDB($_SESSION['variables']['db']);
	$actualiza->registroDB($q2txt);
	
	header("Location: repair.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>