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
//Consulta
$Niveles = new DBMySQL;
$Niveles->consultarDB("select * from niveles");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Niveles</title>
<link href="../css/front_adm_user.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="600" id="niveles">
  <caption>
    Niveles
  | <a href="index.php">Regresar</a>
  </caption>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Descripcion</th>
    <th scope="col">Leer</th>
    <th scope="col">Escribir</th>
    <th scope="col">Editar</th>
    <th scope="col">Borrar</th>
    <th scope="col">Avanzado</th>
  </tr><?php do{ ?>
  <tr>
    <td align="center"><?php echo $Niveles->resultado['id']; ?></td>
    <td><?php echo $Niveles->resultado['descripcion']; ?></td>
    <td align="center"><?php show_img_result($Niveles->resultado['lectura']);?></td>
    <td align="center"><?php show_img_result($Niveles->resultado['escritura']);?></td>
    <td align="center"><?php show_img_result($Niveles->resultado['edicion']);?></td>
    <td align="center"><?php show_img_result($Niveles->resultado['borrado']);?></td>
    <td align="center"><?php show_img_result($Niveles->resultado['avanzado']);?></td>
  </tr><?php }while ($Niveles->resultado = mysql_fetch_assoc($Niveles->consulta));?>
</table>
</body>
</html>
<?php $Niveles->liberar(); ?>