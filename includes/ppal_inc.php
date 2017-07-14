<?php 
require('config.php');
require(CLASES.'mygeneric_class.php');

//Alarmas
$dpais = new DBMySQL;
$dpais->nombreDB(USERDB);
$dpais->consultarDB("SELECT nlinea AS `linea`, COUNT(*) `cantidad` FROM existenciagral WHERE dpais > 89 GROUP BY linea ORDER BY nlinea");

$dpatio = new DBMySQL;
$dpatio->nombreDB(USERDB);
$dpatio->consultarDB("SELECT nlinea AS `linea`, COUNT(*) `cantidad` FROM existenciagral WHERE dpatio > 89 GROUP BY linea ORDER BY nlinea");

?>

<?php
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
$query_totalgral = "SELECT COUNT(*) AS cantidad FROM existencia;";
$totalgral = mysql_query($query_totalgral, $conexion) or die(mysql_error());
$row_totalgral = mysql_fetch_assoc($totalgral);
$totalRows_totalgral = mysql_num_rows($totalgral);

mysql_select_db($database_conexion, $conexion);
$query_tipocant = "SELECT tipo, COUNT(*) AS cantidad FROM existenciagral GROUP BY tipo ORDER BY tipo";
$tipocant = mysql_query($query_tipocant, $conexion) or die(mysql_error());
$row_tipocant = mysql_fetch_assoc($tipocant);
$totalRows_tipocant = mysql_num_rows($tipocant);

mysql_select_db($database_conexion, $conexion);
$query_lineacant = "SELECT nlinea, COUNT(contenedor) AS cantidad  FROM existencia GROUP BY nlinea ORDER BY nlinea";
$lineacant = mysql_query($query_lineacant, $conexion) or die(mysql_error());
$row_lineacant = mysql_fetch_assoc($lineacant);
$totalRows_lineacant = mysql_num_rows($lineacant);

mysql_select_db($database_conexion, $conexion);
$query_condcant = "SELECT nlinea, CASE `condicion` when 0 then 'DMG' when 1 then 'OPR1' when 2 then 'OPR2' when 3 then 'OPR3' when 4 then 'N-OPR' end AS `condicion`, COUNT(condicion) AS cantidad  FROM existencia GROUP BY nlinea, condicion ORDER BY nlinea, condicion";
$condcant = mysql_query($query_condcant, $conexion) or die(mysql_error());
$row_condcant = mysql_fetch_assoc($condcant);
$totalRows_condcant = mysql_num_rows($condcant);

mysql_select_db($database_conexion, $conexion);
$query_vaciados = "SELECT existencia.*, vaciado.fecha AS fvaciado FROM existencia, vaciado WHERE existencia.`vaciado` = vaciado.id";
$vaciados = mysql_query($query_vaciados, $conexion) or die(mysql_error());
$row_vaciados = mysql_fetch_assoc($vaciados);
$totalRows_vaciados = mysql_num_rows($vaciados);

mysql_select_db($database_conexion, $conexion);
$query_totalpatio = "SELECT patio AS `ubicacion`, count(*) AS cantidad  FROM existenciagral GROUP BY patio";
$totalpatio = mysql_query($query_totalpatio, $conexion) or die(mysql_error());
$row_totalpatio = mysql_fetch_assoc($totalpatio);
$totalRows_totalpatio = mysql_num_rows($totalpatio);

mysql_select_db($database_conexion, $conexion);
$query_teus = "SELECT SUM(ocupado) AS T_TEUS FROM rpt_teus";
$teus = mysql_query($query_teus, $conexion) or die(mysql_error());
$row_teus = mysql_fetch_assoc($teus);
$totalRows_teus = mysql_num_rows($teus);
?>
<?php
//COMENTARIO: CONSULTAS PARA CARGA GENERAL
$qry1 = "select consignatario.nombre, SUM(inventario_cg.cantidad) AS cantidad
FROM consignatario, inventario_cg 
where inventario_cg.consignatario = consignatario.id 
group by consignatario.id";
$exe1 = mysql_query($qry1, $conexion) or die(mysql_error());
$row1 = mysql_fetch_assoc($exe1);

