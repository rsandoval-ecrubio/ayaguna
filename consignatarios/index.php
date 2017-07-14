<?php
session_start();
require_once('../Connections/conexion.php');
require_once('../funciones/funciones.php');	
//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d");
if(!isset($_SESSION['autentificado']) and !isset($_GET['linea'])) {
	header("location:../../home/index.php");
}	
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

mysql_select_db($database_conexion, $conexion);
//DEBE CORREGIRSE
$linea = $_SESSION['linea'];
//DEBE CORREGIRSE
$query_cntg = "SELECT contenedor, tipo, estatus, condicion, eirR, descarga, recepcion,ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = '$linea' AND c = 0 ORDER BY descarga ASC";
$cntg = mysql_query($query_cntg, $conexion) or die(mysql_error());
$row_cntg = mysql_fetch_assoc($cntg);
$totalRows_cntg = mysql_num_rows($cntg);

$colname_track = "-1";
if (isset($_POST['number'])) {
  $colname_track = $_POST['number'];
}
mysql_select_db($database_conexion, $conexion);
$query_track = sprintf("SELECT contenedor, tipo, estatus, condicion, eirR, descarga, despacho, recepcion, devolucion, eirD, ubicacion, obs, linea, buque, viaje, DIC, DIY FROM consulta_x_consignatario WHERE consig_id = '$linea' AND contenedor = %s", GetSQLValueString($colname_track, "text"));
$track = mysql_query($query_track, $conexion) or die(mysql_error());
$row_track = mysql_fetch_assoc($track);
$totalRows_track = mysql_num_rows($track);
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
     <li><a href="entradas.php">Entradas</a>      </li>
     <li><a href="salidas.php">Salidas</a></li>
     <li><a href="#" class="MenuBarItemSubmenu">Por Tipo</a>
       <ul>
         <li><a href="invt20.php">Tipo 20'</a></li>
         <li><a href="invt40.php">Tipo 40'</a></li>
         <li><a href="invdmg.php">DMG</a></li>
       </ul>
     </li>
     <li><a href="../logout.php">Salir</a></li>
   </ul>
 
 </div>
  <div id="content">
    <form id="track" name="track" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <label for="number">Contenedor:</label>
          <input name="number" type="text" id="number" size="12" maxlength="11" onkeyup="this.value=this.value.toUpperCase()" onblur="validarContenedor(this.id, this.value)" />
          <label for="validacion">Check Digit:</label>
          <input name="validacion" type="text" class="txtImportante" id="validacion" size="1" readonly="readonly" />
      <input type="submit" name="trackButton" id="trackButton" value="Buscar" />
      <input type="submit" name="button" id="button" value="Limpiar" />
    </form>
    <?php if($totalRows_track > 0){?>
    <!-- Resultados del Tracking !-->
    <div id="trackresult">
      <h2>Resultados del Tracking</h2>
      <table width="100%">
        <tr>
          <th scope="col">Contenedor</th>
          <th width="5%" scope="col">Tipo</th>
          <th scope="col">Estatus</th>
          <th scope="col">Condicion</th>
          <th scope="col">EIR</th>
          <th width="8%" scope="col">Descargado</th>
          <th width="8%" scope="col">D-Muelle</th>
          <th width="8%" scope="col">Rececpcion</th>
          <th scope="col">Ubicacion</th>
          <th scope="col">Observacion</th>
          <th width="8%" scope="col">Devolución</th>
          <th scope="col">EIR</th>
          <th scope="col">Linea</th>
          <th scope="col">Buque</th>
          <th scope="col">Viaje</th>
          <th scope="col">D-Pais</th>
          <th scope="col">D-Patio</th>
        </tr>
        <?php do { ?>
        <tr>
          <td><?php echo $row_track['contenedor']; ?></td>
          <td><?php echo $row_track['tipo']; ?></td>
          <td><?php echo $row_track['estatus']; ?></td>
          <td><?php cdt($row_track['condicion']); ?></td>
          <td><?php echo $row_track['eirR']; ?></td>
          <td><?php echo $row_track['descarga']; ?></td>
          <td><?php echo $row_track['despacho']; ?></td>
          <td><?php echo $row_track['recepcion']; ?></td>
          <td><?php echo $row_track['ubicacion']; ?></td>
          <td width="18%"><?php echo $row_track['obs']; ?></td>
          <td><?php echo $row_track['devolucion']; ?></td>
          <td><?php echo $row_track['eirD']; ?></td>
          <td><?php echo $row_track['linea']; ?></td>
          <td><?php echo $row_track['buque']; ?></td>
          <td><?php echo $row_track['viaje']; ?></td>
          <td align="right"><?php alarmapais($row_track['DIC']); ?></td>
          <td align="right"><?php alarma($row_track['DIY']); ?></td>
        </tr><?php } while($row_track = mysql_fetch_assoc($track));?>
      </table>
    </div><?php }?> <!-- Resultados del Tracking !-->
    <?php if($totalRows_track == 0){?>
<p><a href="exportar_existencia.php">Exportar a Excel</a></p>
<table width="100%" class="sortable" id="inv">
  <thead>
    <tr>
      <th scope="col"><a href="#">Contenedor</a></th>
      <th scope="col"><a href="#">Tipo</a></th>
      <th scope="col"><a href="#">Estatus</a></th>
      <th scope="col"><a href="#">Condicion</a></th>
      <th scope="col"><a href="#">EIR</a></th>
      <th scope="col"><a href="#">Descargado</a></th>
      <th scope="col"><a href="#">Rececpcion</a></th>
      <th scope="col"><a href="#">Ubicacion</a></th>
      <th scope="col"><a href="#">Observacion</a></th>
      <th scope="col"><a href="#">Linea</a></th>
      <th scope="col"><a href="#">Buque</a></th>
      <th scope="col"><a href="#">Viaje</a></th>
      <th scope="col"><a href="#">D-Pais</a></th>
      <th scope="col"><a href="#">D-Patio</a></th>
    </tr>
  </thead>
  <tbody>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cntg['contenedor']; ?></td>
      <td><?php echo $row_cntg['tipo']; ?></td>
      <td><?php echo $row_cntg['estatus']; ?></td>
      <td><?php cdt($row_cntg['condicion']); ?></td>
      <td><?php echo $row_cntg['eirR']; ?></td>
      <td><?php echo $row_cntg['descarga']; ?></td>
      <td><?php echo $row_cntg['recepcion']; ?></td>
      <td><?php echo $row_cntg['ubicacion']; ?></td>
      <td width="18%"><?php echo $row_cntg['obs']; ?></td>
      <td><?php echo $row_cntg['linea']; ?></td>
      <td><?php echo $row_cntg['buque']; ?></td>
      <td><?php echo $row_cntg['viaje']; ?></td>
      <td align="right"><?php alarmapais($row_cntg['DIC']); ?></td>
      <td align="right"><?php alarma($row_cntg['DIY']); ?></td>
    </tr><?php } while ($row_cntg = mysql_fetch_assoc($cntg));?>
  </tbody>
</table>
<?php } ?>
  </div>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
