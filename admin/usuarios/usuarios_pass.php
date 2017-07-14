<?php 
require('../../config.php');
require('../../clases/mygeneric_class.php');

if(isset($_GET['id']) and !empty($_GET['id'])){
	$usuario = new DBMySQL;
	$usuario->nombreDB(MASTERTABLE);
	$usuario->consultarDB(sprintf("SELECT * FROM usuarios WHERE id = %d",$_GET['id']));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
<!--////////////fin////////////////////// -->
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
<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
</head>
<body onload="Noenter();">
<?php include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
?>
<div class="info" id="info">
<h2 align="center">Tablas - Cambio de password</h2>
  <hr />
  <fieldset>
<legend>Cambio de Password
</legend><form id="form1" name="form1" method="post" action="cambiapass.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="29%">Nombre(s):</td>
      <td width="71%"><?php echo $usuario->resultado['nombre']; ?></td>
    </tr>
    <tr>
      <td>Apellidos(s):</td>
      <td><?php echo $usuario->resultado['apellido']; ?></td>
    </tr>
    <tr>
      <td>Tel&eacute;fono:</td>
      <td><?php echo $usuario->resultado['telefono']; ?></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><?php echo $usuario->resultado['email']; ?></td>
    </tr>
    <tr>
      <td>Usuario:</td>
      <td><?php echo $usuario->resultado['usuario']; ?></td>
    </tr>
    <tr>
      <td>Nueva Contrase&ntilde;a:</td>
      <td><input type="password" name="password" id="password" style="font-size:16px;" /></td>
    </tr>
    <tr>
      <td>Repetir Contrase&ntilde;a:</td>
      <td><input type="password" name="password2" id="password2" style="font-size:16px;" onblur="return clave(this,password,button);" /></td>
    </tr>
    <tr>
      <td><input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>" /></td>
      <td><label>
        <input type="submit" name="button" id="button" value="Cambiar" />
        </label></td>
    </tr>
  </table>
</form>
</fieldset>
  <hr />
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>  
</body>
</html>