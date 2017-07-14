<?php
require_once('../../config.php');
require_once('../../clases/seguridad_class.php');
require_once('../../clases/class.MySQL.php');

seguridad();
$total20 = array();
$total40 = array();;
$numeracion = 0;
$linea = $_SESSION['variables']['linea'];

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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AYAGUNA</title>
<link href="../../css/estilo_general_cli.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../js/jquery.tablesorter.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function()
    {
        $("#lista").tablesorter();
    }
);
</script>
</head>
<body>
<header><?php include(INCLUDE_DIR.'toindex_inc.php');?></header>
<div id="wrapper">
<h1><?php echo $_SESSION['online'] = $inventario->Resultado['linea']; ?></h1>
<table width="400" class="resumen" id="resumen"><caption>Resumen</caption>
  <tr>
    <th>Equipo de 20&quot;</th>
    <th>Equipos de 40&quot;</th>
  </tr>
  <tr>
    <td valign="top"><table width="100%" class="recaps">
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
    <td valign="top"><table width="100%" class="recaps">
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
<p><a href="export_existencia.php?linea=<?php echo $inventario->Resultado['idlinea'];?>" target="new">Exportar</a></p>
  <table cellpadding="0" class="listado" id="lista" ><caption>
  Inventario | <?php echo $inventario->Total; ?> Equipos
  </caption>
    <thead>
      <tr>
        <th axis="number">ID</th>
        <th axis="string">Equipo</th>
        <th axis="string">Tipo</th>
        <th axis="string">Estatus</th>
        <th axis="string">Condicion</th>
        <th axis="string">Buque</th>
        <th axis="string">Viaje</th>
        <th axis="date">Arribo</th>
        <th axis="date">D. Muelle</th>
        <th axis="date">Ingreso</th>
        <th axis="number">EIR</th>
        <th axis="number">EIR-B.P.</th>
        <th axis="string">Obs.</th>
        <th axis="string">Patio</th>
        <th axis="number">D/Pais</th>
        <th axis="number">D/Patio</th>
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
          <td><a href="#" title="<?php echo $inventario->Resultado['obs']; ?>">Leer...</a></td>
          <td align="center"><?php echo $inventario->Resultado['patio']; ?></td>
          <td align="right"><?php alarmapais($inventario->Resultado['dpais']); ?></td>
          <td align="right"><?php alarma($inventario->Resultado['dpatio']); ?></td>
        </tr><?php }while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta))?>
    </tbody>
  </table>
  </div>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>
