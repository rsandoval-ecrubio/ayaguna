<?php
if(class_exists(MySQL)){

}else {
	require_once('../clases/class.MySQL.php');
}

if(isset($_GET['linea']) and $_GET['linea'] !=0){
	//Buques
	$buquesSel = new MySQL(USERDB);
	$buquesSel->Consultar("SELECT id, nombre FROM buques WHERE linea =".$_GET['linea']." AND activo=0;");
	echo '<select name="buque" id="buque">';
	echo '<option value="0">Elige</option>';
	do {
		echo '<option value="'.$buquesSel->Resultado['id'].'">'.htmlentities($buquesSel->Resultado['nombre']).'</option>';
	}while($buquesSel->Resultado = mysqli_fetch_assoc($buquesSel->Consulta));
}

if(isset($_GET['buque']) and $_GET['buque'] !=0){
	//Viajes
	$viajesSel = new MySQL(USERDB);
	$viajesSel->Consultar("SELECT id, viaje FROM viajes WHERE buque =".$_GET['buque']." AND activo=0;");
	echo '<select name="viaje" id="viaje">';
	echo '<option value="0">Elige</option>';
	do {
		echo '<option value="'.$vaijesSel->Resultado['id'].'">'.htmlentities($viajesSel->Resultado['viaje']).'</option>';
	}while($viajesSel->Resultado = mysqli_fetch_assoc($viajesSel->Consulta));
}
?>