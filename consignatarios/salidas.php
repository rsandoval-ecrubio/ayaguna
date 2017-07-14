<?php require_once('../Connections/conexion.php'); ?>
<?php
session_start();
require_once('../Connections/conexion.php');
require_once('../funciones/funciones.php');
//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d");

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_dsp = "-1";
if (isset($_POST['date1'])) {
  $colname_dsp = $_POST['date1'];
}
$colname1_dsp = "-1";
if (isset($_POST['date2'])) {
  $colname1_dsp = $_POST['date2'];
}
//DEBE CORREGIRSE
$linea = $_SESSION['linea'];
//DEBE CORREGIRSE
mysql_select_db($database_conexion, $conexion);
$query_dsp = sprintf("SELECT contenedor, tipo, estatus, condicion, eirR, descarga, recepcion, devolucion, eirD, ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = $linea AND c = 1 AND devolucion BETWEEN %s AND %s", GetSQLValueString($colname_dsp, "date"),GetSQLValueString($colname1_dsp, "date"));
$dsp = mysql_query($query_dsp, $conexion) or die(mysql_error());
$row_dsp = mysql_fetch_assoc($dsp);
$totalRows_dsp = mysql_num_rows($dsp);

if(isset($_POST['date1'])){
	$fecha1 = $_POST['date1'];
}else {
	$fecha1 = $ahora;
}
if(isset($_POST['date2'])){
	$fecha2 = $_POST['date2'];
}else {
	$fecha2 = $ahora;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="../js/validaciones.js"></script>
<script src="../js/sorttable.js"></script>
<link href="../SpryAssets/SpryMenuBarhorizontal.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../css/DatePicker.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/DatePicker.js" type="text/javascript"></script>
<script type="text/javascript">  
// The following should be put in your external js file,
// with the rest of your ondomready actions.
 
window.addEvent('domready', function(){
	$$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});
});
</script>
<style type="text/css">
#inv {
	border: 1px solid #9FB6CD;
}
#inv tr td {
	border: 1px solid #E0EEEE;
}
</style>
</head>
<body onload="KW_doClock()">
<div id="wrapper">
  <div id="header">
    <div id="titulo"><span id="nombre">IMSSis</span> <span id="version">v.1.0.1</span></div>
    <div id="clock"><script language='JavaScript'>
// Kaosweaver Live Clock Start
function class_clock(f,s,c,b,w,h,d,m,g,z) { // Copyright 2002 by Kaosweaver, All rights reserved
	this.b=b;this.w=w;this.h=h;this.d=d;this.g=g;this.z=z
	this.o='<font style="color:'+c+'; font-family:'+f+'; font-size:'+s+'pt;">';
if (m==1) this.o+=0
}
var clock=new class_clock("Verdana, Geneva, sans-serif","12","#000000","#FFFFFF","84",1,1,0,0,0)
// If the clock's size needs adjusting, change the 84 above.
d=document
if (d.all || d.getElementById) {d.write('<span id="activeClock" style="width:'+clock.w+'px; "></span>'); }
else if (d.layers) {d.write('<ilayer  id="wrapClock"><layer width="'+clock.w+'" id="activeClock"></layer></ilayer>'); }
else {KW_doClock(1);}
function KW_doClock(a) { // Copyright 2003 by Kaosweaver, All rights reserved
	d=document;t=new Date();p="";dClock="";	if (d.layers) d.wrapClock.visibility="show";
	tD=(t.getTimezoneOffset()-(clock.z*60))*clock.g;t.setMinutes(tD+t.getMinutes())
	h=t.getHours();m=t.getMinutes();s=t.getSeconds();if (clock.h)
	 {p=(h>11)?"PM":"AM";h=(h>12)?h-12:h;h=(h==0)?12:h;}if (clock.d)
	 {m=(m<=9)?"0"+m:m; s=(s<=9)?"0"+s:s;} dClock = clock.o+h+':'+m+':'+s+' '+p+'</font>';
	if (a) {d.write(dClock);}if (d.layers) {wc = document.wrapClock;lc = wc.document.activeClock;
		lc.document.write(dClock);lc.document.close();
	} else if (d.all) {	activeClock.innerHTML = dClock;
	} else if (d.getElementById) {d.getElementById("activeClock").innerHTML = dClock;}
	if (!a) setTimeout("KW_doClock()",1000);
}

