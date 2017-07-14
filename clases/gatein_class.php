<?php
/* Clase GATE-IN, Movimiento de Entrada */
class Movimientos {
	var $Linea;
	var $Buque;
	var $Viaje;
	var $Equipo;
	var $Tipo;
	var $Estatus;
	var $Condicion;
	var $Consignatario;
	var $Bl;
	var $Fact;
	var $Precinto;
	var $Eir;
	var $Fdb;
	var $Fdm;
	var $Frd;
	var $Fdespims;
	var $Ubicacion;
	var $Obsevacion;
	
	public function tipoMovimiento($movTipo){
		switch($movTipo){
			case 1://Entrada Vacio
			//condicion
			break;
			case 2://Entrada Full
			//Condicion
			break;
			case 3://Vaciado
			//Condicion
			break;
			case 4://Despacho
			//Condicion
			break;
			case 5://Devolucion
			//Condicion
			break;
			case 6://Asignacion
			//Condicion
			break;
			return $this->condicion; //condicion
		}
	}
	
	public function entradaVacio(){
		$this->Linea = 1; //$linea;
		$this->Buque = 2; //$buque;
		$this->Viaje = 3; //$viaje;
		$this->Tipo = 4; //$tipo;
		$this->Equipo = 'FSCU3259761'; //$equipo;
		$this->Fdm = '2011-06-25'; //$fdm;
		$this->Frd = '2011-06-27'; //$frd;
		$this->Eir = 123456; //$eir;
		$this->Estatus = 0; //$estatus;
		$this->Condicion = 3; //$condicion;
		$this->Ubicacion = 1; //$ubicacion;
		$this->Consignatario = 123; //$consignatario;
		$this->Obsevacion = 'S/O'; //$obs;
		$this->Auditoria = 1;
		
		$SQL = "INSERT INTO inventario(linea,buque,viaje,tcont,contenedor,fdm,frd,eir_r,`status`,condicion,ubicacion,consignaario,obs,auditoria)
				VALUES(%d,%d,%d,%d,%s,%s,%s,%d,%d,%d,%d,%d,%s,%d)";
		printf($SQL,$this->Linea,$this->Buque,$this->Viaje,$this->Tipo,$this->Equipo,$this->Fdm,$this->Frd,$this->Eir,$this->Estatus,$this->Condicion,$this->Ubicacion,$this->Consignatario,$this->Obsevacion,$this->Auditoria);
	}
}
$test = new Movimientos();
$test->entradaVacio();
?>