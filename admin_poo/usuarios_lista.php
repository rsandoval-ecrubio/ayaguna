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
$Usuarios = new DBMySQL;
$Usuarios->consultarDB("select * from usuarios");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Usuarios</title>
<link href="../css/front_adm_user.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="75%">
  <caption>
    Lista de Usuarios
  | <a href="index.php">Regresar</a>
  </caption>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Nombre</th>
    <th scope="col">Email</th>
    <th scope="col">Telefono</th>
    <th scope="col">Usuario</th>
    <th scope="col">Nivel</th>
    <th scope="col">Tipo</th>
    <th scope="col">Linea</th>
    <th scope="col">BD</th>
    <th scope="col">Habilitado</th>
  </tr><?php do{ ?>
  <tr>
    <td align="center"><?php echo $Usuarios->resultado['id']; ?></td>
    <td><?php echo $Usuarios->resultado['nombre']." ".$Usuarios->resultado['apellido']; ?></td>
    <td><?php echo $Usuarios->resultado['email']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['telefono']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['usuario']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['nivel']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['tipo']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['linea']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['datos']; ?></td>
    <td align="center"><?php echo $Usuarios->resultado['habilitado']; ?></td>
  </tr><?php }while ($Usuarios->resultado = mysql_fetch_assoc($Usuarios->consulta));?>
</table>
</body>
</html>