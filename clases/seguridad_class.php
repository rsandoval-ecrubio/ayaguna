<?php
class Seguridad {
	var $dato;
	
	function getDato(){
		$this->dato = $_SESSION['autentificado'];
	}
	
	function valida(){
		if($this->dato != true){
			header("Location: http://appstc.net/ayaguna/login.php");
			exit;
		}
	}
}
?>