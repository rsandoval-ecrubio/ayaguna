<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();

//Eliminar acarreos realizados
mysql_select_db($database_conexion, $conexion);
$sqlsrch = "SELECT acarreo FROM devtemp WHERE dev = 0";
$sqlsrchrun = mysql_query($sqlsrch, $conexion) or die(mysql_error());
$sqlsrchfiles = mysql_fetch_assoc($sqlsrchrun);
$sqlsrchtotal = mysql_num_rows($sqlsrchrun);
//echo $sqlsrchtotal;
if($sqlsrchtotal > 0){
	$mostrar = $sqlsrchtotal;
	do {
		$devtxt = sprintf("SELECT * FROM existenciadevolucion WHERE id IN(%s)",$sqlsrchfiles['acarreo']);
		$devsql = mysql_query($devtxt, $conexion) or die(mysql_error()." Error en consulta para actualizar DEVTEMP");
		$devfiles = mysql_fetch_assoc($devsql);
		$devtotal = mysql_num_rows($devsql);
		if($devtotal == 0){
			$updtemptxt = sprintf("UPDATE devtemp SET dev = 1 WHERE acarreo = '%s'",$sqlsrchfiles['acarreo']);
			$updtemprun = mysql_query($updtemptxt, $conexion) or die(mysql_error()." ->Error al actualizar DEVTEMP");
		}
	}while ($sqlsrchfiles = mysql_fetch_assoc($sqlsrchrun));
}



mysql_select_db($database_conexion, $conexion);
$sqltxt = "SELECT * FROM devtemp WHERE dev = 0";
$sqlrun = mysql_query($sqltxt, $conexion) or die(mysql_error());
$sqlfiles = mysql_fetch_assoc($sqlrun);
$sqlfilestotal = mysql_num_rows($sqlrun);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="content">
	<div id="modulo_title">
			<h2>PRE - Acarreos</h2>
	  </div><?php if($sqlfilestotal > 0) { ?>
    <table width="300" cellpadding="2" cellspacing="2">
          <caption>
            Guardados
      </caption>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Fecha</th>
            <th colspan="2" scope="col">Cant/Contenedores</th>
          </tr><?php do { ?>
          <tr>
            <td align="center"><?php echo $sqlfiles['id']; ?>&nbsp;</td>
            <td align="center"><?php echo $sqlfiles['fecha']; ?>&nbsp;</td>
            <td align="right"><?php echo substr_count($sqlfiles['acarreo'],',')+1; ?>&nbsp;</td>
            <td align="center"><a href="gateout_form.php?ids=<?php echo urlencode($sqlfiles['acarreo']);?>">Ver</a></td>
          </tr>
          <?php } while($sqlfiles = mysql_fetch_assoc($sqlrun));?>
    </table><?php }else { echo "<h1>No hay listas guardadas</h1>"; } ?>
    <p>&nbsp;</p>
	</div>
</div>
</body>
</html>