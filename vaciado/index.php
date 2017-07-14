<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
include('../clases/mygeneric_class.php');
seguridad();
?>
<?php
$DB = $database_conexion;
$Qconsig = new DBMySQL();
$Qconsig->nombreDB($DB);
$Qconsig->consultarDB("SELECT id, nombre FROM consignatario");

if(isset($_POST['consig'])){
	$Consignatario = $_POST['consig'];
	$Qvaciado = new DBMySQL();
	$Qvaciado->nombreDB($DB);
	$Qvaciado->consultarDB("SELECT * FROM existencia WHERE `status` = 1 AND idconsignatario = $Consignatario");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/mootools.js"></script>
<script type="text/javascript" src="../js/sortableTable.js"></script>
<link href="../css/sortableTable.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  <p>&nbsp;</p>
  <table width="520" class="resumen"><caption>Indentificacion de Consignatario</caption>
    <tr>
      <td width="79">Consignatario</td>
      <td width="387"><label for="consig"></label>
        <select name="consig" id="consig">
          <option value="">Seleccione</option>
          <?php
do {  
?>
          <option value="<?php echo $Qconsig->resultado['id']?>"><?php echo $Qconsig->resultado['nombre']?></option>
          <?php
} while ($Qconsig->resultado = mysql_fetch_assoc($Qconsig->consulta));
  $rows = mysql_num_rows($Qconsig->consulta);
  if($rows > 0) {
      mysql_data_seek($Qconsig->consulta, 0);
	  $Qconsig->resultado = mysql_fetch_assoc($Qconsig->consulta);
  }
?>
      </select></td>
      <td width="38"><input type="submit" name="button" id="button" value="ver" /></td>
    </tr>
  </table>
</form>
<?php if($Qvaciado->total > 0){?>
<form id="form2" name="form2" method="post" action="confirmar.php">
  <table width="80%" align="center" id="pf_sortableTable1">
    <caption>
      Equipos Full
   &nbsp; 
   <input type="submit" name="button2" id="button2" value="Confirmar" />
    </caption>
    <tr>
      <th width="26" scope="col">#</th>
      <th width="90" scope="col">Equipo</th>
      <th width="42" scope="col">Tipo</th>
      <th width="52" scope="col">Linea</th>
      <th width="38" scope="col">B/L</th>
      <th width="80" scope="col">Precinto</th>
      <th width="100" scope="col">Recepcion</th>
      <th width="38" scope="col">EIR</th>
      <th width="135" scope="col">Consignatario</th>
      <th width="55" scope="col">Patio</th>
    </tr><?php do { ?>
    <tr>
      <td><input name="id" type="checkbox" id="id" value="<?php echo $Qvaciado->resultado['id'];?>" /></td>
      <td><?php echo $Qvaciado->resultado['contenedor']; ?></td>
      <td><?php echo $Qvaciado->resultado['tipo']; ?></td>
      <td><?php echo $Qvaciado->resultado['nlinea']; ?></td>
      <td><?php echo $Qvaciado->resultado['bl']; ?></td>
      <td><?php echo $Qvaciado->resultado['precinto']; ?></td>
      <td><?php echo $Qvaciado->resultado['frd']; ?></td>
      <td><?php echo $Qvaciado->resultado['eir_r']; ?></td>
      <td><?php echo $Qvaciado->resultado['consignatario']; ?></td>
      <td><?php echo $Qvaciado->resultado['patio']; ?></td>
    </tr><?php }while ($Qvaciado->resultado = mysql_fetch_assoc($Qvaciado->consulta));?>
  </table>
</form>
<?php } ?>
<p>&nbsp;</p>
</body>
</html>