$qry2 = "select consignatario.nombre, SUM(inventario_cg.cantidad) AS cantidad
FROM consignatario, inventario_cg 
where inventario_cg.consignatario = consignatario.id and in_out = '1'
group by consignatario.id";
$exe2 = mysql_query($qry2, $conexion) or die(mysql_error());
$row2 = mysql_fetch_assoc($exe2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<style type="text/css">
#info {
	float: left;
	width: auto;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
.border0 {
	padding: 4px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
#devoluciones {
	background-color: #FFFFD7;
	padding: 4px;
	border: 1px solid #39F;
	width: 100%;
	height: auto;
}
#info #devoluciones #form1 table tr td {
	background-color: #FFF;
}
</style>
</head>

<body>
<div class="info" id="info">
  <?php if ($totalRows_vaciados > 0) { // Show if recordset not empty ?>
  <div id="devoluciones">
    <form id="form1" name="form1" method="post" action="gateout/gateout_form.php">
      <table width="100%">
        <caption>
          Equipo para devoluci&oacute;n
          </caption>
        <tr>
          <th colspan="2" scope="col">Equipo</th>
          <th scope="col">Tipo</th>
          <th scope="col">Linea</th>
          <th scope="col">Buque</th>
          <th scope="col">Viaje</th>
          <th scope="col">Estatus</th>
          <th scope="col">Condicion</th>
          <th scope="col">Consignatario</th>
          <th scope="col">Recepcion</th>
          <th scope="col">EIR</th>
          <th scope="col">B/L</th>
          <th scope="col">Precinto</th>
          <th scope="col">Vaciado</th>
          <th scope="col">Fecha</th>
          </tr>
        <tr>
          <td><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row_vaciados['id']; ?>" />
            <label for="id[]"></label></td>
          <td><?php echo $row_vaciados['contenedor']; ?></td>
          <td><?php echo $row_vaciados['tipo']; ?></td>
          <td><?php echo $row_vaciados['nlinea']; ?></td>
          <td><?php echo $row_vaciados['buque']; ?></td>
          <td><?php echo $row_vaciados['viaje']; ?></td>
          <td><?php estatus($row_vaciados['status']); ?></td>
          <td><?php condicion($row_vaciados['condicion']); ?></td>
          <td><?php echo $row_vaciados['consignatario']; ?></td>
          <td><?php echo $row_vaciados['frd']; ?></td>
          <td><?php echo $row_vaciados['eir_r']; ?></td>
          <td><?php echo $row_vaciados['bl']; ?></td>
          <td><?php echo $row_vaciados['precinto']; ?></td>
          <td><?php echo $row_vaciados['vaciado']; ?></td>
          <td><?php echo $row_vaciados['fvaciado']; ?></td>
          </tr>
        </table>
      <input type="submit" name="button" id="button" value="Devolver" />
      </form>
  </div>
  <?php } // Show if recordset not empty ?>
<h2 align="center">Total de Equipos en el Almacen: <?php echo $row_totalgral['cantidad']; ?> | Total TEUS: <?php echo $row_teus['T_TEUS']; ?></h2>
  <hr />
  <table width="900" id="index" class="border0">
    <tr>
      <td width="25%" valign="top"><table width="220" align="center" class="border0">
        <caption>
          Cantidad por Tipo
        </caption>
        <tr>
          <th width="50%" scope="col">Tipo</th>
          <th scope="col">Cantidad</th>
        </tr>
        <?php do { ?>
        <tr>
          <td align="center"><?php echo $row_tipocant['tipo']; ?></td>
          <td align="right"><?php echo $row_tipocant['cantidad']; ?></td>
        </tr>
        <?php } while ($row_tipocant = mysql_fetch_assoc($tipocant)); ?>
      </table></td>
      <td width="25%" valign="top"><table width="220" align="center" class="border0"><caption>Cantidad por Linea</caption>
        <tr>
          <th>Linea</th>
          <th>Cantidad</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_lineacant['nlinea']; ?></td>
            <td align="right"><?php echo $row_lineacant['cantidad']; ?></td>
          </tr>
          <?php } while ($row_lineacant = mysql_fetch_assoc($lineacant)); ?>
      </table></td>
      <td width="25%" valign="top"><table width="300" align="center" class="border0">
        <caption>
          Cantidad por Condicion
        </caption>
        <tr>
          <th scope="col">Linea</th>
          <th scope="col">Condici&oacute;n</th>
          <th scope="col">Cantidad</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_condcant['nlinea']; ?></td>
            <td align="center"><?php echo $row_condcant['condicion']; ?></td>
            <td align="right"><?php echo $row_condcant['cantidad']; ?></td>
          </tr>
          <?php } while ($row_condcant = mysql_fetch_assoc($condcant)); ?>
      </table></td>
      <td width="25%" valign="top"><table width="220" align="center">
        <caption>
          Cantidad por Ubicacion
          </caption>
        <tr>
          <th scope="col">Patio</th>
          <th scope="col">Cantidad</th>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_totalpatio['ubicacion']; ?></td>
            <td align="right"><?php echo $row_totalpatio['cantidad']; ?></td>
          </tr>
          <?php } while ($row_totalpatio = mysql_fetch_assoc($totalpatio)); ?>
      </table></td>
    </tr>
  </table>
