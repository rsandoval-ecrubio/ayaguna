<?php
//Conexion
class DBMySQL {
	private $host;
	private $user;
	private $pass;
	var $conexion;
	var $consulta;
	var $resultado;
	var $ultRegistro;
	var $afectados;
	var $total;
	//Orientado a Objetos
	var $conexionli;
	var $dbli;
	var $consultali;
	var $resultadoli;
	var $ultRegistroli;
	var $afectadosli;
	var $totalli;
	
	public function nombreDB($database){
		$this->DataBase = $database;
		return;
	}
	
	private function conectar(){
		$this->host = "localhost";
		$this->user = "appstc";
		$this->pass = "nVgXi3HT40";
		$this->conexion = mysql_connect($this->host,$this->user,$this->pass)or die("<h3>Imposible conectar</h3>".mysql_error());
	}
	
	private function selectDB(){
		$this->db = mysql_select_db($this->DataBase);
	}
	
	public function consultarDB($query){
		$this->conectar();
		$this->selectDB();
		$this->query = $query;
		$this->consulta = mysql_query($this->query,$this->conexion)or die("<h3>Imposible consultar</h3>".mysql_error());
		$this->resultado = mysql_fetch_assoc($this->consulta);
		$this->total = mysql_num_rows($this->consulta);
	}
	
	public function consultarDBArr($query){
		$this->conectar();
		$this->selectDB();
		$this->query = $query;
		$this->consulta = mysql_query($this->query,$this->conexion)or die("<h3>Imposible consultar</h3>".mysql_error());
		$this->resultado = mysql_fetch_array($this->consulta);
		//$this->total = mysql_num_rows($this->consulta);
	}
	
	public function registroDB($registro){
		$this->conectar();
		$this->selectDB();
		$this->query = $registro;
		$this->consulta = mysql_query($this->query,$this->conexion)or die("<h3>Imposible registrar</h3><p>$this->query</p>".mysql_error());
		$this->afectados = mysql_affected_rows();
	}
	
	public function ultimoRegistro(){
		$this->ultRegistro = mysql_insert_id();
		return $this->ultRegistro;
	}
	
	public function liberar(){
		mysql_free_result($this->consulta);
	}
	
	public function cerrar(){
		mysql_close($this->conexion);
	}
	
	//Orientado a Objetos
	private function Conectarli($db){
		switch($db){
			case 1:
				$this->dbli = USERDB;
			break;
			case 2:
				$this->dbli = MASTERTABLE;
			break;
		}
		
		$this->host = "localhost";
		$this->user = "appstc";
		$this->pass = "nVgXi3HT40";
		
		$this->conexionli = mysqli_connect($this->host,$this->user,$this->pass,$this->dbli) or trigger_error(mysqli_error(),E_USER_ERROR); 
		
		return $this->conexionli;
	}
	
	public function consultarDBli($db,$query){
		$this->Conectarli($db);
		$this->queryli = $query;
		$this->consultali = mysqli_query($this->conexionli,$this->queryli)or die("Imposible consultar LI: ".mysqli_error($this->conexionli));
		$this->resultadoli = mysqli_fetch_assoc($this->consultali);
		$this->totalli = mysqli_num_rows($this->consultali);
	}
	
	public function insertarDBli($db,$query){
		$this->Conectarli($db);
		$this->queryli = $query;
		$this->consultali = mysqli_query($this->conexionli,$this->queryli)or die("Insertando: ".mysqli_error($this->conexionli));
		$this->afectadosli = mysqli_affected_rows($this->conexionli);
	}
	
	public function afectadosli(){
		$this->afectadosli = mysqli_affected_rows($this->conexionli);
		return $this->afectadosli;
	}

	public function closeli(){
		mysqli_close($this->conexionli);
	}
}
?>