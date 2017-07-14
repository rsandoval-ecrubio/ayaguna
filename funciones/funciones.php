<?php
//session_start();
//Funciones
//Funcion restar fechas
function restafechas($ini, $fin){
	$resultado = abs((strtotime($ini) - strtotime($fin))/86400);
	if($resultado == 0){
		echo 1;
	}else {
		$alerta = $resultado + 1;
		if($alerta > 80 && $alerta < 91){
			echo "<span>".$resultado."</span>";
			}elseif($alerta > 91){
				echo "<span style='color:#C00'>".$resultado."</span>";
			}else {
				if($alerta > 80 && $alerta < 91){
				echo "<span style='color:#F60'>".$resultado."</span>";
			}else{
				echo "<span>".$resultado."</span>";
			}
		}	
	}
}

function condicion($condicion){
	switch($condicion){
		case null:
		echo "<span style='color:#C00'>DMG</span>";
		break;
		case 'DMG':
		echo "<span style='color:#C00'>DMG</span>";
		break;
		case 0:
		echo "<span style='color:#C00'>DMG</span>";
		break;
		case 1:
		echo "OPR1";
		break;
		case 2:
		echo "OPR2";
		break;
		case 3:
		echo "OPR3";
		break;
		case 4:
		echo "<span style='color:#C00'>N-OPR</span>";
		break;
	}
}

function estatus($var){
	if($var == 0){
		echo "EMPTY";
	}else if($var == 1){
		echo "FULL";
	}else {
		echo "NULL";
	}
}

//Funcion para mejorar datos de consulta ->
#Identifica el Tipo de Usuarios
function tipoUser($tipo){
	if($tipo == -1){
		echo "IMSSIs User";
	}else {
		echo "Line User";
	}
}
#Tipo de Usuario String
function userLevel($level){
	$data = (int) $level;
	switch($data){
		case -1:
		echo "Root";
		break;
		case 1:
		echo "User View";
		break;
		case 2:
		echo "User A";
		break;
		case 3:
		echo "User B";
		break;
		case 4:
		echo "Administrator";
		break;
	}
}
#Habilitado o Inhabilitado
function userStatus($sta){ 
	switch($sta){
		case 0:
		echo "<span style='color:#039'>Enable</span>";
		break;
		case 1:
		echo "<span style='color:#FF3300'>Disable</span>";
		break;
	}
}
#Errores de inicio de session
function errorSession($vars){
	switch($vars){
		case 1:
		echo "Not authorized";
		break;
		case 2:
		echo "Wrong username or password";
		break;
		case 3:
		echo "Missing Data";
		break;
	}
}
#Validar Session
function Session(){
	if($_SESSION['authorized'] != true){
		header("Location: ../home/index.php?error=1");
	}
}
function showPhone($phone){
	if($phone != null){
		$codigo = substr($phone,0,4);
		$numeroA = substr($phone,4,3);
		$numeroB = substr($phone,7,2);
		$numeroC = substr($phone,9,2);
		echo "(".$codigo.")-".$numeroA.".".$numeroB.".".$numeroC;
	}else {
		echo "No phone number";
	}
}

//seguridad
function seguridad(){
	if(!$_SESSION['autentificado']){
		header('Location: ../home/index.php?error=1');
	}else if(isset($_SESSION['autentificado']) and $_SESSION['autentificado'] != true){
		header('Location: ../home/index.php?error=1');
	}
}
//Nuevas funciones
//Condicion
function cdt($cdt){
	if($cdt == "DMG" or $cdt == "N-OPR"){
		echo "<span style='color:#900; font-weight:bold'>".$cdt."</span>";
	}else {
		echo "<span style='color:#090; font-weight:bold'>".$cdt."</span>";
	}

}
//Alarma de Dias en patio
function alarma($dias){
	(int) $dias;
	if($dias > 0 and $dias < 31){
		echo "<span style='color:#006600; font-weight:bold'>".$dias."</span>";
	}else if($dias > 30 and $dias < 61){
		echo "<span style='color:#003366; font-weight:bold'>".$dias."</span>";
	}else if($dias > 60 and $dias < 91){
		echo "<span style='color:#FF3300; font-weight:bold'>".$dias."</span>";
	}else if($dias > 90){
		echo "<span style='color:#FF0000; font-weight:bold; text-decoration:blink;'>".$dias."</span>";
	}else if($dias == 0){
		echo "<span style='color:#006600; font-weight:bold'>1</span>";
	}
}
//Alarma de dias en pais
function alarmapais($diaspais){
	(int) $diaspais;
	if($diaspais > 89){
		echo "<span style='color:#FF0000; font-weight:bold; text-decoration:blink;'>".$diaspais."</span>";
	}else if($diaspais == 0){
		echo "<span style='color:#006600; font-weight:bold'>1</span>";
	}else {
		echo $diaspais;
	}
}
//Verificar si fue devuelto | consulta consignatario
function dvlto($date){
	if(is_null($date)){
		echo "<img src='../img/circle_green.gif' width='10' height='10' />";
		$dias = true;
	}else{
		echo "<img src='../img/circle_red.gif' width='10' height='10' />";
		$dias = false;
	}
	return $dias;
}
//IN-OUT para tracking
function inout($c){
	if($c == 0){
		echo "INV";
	}elseif($c == 1){
		echo "DEV";
	}else{
		echo "ERROR";
	}
}

function activo($a){
	switch($a){
		case 0:
		echo "SI";
		break;
		case 1;
		echo "NO";
		break;
	}
}
#Codificar parametro URL
function codificar($parametro){
	$codificado = base64_encode($parametro);
	return $codificado;
}
#Decodificar parametro URl
function decodificar($parametro){
	$decoficado = base64_decode($parametro);
	return $decoficado;
}
?>