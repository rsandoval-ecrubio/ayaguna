<?php

require('mygeneric_class.php');

class Movimiento{
	
	public $_linea;
	public $_buque;
	public $_viaje;
	public $_Consignatario;
	public $_fdm;
	public $_frd;
	public $_contenedor;
	public $_tipo;
	public $_status;
	public $_condicion;
	public $_eirr;
	public $_ubicacion;
	public $_bl;
	public $_precinto;
	public $_factura; #Factura de la Naviera
	public $_pasenaviera; #Pase  de la Naviera
	public $_observacion;
	public $_auditoria;
		
	public  function validarcontenedor($contenedor){
		$validar = new DBMySQL();
		$validar->nombreDB($_SESSION['variables']['db']);
		$qvalida = sprintf("SELECT COUNT(contenedor) AS Validado FROM inventario WHERE c = 0 AND contenedor = '%s'",$contenedor);
		$validar->consultarDB($qvalida);
		return $validar->resultado['Validado'];
	}
	
	public function entradaVacios($linea,$buque,$viaje,$consignatario,$fdm,$frd,$contenedor,$tipo,$status,$condicion,$eirr,$ubicacion,$bl,$precinto,$factura,$pasenaviera,$observacion,$auditoria){
		
		$this->_linea = $linea;
		$this->_buque = $buque;
		$this->_viaje = $viaje;
		$this->_Consignatario = $consignatario;
		$this->_fdm = $fdm;
		$this->_frd = $frd;
		$this->_contenedor = $contenedor;
		$this->_tipo = $tipo;
		$this->_status = $status;
		$this->_condicion = $condicion;
		$this->_eirr = $eirr;
		$this->_ubicacion = $ubicacion;
		$this->_bl = $bl;
		$this->_precinto = $precinto;
		$this->_factura = $factura;
		$this->_pasenaviera = $pasenaviera;
		$this->_observacion = $observacion;
		$this->_auditoria = $auditoria;
	}
}
?>