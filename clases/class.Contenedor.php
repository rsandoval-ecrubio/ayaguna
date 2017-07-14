<?php
/* Clase para correccion de datos de contenedor */

require('mygeneric_class.php');

class Contenedor{
	
	public $_idcontenedor;
	private $_contenedor;
	public $_tipo;
	public $_estatus;
	public $_condicion;
	public $_eirin;
	public $_consignatario;
	public $_frd;
	public $_patio;
	public $_obs;
	public $_eirout;
	public $_estatusout;
	public $_fdesp;
	public $_total;
	
	public function getDatos($equipo){
		#Funcion para obtener los datos para editar del contenedor
		$datos = new DBMySQL();
		$datos->nombreDB($_SESSION['variables']['db']);
		$datos->consultarDB(sprintf("SELECT inventario.id, inventario.contenedor, tequipos.tipo AS tcont, IF(inventario.`status` = 0,'EMPTY','FULL') AS estatus, CASE inventario.condicion WHEN 0 THEN 'DMG' WHEN 1 THEN 'OPR1' WHEN 2 THEN 'OPR2' WHEN 3 THEN 'OPR3' WHEN 4 THEN 'N-OPR' END AS condicion,
inventario.eir_r, 
consignatario.nombre AS `consignatario`, 
inventario.frd, 
patios.patio, 
inventario.eir_d, IF(inventario.`status` = 0,'EMPTY','FULL') AS status_d,
inventario.fdespims, inventario.obs
FROM inventario, tequipos, consignatario, patios
WHERE inventario.contenedor = '%s' AND inventario.tcont = tequipos.id AND inventario.`consignatario` = consignatario.id AND inventario.patio = patios.id AND inventario.c = 0", $equipo));
		$this->_idcontenedor = $datos->resultado['id'];
		$this->_contenedor = $datos->resultado['contenedor'];
		$this->_tipo = $datos->resultado['tcont'];
		$this->_estatus = $datos->resultado['estatus'];
		$this->_condicion = $datos->resultado['condicion'];
		$this->_eirin = $datos->resultado['eir_r'];
		$this->_consignatario = $datos->resultado['consignatario'];
		$this->_frd = $datos->resultado['frd'];
		$this->_patio = $datos->resultado['patio'];
		$this->_obs = $datos->resultado['obs'];
		$this->_eirout = $datos->resultado['eir_d'];
		$this->_estatusout = $datos->resultado['status_d'];
		$this->_fdesp = $datos->resultado['fdepims'];
		$this->_total = $datos->total;
	}
	
	public function getContenedor(){
		return $this->_contenedor;
	}
}
?>