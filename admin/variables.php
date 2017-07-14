<?php
session_start();
require('../config.php');
if(isset($_SESSION['variables']['nivel']) and $_SESSION['variables']['nivel'] == -1){
	echo "<pre>Variables de Session</pre>";
	echo "<pre>";
	print_r($_SESSION);
	print_r(get_defined_constants(true));
	echo "</pre>";
}else{
	//echo "<pre>Variables de Servidor</pre>";
	//echo "<pre>";
	//print_r($_SERVER);
	//echo "</pre>";
}
?>