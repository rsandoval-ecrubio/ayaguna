<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%">
  <tr>
    <td width="50%">Registrar Daño</td>
    <td width="50%">Registro de Daños</td>
  </tr>
  <tr>
    <td valign="top"><form id="registrodano" name="registrodano" method="post" action="registro.php">
      <table width="100%">
        <tr>
          <td>Lado</td>
          <td>Panel</td>
          <td>Daño</td>
        </tr>
        <tr>
          <td><select name="lado" id="lado">
            <option value="0">Seleccione</option>
            <option value="R">Derecho</option>
            <option value="L">Izquierdo</option>
          </select></td>
          <td><select name="panel" id="panel">
            <option value="0">Seleccione</option>
            <option value="1">Panel 1</option>
            <option value="2">Panel 2</option>
            <option value="3">Panel 3</option>
            <option value="4">Panel 4</option>
            <option value="5">Panel 5</option>
            <option value="6">Panel 6</option>
            <option value="7">Panel 7</option>
            <option value="8">Panel 8</option>
            <option value="9">Panel 9</option>
            <option value="10">Panel 10</option>
            <option value="11">Panel 11</option>
          </select></td>
          <td><select name="dano" id="dano">
            <option value="0">Seleccione</option>
            <option value="D">Golpe</option>
            <option value="H">Agujero</option>
            <option value="C">Roto</option>
            <option value="B">Rozadura</option>
            <option value="M">Falla</option>
            <option value="BR">Quebradura</option>
            <option value="BAT">Bateria</option>
            <option value="REF">Refrigeracion</option>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="registrar" id="registrar" value="Agregar" /></td>
          <td><div align="center"><a href="resetdanos.php">Reiniciar</a></div></td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form></td>
    <td valign="top">
	<?php
	if(!empty($_SESSION['dmg'])){
		$result = array_unique($_SESSION['dmg']);
		echo "<ul>";
		foreach ($result as $valor){
			echo "<li>Daño: $valor</li>"; 
		}
		echo "</ul>";
	} 
	?>
    &nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>