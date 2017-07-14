<?php
require_once('../../config.php');
require_once('../../clases/seguridad_class.php');
require_once('../../clases/class.MySQL.php');
seguridad();


if(isset($_GET)){
	$ini = $_GET['dia'];
	$fin = $_GET['dia2'];
	$linea = $_GET['linea'];
	$total20 = array();
	$total40 = array();;
	$numeracion = 0;
	
	$inventario = new MySQL(USERDB);
	$qinventario = sprintf("CALL `GateIn`('%d', '%s', '%s');",$linea,$ini,$fin);
	$inventario->Consultar($qinventario);
	
	$mostrar = $inventario->Total;
	
	$recap20 = new MySQL(USERDB);
	$qrecap20 = sprintf("SELECT tequipos.tipo, COUNT(*) AS cantidad FROM inventario, tequipos WHERE inventario.delete = 0 AND inventario.linea = %d AND inventario.frd BETWEEN '%s' AND '%s' AND tequipos.id = inventario.tcont AND tequipos.tipo LIKE '2%%'GROUP BY inventario.tcont;",$linea,$ini,$fin);
	$recap20->Consultar($qrecap20);
	
	$recap40 = new MySQL(USERDB);
	$qrecap40 = sprintf("SELECT tequipos.tipo, COUNT(*) AS cantidad FROM inventario, tequipos WHERE inventario.delete = 0 AND inventario.linea = %d AND inventario.frd BETWEEN '%s' AND '%s' AND tequipos.id = inventario.tcont AND tequipos.tipo LIKE '4%%'GROUP BY inventario.tcont;",$linea,$ini,$fin);
	$recap40->Consultar($qrecap40);
}


#exportar a excel
$nombreArchivo = "ingreso".$_SESSION['online']."_".$ini.$fin."_".$linea.".xls";
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$nombreArchivo");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AYAGUNA</title>
<style type="text/css">
/* CSS Document */
body,td,th {
	font-family: Calibri;
	font-size: 12px;
}
caption{
	font-size:20px;
	text-align:left;
}
#resumen th {
	background:#CCC;
}
.recaps {

}
#lista{
	width:100%;
}
#lista th {
	background:#CCC;
}
#lista tbody tr #obs {
	font-size: 10px;
	width: 22%;
}
</style>

</head>

<body>
<div id="wrapper">
<header>&nbsp;</header>
<h1><?php echo $_SESSION['online']; ?></h1>
<table width="400" class="resumen" id="resumen">
  <caption>
    Resumen
    </caption>
  <tr>
    <th width="50%">Equipo de 20&quot;</th>
    <th width="50%">Equipos de 40&quot;</th>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" class="recaps">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr>
      <?php do{ ?>
      <tr>
        <td><?php echo $recap20->Resultado['tipo']; ?></td>
        <td><div align="right"><?php echo $total20[] = $recap20->Resultado['cantidad']; ?></div></td>
      </tr>
      <?php }while($recap20->Resultado = mysqli_fetch_assoc($recap20->Consulta));?>
      <tr>
        <th>Sub-Total:</th>
        <th align="right"><?php echo array_sum($total20);?></th>
      </tr>
    </table></td>
    <td valign="top"><table width="100%" border="1" class="recaps">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr>
      <?php do{ ?>
      <tr>
        <td><?php echo $recap40->Resultado['tipo']; ?></td>
        <td><div align="right"><?php echo $total40[] = $recap40->Resultado['cantidad']; ?></div></td>
      </tr>
      <?php }while($recap40->Resultado = mysqli_fetch_assoc($recap40->Consulta)); ?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="right"><?php echo array_sum($total40);?></div></th>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo array_sum($total20) + array_sum($total40); ?></strong></td>
  </tr>
</table>
<table width="800" border="1" cellpadding="0" class="listado" id="lista" >
  <caption>
    Movimientos de Entrada | <?php echo $inventario->Total; ?> Equipos
    |
  </caption>
  <thead>
    <tr>
      <th axis="number">ID</th>
      <th axis="number">Linea</th>
      <th axis="number">Buque</th>
      <th axis="number">Viaje</th>
      <th axis="string">Equipo</th>
      <th axis="string">Tipo</th>
      <th axis="string">Estatus</th>
      <th axis="string">Condicion</th>
      <th axis="date">Arribo</th>
      <th axis="date">Ingreso</th>
      <th axis="number">EIR</th>
      <th axis="string">Devolución</th>
      <th axis="string">D/Pais</th>
      <th axis="number">D/Patio</th>
    </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr>
      <td align="right"><?php echo $numeracion = $numeracion + 1;?></td>
      <td align="right"><?php echo $inventario->Resultado['nombre']; ?></td>
      <td align="right"><?php echo $inventario->Resultado['buque']; ?></td>
      <td align="right"><?php echo $inventario->Resultado['viaje']; ?></td>
      <td><?php echo $inventario->Resultado['contenedor']; ?></td>
      <td align="center"><?php echo $inventario->Resultado['tipo']; ?></td>
      <td align="center"><?php echo $inventario->Resultado['estatus']; ?></td>
      <td align="center"><?php cdt($inventario->Resultado['condicion']); ?></td>
      <td align="center"><?php echo $inventario->Resultado['fda']; ?></td>
      <td align="center"><?php echo $inventario->Resultado['frd']; ?></td>
      <td align="center"><?php echo $inventario->Resultado['eir_r']; ?></td>
      <td><?php echo $inventario->Resultado['fdespims']; ?></td>
      <td align="right"><?php alarmapais($inventario->Resultado['dpais']); ?></td>
      <td align="right"><?php alarma($inventario->Resultado['dpatio']); ?></td>
    </tr>
    <?php }while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta))?>
  </tbody>
</table>
</div>
<footer>&nbsp;</footer>
</body>
</html>
