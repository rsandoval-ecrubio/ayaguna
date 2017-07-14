<?php 
session_start();
//error_reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors", 1);
require('../config.php');
require_once('../clases/mygeneric_class.php');

$row_re20 = new DBMySQL();
$row_re20->nombreDB($_SESSION['variables']['db']);
$row_re20->consultarDB("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '2%' GROUP BY tipo ORDER BY tipo");
$totalRows_re20 = $row_re20->total;

$row_re40 = new DBMySQL();
$row_re40->nombreDB($_SESSION['variables']['db']);
$row_re40->consultarDB("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '4%' GROUP BY tipo ORDER BY tipo");
$totalRows_re40 = $row_re40->total;

$row_inv = new DBMySQL();
$row_inv->nombreDB($_SESSION['variables']['db']);
$row_inv->consultarDB("SELECT * FROM existenciagral");
$totalRows_inv = $row_inv->total;

//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=InventarioGeneral.xls");
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
  <h2>INVENTARIO GENERAL - <?php echo ALMACEN;?></h2>
  <table width="400" align="center" class="resumen" id="resumen">
      <tr>
        <th width="50%">Equipo de 20&quot;</th>
        <th width="50%">Equipos de 40&quot;</th>
      </tr>
      <tr>
        <td valign="top"><table width="100%" id="re20">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_re20->resultado['tipo']; ?></td>
              <td><div align="right">
                <?php $suma20 = $suma20 + $row_re20->resultado['cantidad']; echo $row_re20->resultado['cantidad']; ?>
              </div></td>
            </tr>
<?php } while ($row_re20->resultado = mysql_fetch_assoc($row_re20->consulta)); ?>
            <tr>
              <th>Sub-Total:</th>
              <th><div align="center"><?php echo $suma20; ?></div></th>
            </tr>
        </table></td>
        <td valign="top"><table width="100%" id="re40">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_re40->resultado['tipo']; ?></td>
              <td><div align="right">
                <?php $suma40 = $suma40 + $row_re40->resultado['cantidad']; echo $row_re40->resultado['cantidad']; ?>
              </div></td>
            </tr>
<?php } while ($row_re40->resultado = mysql_fetch_assoc($row_re40->consulta)); ?>
            <tr>
              <th>Sub-Total:</th>
              <th><div align="center"><?php echo $suma40; ?></div></th>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo $totalRows_inv ?></strong></td>
      </tr>
    </table>
    <table align="center" cellpadding="0" id="listado" ><caption>&nbsp;
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
          <th>Despacho/Muelle</th>
          <th>Recepcion/Patio</th>
          <th>Precinto</th>
          <th>B/L</th>
          <th>EIR</th>
          <th>Paset</th>
          <th>Observaciones</th>
          <th>Patio</th>
          <th>Consignatario</th>
          <th>D-Pais</th>
          <th>D-Patio</th>
        </tr>
      </thead>
      <tbody>
        <?php do { ?>
          <tr>
            <td><?php echo $row_inv->resultado['id']; ?></td>
            <td><?php echo $row_inv->resultado['contenedor']; ?></td>
            <td><?php echo $row_inv->resultado['tipo']; ?></td>
            <td><?php estatus($row_inv->resultado['status']); ?></td>
            <td><?php condicion($row_inv->resultado['condicion']); ?></td>
            <td><?php echo $row_inv->resultado['buque']; ?></td>
            <td><?php echo $row_inv->resultado['viaje']; ?></td>
            <td width="5%"><?php echo $row_inv->resultado['fdm']; ?></td>
            <td width="5%"><?php echo $row_inv->resultado['frd']; ?></td>
            <td><?php echo $row_inv->resultado['precinto']; ?></td>
            <td><?php echo $row_inv->resultado['bl']; ?></td>
            <td><?php echo $row_inv->resultado['eir_r']; ?></td>
            <td><?php echo $row_inv->resultado['paset']; ?></td>
            <td width="18%"><?php echo htmlentities($row_inv->resultado['obs']); ?></td>
            <td><?php echo $row_inv->resultado['patio']; ?></td>
            <td><?php echo $row_inv->resultado['consignatario']; ?></td>
            <td><?php alarmapais($row_inv->resultado['dpais']); ?></td>
            <td><?php alarma($row_inv->resultado['dpatio']); ?></td>
          </tr>
          <?php } while ($row_inv->resultado = mysql_fetch_assoc($row_inv->consulta)); ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <p><?php echo USERREPORT; ?></p>
</body>
</html>
