<?php 
require('../../config.php');
require('../../clases/mygeneric_class.php');
$lista = new DBMySQL;
$lista->nombreDB(MASTERTABLE);
$consulta = sprintf("SELECT * FROM usuarios WHERE datos = %d AND nivel <> -1 ORDER BY nombre",$_SESSION['variables']['ndb']);
$lista->consultarDB($consulta);
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
</head>
<body>
<?php include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
?>
<div class="info" id="info">
<h2 align="center">Tablas - Usuarios</h2>
  <hr />
<fieldset>
<legend>Listado de usuarios</legend>
<form id="form2" name="form2" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">Clave</td>
      <td align="center">Usuario</td>
      <td align="center">Nombre</td>
      <td align="center">Apellido</td>
      <td align="center">Tel&eacute;fono</td>
      <td align="center">Email</td>
      <td align="center">Nivel</td>
      <td align="center">Activo</td>
      <td align="center"><label>
        <input type="submit" name="button2" id="button2" value="desactivar" />
      </label></td>
    </tr>
    <?php do { ?>
    <tr>
      <td align="center">
      <?php if($_SESSION['variables']['nivel'] < 2){ ?>
      <a href="usuarios_pass.php?id=<?php echo $lista->resultado['id']; ?>"><img src="../../img/sys/user_edit.png" width="16" height="16" alt="Edit" title="Nueva Clave" /></a>
      <?php } ?>
      </td>
      <td align="center"><?php echo $lista->resultado['usuario']; ?></td>
      <td align="left"><?php echo $lista->resultado['nombre']; ?></td>
      <td align="left"><?php echo $lista->resultado['apellido']; ?></td>
      <td align="center"><?php echo $lista->resultado['telefono']; ?></td>
      <td align="center"><?php echo $lista->resultado['email']; ?></td>
      <td align="center"><?php echo $lista->resultado['nivel']; ?></td>
      <td align="center"><?php activo($lista->resultado['habilitado']); ?></td>
      <td align="center"><label>
                <input name="campos[<?php echo $lista->resultado['id']; ?>]" type="checkbox" />
          </label></td>
    </tr>
    <?php } while($lista->resultado = mysql_fetch_assoc($lista->consulta)); ?>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="9"></td>
      </tr>
  </table>
</form>
</fieldset>
  <hr />
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>