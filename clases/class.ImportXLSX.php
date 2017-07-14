<?php
/* Clase para importar Archivo de excel a la Base de datos */

		
class ImportarXLSX{
	
	var $DatosExcel;
	var $ColumnasExcel;
	var $CantColumnasExcel;
	var $LetrasColumnas;
	var $FilasExcel;
	var $ColumnasDB;
	var $LBV;
	
	private $Idlinea;
	var $Linea;
	
	private $Idbuque;
	var $Buque;
	
	private $Idviaje;
	var $Viaje;
	
	var $aRegistrar;
	
	var $Insertado;
	
	function __construct(){
		//Conexion MySQL
		require('mygeneric_class.php');
		//Para crear Objetos PHPExcel
		require('PHPExcel/Classes/PHPExcel.php');
		require('PHPExcel/Classes/PHPExcel/IOFactory.php');
		//Columnas de la Base de Datos
		$this->ColumnasDB = array('linea','buque','viaje','equipo','tipo','precinto','peso','estatus','bl','consignatario');
		$this->LBV = array('A'=>NULL,'B'=>NULL,'C'=>NULL);
		$this->LetrasColumnas = array();
	}
	
	function Leer($file){
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$this->DatosExcel = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		//Nombres de las columnas de excel
		$this->ColumnasExcel = array_filter($this->DatosExcel[1]);
		//Cantidades de Filas de excel (Sin encabezados)
		$this->FilasExcel = count($this->DatosExcel) - 1;
		$this->LetraColumna();
		$this->Identificar();
	}
	
	private function Identificar(){
		//Identifica Linea, Buque y Viaje en el archivo de Excel
		//Linea
		$linea = array_search($this->ColumnasDB[0],$this->ColumnasExcel);
		$this->LBV['A'] = $this->Linea = $this->DatosExcel[2][$linea];
		$this->ValidarLinea();		
		//Buque
		$buque = array_search($this->ColumnasDB[1],$this->ColumnasExcel);
		$this->LBV['B'] = $this->Buque = $this->DatosExcel[2][$buque];
		$this->ValidarBuque();
		//Viaje
		$viaje = array_search($this->ColumnasDB[2],$this->ColumnasExcel);
		$this->LBV['C'] = $this->Viaje = $this->DatosExcel[2][$viaje];
		$this->ValidarViaje();
	}
	
	private function ValidarLinea(){
		$vlinea = new DBMySQL;
		$consultaLinea = "SELECT id, nombre FROM lineas WHERE activo = 0 AND nombre LIKE '%".$this->Linea."%'";
		$vlinea->consultarDBli(1,$consultaLinea);
		
		if($vlinea->totalli == 0){
			die("<h1>La linea no existe</h1>");
		}else if($vlinea->totalli == 1){
			$this->Idlinea = $vlinea->resultadoli['id'];
		}else{
			die("<h1>No se puede importar el Archivo::Error-Linea</h1>Comuniquese con el Administrador del Sistema");
		}
		return $this->Idlinea;
	}
	
	private function ValidarBuque(){
		$vbuque = new DBMySQL;
		$consultarBuque = "SELECT id,nombre FROM buques WHERE linea = ".$this->Idlinea." AND nombre LIKE '%".$this->Buque."%'";
		$vbuque->consultarDBli(1,$consultarBuque);
		
		if($vbuque->totalli == 0){
			die("<h1>Buque no existe</h1>");
		}else if($vbuque->totalli == 1){
			$this->Idbuque = $vbuque->resultadoli['id'];
		}else{
			die("<h1>No se puede importar el Archivo::Error-Buque</h1>Comuniquese con el Administrador del Sistema");
		}
		return $this->Idbuque;
	}
	
	private function ValidarViaje(){
		$vviaje = new DBMySQL;
		$consultaViaje = sprintf("SELECT id, viaje, eta FROM viajes WHERE buque = %d AND viaje = '%s'",$this->Idbuque,$this->Viaje);
		$vviaje->consultarDBli(1,$consultaViaje);
		
		if($vviaje->totalli == 0){
			die("<h1>viaje no existe</h1>");
		}else if($vviaje->totalli == 1){
			$this->Idviaje = $vviaje->resultadoli['id'];
			$this->DatosImportar();
		}else{
			//Para ver el id del viaje 13-12-2013
			echo $vviaje->resultadoli['id'];
			die("<h1>No se puede importar el Archivo::Error-Viaje</h1>Comuniquese con el Administrador del Sistema");
		}
		return $this->Idviaje;
	}
	
	private function LetraColumna(){
		//Abecedario
		for ($i=65;$i<=90;$i++){
			$letras[] = chr($i);
		}
		$this->CantColumnasExcel = count($this->ColumnasExcel) - 1;//10
		for($e=0;$e<=$this->CantColumnasExcel;$e++){
			$this->LetrasColumnas[] = $letras[$e];
		}
		return $this->LetrasColumnas;
	}
	
	private function DatosImportar(){
		unset($this->DatosExcel[1]);
		return $this->DatosExcel;
	}
	
	function Importar(){
		$ABC = array(0=>'A',1=>'B',2=>'C',3=>'D',4=>'E');
		
		for($x=0;$x<=4;$x++){
			unset($this->LBV[$ABC[$x]]);
			unset($this->ColumnasExcel[$this->LetrasColumnas[$x]]);
		}
		
		$this->LBV['A'] = $this->Idlinea;
		$this->LBV['B'] = $this->Idbuque;
		$this->LBV['C'] = $this->Idviaje;
		
		//Quitar columnas
		for($d=2;$d<=$this->FilasExcel+1;$d++){
			for($b=0;$b<=4;$b++){
				unset($this->DatosExcel[$d][$ABC[$b]]);
			}
		}
		
		for($r=2;$r<=$this->FilasExcel+1;$r++){

			$registros[] = array_merge($this->LBV,$this->DatosExcel[$r]);
		}
		
		
		$consulta ="INSERT INTO precarga (linea,buque,viaje,equipo,tipo,precinto,peso,bl,consig) VALUES "."\n";
		
		for($e=2;$e<=count($this->FilasExcel)-1;$e++){
		}
		
		foreach($registros as $clave=>$valor){
			$registroA[$clave] = implode("','",array_filter($valor));
			$consulta .= "('".$registroA[$clave]."'),"."\n";
		}  
		$this->aRegistrar = substr(trim($consulta),0,-1);
		
		return $this->aRegistrar;
	}
	
	function Insertar(){
		$insertar = new DBMySQL;
		$insertar->insertarDBli(1,$this->aRegistrar);
		
		if($insertar->afectadosli > 0){
			$normalizar = new DBMySQL;
			$normalizar->insertarDBli(1,"CALL `normalizaPrecarga`()");
			
			$listar = new DBMySQL;
			$listar->insertarDBli(1,"CALL `precarga_limpia`()");
			
			$borrar = new DBMySQL;
			$borrar->insertarDBli(1,"TRUNCATE `precarga`;");
			
			$this->Insertado = 1;
		}
		return $this->Insertado;
	}
	
}
?>