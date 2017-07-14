<?php
//session_start();
require('../config.php');
require('../clases/mygeneric_class.php');
require('../clases/digitoChequeo_class.php');
$muestra = 0;
$msg = NULL;
$deny = NULL;
if(!empty($_POST['seriales']) and $_POST['buque'] <> 0 and !empty($_POST['fecha']) and !isset($_POST['consulta'])){
	$_SESSION['fecha'] = $_POST['fecha'];
	$_SESSION['seriales'] = trim($_POST['seriales']);
	$buque = $_POST['buque'];
	
	$string = preg_split("/[\s,]+/",$_SESSION['seriales']);
	$tstring = count($string);
	//si es solo un contenedor
	if($tstring == 1){
		//evaluar serial
		$evaluar = new CHECKDigit();
		$evaluar->dameNumero($_SESSION['seriales']);
		if($evaluar->comparaValida() == 1){
			$cadena = "'".$_SESSION['seriales']."'";
		}else {
			die("<input type='button' value='Atras' onClick='history.go(-1);'>");
		}
	}else{
		$istring = implode("','",$string);
		$cadena = "'".$istring."'";
	}
	//Verificar contenedores
	$verificar = new DBMySQL();
	$verificar->nombreDB($_SESSION['variables']['db']);
	$verificar->consultarDB(sprintf("SELECT contenedor FROM inventario WHERE contenedor IN(%s) AND c = 1 AND fdespims = '%s'",$cadena,$_SESSION['fecha']));
	if($verificar->total == $tstring){
		$deny = 0;
		//Reintegro de Asignacion
		if($buque == -1){
			unset($_SESSION['query']);
			$_SESSION['query'] = sprintf("UPDATE inventario SET fdespims = NULL, c = 0 WHERE contenedor IN(%s) AND c = 1 AND fdespims = '%s'",$cadena,$_SESSION['fecha']);
		}else if($buque > 0){
			//Reintegro de Devolucion
			unset($_SESSION['query']);
			$_SESSION['query'] = sprintf("UPDATE inventario SET fdespims = NULL, buqued = NULL, c = 0 WHERE contenedor IN(%s) AND c = 1 AND buqued =%d AND fdespims = '%s'",$cadena,$buque,$_SESSION['fecha']);
		}else{
			unset($_SESSION['query']);
			$_SESSION['query'] = -1; 
		}
		
		$msg = "<h3>Se van a reintegrar al inventario los siguientes contenedores:</h3>";
	
	}else if($verificar->total == 0){
		$deny = 1;
		$msg = "<h3>Imposible hacer el reintegro</h3>";
		$msg .= "<h4>El o los contenedores no se encuentrar en la base de datos, o los datos no concuerdan</h4>";
	
	}else if($verificar->total <> $tstring and $verificar->total > 0){
		$deny = 2;
		$msg = "<h3>Imposible hacer el reintegro</h3>";
		$msg .= "<h4>Posiblemente: Uno o mas contenedores aun esten en inventario, o no se encuentran en la base de datos</h4>"; 
		do {
			$res[] = $verificar->resultado['contenedor'];
		}while($verificar->resultado = mysql_fetch_assoc($verificar->consulta));
		
		$existentes = array_diff_assoc($res,$string);
		$existentes = implode(",",$existentes);
		$msg .= "<h2>Contenedores en la base de datos:<br>";
		$msg .= $existentes."</h2>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reintegro</title>
<style type="text/css">
.edit {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
}
</style>
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php'); ?>
<?php if(!isset($_POST['consulta'])){ ?>
<p><a href="reintegro.php">Regresar</a></p>
<?php } ?>
<?php if(isset($_POST['consulta'])){ ?>
<p><a href="vaciar_variables.php">Regresar</a></p>
<?php } ?>
<p><?php echo $msg; ?></p>
<?php if($deny == 0){ ?>
<form id="form1" name="form1" method="post" action="vaciar_variables.php">
  <p><span style="font-size:14px;"><?php echo strtoupper(nl2br($_SESSION['seriales'])); ?></span> </p>
    	<p>
    	  <input name="consulta" type="hidden" id="consulta" value="1" />
    	  <input type="submit" name="button" id="button" value="Continuar" />
  	  </p>
</form>
<?php }else if($deny == 3){
	//echo $_POST['consulta'];
	echo strtoupper(nl2br($_SESSION['seriales']));
	echo "<h2>Reintegro realizado</h2>";
}?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>