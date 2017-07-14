<?php
require('../config.php');
require('../clases/mygeneric_class.php');
$mostrar = NULL;
$suma20 = NULL;
$suma40 = NULL;

$linea = new DBMySQL;
$linea->nombreDB(USERDB);
$linea->consultarDB("SELECT id, nombre FROM lineas WHERE activo = 0");

	$var = $_GET['var'];
	$var1 = $_GET['var1'];
	$var2 = $_GET['var2'];
	
	$reparaciones = new DBMySQL;
	$reparaciones->consultarDBli(1,sprintf("CALL `list_repair`(%d, '%s', '%s')",$var,$var1,$var2));
	$mostrar = $reparaciones->totalli;
	
	//Recap
	$recap20 = new DBMySQL;
	$recap20->nombreDB(USERDB);
	$qrecap20 = sprintf("SELECT tipo, COUNT(tipo) AS cantidad FROM reparaciones, inventario, tequipos WHERE reparaciones.idcontenedor = inventario.id AND inventario.tcont = tequipos.id AND tipo LIKE '2%%' AND reparaciones.fecha BETWEEN '%s' AND '%s' AND inventario.linea = %d GROUP BY tipo",$var1,$var2,$var);
	$recap20->consultarDB($qrecap20);
	
	$recap40 = new DBMySQL;
	$recap40->nombreDB(USERDB);
	$qrecap40 = sprintf("SELECT tipo, COUNT(tipo) AS cantidad FROM reparaciones, inventario, tequipos WHERE reparaciones.idcontenedor = inventario.id AND inventario.tcont = tequipos.id AND tipo LIKE '4%%' AND reparaciones.fecha BETWEEN '%s' AND '%s' AND inventario.linea = %d GROUP BY tipo",$var1,$var2,$var);
	$recap40->consultarDB($qrecap40);

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=equipos_reparados.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reparaciones</title>
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
	<h3><?php echo "Reporte de Equipos Reparados entre ".$var1." y ".$var2;?></h3>
<table width="400" class="resumen" id="resumen">
  <tr>
    <th>Equipo de 20&quot;</th>
    <th>Equipos de 40&quot;</th>
  </tr>
  <tr>
    <td valign="top"><?php if($recap20->total > 0){ ?><table width="100%">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr><?php do { ?>
      <tr>
        <td><?php echo $recap20->resultado['tipo'];?></td>
        <td><div align="right"><?php $suma20 = $suma20 + $recap20->resultado['cantidad']; echo $recap20->resultado['cantidad'];?></div></td>
      </tr><?php } while($recap20->resultado = mysql_fetch_assoc($recap20->consulta)); ?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="center"><?php echo $suma20;?></div></th>
      </tr>
    </table><?php } ?></td>
    <td valign="top"><?php if($recap40->total > 0){ ?><table width="100%">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr><?php do { ?>
      <tr>
        <td><?php echo $recap40->resultado['tipo'];?></td>
        <td><div align="right"><?php $suma40 = $suma40 + $recap40->resultado['cantidad']; echo $recap40->resultado['cantidad'];?></div></td>
      </tr><?php } while($recap40->resultado = mysql_fetch_assoc($recap40->consulta));?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="center"><?php echo $suma40;?></div></th>
      </tr>
    </table><?php } ?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo $suma20 + $suma40;?></strong></td>
  </tr>
</table>
<table width="70%" border="1" align="center">
    <caption>
    Listado
    </caption>
  <tr>
    <th scope="col">Buque</th>
    <th scope="col">Viaje</th>
    <th scope="col">Contenedor</th>
    <th scope="col">Tipo</th>
    <th scope="col">Fecha/Rep.</th>
    <th scope="col">Monto</th>
    <th scope="col" title="Condicion Anterior">C-A</th>
    <th scope="col">Condicion</th>
    <th scope="col" title="Observacion Anterior">A.Obs</th>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center"><?php echo $reparaciones->resultadoli['buque'];?></td>
    <td align="center"><?php echo $reparaciones->resultadoli['viaje'];?></td>
    <td align="center"><?php echo $reparaciones->resultadoli['contenedor'];?></td>
    <td align="center"><?php echo $reparaciones->resultadoli['tipo'];?></td>
    <td align="center"><?php echo $reparaciones->resultadoli['fecha'];?></td>
    <td align="center"><?php echo number_format($reparaciones->resultadoli['monto'],2);?></td>
    <td align="center"><?php condicion($reparaciones->resultadoli['C-A']);?></td>
    <td align="center"><?php condicion($reparaciones->resultadoli['condicion']);?></td>
    <td align="left"><?php echo $reparaciones->resultadoli['antobs'];?></td>
  </tr><?php } while($reparaciones->resultadoli = mysqli_fetch_assoc($reparaciones->consultali));?>
</table>
<p><?php echo USERREPORT; ?></p>
</div>
</body>
</html>