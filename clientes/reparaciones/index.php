<?php
require_once('../../config.php');
require_once('../../clases/seguridad_class.php');
require_once('../../clases/class.MySQL.php');
seguridad();

$ini = $ahoraShort;
$fin = $ahoraShort;
$mostrar = 0;

if(isset($_POST) and !empty($_POST)){
	$ini = $_POST['ini'];
	$fin = $_POST['fin'];
	$linea = $_SESSION['variables']['linea'];
	$total20 = array();
	$total40 = array();;
	$numeracion = 0;
	
	$inventario = new MySQL(USERDB);
	$qinventario = sprintf("SELECT * FROM rpt_reparados_linea WHERE linea = %d AND fecha BETWEEN '%s' AND '%s';",$linea,$ini,$fin);
	$inventario->Consultar($qinventario);
	
	$mostrar = $inventario->Total;
	
	$recap20 = new MySQL(USERDB);
	$qrecap20 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM rpt_reparados_linea WHERE tipo LIKE '2%%' AND linea = %d AND fecha BETWEEN '%s' AND '%s' GROUP BY tipo;",$linea,$ini,$fin);
	$recap20->Consultar($qrecap20);
	
	$recap40 = new MySQL(USERDB);
	$qrecap40 = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM rpt_reparados_linea WHERE tipo LIKE '4%%' AND linea = %d AND fecha BETWEEN '%s' AND '%s' GROUP BY tipo;",$linea,$ini,$fin);
	$recap40->Consultar($qrecap40);
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AYAGUNA</title>
<link href="../../css/estilo_general_cli.css" rel="stylesheet" type="text/css" />
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
<div id="wrapper">
<header><?php include(INCLUDE_DIR.'toindex_inc.php');?></header>
<h1><?php echo $_SESSION['online']; ?></h1>
<form name="form1" method="post" action="">
  <label for="ini">Periodo</label>
  <input name="ini" type="date" id="ini" value="<?php echo $ini; ?>" input.value="aaaa-mmm-dd">
  <label for="fin"></label>
  <input name="fin" type="date" id="fin" value="<?php echo $fin; ?>" input.value="aaaa-mmm-dd">
  <input type="submit" name="button" id="button" value="Enviar">
</form>
<?php if($mostrar > 0){ ?>
<table width="400" class="resumen" id="resumen">
  <caption>
    Resumen
    </caption>
  <tr>
    <th>Equipo de 20&quot;</th>
    <th>Equipos de 40&quot;</th>
  </tr>
  <tr>
    <td valign="top"><table width="100%" class="recaps">
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
    <td valign="top"><table width="100%" class="recaps">
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
<table cellpadding="0" class="listado" id="lista" >
  <caption>
    Equipos Reparados| <?php echo $inventario->Total; ?> Equipos
    | <a href="export_reparaciones.php?linea=<?php echo $linea;?>&dia=<?php echo $ini;?>&dia2=<?php echo $fin;?>">Exportar</a>
  </caption>
  <thead>
    <tr>
      <th axis="number">ID</th>
      <th axis="string">Equipo</th>
      <th axis="string">Tipo</th>
      <th axis="string">Condicion</th>
      <th axis="string">Observación</th>
      <th axis="number">Fecha/Rep.</th>
      <th axis="string">Condicion - Ant.</th>
      <th axis="string">Observación - Ant.</th>
      </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr>
      <td align="right"><?php echo $numeracion = $numeracion + 1;?></td>
      <td><?php echo $inventario->Resultado['contenedor']; ?></td>
      <td align="center"><?php echo $inventario->Resultado['tipo']; ?></td>
      <td align="center"><?php condicion($inventario->Resultado['condicionA']); ?></td>
      <td><a title="<?php echo $inventario->Resultado['obs']; ?>" href="#">Leer</a></td>
      <td align="center"><?php echo $inventario->Resultado['fecha']; ?></td>
      <td align="center"><?php condicion($inventario->Resultado['condicionB']); ?></td>
      <td><a title="<?php echo $inventario->Resultado['antobs']; ?>" href="#">Leer</a></td>
      </tr>
    <?php }while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta))?>
  </tbody>
</table><?php }else if(isset($_POST) and !empty($_POST) and $mostrar == 0) { echo "<h1>Sin Resultados</h1>"; } ?>
</div>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>
