<?php 
session_start();
require('../../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
include('../../../clases/mygeneric_class.php');

$Buques = new DBMySQL();
$Buques->nombreDB($_SESSION['variables']['db']);
$Buques->consultarDB("SELECT buques.id, lineas.nombre AS linea, buques.nombre AS buque FROM buques, lineas WHERE buques.activo = 0 AND lineas.id = buques.linea ORDER BY buque");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../../../css/estilo_general.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.info {
	width: 900px;
	padding: 4px;
}
#info {
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	margin-top: 0px;
}
#index {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
#index tr td {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
</style>
<body>
<div class="info" id="info">
<h2 align="center">Tablas - Viaje</h2>
  <hr />
<fieldset>
<legend>Viaje nuevo</legend>
<form id="form1" name="form1" method="post" action="qry_viajes.php">
  <table width="40%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="29%">Buque</td>
      <td width="71%"><label>
        <select name="buque" id="buque" form="form1">
        <option>Seleccione una buque</option>
        <?php do { ?>
        <option value="<?php echo $Buques->resultado['id']; ?>"><?php echo strtoupper($Buques->resultado['buque'])." | <strong>".strtoupper($Buques->resultado['linea'])."</strong>"; ?></option>
        <?php } while($Buques->resultado = mysql_fetch_assoc($Buques->consulta));?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Viaje:</td>
      <td><label>
        <input name="viaje" type="text" id="viaje" form="form1" onkeyup="this.value=this.value.toUpperCase()" />
        </label></td>
    </tr>
    <tr>
      <td>Arribo</td>
      <td><label>
        <input name="eta" type="date" required="required" id="eta" form="form1" />
     &nbsp; YYYY-MM-DD</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input name="ad" type="hidden" id="ad" form="form1" />
        &nbsp;</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button2" id="button2" value="Agregar" />
        </label></td>
    </tr>
  </table>
</form>
</fieldset>
<hr />
</div>
</body>
</html>