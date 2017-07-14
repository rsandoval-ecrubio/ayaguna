<?php
/* Clase para correccion de datos de contenedor */

require('mygeneric_class.php');

class Contenedor{
	public $Contenedor;
	public $Idcontenedor;
	public $Propiedades;
	public $Estado;
	public $Editables;
	private $Consulta;
	public $Manteriores;
	public $Tapariaciones;
	
	
	public function Datos($numero){
		$this->Contenedor = $numero;
		$datos = new DBMySQL;
		$datos->nombreDB(USERDB);
		$Qpropiedades = sprintf("SELECT * FROM inventario WHERE contenedor = '%s' ORDER BY id DESC",$this->Contenedor);
		$datos->consultarDB($Qpropiedades);
		$this->Propiedades = $datos->resultado;
		$this->Idcontenedor = $datos->resultado['id'];
		$this->Consulta = $datos->consulta;
		$this->Tapariaciones = $datos->total;
		$this->Aparicion();
		return $datos->resultado;
	}
	
	private function Aparicion(){
		if($this->Propiedades['c'] == 0){
			$this->Ininv();
		}else if($this->Propiedades['c'] == 1){
			$this->Outinv();
		}
	}
	
	private function Ininv(){
		$this->Editables = array(
									'id'=>$this->Idcontenedor,
									'contenedor'=>$this->Contenedor,
									'viaje'=>$this->Propiedades['viaje'],
									'tcont'=>$this->Propiedades['tcont'],
									'frd'=>$this->Propiedades['frd'],
									'eir_r'=>$this->Propiedades['eir_r'],
									'fact'=>$this->Propiedades['fact'],
									'status'=>$this->Propiedades['status'],
									'condicion'=>$this->Propiedades['condicion'],
									'precinto'=>$this->Propiedades['precinto'],
									'bl'=>$this->Propiedades['bl'],
									'patio'=>$this->Propiedades['patio'],
									'consignatario'=>$this->Propiedades['consignatario'],
									'obs'=>$this->Propiedades['obs'],
									'c'=>$this->Propiedades['c']
								);
		return $this->Editables;
	}
	
	
	private function Outinv(){
		$this->Editables = array(
									'id'=>$this->Idcontenedor,
									'contenedor'=>$this->Contenedor,
									'tcont'=>$this->Propiedades['tcont'],
									'frd'=>$this->Propiedades['frd'],
									'fact'=>$this->Propiedades['fact'],
									'status'=>$this->Propiedades['status'],
									'precinto'=>$this->Propiedades['precinto'],
									'bl'=>$this->Propiedades['bl'],
									'consignatario'=>$this->Propiedades['consignatario'],
									'buqued'=>$this->Propiedades['buqued'],
									'fdespims'=>$this->Propiedades['fdespims'],
									'c'=>$this->Propiedades['c']
								);
		return $this->Editables;
	}
	
	private function __detruct(){
		$this->Contenedor;
	}
}
?>
