<?php 
require('../../config.php');
require('../../clases/mygeneric_class.php'); 

//Lineas
$lineas = new DBMySQL;
$lineas->nombreDB(USERDB);
$lineas->consultarDB("SELECT id, nombre FROM lineas WHERE activo = 0");

//Niveles
$niveles = new DBMySQL;
$niveles->nombreDB(MASTERTABLE);
$niveles->consultarDB("SELECT id, descripcion from niveles");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
</head>
<body>
<?php include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
?>
<div class="info" id="info">
<h2 align="center">Nuevo Usuario</h2>
<form id="form1" name="form1" method="post" action="qry_usuarios.php">
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="29%">Nombre(s):</td>
      <td width="71%"><input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase()"/></td>
    </tr>
    <tr>
      <td>Apellidos(s):</td>
      <td><input type="text" name="apellido" id="apellido" onkeyup="this.value=this.value.toUpperCase()" /></td>
    </tr>
    <tr>
      <td>Tel&eacute;fono:</td>
      <td><input type="text" name="tlf" id="tlf" /></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input type="text" name="email" id="email" onkeyup="this.value=this.value.toLowerCase()" /></td>
    </tr>
    <tr>
      <td>Usuario:</td>
      <td><input type="text" name="login" id="login" /></td>
    </tr>
    <tr>
      <td>Clave:</td>
      <td><input type="password" name="pass" id="pass" /></td>
    </tr>
    <tr>
      <td>Repetir Clave</td>
      <td><input type="password" name="pass1" id="pass1" onblur="return clave(this,pass,button);" /></td>
    </tr>
    <tr>
      <td>Tipo</td>
      <td><select name="tipo" id="tipo">
        <option value="1" selected="selected">Interno</option>
        <option value="2">Externo</option>
      </select></td>
    </tr>
    <tr>
      <td>Linea</td>
      <td><label>
        <select name="linea" id="linea">
          <option value="-1" selected="selected">TODAS</option>
		  <?php do { ?>
          <option value="<?php echo $lineas->resultado['id']; ?>"><?php echo $lineas->resultado['nombre']; ?></option>
          <?php } while ($lineas->resultado = mysql_fetch_assoc($lineas->consulta)); ?>
</select>
      </label></td>
    </tr>
    <tr>
      <td>Nivel</td>
      <td><label>
        <select name="nivel" id="nivel">
        <option value="0" selected="selected">Seleccione</option>
            <?php do { ?>
            <option value="<?php echo $niveles->resultado['id'];?>"><?php echo $niveles->resultado['descripcion'];?></option>
            <?php } while($niveles->resultado = mysql_fetch_assoc($niveles->consulta));?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><input name="auditoria" type="hidden" id="auditoria" value="001" />
        <input name="db" type="hidden" id="db" value="<?php echo $_SESSION['variables']['ndb']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="Crear" />
      </label></td>
    </tr>
  </table>
</form>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>