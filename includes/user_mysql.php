<?php
#Usuarios MySQL
$user = NULL;

switch($database){
	case 1:
		$user = "appstc_jmp";
	break;
	case 2:
		$user = "appstc_menfel";
	break;
	case 3:
		$user = "appstc_conslg";
	break;
	case 4:
		$user = "appstc_gonavi";
	break;
	case 5:
		$user = "appstc_multimen";
	break;
	return $user;
}
#Usuarios MySQL

?>