<?php
/*
Clase MySQL Orientada a Objetos
Para ser usada en Ayaguna
*/
class MySQL {
	
	private $Servidor = "localhost";
	private $Usuario = "appstc";
	private $Clave = "nVgXi3HT40";
	private $Dbli;
	public $MySQL;
	public $Consulta;
	public $Resultado;
	public $Total;
	
	public function MySQL($db){
		$this->Dbli = $db;
		$this->MySQL = new mysqli($this->Servidor,$this->Usuario,$this->Clave,$this->Dbli);
		 if($this->MySQL->connect_errno){
			 die("No se pudo conectar a MySQL, error: ".$this->MySQL->connect_error());
		 }else {
			 return $this->MySQL;
		 }
	}
	
	public function Consultar($sql){
		if(is_object($this->MySQL)){
			$this->Consulta = $this->MySQL->query($sql) or die($this->MySQL->error);;
			if($this->MySQL->errno){
				die("Error al consultar: ".$this->MySQL->errno."<br />".$this->MySQL->error);
			}
			
			$this->Resultado = $this->Consulta->fetch_assoc();
			$this->Total = $this->Consulta->num_rows;
		}else {
			die("No se a creado el Objeto MySQLi");
		}
	}
	
	public function Liberar(){
		$this->Consulta->free();
	}
	
	public function Cerrar(){
		$this->MySQL->close();
	}
}
?>