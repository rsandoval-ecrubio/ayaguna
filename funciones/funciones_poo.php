<?php
//Mostrar iconos en nivel de usuario
function show_img_result($int){
	switch($int){
		case NULL:
		echo '<img src="img/circle_red.gif" width="10" height="10">';
		break;
		case '0':
		echo '<img src="img/circle_red.gif" width="10" height="10">';
		break;
		case '1':
		echo '<img src="img/circle_green.gif" width="10" height="10">';
		break;
	}
}

function showAlmacen($var){
	switch ($var) {
    case "appstc_ayaguna_jmp":
        echo "JMP";
        break;
    case "appstc_ayaguna_menfel":
        echo "MENFEL";
        break;
	 case "appstc_ayaguna_conslg":
        echo "Consolidados La Guaira";
        break;
	case "appstc_ayaguna_gonavi":
		echo "GONAVI";
		break;
	case "appstc_ayaguna_multimenfel":
		echo "Multiservicios Menfel";
		break;
	case "appstc_ayaguna_multiorion":
		echo "Multiservicios Orion 3000";
		break;
	case "appstc_ayaguna_daqui":
		echo "Corporacion Daqui C.A.";
		break;
}

#Mostrar nombre para la impresion del acta
function NomAlmacen($var){
	$alm = NULL;
	switch ($var) {
    case "appstc_ayaguna_jmp":
        $alm = "JMP";
        break;
    case "appstc_ayaguna_menfel":
        $alm = "MENFEL";
        break;
	 case "appstc_ayaguna_conslg":
        $alm = "Consolidados La Guaira";
        break;
	case "appstc_ayaguna_gonavi":
		$alm = "GONAVI";
		break;
	case "appstc_ayaguna_multimenfel":
		$alm = "Multiservicios Menfel";
		break;
	case "appstc_ayaguna_multiorion":
		$alm = "Multiservicios Orion 3000";
		break;
	case "appstc_ayaguna_daqui":
		$alm = "Corporacion Daqui C.A.";
		break;
	return $alm;
	}
}
	
}
?>	