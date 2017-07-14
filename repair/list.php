<?php
require('../config.php');
require('../clases/mygeneric_class.php');
$mostrar = NULL;
$suma20 = NULL;
$suma40 = NULL;

$linea = new DBMySQL;
$linea->nombreDB(USERDB);
$linea->consultarDB("SELECT id, nombre FROM lineas WHERE activo = 0");

if(isset($_POST['f1']) and isset($_POST['f2']) and isset($_POST['linea'])){
	$var = $_POST['linea'];
	$var1 = $_POST['f1'];
	$var2 = $_POST['f2'];

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
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reparaciones</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');?>
<div id="content">
<p>&nbsp;</p>	
  <form id="form1" name="form1" method="post" action="">
    Linea: 
    <select name="linea" id="linea">
    	<option selected="selected" value="-1">Seleccione</option>
        <?php do { ?>
        <option value="<?php echo $linea->resultado['id'];?>"><?php echo $linea->resultado['nombre'];?></option>
        <?php } while($linea->resultado = mysql_fetch_assoc($linea->consulta));?>
    </select>
    <br />
    Indique el periodo de la fecha de reparación:
<input name="f1" type="date" required="required" id="f1" />
  y 
  <input name="f2" type="date" required="required" id="f2" />
  <input type="submit" name="button" id="button" value="Mostrar" />
  </form>
<p>&nbsp;</p>
<p>
  <?php if($mostrar > 0){ ?>
</p>
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
<div id="export"><a href="../export/export_list_repair.php?var=<?php echo $var;?>&var1=<?php echo $var1;?>&var2=<?php echo $var2;?>">exportar</a></div>
<p>&nbsp; </p>
<table width="85%" border="1" align="center">
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
    <th width="45%" title="Observacion Anterior" scope="col">A.Obs</th>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center"><a href="repair_edit.php?id=<?php echo $reparaciones->resultadoli['id'];?>"><?php echo $reparaciones->resultadoli['buque'];?></a></td>
    <td align="center"><a href="repair_edit.php?id=<?php echo $reparaciones->resultadoli['id'];?>"><?php echo $reparaciones->resultadoli['viaje'];?></a></td>
    <td align="center"><a href="repair_edit.php?id=<?php echo $reparaciones->resultadoli['id'];?>"><?php echo $reparaciones->resultadoli['contenedor'];?></a></td>
    <td align="center"><?php echo $reparaciones->resultadoli['tipo'];?></td>
    <td align="center"><?php echo $reparaciones->resultadoli['fecha'];?></td>
    <td align="center"><?php echo number_format($reparaciones->resultadoli['monto'],2);?></td>
    <td align="center"><?php condicion($reparaciones->resultadoli['C-A']);?></td>
    <td align="center"><?php condicion($reparaciones->resultadoli['condicion']);?><a href="verdmg.php?id=<?php echo $reparaciones->resultadoli['idcontenedor']; ?>" target="_blank"> |Ver</a></td>
    <td align="left"><?php echo $reparaciones->resultadoli['antobs'];?></td>
  </tr><?php } while($reparaciones->resultadoli = mysqli_fetch_assoc($reparaciones->consultali));?>
</table><?php } ?>
<?php
if(isset($_POST['f1']) and isset($_POST['f2']) and isset($_POST['linea'])){
	if($reparaciones->totalli == 0){
		echo "<h2>No se consiguen Contenedores reparados con ese criterio</h2>";
	}
}
?> 
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>