<hr />
<table width="220" align="left" class="border0">
  <caption>
  Mas de 90 Dias/Pais
  </caption>
  <tr>
    <th width="50%" scope="col">Linea</th>
    <th scope="col">Cantidad</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td align="left"><?php echo $dpais->resultado['linea']; ?></td>
    <td align="right"><?php echo $dpais->resultado['cantidad']; ?></td>
  </tr>
  <?php }while ($dpais->resultado = mysql_fetch_assoc($dpais->consulta));?>
</table>
<table width="220" align="left" class="border0">
  <caption>
    Mas de 90 Dias/Patio
  </caption>
  <tr>
    <th width="50%" scope="col">Linea</th>
    <th scope="col">Cantidad</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td align="left"><?php echo $dpatio->resultado['linea']; ?></td>
    <td align="right"><?php echo $dpatio->resultado['cantidad']; ?></td>
  </tr>
  <?php }while ($dpais->resultado = mysql_fetch_assoc($dpais->consulta));?>
</table>
<p>&nbsp;</p>
  <!-- COMENTARIO: ESTADO DE MODULO CARGA GENERAL - SE MOSTRAR SI CARGA GENERAL ESTA HABILITADO -->
  <?PHP if(CARGAGENERAL == 1) { } else { ?>

<h2 align="center"> Estatus Carga General</h2>
<hr />
<table width="900" id="index" class="border0">
  <tr>
    <td><table width="220" align="center" class="border0">
      <tr>
        <td colspan="2" align="center">ESTADO DEL ALMACEN</td>
        </tr>
      <tr>
        <th align="center" scope="col">Consignatario</th>
        <th align="center" scope="col">Cantidad</th>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row1['nombre']; ?></td>
        <td align="right"><?php echo $row1['cantidad']; ?></td>
      </tr>
      <?php } while ($row1 = mysql_fetch_assoc($exe1)); ?>
    </table></td>
    <td valign="top"><table width="220" align="center" class="border0">
      <tr>
        <td colspan="2" align="center">CARGA DESPACHADA</td>
        </tr>
      <tr>
        <th align="center">Consignatario</th>
        <th align="center">Cantidad</th>
      </tr>
      <?php do { ?>
      <tr>
        <td><?php echo $row2['nombre']; ?></td>
        <td align="right"><?php echo $row2['cantidad']; ?></td>
      </tr>
      <?php } while ($row2 = mysql_fetch_assoc($exe2)); ?>
    </table></td>
    <td align="center" valign="top"><table width="220" align="center" class="border0">
      <tr>
        <td colspan="2" align="center">ACTAS POR ANULAR</td>
        </tr>
      <tr>
        <th align="center"># Acta</th>
        <th align="center">Estado</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<hr />
<?php } ?>
</div>
</body>
</html>
<?php
mysql_free_result($totalgral);

mysql_free_result($tipocant);

mysql_free_result($lineacant);

mysql_free_result($condcant);

mysql_free_result($vaciados);

mysql_free_result($totalpatio);

mysql_free_result($teus);
?>
