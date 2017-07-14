<?php
//session_start();
require_once('../../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
require_once(CLASES.'mygeneric_class.php');
require_once('../../clases/class.MySQL.php');

$lineas = new DBMySQL();
$lineas->nombreDB($_SESSION['variables']['db']);
$sql = "SELECT id, nombre FROM lineas WHERE activo = 0";
$lineas->consultarDB($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function validarDatos(){
	if(linea.selectedIndex == 0){
		boton.disabled = true;
		linea.focus();
		alert('Debe seleccionar la linea');
	}else {
		boton.disabled = false;
	}
}
</script>
</head>
<body>
<form id="form1" name="form1" method="post" action="cobracopio.php">
  <table width="380" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <th scope="row"><label for="linea"></label>
        <div align="right">
      Linea:      </div></th>
      <th scope="row"><div align="left">
        <select name="linea" id="linea" onchange="boton.disabled = false;">
          <option value="0">Seleccion</option>
          <?php do{ ?>
          <option value="<?php echo $lineas->resultado['id'];?>"><?php echo $lineas->resultado['nombre'];?></option>
          <?php }while($lineas->resultado = mysql_fetch_assoc($lineas->consulta)); ?>
        </select>
      </div></th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row"><label for="despacho"></label>
        <div align="right">Fecha Despacho:      </div></th>
      <th scope="row"><div align="left">
        <input name="despacho" type="date" id="despacho" value="<?php echo date('Y-m-d'); ?>" size="10" input.value="aaaa-mm-dd" />
      </div></th>
      <td><input name="boton" type="submit" id="boton" onclick="validarDatos()" value="Enviar" /></td>
    </tr>
  </table>
</form>
</body>
</html>