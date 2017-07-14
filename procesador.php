<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

#Clase Mysqli
class DBMySQLi {
	private $Host = 'localhost';
	private $Usuario;
	private $Clave;
	public $Basedatos;
	public $Conexion;
	public $Consulta;
	public $Num_resultados;
	public $Filas = array();
	public $Afectados;
	
	public function Datosconexion($user,$pass,$db){
		$this->Usuario = $user;
		$this->Clave = $pass;
		$this->Basedatos = $db;
	}
	
	private function Conectar(){
		date_default_timezone_set('America/Caracas');
		$this->Conexion = mysqli_connect($this->Host,$this->Usuario,$this->Clave,$this->Basedatos);
		if(mysqli_connect_errno()){
			die('Error de conexion a la base de datos');
		}
	}
	
	public function Consulta($sql){
		if(isset($this->Conexion)){
			$this->Consulta = mysqli_query($this->Conexion,$sql);
			$this->Num_resultados = mysqli_num_rows($this->Consulta);
			$this->Filas = mysqli_fetch_assoc($this->Consulta);
		}else {
			self::Conectar();
			$this->Consulta = mysqli_query($this->Conexion,$sql);
			$this->Num_resultados = mysqli_num_rows($this->Consulta);
			$this->Filas = mysqli_fetch_assoc($this->Consulta);
		}
		return $this->Filas;
	}
	
	public function Insertar($sql){
		if(isset($this->Conexion)){
			$this->Consulta = mysqli_query($this->Conexion,$sql);
			$this->Afectados = mysqli_affected_rows($this->Conexion);
			if($this->Afectados === 0){
				die('Error: No se pudo ejecutar la consulta. ' .mysqli_errno($this->Conexion));
			}
		}else {
			self::Conectar();
			$this->Consulta = mysqli_query($this->Conexion,$sql);
			$this->Afectados = mysqli_affected_rows($this->Conexion);
			if($this->Afectados === 0){
				die('Error: No se pudo ejecutar la consulta. ' .mysqli_errno($this->Conexion));
			}
		}
		
	}
	
	public function Liberar(){
		mysqli_free_result($this->Consulta);
	}

}
#Clase Mysqli


#Clase Usuario
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
		if($password === $confirm){
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
		$user = $login;
		$pass = md5($pass);
		#Creo el objeto
		$mysql = new DBMySQLi();
		#Creo la conexion
		$mysql->Datosconexion('appstc','nVgXi3HT40','appstc_ayaguna_mastertable');
		$consulta = sprintf("SELECT * FROM usuarios WHERE usuario = '%s' AND clave = '%s'",$user,$pass);
		#Hago la consulta
		$mysql->Consulta($consulta);
		#Valido los resultados
		if($user === $mysql->Filas['usuario'] and $pass === $mysql->Filas['clave']){
			#Listado de Bases de datos
			$dbs = array(
						1 =>'appstc_ayaguna_jmp',
						2 =>'appstc_ayaguna_menfel',
						3 =>'appstc_ayaguna_conslg',
						4 =>'appstc_ayaguna_gonavi',
						5 =>'appstc_ayaguna_multimenfel',
						6 =>'appstc_ayaguna_multiorion',
						7 =>'appstc_ayaguna_daqui',
						8 =>"appstc_ayaguna_venemar",
						9 =>"appstc_ayaguna_intercon"
						);
			#Listado de Usuarios DB (18-05-2015)
			$dbs_usuarios = array(
								1 =>'appstc_jmp',
								2 =>'appstc_menfel',
								3 =>'appstc_conslg',
								4 =>'appstc_gonavi',
								5 =>'appstc_multimen',
								6 =>'appstc_multiorion',
								7 =>'appstc_daqui',
								8=>'appstc_venemar',
								9 =>"appstc_intercon"
								);
			#Variables datos del Usuario
			$_SESSION['variables'] = array("idusuario" => $mysql->Filas['id'],
										"login" => $mysql->Filas['usuario'],
										"nombreUsuario" => $mysql->Filas['nombre'],
										"apellidoUsuario" => $mysql->Filas['apellido'],
										"nivel" => $mysql->Filas['nivel'],
										"tipo" => $mysql->Filas['tipo'],
										"linea" => $mysql->Filas['linea'],
										"db" => $dbs[$mysql->Filas['datos']],
										"ndb" => $mysql->Filas['datos'],
										"udb" => $dbs_usuarios[$mysql->Filas['datos']]
										);
			$_SESSION['autentificado'] = true;
			$SID = session_id();
			$timestamp = date("Y-m-d H:i:s");
			$idusuario = $_SESSION['variables']['idusuario'];
			$usuario = $_SESSION['variables']['usuario'];
			

			if($_SESSION['variables']['login'] != "root"){
				if($mysql->Filas['nivel'] < 6){
					header(self::APP_USER);
				}else{
					header(self::APP_CLI);
				}
					
			}else {
				header(self::APP_LOGIN);
			}
			//*/
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
#Clase Usuario
	
//require_once('config.php');
$Login = new Usuario();
$Login->login($_POST['usuario'],$_POST['clave']);
?>