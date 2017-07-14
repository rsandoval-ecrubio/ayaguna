<?php
require_once('../../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
require_once('../../clases/class.MySQL.php');
require_once('../../clases/class.Acopio.php');

/* Iniciar variables */
$diasT1 = NULL;
//$tt1 = NULL;
//$tt2 = NULL;
$rt20 = array();
$rt40 = array();
$contador = 0;
//$stt1 = array();
//$stt2 = array();
$tt = array();

if(isset($_POST) and !empty($_POST)){
	$linea = $_POST['linea'];
	$despacho = $_POST['despacho'];
	
	try{
	$recap20 = new MySQL(USERDB);
	$recap20->Consultar(sprintf("SELECT tequipos.tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.tcont = tequipos.id AND inventario.linea = %d AND inventario.fdespims = '%s' AND tequipos.tipo LIKE '2%%' GROUP BY tequipos.tipo ",$_POST['linea'],$_POST['despacho']));
	
	$recap40 = new MySQL(USERDB);
	$recap40->Consultar(sprintf("SELECT tequipos.tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.tcont = tequipos.id AND inventario.linea = %d AND inventario.fdespims = '%s' AND tequipos.tipo LIKE '4%%' GROUP BY tequipos.tipo ",$_POST['linea'],$_POST['despacho']));
	
	$acopio = new MySQL(USERDB);
	$q = sprintf("CALL `acopios`('%d', '%s');",$linea,$despacho);
	$acopio->Consultar($q);
	}catch(exception $e){
		echo $e;
	}
}else {
	die("No se recibieron los datos");
}

$cobrar = new Acopio;
$cobrar->DefineLinea($_POST['linea']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<title>AYAGUNA</title>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php if($acopio->Total > 0){ ?>
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
      <?php do{ ?>
      <tr>
        <td><?php echo $recap20->Resultado['tipo']; ?></td>
        <td><div align="right"><?php echo $rt20[] = $recap20->Resultado['cantidad']; ?></div></td>
      </tr>
      <?php }while($recap20->Resultado = mysqli_fetch_assoc($recap20->Consulta)); ?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="center"><?php echo array_sum($rt20);?></div></th>
      </tr>
    </table></td>
    <td valign="top"><table width="100%">
      <tr>
        <th>Tipo</th>
        <th>Cant</th>
      </tr>
      <?php do{ ?>
      <tr>
        <td><?php echo $recap40->Resultado['tipo']; ?></td>
        <td><div align="right"><?php echo $rt40[] = $recap40->Resultado['cantidad']; ?></div></td>
      </tr>
      <?php }while($recap40->Resultado = mysqli_fetch_assoc($recap40->Consulta));?>
      <tr>
        <th>Sub-Total:</th>
        <th><div align="center"><?php echo array_sum($rt40); ?></div></th>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo array_sum($rt20) + array_sum($rt40); ?></strong></td>
  </tr>
</table>
<div id="export"><a href="cobracopio_rpt.php?linea=<?php echo $_POST['linea']; ?>&amp;despacho=<?php echo $_POST['despacho'] ?>">exportar</a></div>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" id="pf_sortableTable1">
  <caption>
    ACOPIO <?php echo $acopio->Resultado['linea']; ?>| 
  |Total: <?php echo $acopio->Total; ?> Equipos
  </caption>
  <thead>
  <tr>
    <th>ID</th>
    <th>Equipo</th>
    <th>Tipo</th>
    <th>Entrada</th>
    <th>Salida</th>
    <th>D-Patio</th>
    <th>Acopio</th>
    <th>Tarifa</th>
    <th>Monto</th>
    </tr>
  </thead>
  <tbody><?php do{ ?>
  <tr>
    <td align="center"><?php echo $contador = $contador + 1; ?></td>
    <td><?php echo $acopio->Resultado['contenedor']; ?></td>
    <td align="center"><?php echo $acopio->Resultado['tipo']; ?></td>
    <td align="center"><?php echo $acopio->Resultado['frd']; ?></td>
    <td align="center"><?php echo $acopio->Resultado['fdespims']; ?></td>
    <td align="center"><?php echo $acopio->Resultado['dpatio']; ?></td>
    <td align="center"><?php $cobrar->DimeDias($acopio->Resultado['dpatio'] - $acopio->Resultado['dlibres']); echo $cobrar->DiasAcopio; ?></td>
    <td align="center"><?php $cobrar->aCobrar($acopio->Resultado['tipo']); echo "Bs. " . number_format($cobrar->Cobra,2); ?></td>
    <?php //$tt[] = $acopio->Resultado['tt']; ?>
    <td align="right"><?php echo "Bs. " . number_format($tt[] = $cobrar->DiasAcopio * $cobrar->Cobra,2); ?></td>
    </tr><?php } while ($acopio->Resultado = mysqli_fetch_assoc($acopio->Consulta)); ?>
  </tbody>
  <tfoot>
  	<tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      <td>&nbsp;</td>
        <th>Total:</th>
        <td align="right"><?php echo "Bs. " . number_format(array_sum($tt),2,",","."); ?></td>
    </tr>
  </tfoot>
</table>
    <p>&nbsp;</p>
<p>&nbsp;</p>
<?php  }else { echo "<h1>SIN RESULTADOS</h1>"; } ?>
</body>
</html>