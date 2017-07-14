<?php 
session_start();
require_once('../config.php');
//Nuevo modelo
require_once('../clases/seguridad_class.php');
require_once('../clases/class.MySQL.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
seguridad();

#Inventario Full
$inventario = new MySQL(USERDB);
$qinventario = "SELECT inventario.id,inventario.acta,inventario.contenedor,tequipos.tipo,inventario.`status`, inventario.condicion,buques.nombre AS buque,viajes.viaje,viajes.eta AS arribo, inventario.fdm,
inventario.frd,inventario.eir_r,inventario.precinto,inventario.bl,consignatario.nombre AS `consignatario`,inventario.obs, patios.patio,
TO_DAYS(curdate()) - TO_DAYS(viajes.eta) AS dpais, TO_DAYS(curdate()) - TO_DAYS(inventario.frd) AS dalm
FROM inventario, tequipos, buques, viajes, consignatario, patios
WHERE inventario.c = 0 AND inventario.`status` = 1 AND tequipos.id = inventario.tcont AND buques.id = inventario.buque
AND viajes.id = inventario.viaje AND consignatario.id = inventario.`consignatario` AND patios.id = inventario.patio";
$inventario->Consultar($qinventario);

#Recaps 20
$recaps20 = new MySQL(USERDB);
$qrecaps20 = "SELECT tequipos.tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.c = 0 AND inventario.`status` = 1 AND tequipos.id = inventario.tcont AND tequipos.tipo LIKE '2%' GROUP BY tequipos.tipo";
$recaps20->Consultar($qrecaps20);

#Recaps 40
$recaps40 = new MySQL(USERDB);
$qrecaps40 = "SELECT tequipos.tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.c = 0 AND inventario.`status` = 1 AND tequipos.id = inventario.tcont AND tequipos.tipo LIKE '4%' GROUP BY tequipos.tipo";
$recaps40->Consultar($qrecaps40);

$suma20 = NULL;
$suma40 = NULL;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../js/mootools.js" type="text/javascript"></script>
<script src="../js/sortableTable.js" type="text/javascript"></script>
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
</head>
<body>
<header><?php include(INCLUDE_DIR.'header_inc.php'); ?></header>
<nav><?php include(INCLUDE_DIR.'toindex_inc.php'); ?></nav>
<?php if($inventario->Total > 1){ ?>
  <h2>INVENTARIO GENERAL - FULL</h2>
<table width="400" class="resumen" id="resumen">
    <tr>
      <th>Equipo de 20&quot;</th>
      <th>Equipos de 40&quot;</th>
  </tr>
    <tr>
      <td valign="top"><table width="100%">
        <tr>
          <th>Tipo</th>
          <th>Cant</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $recaps20->Resultado['tipo']; ?></td>
            <td><div align="right">
              <?php $suma20 = $suma20 + $recaps20->Resultado['cantidad']; echo $recaps20->Resultado['cantidad']; ?>
            </div></td>
          </tr>
          <?php } while($recaps20->Resultado = mysqli_fetch_assoc($recaps20->Consulta)); ?>
        <tr>
          <th>Sub-Total:</th>
          <th><div align="center"><?php echo $suma20; ?></div></th>
        </tr>
      </table></td>
      <td valign="top"><table width="100%">
        <tr>
          <th>Tipo</th>
          <th>Cant</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $recaps40->Resultado['tipo']; ?></td>
            <td><div align="right">
              <?php $suma40 = $suma40 + $recaps40->Resultado['cantidad']; echo $recaps40->Resultado['cantidad']; ?>
            </div></td>
          </tr>
          <?php } while($recaps40->Resultado = mysqli_fetch_assoc($recaps40->Consulta)); ?>
        <tr>
          <th>Sub-Total:</th>
          <th><div align="center"><?php echo $suma40; ?></div></th>
        </tr>
      </table></td>
    </tr>
  </table>
  <div id="export"><a href="../export/export_reports_inventory_full.php">exportar</a></div>
  <table align="left" cellpadding="0" id="pf_sortableTable1" ><caption>
    Total de Equipos: <?php echo $inventario->Total; ?>
    </caption>
    <thead>
      <tr>
        <th axis="number">#</th>
        <th axis="string">Equipo</th>
        <th axis="string">Tipo</th>
        <th axis="string">Estatus</th>
        <th axis="string">Condicion</th>
        <th axis="string">Buque</th>
        <th axis="string">Viaje</th>
        <th axis="date">D-Muelle</th>
        <th axis="date">Entrada</th>
        <th axis="date">Acta</th>
        <th axis="string">Precinto</th>
        <th axis="string">B/L</th>
        <th axis="number">EIR</th>
        <th axis="string">Observaciones</th>
        <th axis="string">Patio</th>
        <th axis="string">Consignatario</th>
        <th axis="number">D-Pais</th>
        <th axis="number">D-Patio</th>
      </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td class="rightAlign"><?php echo $inventario->Resultado['id']; ?></td>
          <td><?php echo $inventario->Resultado['contenedor']; ?><br>
          <a target="_blank" title="Pre-Liquidar" href="/ayaguna/preliquidacion/index.php?var1=<?php echo codificar($inventario->Resultado['acta']); ?>&var2=<?php echo codificar($inventario->Resultado['contenedor']); ?>">Preliquidar</a></td>
          <td><?php echo $inventario->Resultado['tipo']; ?></td>
          <td><?php estatus($inventario->Resultado['status']); ?></td>
          <td><?php condicion($inventario->Resultado['condicion']); ?></td>
          <td><?php echo $inventario->Resultado['buque']; ?></td>
          <td><?php echo $inventario->Resultado['viaje']; ?></td>
          <td class="rightAlign"><?php echo $inventario->Resultado['fdm']; ?></td>
          <td width="3%" class="rightAlign"><?php echo $inventario->Resultado['frd']; ?></td>
          <td width="2%" class="rightAlign"><a title="Re-Imprimir" target="_blank" href="/ayaguna/actas_cont/reimprimir_acta.php?id=<?php echo codificar($inventario->Resultado['acta']); ?>"><?php echo $inventario->Resultado['acta']; ?></a></td>
          <td class="rightAlign"><?php echo $inventario->Resultado['precinto']; ?></td>
          <td class="rightAlign"><?php echo $inventario->Resultado['bl']; ?></td>
          <td class="rightAlign"><?php echo $inventario->Resultado['eir_r']; ?></td>
          <td><?php echo $inventario->Resultado['obs']; ?></td>
          <td class="rightAlign"><?php echo $inventario->Resultado['patio']; ?></td>
          <td><?php echo $inventario->Resultado['consignatario']; ?></td>
          <td class="rightAlign"><?php echo $inventario->Resultado['dpais'];?>&nbsp;</td>
          <td class="rightAlign"><?php echo $inventario->Resultado['dalm'];?>&nbsp;</td>
        </tr>
        <?php } while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta)); ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="18">&nbsp;</td>
      </tr>
    </tfoot>
  </table>
  <script type="text/javascript">
// BeginWebWidget phatfusion_sortableTable: pf_sortableTable1

		var pf_sortableTable1 = {};
		window.addEvent('domready', function(){
			pf_sortableTable1 = new sortableTable('pf_sortableTable1', {overCls: 'over'});
		});
	

// EndWebWidget phatfusion_sortableTable: pf_sortableTable1
    </script>
  <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php }else { ?>
<h6>No hay equipos full en el inventario</h6>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>