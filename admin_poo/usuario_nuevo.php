<?php
session_start();
include('../includes/config.php');
require('../clases/seguridad_class.php');
require('../funciones/funciones_poo.php');
require('../clases/mygeneric_class.php');
//Seguridad
$seguridad = new Seguridad();
$seguridad->getDato();
$seguridad->valida();
?>
<?php
//Bases de Datos Consulta
$baseDatos = new DBMySQL;
$baseDatos->nombreDB($_SESSION['variables']['db']);
$baseDatos->consultarDB("SELECT id, ndatos FROM dbs WHERE habilitado = 0");

//Niveles
$nivelDatos = new DBMySQL;
$nivelDatos->nombreDB($_SESSION['variables']['db']);
$nivelDatos->consultarDB("SELECT id, descripcion FROM niveles");

//Lineas
$lineaDatos = new DBMySQL;
$lineaDatos->nombreDB($_SESSION['variables']['db']);
$lineaDatos->consultarDB("SELECT id, nombre FROM lineas WHERE regsta = 0 ORDER BY nombre ASC");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crear Usuario</title>
<link href="../css/front_adm_user.css" rel="stylesheet" type="text/css" />
<script src="../js/funciones_poo.js" type="text/javascript"></script>
</head>

<body onload="document.forms[0].elements[11].disabled = true;">
<h1>Nuevo Usuario</h1><span><a href="index.php">Regresar</a></span>
<form action="usuario_nuevo_procesar.php" method="post" name="newUser" id="newUser" onSubmit="Submit_seguro(this)">
  <table width="500">
    <caption>
      Datos Generales
    </caption>
    <tr>
      <td width="82">Nombre</td>
      <td width="182"><label for="nombre"></label>
      <input name="nombre" type="text" id="nombre" onblur="validarNombres(this.id,this.value)" onkeypress="return permite(event, 'car')" onkeyup="this.value=this.value.toUpperCase()" maxlength="20" />
      <span class="obligatorio">*</span></td>
      <td width="49">Apellido</td>
      <td width="167"><label for="apellido"></label>
      <input name="apellido" type="text" id="apellido" onblur="validarNombres(this.id,this.value)"')" onkeyup="this.value=this.value.toUpperCase()" maxlength="20"return permite(event, 'car />
      <span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>Correo</td>
      <td><label for="correo"></label>
      <input name="correo" type="text" id="correo" onblur="validarEmail(this.id,this.value)" />
      <span class="obligatorio">*</span></td>
      <td>Telefono</td>
      <td><label for="telefono"></label>
      <input name="telefono" type="text" id="telefono" onblur="validarTlf(this.id)" onkeypress="return permite(event, 'num')" maxlength="11"/>
      <span class="obligatorio"> *</span></td>
    </tr>
  </table>
  <hr />
  <table width="320">
    <caption>
      Datos de Acceso
    </caption>
    <tr>
      <td width="80">Usuario</td>
      <td width="228"><label for="usuario"></label>
      <input type="text" name="usuario" id="usuario" onblur="validarUsuario(this.id);" /><span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>Clave</td>
      <td><label for="c1"></label>
      <input type="password" name="c1" id="c1" onblur="validarClave(this.id)" /><span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>Confirmar</td>
      <td><label for="c2"></label>
      <input name="c2" type="password" id="c2" onblur="confirmarClave(this.id);" /><span class="obligatorio">*</span></td>
    </tr>
  </table>
  <hr />
  <table width="320">
    <caption>
      Configuracion de Acceso
    </caption>
    <tr>
      <td width="80">Datos (DB)</td>
      <td width="232"><label for="db"></label>
        <select name="db" id="db" onblur="validarLista(this.id)" >
          <option value="0">Seleccion</option>
          <?php
do {  
?>
          <option value="<?php echo $baseDatos->resultado['id']; ?>"><?php echo $baseDatos->resultado['ndatos']?></option>
          <?php
} while ($baseDatos->resultado = mysql_fetch_assoc($baseDatos->consulta));
  $rows = mysql_num_rows($baseDatos->consulta);
  if($rows > 0) {
      mysql_data_seek($baseDatos->consulta, 0);
	  $baseDatos->resultado = mysql_fetch_assoc($baseDatos->consulta);
  }
?>
      </select><span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>Tipo</td>
      <td><select name="tipo" id="tipo" onblur="validarLista(this.id)" >
        <option value="0" selected="selected">Seleccion</option>
        <option value="1">Agencia</option>
        <option value="2">Almacen</option>
        <option value="3">Consignatario</option>
        <option value="1">Linea</option>
      </select><span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>Linea</td>
      <td><label for="nivel">
        <select name="linea" id="linea" onblur="validarLista(this.id)" >
          <option value="0">Seleccion</option>
          <option value="-1">Todas</option>
          <?php
do {  
?>
          <option value="<?php echo $lineaDatos->resultado['id']?>"><?php echo $lineaDatos->resultado['nombre']?></option>
          <?php
} while ($lineaDatos->resultado = mysql_fetch_assoc($lineaDatos->consulta));
  $rows = mysql_num_rows($lineaDatos->consulta);
  if($rows > 0) {
      mysql_data_seek($lineaDatos->consulta, 0);
	  $row_linea = mysql_fetch_assoc($lineaDatos->consulta);
  }
?>
        </select>
      </label><span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>Nivel</td>
      <td><label for="nivel">
        <select name="nivel" id="nivel" onblur="validarLista(this.id); validarNewUser(this);" >
          <option value="0">Seleccion</option>
          <?php
do {  
?>
          <option value="<?php echo $nivelDatos->resultado['id']?>"><?php echo $nivelDatos->resultado['descripcion']?></option>
          <?php
} while ($nivelDatos->resultado = mysql_fetch_assoc($nivelDatos->consulta));
  $rows = mysql_num_rows($nivelDatos->consulta);
  if($rows > 0) {
      mysql_data_seek($nivelDatos->consulta, 0);
	  $row_nivel = mysql_fetch_assoc($nivelDatos->consulta);
  }
?>
        </select>
      </label><span class="obligatorio">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <hr />
  <p>
    <input name="enviar" type="submit" id="enviar" value="Crear" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
$baseDatos->liberar();
$nivelDatos->liberar();
$lineaDatos->liberar();
?>
