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
$dbs = new DBMySQL;
$dbs->consultarDB("select * from dbs");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Origen de Datos</title>
<link href="../css/front_adm_user.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="75%" id="dbs">
  <caption>
    BD - Datos
  | <a href="index.php">Regresar </a>
  </caption>
  <tr>
    <th scope="col">ID</th>
    <th width="8%" scope="col">RIF</th>
    <th width="25%" scope="col">Cliente</th>
    <th width="25%" scope="col">Dirección</th>
    <th scope="col">DB</th>
    <th scope="col">Estatus</th>
  </tr><?php do { ?>
  <tr>
    <td align="center"><?php echo $dbs->resultado['id']; ?></td>
    <td><?php echo $dbs->resultado['rif']; ?></td>
    <td><?php echo $dbs->resultado['cliente']; ?></td>
    <td><?php echo $dbs->resultado['direccion']; ?></td>
    <td align="center"><?php echo $dbs->resultado['ndatos']; ?></td>
    <td align="center"><?php show_img_result($dbs->resultado['habilitado'] + 1); ?></td>
  </tr><?php }while ($dbs->resultado = mysql_fetch_assoc($dbs->consulta));?>
</table>
</body>
</html>
<?php $dbs->liberar(); ?>