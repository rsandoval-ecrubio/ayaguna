<?php
session_start();
require('../config.php');
seguridad();
include('../clases/mygeneric_class.php');
?>
<?php
//Lineas
$qlineas = "SELECT lineas.id, lineas.nombre FROM inventario, lineas WHERE buqued IS NOT NULL AND inventario.linea = lineas.id GROUP BY Linea ORDER BY lineas.nombre";
$lineas = new DBMySQL();
$lineas->nombreDB($_SESSION['variables']['db']);
$lineas->consultarDB($qlineas);

if(isset($_GET)){
	//Variables
	$linea = $_GET['linea'];
	$fecha1 = $_GET['var'];
	$fecha2 = $_GET['var2'];
	
	//DEVOLUCION CON BUQUE
	$consulta = sprintf("SELECT inventario.linea, inventario.contenedor,tequipos.tipo, inventario.fdb,inventario.fdm,inventario.frd,inventario.eir_r,IF(inventario.`status`=0,'EMPTY','FULL') AS estatus,inventario.condicion,inventario.obs,inventario.fdespims,buques.nombre AS buque, inventario.viajed FROM inventario, buques, tequipos WHERE inventario.buqued IS NOT NULL AND inventario.buqued = buques.id AND tequipos.id = inventario.tcont AND inventario.linea = %d AND fdespims BETWEEN '%s' AND '%s' ORDER BY inventario.fdespims DESC",$linea,$fecha1,$fecha2);
	
	$devBu = new DBMySQL();
	$devBu->nombreDB($_SESSION['variables']['db']);
	$devBu->consultarDB($consulta);
	
	//Equipos de 20
	$q20 = sprintf("SELECT tequipos.tipo, COUNT(inventario.tcont) AS cant FROM inventario, tequipos WHERE inventario.buqued IS NOT NULL AND inventario.tcont = tequipos.id AND tequipos.tipo LIKE '2%%' AND inventario.linea = %d AND inventario.fdespims BETWEEN '%s' AND '%s' GROUP BY tequipos.tipo ORDER BY tequipos.tipo",$linea,$fecha1,$fecha2);
	$r20 = new DBMySQL();
	$r20->nombreDB($_SESSION['variables']['db']);
	$r20->consultarDB($q20);
	
	//Equipos de 40
	$q40 = sprintf("SELECT tequipos.tipo, COUNT(inventario.tcont) AS cant FROM inventario, tequipos WHERE inventario.buqued IS NOT NULL AND inventario.tcont = tequipos.id AND tequipos.tipo LIKE '4%%' AND inventario.linea = %d AND inventario.fdespims BETWEEN '%s' AND '%s' GROUP BY tequipos.tipo ORDER BY tequipos.tipo",$linea,$fecha1,$fecha2);
	$r40 = new DBMySQL();
	$r40->nombreDB($_SESSION['variables']['db']);
	$r40->consultarDB($q40);
	
}

$res20 = 0;
$res40 = 0;

//exportar a excel

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=reporte_egresos_buque.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<style type="text/css">
body,td,th {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
}
#resumen {
	border: 1px solid #CCC;
	padding: 4px;
}
#resumen tr th {
	background-color: #EEE;
}
#resumen tr td #re20 {
	border: 1px solid #333;
}
#resumen tr td #re40 {
	border: 1px solid #333;
}
#listado {
}
#listado thead tr th {
	background-color: #EEE;
	padding: 2px;
	border: 1px solid #000;
}
#listado tbody tr td {
	border: 1px solid #CCC;
}
</style>
</head>
<body>
  <div id="content">
<h2 align="center">MOVIMIENTOS DE SALIDA </h2>
<table width="400" align="center" class="resumen" id="resumen">
    <caption>
      Resumen
    </caption>
      <tr>
        <th>Equipos de 20&quot;</th>
        <th>Equipos de 40&quot;</th>
      </tr>
      <tr>
        <td valign="top"><table width="100%">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr><?php do{ ?>
          <tr>
            <td><?php echo $r20->resultado['tipo']; ?></td>
            <td><div align="right"><?php $res20 = $res20 + $r20->resultado['cant']; echo $r20->resultado['cant']; ?></div></td>
          </tr><?php }while($r20->resultado = mysql_fetch_assoc($r20->consulta)); ?>
<tr>
            <th>Sub-Total:</th>
            <th><?php echo $res20; ?>&nbsp;</th>
          </tr>
        </table></td>
        <td valign="top"><table width="100%">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr><?php do{ ?>
          <tr>
            <td><?php echo $r40->resultado['tipo']; ?></td>
            <td><div align="right"><?php $res40 = $res40 + $r40->resultado['cant']; echo $r40->resultado['cant']; ?></div></td>
          </tr><?php }while($r40->resultado = mysql_fetch_assoc($r40->consulta)); ?>
<tr>
            <th>Sub-Total:</th>
            <th><?php echo $res40; ?>&nbsp;</th>
          </tr>
        </table></td>
      </tr>
    </table>
    <table align="center" cellpadding="0" id="listado" >
      <caption>
        Total de Equipos:&nbsp;
      <?php echo $res20 + $res40 ?>
      </caption>
      <thead>
        <tr>
          <th axis="number">ID</th>
          <th axis="string">Buque</th>
          <th axis="string">Viaje</th>
          <th axis="string">Equipo</th>
          <th axis="string">Tipo</th>
          <th axis="date">Despacho/Buque</th>
          <th axis="date">Despacho/Muelle</th>
          <th axis="date">Entrada</th>
          <th axis="string">Condicion</th>
          <th width="30%" axis="string">Obs.</th>
          <th axis="date">Devolucion</th>
        </tr>
      </thead>
      <tbody>
      	<?php $n = 1; do{ ?>
        <tr>
          <td class="rightAlign"><?php echo $n++; ?></td>
          <td><?php echo $devBu->resultado['buque']; ?></td>
          <td><?php echo $devBu->resultado['viajed']; ?></td>
          <td><?php echo $devBu->resultado['contenedor']; ?></td>
          <td align="center"><?php echo $devBu->resultado['tipo']; ?></td>
          <td align="center"><?php echo $devBu->resultado['fdb']; ?></td>
          <td align="center"><?php echo $devBu->resultado['fdm']; ?></td>
          <td align="center"><?php echo $devBu->resultado['frd']; ?></td>
          <td align="center"><?php condicion($devBu->resultado['condicion']); ?></td>
          <td><?php echo $devBu->resultado['obs']; ?></td>
          <td class="rightAlign"><?php echo $devBu->resultado['fdespims']; ?></td>
        </tr>
        <?php } while($devBu->resultado = mysql_fetch_assoc($devBu->consulta)); ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <p>&nbsp;</p>
</div>
</body>
</html>
<?php

?>