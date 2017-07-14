<?php
#Clase para conectar a MySQL orientada a Objetos

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
?>