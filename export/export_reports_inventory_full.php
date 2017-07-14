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
$qinventario = "SELECT inventario.id,inventario.contenedor,tequipos.tipo,inventario.`status`, inventario.condicion,buques.nombre AS buque,viajes.viaje,viajes.eta AS arribo, inventario.fdm,
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

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Inventario.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
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
	width: auto;
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
      <h2>INVENTARIO GENERAL - FULL</h2>
    <br />
    <table width="400" align="center" class="resumen" id="resumen">
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
    <table align="center" cellpadding="0" id="listado" >
  <caption>
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
      <th axis="date">Despacho/Muelle</th>
      <th axis="date">Entrada</th>
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
      <td><?php echo $inventario->Resultado['contenedor']; ?></td>
      <td><?php echo $inventario->Resultado['tipo']; ?></td>
      <td><?php estatus($inventario->Resultado['status']); ?></td>
      <td><?php condicion($inventario->Resultado['condicion']); ?></td>
      <td><?php echo $inventario->Resultado['buque']; ?></td>
      <td><?php echo $inventario->Resultado['viaje']; ?></td>
      <td width="5%" class="rightAlign"><?php echo $inventario->Resultado['fdm']; ?></td>
      <td width="5%" class="rightAlign"><?php echo $inventario->Resultado['frd']; ?></td>
      <td class="rightAlign"><?php echo $inventario->Resultado['precinto']; ?></td>
      <td class="rightAlign"><?php echo $inventario->Resultado['bl']; ?></td>
      <td class="rightAlign"><?php echo $inventario->Resultado['eir_r']; ?></td>
      <td width="18%"><?php echo $inventario->Resultado['obs']; ?></td>
      <td class="rightAlign"><?php echo $inventario->Resultado['patio']; ?></td>
      <td><?php echo $inventario->Resultado['consignatario']; ?></td>
      <td class="rightAlign"><?php echo $inventario->Resultado['dpais'];?>&nbsp;</td>
      <td class="rightAlign"><?php echo $inventario->Resultado['dalm'];?>&nbsp;</td>
    </tr>
    <?php } while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta)); ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="17">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<p><?php echo USERREPORT; ?></p>
</body>
</html>
