<?php
//Clase Menu
class Menu{
	private $enlace = array();
	private $titulos = array();
	public $Aul;
	public $Cul;
	
	public function aUl(){
		echo $this->Aul = "<ul>";
	}
	public function cUl(){
		echo $this->Cul = "</ul>";
	}
	
	public function cargaDatos($en,$ti){
		$this->enlace[] = $en;
		$this->titulos[] = $ti;
	}
	public function muestraMenu($i,$css){
		switch($css){
			case 0:
			echo $this->vinculo = '<li><a href="'.$this->enlaces[$i].'">'.$this->titulos[$i].'</a></li>';
			break;
			case 1:
			echo $this->vinculo = '<li><a class="MenuBarItemSubmenu" href="'.$this->enlaces[$i].'">'.$this->titulos[$i].'</a></li>';
			break;
		}
		return ($this->vinculo);
	}

}
?>

<?php
$menuP = new Menu();
$menuP->cargaDatos('#','Movimientos');
$menuP->cargaDatos('#','Reportes');
$menuP->cargaDatos('#','Admin');
$menuP->cargaDatos('#','Salir');

$Movimientos = new Menu();
$Movimientos->cargaDatos('#','Entradas');
$Movimientos->cargaDatos('#','Salidas');

$Entrada = new Menu();
$Entrada->cargaDatos('#','Acta de Recepcion');
$Entrada->cargaDatos('#','Recepcion');

$Salida = new Menu();
$Salida->cargaDatos('#','Pase de Salida');
$Salida->cargaDatos('#','Devolucion');
$Salida->cargaDatos('#','Asignacion');

$Reportes = new Menu();
$Reportes->cargaDatos('#','Inventario');
$Reportes->cargaDatos('#','Inv. CGA Gral');
$Reportes->cargaDatos('#','Asignaciones');
$Reportes->cargaDatos('#','Entradas');
$Reportes->cargaDatos('#','Salidas');

$Inventario = new Menu();
$Inventario->cargaDatos('#','Inventario General');
$Inventario->cargaDatos('#','Full');
$Inventario->cargaDatos('#','Por Consignatario');
$Inventario->cargaDatos('#','Por Linea');
$Inventario->cargaDatos('#','Por Linea 20');
$Inventario->cargaDatos('#','Por Linea 40');
$Inventario->cargaDatos('#','Por Linea DMG');
$Inventario->cargaDatos('#','Por Ubicacion');

$Cgagral = new Menu();
$Cgagral->cargaDatos('#','General');
$Cgagral->cargaDatos('#','Consignatario');
$Cgagral->cargaDatos('#','B/L');
$Cgagral->cargaDatos('#','Lote');

$menuP->aUl();
$menuP->muestraMenu(0,1);//Movimientos
$Movimientos->aUl();
$Movimientos->muestraMenu(0,1);//Entradas
$Entrada->aUl();
$Entrada->muestraMenu(0,0);
$Entrada->muestraMenu(1,0);
$Entrada->cUl();
$Movimientos->muestraMenu(1,1);//Salidas
$Salida->aUl();
$Salida->muestraMenu(0,0);
$Salida->muestraMenu(1,0);
$Salida->muestraMenu(2,0);
$Salida->cUl();
$Movimientos->cUl();
$menuP->muestraMenu(1,1);//Reportes
$Reportes->aUl();
$Reportes->muestraMenu(0,1);//Reportes Inventario
$Inventario->aUl();
$Inventario->muestraMenu(0,0);
$Inventario->muestraMenu(1,0);
$Inventario->muestraMenu(2,0);
$Inventario->muestraMenu(3,0);
$Inventario->muestraMenu(4,0);
$Inventario->muestraMenu(5,0);
$Inventario->muestraMenu(6,0);
$Inventario->muestraMenu(7,0);
$Inventario->cUl();
$Reportes->muestraMenu(1,1);//Reportes Inventario CGA GRAL
$Cgagral->aUl();
$Cgagral->muestraMenu(0,0);
$Cgagral->muestraMenu(1,0);
$Cgagral->muestraMenu(2,0);
$Cgagral->muestraMenu(3,0);
$Cgagral->cUl();
$Reportes->muestraMenu(2,0);//Reportes Asignaciones
$Reportes->muestraMenu(3,0);//Reportes Entradas
$Reportes->muestraMenu(4,0);//Reportes Salidas
$Reportes->cUl();
$menuP->muestraMenu(2,0);//Admin
$menuP->muestraMenu(3,0);//Salir
$menuP->cUl();
?>