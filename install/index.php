<?php
session_start();
define('CONFIGURACION',"Configuracion IMSSis V1.1");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/estilo_general.css">
<style>
#fieldset {
	
	border-radius:5px;
}
#instalacion {
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	width: 800px;
}
body {
	margin-top: 120px;
}
</style>
</head>
<body>
<div id="instalacion">
<fieldset id="fieldset">
<legend><?php echo CONFIGURACION; ?></legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="51%">OPCIONES GENERALES</td>
    <td width="49%">OPCIONES DE USUARIOS</td>
    </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="66%">Permitir usuarios admin/root:</td>
        <td width="34%"><input type="checkbox" name="checkbox" id="checkbox">
          <label for="checkbox"></label></td>
      </tr>
      <tr>
        <td>Permitir usuarios duplicados:</td>
        <td><input type="checkbox" name="checkbox2" id="checkbox2"></td>
      </tr>
      <tr>
        <td>Definir máximo de contraseña:</td>
        <td><label for="max_pass"></label>
          <input name="max_pass" type="text" id="max_pass" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td>Nombre de la Empresa:</td>
        <td><input name="cia_name" type="text" id="cia_name" size="10"></td>
      </tr>
      <tr>
        <td>RIF:</td>
        <td><input name="cia_rif" type="text" id="cia_rif" size="10"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="41%">Usuario #1</td>
        <td width="59%"><input name="user1" type="text" id="user1" size="10"></td>
      </tr>
      <tr>
        <td>Pass #1</td>
        <td><input name="pass1" type="text" id="pass1" size="10"></td>
      </tr>
      <tr>
        <td>Cant. de niveles</td>
        <td><input name="cant_niveles" type="text" id="cant_niveles" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>ALMACEN / AGD</td>
    <td>TABLAS</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="53%">Nombre del almacen</td>
        <td width="47%"><input name="name_almacen" type="text" id="name_almacen" size="10"></td>
      </tr>
      <tr>
        <td>Cant de Patios</td>
        <td><input name="cant_patios" type="text" id="cant_patios" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td>Cant de zonas</td>
        <td><input name="cant_zonas" type="text" id="cant_zonas" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td>Cant de bloques</td>
        <td><input name="cant_bloques" type="text" id="cant_bloques" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</fieldset>
</div>
</body>
</html>