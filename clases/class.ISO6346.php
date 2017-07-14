<?php
//=======================================================================
// Archivo:	digitoChequeo_class.php
// Descripción:	Clase para validar el digito de chequeo de los contenedores maritimos
// Created: 	2011-06-29
// Ver:		1.0
//
// Autor:  Laymont Arratia. Email: laymontarratia@hotmail.com
// Copyright : Laymont Arratia.
//========================================================================
/*
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
//========================================================
// Nota: Esta clase puede ser usada libremente, solo
// agradesco dejar este comentario como un agradecimiento
//========================================================

//===============================================================
// CLASS CHECKDigit
// Se debe indicar el numero de contenedor de 10 o 11 caracteres.
//===============================================================
class CHECKDigit{
	public $Equipo;
	public $Dueno;
	public $Serial;
	public $Chequear_Digito;
	public $Resultado_Digito;
	public $Chequeo;
	public $MsgError;
	
	private function tablasChequeo(){
		//Valores del Texto
		$this->tablaValores = array(10 =>"A",12 =>"B",13 =>"C",14 =>"D",15 =>"E",16 =>"F",17 =>"G",18 =>"H",19 =>"I",20 =>"J",21 =>"K",23 =>"L",24 =>"M",25 =>"N",26 =>"O",27 =>"P",28 =>"Q",29 =>"R",30 =>"S",31 =>"T",32 =>"U",34 =>"V",35 =>"W",36 =>"X",37 =>"Y",38=>"Z");
		//Factores de multiplicacion
		$this->tablaFactor = array (1,2,4,8,16,32,64,128,256,512);
		return;
	}
	
	public function dameNumero($contenedor){
		$str = trim($contenedor);
		$this->Equipo = strtoupper($str);
		if(strlen($this->Equipo) > 11){
			
			return die("El numero indicado supera la cantidad de caracteres permitidos (11)");
		}else {
			if(substr($this->Equipo,3,1) != "U"){
				
				return die("La 4ta Sigla del numero indicado es invalida");
			}else {
				$this->DigitoChequeo();
				return $this->Equipo;
			}
		}
	}
	
	private function descomponeNumero(){
		//Dueño
		$this->Dueno = substr($this->Equipo,0,3);
		$this->Serial = substr($this->Equipo,4,6);
		//Separar caracteres
		$this->Chart = array();
		$this->Chart[0] = substr($this->Equipo,0,1);
		$this->Chart[1] = substr($this->Equipo,1,1);
		$this->Chart[2] = substr($this->Equipo,2,1);
		$this->Chart[3] = substr($this->Equipo,3,1);
		$this->Chart[4] = substr($this->Equipo,4,1);
		$this->Chart[5] = substr($this->Equipo,5,1);
		$this->Chart[6] = substr($this->Equipo,6,1);
		$this->Chart[7] = substr($this->Equipo,7,1);
		$this->Chart[8] = substr($this->Equipo,8,1);
		$this->Chart[9] = substr($this->Equipo,9,1);
		$this->Chart[10] = substr($this->Equipo,10,1);
		//Digito a validar
		$this->Chequear_Digito = $this->Chart[10];
		return;
	}
	
	private function asignaValores(){
		$this->tablasChequeo();
		$this->descomponeNumero();
		//Valores numericos Dueño
		$this->Valores = array();
		for($i=0;$i<=count($this->Chart)-8;$i++){
			$this->Valores[] = array_search($this->Chart[$i],$this->tablaValores);
		}
		//Valores del numero de contenedor
		for($n=4;$n<=9;$n++){
			$this->Valores[] = $this->Chart[$n];
		}
		//Multiplica valores por factor
		$this->Resultado = array();
		for($r=0;$r<=9;$r++){
			$this->Resultado[]= $this->Valores[$r] * $this->tablaFactor[$r];
		}
		return $this->Resultado;
	}
	
	public function DigitoChequeo(){
		$this->asignaValores();
		$this->Digito = array_sum($this->Resultado) % 11;
		if($this->Digito == 10){
			$this->Resultado_Digito = 0;
		}else {
			$this->Resultado_Digito = $this->Digito;
		}
		return $this->Resultado_Digito;
	}
	
	public function comparaValida(){
		$this->descomponeNumero();
		if ($this->Chequear_Digito == $this->Resultado_Digito){
			return true;
		}else {
			self::getMensaje();
			return false;
		}
	}
	
	public function getMensaje(){
		$this->MsgError ="El Serial de contenedor (".$this->Equipo.") que esta usando es incorrecto. El Digito Validador correcto es (".$this->Resultado_Digito.")";
		return $this->MsgError;
	}
}
?>