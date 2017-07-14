<?php
/*
Equipos secos
elevadora entrada y salida 160 bs
10 primero dias manejo 1800 bs
11->20 bs 170
21->30 bs 160
31->45 libre
46-> bs 140
Equipos refrigerados
elevadora entrada y salida 160 bs
10 primero dias manejo 2300 bs
11-> bs 220
*/

class Preliquidar{
	public $tarifabase;
	public $elevadora;
	public $tipo;
	public $tarifaM10;
	public $tarifaM20;
	public $tarifaM30;
	public $tarifaM45;
	
	public $calculo;
	public $dias;
	
	public $aM10;
	public $aM20;
	public $aM30;
	public $aM45;
	public $resultados;
	
	
	public function DatosEquipo($acta,$equipo){
		if($acta <> NULL and $equipo <> NULL){
			require_once('class.MySQL.php');
			$datos = new MySQL(USERDB);
			$consulta = sprintf("SELECT inventario.id, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, viajes.eta, inventario.acta, inventario.eir_r, inventario.contenedor, tequipos.tipo, inventario.frd, consignatario.nombre AS consig, DATEDIFF(curdate(),inventario.frd) AS dias
FROM inventario, tequipos, lineas, buques, viajes, consignatario
WHERE inventario.c = 0 AND consignatario.id = inventario.`consignatario`AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.`status` = 1 AND inventario.c = 0 AND inventario.acta = %d AND inventario.contenedor = '%s';",$acta,$equipo);
			$datos->Consultar($consulta);
			$this->Tipo($datos->Resultado['tipo']);
			$this->dias = $datos->Resultado['dias'];
			$this->Dias($this->dias);
			$this->resultados = $datos->Resultado;
		}
		return $this->resultados;
	}
	
	private function TarifasDC(){
		$this->tarifabase = 1800;
		$this->elevadora = 160 * 2;
		$this->tarifaM10 = 170;
		$this->tarifaM20 = 160;
		$this->tarifaM30 = 0;
		$this->tarifaM45 = 140;
		return;
	}
	
	private function TarifasRF(){
		$this->tarifabase = 2300;
		$this->elevadora = 160 * 2;
		$this->tarifaM10 = 220;
		return;
	}
	
	private function Tipo($var){
		$this->tipo = substr($var, 4);
		switch($this->tipo){
			case 'DC':
				$this->TarifasDC(); $this->calculo = 1; 
			break;
			case 'RF':
				$this->TarifasRF(); $this->calculo = 2;
			break;
			
		}
	}
	
	private function Dias($valor){
		if($this->calculo == 1){
			#Mas de 10 dias hasta 20 dias TIPO DC
			if($valor < 10 and $valor == 10){
				$this->aM10 = 0;
			}else if($valor >10 and $valor < 21){
				$var = $valor - 10;
				$this->aM10 = $this->tarifaM10 * $var;
			}else if($valor > 10 and $valor > 20){
				$this->aM10 = $this->tarifaM10 * 10;
			}
		}else if($this->calculo == 2){
			#Mas de 10 dias hasta 20 dias TIPO RF
			if($valor > 10){
				$var = $valor -10;
				$this->aM10 = $this->tarifaM10 * $var;
			}
		}
				
		#Mas de 20 dias hasta 30 dias
		if($valor > 20 and $valor< 31){
			$var = $valor - 20;
			$this->aM20 = $this->tarifaM20 * $var;
		}else if($valor > 20 and $valor > 30) {
			$this->aM20 = $this->tarifaM20 * 10;
		}else {
			$this->aM20 = 0;
		}
		
		#Mas de 30 dias y hasta 45 dias
		if($valor > 30 and $valor < 46){
			$var = $valor - 30;
			$this->aM30 = $this->tarifaM30 * $var;
		}else if($valor > 30 and $valor > 45){
			$this->aM30 = $this->tarifaM30 * 15;
		}else {
			$this->aM30 = 0;
		}
		
		#Mas de 45 dias
		if($valor > 45){
			$var = $valor - 45;
			$this->aM45 = $this->tarifaM45 * $var;
		}else {
			$this->aM45 = 0;
		}
		return;
	}

}
?>