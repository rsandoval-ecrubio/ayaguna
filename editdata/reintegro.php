<?php
//session_start();
require('../config.php');
require('../clases/mygeneric_class.php');
$pag = explode("/",$_SERVER['HTTP_REFERER']);
if(end($pag) == "index.php"){
	unset($_SESSION['error']);
	unset($_SESSION['fecha']);
	unset($_SESSION['seriales']);
	unset($_SESSION['query']);
}

$buques = new DBMySQL();
$buques->nombreDB($_SESSION['variables']['db']);
$buques->consultarDB("SELECT id, nombre FROM buques WHERE activo = 0");
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
<script type="text/javascript" language="javascript">
/**************************************************************
Máscara de entrada. Script creado por Tunait! (21/12/2004)
Si quieres usar este script en tu sitio eres libre de hacerlo con la condición de que permanezcan intactas estas líneas, osea, los créditos.
No autorizo a distribuír el código en sitios de script sin previa autorización
Si quieres distribuírlo, por favor, contacta conmigo.
Ver condiciones de uso en http://javascript.tunait.com/
tunait@yahoo.com 
****************************************************************/
var patron = new Array(4,2,2)
var patron2 = new Array(1,3,3,3,3)
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}
</script>
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php'); ?>
<a href="../admin/index.php">Regresar</a>
<form id="form1" name="form1" method="post" action="reintegro_end.php" style="margin-left:10px;">
  <p>Reintegro de Contenedor(es) al Almacen </p>
  <p>Serial(es) Contenedores: <br />
  <strong>Para reintegrar mas de un contenedor, por favor ingrese los numero de contenedor separados por linea (enter).</strong><br />
  <?php if(isset($_SESSION['error']) and $_SESSION['error'] == 1){ ?>
  </p>
  <h3 style="color:#F00;">El formulario que esta intentato enviar le faltan datos; verifique por favor.</h3>
  <?php } ?>
  <p>
    <label for="seriales"></label>
    <textarea name="seriales" id="seriales" cols="18" style="width:140px; height:140px;"><?php if(isset($_SESSION['seriales']) and !empty($_SESSION['seriales'])){echo strtoupper($_SESSION['seriales']);}?></textarea>
  </p>
  <?php  ?>
  <p>Buque
    <select name="buque" id="buque">
      <option selected="selected" value="-1">Por Asignacion</option>
      <?php do { ?>
      <option value="<?php echo $buques->resultado['id']; ?>"><?php echo $buques->resultado['nombre']; ?></option>
      <?php }while($buques->resultado = mysql_fetch_assoc($buques->consulta)); ?>
    </select>
  </p>
  <p>Fecha
    <label for="fecha"></label>
    <input name="fecha" type="text" id="fecha" onkeyup="mascara(this,'-',patron,true)"  />
  Ej.: 20130101</p>
  <p>
    <input type="submit" name="button" id="button" value="Enviar" />
  </p>
</form>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>