<?php
//Clase de Usuarios
class Usuario {
	private $Login;
	private $Password;
	var $Nombre;
	var $Apellido;
	var $Correo;
	var $Telefono;
	var $Db;
	var $Tipo;
	var $Linea;
	var $Nivel;
	var $DatosUsuario;
	private $Error;
	public $Registrado;
	
	const APP_LOGIN = "Location: index.php";
	const LOGIN = "Location: login.php";
	const LIST_USER = "Location: usuarios_lista.php";
	const ERROR_LOGIN = "Location: login.php?Error=DatosInvalidos";
	const APP_USER = "Location: index.php";
	const APP_CLI = "Location: clientes/index.php";
	
	function datosUsuario($name,$lastname,$email,$phone,$login,$password,$confirm,$db,$tipo,$line,$level){
		$this->Nombre = $name;
		$this->Apellido = $lastname;
		$this->Correo = $email;
		$this->Telefono = $phone;
		$this->Login = $login;
		$this->Db = $db;
		$this->Tipo = $tipo;
		$this->Linea = $line;
		$this->Nivel = $level;
		if($password == $confirm){
			$this->Password = md5($password);
			$this->Error = false;
		}else {
			$this->Error = true;
			exit;
		}
		return ($this->error);
	}
	
	public function crearUsurio(){
		if($this->Error == false){
			$sql = "INSERT INTO usuarios(nombre,apellido,email,telefono,usuario,clave,nivel,tipo,linea,datos) ";
			$sql .= "VALUES('".$this->Nombre."','".$this->Apellido."','".$this->Correo."',".$this->Telefono.",'".$this->Login."','".$this->Password."',".$this->Nivel.",".$this->Tipo.",".$this->Linea.",".$this->Db.")";
			$RegistroUsuario = new DBMySQL();
			$RegistroUsuario->registroDB($sql);
			$this->Registrado = true;
			header(self::LIST_USER);
		}
		return ($this->Registrado);
	}
	
	function login($login,$pass){
		$this->user = $login;
		$this->pass = md5($pass);
		require_once('mygeneric_class.php');
		$mysql = new DBMySQL();
		$mysql->nombreDB("appstc_ayaguna_mastertable");
		$consulta = sprintf("SELECT * FROM usuarios WHERE usuario = '%s' AND clave = '%s'",$this->user,$this->pass);
		$mysql->consultarDB($consulta);
		if($this->user == $mysql->resultado['usuario'] and $this->pass = $mysql->resultado['clave']){
			session_start();
			//Bases de datos
			$dbs = array(
						1 =>"appstc_ayaguna_jmp",
						2 =>"appstc_ayaguna_menfel",
						3 =>"appstc_ayaguna_conslg",
						4 =>"appstc_ayaguna_gonavi",
						5 =>"appstc_ayaguna_multimenfel",
						6 =>"appstc_ayaguna_multiorion",
						7 =>"appstc_ayaguna_daqui",
						8 =>"appstc_ayaguna_venemar"
						);
			$usersdb = array(
						1 =>"appstc_jmp",
						2 =>"appstc_menfel",
						3 =>"appstc_conslg",
						4 =>"appstc_gonavi",
						5 =>"appstc_multimen",
						6 =>"appstc_multio",
						7 =>"appstc_daqui",
						8=>"appstc_venemar"
						);
			$NDBs = array(
						1 =>"CORPORACION JMP C.A.",
						2 =>"Almacenadora MENFEL Almenfelca C.A.",
						3 =>"Consolidados La Guaira 2011, C.A.",
						4 =>"IMPORTADORA Y TRANSPORTE GONAVI, C.A.",
						5 =>"MULTISERVICIOS MENFEL C.A.",
						6 =>"MULTISERVICIOS ORION 3000 C.A.",
						7 =>"appstc_daqui",
						8=>"Inversiones Pegasus 2021, C.A."
						);
			$_SESSION['variables'] = array(
										"idusuario" => $mysql->resultado['id'], 
										"login" => $mysql->resultado['usuario'],
										"nombreUsuario" => $mysql->resultado['nombre'],
										"apellidoUsuario" => $mysql->resultado['apellido'],
										"nivel" => $mysql->resultado['nivel'],
										"tipo" => $mysql->resultado['tipo'],
										"linea" => $mysql->resultado['linea'],
										"db" => $dbs[$mysql->resultado['datos']],
										"ndb" => $mysql->resultado['ndatos'],
										"udb" => $usersdb[$mysql->resultado['datos']]
										);
			$_SESSION['variables']['udb'] = $usersdb[$_SESSION['variables']['ndb']];;
			$_SESSION['autentificado'] = true;
			$SID = session_id();
			$timestamp = date("Y-m-d H:i:s");
			$idusuario = $_SESSION['variables']['idusuario'];
			$usuario = $_SESSION['variables']['usuario'];
			$this->usuario = $usuario;
			$mysql->liberar();
			//Registrar el acceso
			$registrar = new DBMySQL();
			$registrar->nombreDB("appstc_ayaguna_mastertable");
			$registrar->registroDB("INSERT INTO control(usuario,sesion,inicio) VALUES($idusuario,'$SID','$timestamp')");
			if($this->usuario != "root"){
				if($mysql->resultado['nivel'] < 6){
					header(self::APP_USER);
				}else{
					header(self::APP_CLI);
				}
					
			}else {
				header(self::APP_LOGIN);
			}
		}else{
			header(self::ERROR_LOGIN);
		}
	}
	
	public function datosSession(){
		session_start();
		$this->idusuario = $_SESSION['variables']['idusuario'];
		$this->SID = session_id();
		$this->timestamp = date("Y-m-d H:i:s");
	}
	
	public function logout(){
		$this->datosSession();
		if(!empty($this->idusuario)){
			require_once('mygeneric_class.php');
			$salir = new DBMySQL();
			$salir->nombreDB("appstc_ayaguna_mastertable");
			$salir->registroDB("UPDATE control SET fin = '".$this->timestamp."' WHERE usuario = '".$this->idusuario."' AND sesion = '".$this->SID."'");
			if($salir->consulta){
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
				header(self::LOGIN);
			}
		}
	}
}
?>