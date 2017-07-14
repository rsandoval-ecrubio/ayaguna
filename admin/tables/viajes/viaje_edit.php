<?php 
//session_start();
require_once('../../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
include('../../../clases/mygeneric_class.php');

if(isset($_GET['id']) and $_GET['id'] <> NULL){
	$idviaje = $_GET['id'];
	$editar = new DBMySQL();
	$editar->nombreDB(USERDB);
	$consulta = sprintf("SELECT * FROM viajes WHERE id =%d",$idviaje);
	$editar->consultarDB($consulta);
	
	$buque = new DBMySQL();
	$buque->nombreDB(USERDB);
	$qbuque = sprintf("SELECT nombre FROM buques WHERE id = %d",$editar->resultado['buque']);
	$buque->consultarDB($qbuque);
}


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
<form id="form1" name="form1" method="post" action="update_viaje.php">
  <table width="40%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="29%">Buque</td>
      <td width="71%"><input name="nbuque" type="text" id="nbuque" form="form1" value="<?php echo $buque->resultado['nombre']; ?>" readonly="readonly" />
        <input name="buque" type="hidden" id="buque" form="form1" value="<?php echo $editar->resultado['buque']; ?>" /></td>
    </tr>
    <tr>
      <td>Viaje:</td>
      <td><label>
        <input name="viaje" type="text" id="viaje" form="form1" onkeyup="this.value=this.value.toUpperCase()" value="<?php echo $editar->resultado['viaje']; ?>" />
        </label></td>
    </tr>
    <tr>
      <td>Arribo</td>
      <td><label>
        <input name="eta" type="date" id="eta" form="form1" value="<?php echo $editar->resultado['eta']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="id" type="hidden" id="id" form="form1" value="<?php echo $idviaje;?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="Actualizar" />
        </label></td>
    </tr>
  </table>
</form>
</fieldset>
<hr />
</div>
</body>
</html>