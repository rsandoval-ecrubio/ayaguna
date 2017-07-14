<?php
require_once('../../config.php');
require_once('../../clases/seguridad_class.php');
require_once('../../clases/class.MySQL.php');

seguridad();
$total20 = array();
$total40 = array();;
$numeracion = 0;
$linea = $_GET['linea'];

//Inventario
$inventario = new MySQL(USERDB);
$qinv = sprintf("CALL `inventarioLinea`('%d');",$linea);
$inventario->Consultar($qinv);

//Recaps 20
$recap20 = new MySQL(USERDB);
$recap20->Consultar(sprintf("SELECT tequipos.tipo, COUNT(tequipos.tipo) AS `cantidad` FROM tequipos, inventario WHERE inventario.tcont = tequipos.id AND tequipos.tipo LIKE '2%%' AND inventario.c = 0 AND inventario.linea = %d GROUP BY inventario.tcont",$linea));

//Recaps 40
$recap40 = new MySQL(USERDB);
$recap40->Consultar(sprintf("SELECT tequipos.tipo, COUNT(tequipos.tipo) AS `cantidad` FROM tequipos, inventario WHERE inventario.tcont = tequipos.id AND tequipos.tipo LIKE '4%%' AND inventario.c = 0 AND inventario.linea = %d GROUP BY inventario.tcont",$linea));


#Email->
$destinos = "support@tconnections.net";
$sujeto = "AYAGUNA v1.0 - Reporte de Uso";
$mensaje = "----------------------------------------------------"."\n";
$mensaje .= "                   Reporte                          "."\n";
$mensaje .= "---------------------------------------------------- "."\n";
$mensaje .= "Fecha: ".$ahora."\n";
$mensaje .= "El Usuario: ".$_SESSION['variables']['nombreUsuario']."\n";
$mensaje .= "Descargo el reporte: Existencia"."\n";
$mensaje .= "---------------------------------------------------- "."\n";
$mensaje .= "Mensaje generado automaticamente por AYAGUNA v1.0; por favor no responda este mensaje"."\n";
$header = "From: ayaguna@appstc.net"."\r\n";
//mail($destinos,$sujeto,$mensaje,$header);
#<-Email

//exportar a excel
$nombreArchivo = "existencia".$ahoraShort.".xls";
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
<h1><?php echo $inventario->Resultado['linea']." - ".$ahora; ?></h1>
<table width="400" id="resumen"><caption>Resumen</caption>
  <tr>
    <th>Equipo de 20&quot;</th>
    <th>Equipos de 40&quot;</th>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" class="recaps" id="recaps20">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr><?php do{ ?>
      <tr>
        <td><?php echo $recap20->Resultado['tipo']; ?></td>
        <td><div align="right"><?php echo $total20[] = $recap20->Resultado['cantidad']; ?></div></td>
      </tr><?php }while($recap20->Resultado = mysqli_fetch_assoc($recap20->Consulta));?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="center"><?php echo array_sum($total20); ?></div></th>
      </tr>
    </table></td>
    <td valign="top"><table width="100%" border="1" class="recaps" id="recaps40">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr><?php do{ ?>
      <tr>
        <td><?php echo $recap40->Resultado['tipo']; ?></td>
        <td><div align="right"><?php echo $total40[] = $recap40->Resultado['cantidad']; ?></div></td>
      </tr><?php }while($recap40->Resultado = mysqli_fetch_assoc($recap40->Consulta)); ?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="center"><?php echo array_sum($total40); ?></div></th>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo array_sum($total20) + array_sum($total40); ?></strong></td>
  </tr>
</table>
  <table border="1" cellpadding="0" class="listado" id="lista" ><caption>
  Inventario | <?php echo $inventario->Total; ?> Equipos
  </caption>
    <thead>
      <tr>
        <th>ID</th>
        <th>Equipo</th>
        <th>Tipo</th>
        <th>Estatus</th>
        <th>Condicion</th>
        <th>Buque</th>
        <th>Viaje</th>
        <th>Arribo</th>
        <th>D. Muelle</th>
        <th>Ingreso</th>
        <th>EIR</th>
        <th>EIR B.P.</th>
        <th>Obs.</th>
        <th>Patio</th>
        <th>D/Pais</th>
        <th>D/Patio</th>
      </tr>
    </thead>
    <tbody><?php do { ?>
        <tr>
          <td align="right"><?php echo $numeracion = $numeracion + 1;?></td>
          <td><?php echo $inventario->Resultado['contenedor']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['tipo']; ?></td>
          <td align="center"><?php estatus($inventario->Resultado['estatus']); ?></td>
          <td align="center"><?php condicion($inventario->Resultado['condicion']); ?></td>
          <td><?php echo $inventario->Resultado['buque']; ?></td>
          <td align="left"><?php echo $inventario->Resultado['viaje']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['arribo']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['fdm']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['frd']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['eir_r']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['eirboli']; ?></td>
          <td id="obs"><?php echo $inventario->Resultado['obs']; ?></td>
          <td align="center"><?php echo $inventario->Resultado['patio']; ?></td>
          <td align="right"><?php alarmapais($inventario->Resultado['dpais']); ?></td>
          <td align="right"><?php alarma($inventario->Resultado['dpatio']); ?></td>
        </tr><?php }while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta))?>
    </tbody>
</table>
<p><?php echo $_SERVER['REMOTE_ADDR']; ?></p>
</body>
</html>
