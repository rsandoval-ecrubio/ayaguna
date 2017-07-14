<?php
class Logout {
	
	var $idusuario;
	var $SID;
	var $timestamp;
	
	function datosSession(){
		session_start();
		$this->idusuario = $_SESSION['variables']['idusuario'];
		$this->SID = session_id();
		$this->timestamp = date("Y-m-d H:i:s");
	}
	
	function muestraDatos(){
		echo "ID: ".$this->idusuario."<br /> SID: ".$this->SID."<br /> TIME:".$this->timestamp;
	}
	
	function cierraSession(){
		include('../login/clases/connections/conexion.php');
		//Seleccionar DB
		$mysqli->select_db($database_conexion);
		$query = "UPDATE control SET fin = '".$this->timestamp."' WHERE usuario = '".$this->idusuario."' AND sesion = '".$this->SID."'";
		$result = $mysqli->query($query);
		$mysqli->close();

		if($result){
			//Vacia las variables
			$_SESSION = array();
			//Elimina las cookies
			if (ini_get("session.use_cookies")){
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
			}
			//Desruye la session
			session_unset();
			session_destroy();
			header('Location: login.php');
		} 
	}
}	