// Kaosweaver Live Clock End
      </script>
      <!-- KW Live Clock -->
    </div>
  </div>
  <div id="showUser">Usuario: <?php echo $_SESSION['nombreusuario']; ?></div>
 <div id="nav">
   <ul id="MenuBar1" class="MenuBarVertical">
     <li><a href="index.php">Regresar</a>      </li>
</ul>
 
 </div>
  <div id="content">
    <h2>DEVOLUCIONES</h2>
    <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <table width="580">
        <tr>
          <td>Fechas entre:</td>
          <td><input name="date1" type="text" class="DatePicker" id="date1" value="<?php echo $fecha1; ?>" size="16" /></td>
          <td><div align="center">y </div></td>
          <td><input name="date2" type="text" class="DatePicker" id="date2" value="<?php echo $fecha2; ?>" size="16" /></td>
          <td><input type="submit" name="button" id="button" value="Mostrar" /></td>
        </tr>
      </table>
    </form>
    <?php if ($totalRows_dsp > 0) { // Show if recordset not empty ?>
    <p><span><a href="exportar_salidas.php?date1=<?php echo $_POST['date1'];?>&amp;date2=<?php echo $_POST['date2'];?>">Exportar a Excel</a><a href="#" onmouseover="msjDiv"></a></span> | Total de equipos listado: <?php echo $totalRows_dsp ?></p>
    <div id="msj" style="visibility:hidden">En Construccion</div>
    <table width="100%" class="sortable" id="inv">
      <tr>
        <th scope="col"><a href="#">Contenedor</a></th>
        <th width="4%" scope="col"><a href="#">Tipo</a></th>
        <th scope="col"><a href="#">Estatus</a></th>
        <th width="3%" scope="col"><a href="#">Condicion</a></th>
        <th scope="col"><a href="#">EIR</a></th>
        <th width="6%" scope="col"><a href="#">Descargado</a></th>
        <th width="8%" scope="col"><a href="#">Rececpcion</a></th>
        <th width="8%" scope="col"><a href="#">Devolucion</a></th>
        <th scope="col"><a href="#">EIR</a></th>
        <th scope="col"><a href="#">Ubicacion</a></th>
        <th scope="col"><a href="#">Observacion</a></th>
        <th scope="col"><a href="#">Linea</a></th>
        <th scope="col"><a href="#">Buque</a></th>
        <th scope="col"><a href="#">Viaje</a></th>
        <th scope="col"><a href="#">D-Pais</a></th>
        <th scope="col"><a href="#">D-Patio</a></th>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row_dsp['contenedor']; ?></td>
        <td><?php echo $row_dsp['tipo']; ?></td>
        <td><?php echo $row_dsp['estatus']; ?></td>
        <td><?php cdt($row_dsp['condicion']); ?></td>
        <td><?php echo $row_dsp['eirR']; ?></td>
        <td><?php echo $row_dsp['descarga']; ?></td>
        <td><?php echo $row_dsp['recepcion']; ?></td>
        <td><?php echo $row_dsp['devolucion']; ?></td>
        <td><?php echo $row_dsp['eirD']; ?></td>
        <td><?php echo $row_dsp['ubicacion']; ?></td>
        <td width="18%"><?php echo $row_dsp['obs']; ?></td>
        <td><?php echo $row_dsp['linea']; ?></td>
        <td><?php echo $row_dsp['buque']; ?></td>
        <td><?php echo $row_dsp['viaje']; ?></td>
        <td><?php alarmapais($row_dsp['DIC']); ?></td>
        <td><?php alarma($row_dsp['DIY']); ?></td>
      </tr>
      <?php } while ($row_dsp = mysql_fetch_assoc($dsp)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
    <p>&nbsp;</p>
  </div>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
