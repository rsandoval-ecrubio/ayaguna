<?php
require('../config.php');
require_once ('../clases/mygeneric_class.php');
seguridad();

#Lineas del Listado
$lineas = new DBMySQL;
$qlineas = "SELECT lista.linea, lineas.nombre FROM lista, lineas WHERE lista.linea = lineas.id GROUP BY lista.linea";
$lineas->consultarDBli(1,$qlineas);

if(isset($_POST['linea'])){
	#Listado
	$descargas = new DBMySQL;
	$consulta = sprintf("SELECT lista.id, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, viajes.eta, lista.equipo, tequipos.tipo, consignatario.nombre AS `consignatario` FROM lista, lineas, buques, viajes, consignatario, tequipos WHERE lista.linea = lineas.id AND lista.buque = buques.id AND lista.viaje = viajes.id AND lista.consig = consignatario.id AND lista.tipo = tequipos.id AND lineas.id = %d ORDER BY lista.id DESC",$_POST['linea']);
$descargas->consultarDBli(1,$consulta);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Listas de Descarga</title>
<style>
nav {
	margin-left: 10px;
	margin-top: 10px;
	margin-bottom: 10px;

}
table {
	margin-left: 20px;
	margin-bottom: 60px;
}

.listado {
	font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
	font-size: medium;
}
.listado caption {
	font-weight: bold;
	font-size: large;
}

.listado tr th {
	background-color: #BCD2EE;
}

.listado tr td {
	border: solid;
	border-width: thin;
}

.listado tr td a {
	text-decoration: none;
	color: #4682B4;
}

body nav a {
	text-decoration: none;
}
</style>
</head>

<body>
<header><?php include(INCLUDE_DIR.'header_inc.php'); ?></header>
<nav>
  <p><a href="../index.php">Volver al inicio</a></p>
</nav>
<article>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="application/x-www-form-urlencoded" name="form1" id="form1">
    <label for="linea">Selecione la Linea:</label>
    <select name="linea" id="linea">
    <option value="-1">Seleccione</option>
    <?php do { ?>
      <option value="<?php echo $lineas->resultadoli['linea']; ?>"><?php echo $lineas->resultadoli['nombre']; ?></option>
      <?php } while($lineas->resultadoli = mysqli_fetch_assoc($lineas->consultali)); ?>
    </select>
    <input type="submit" name="submit" id="submit" value="Enviar">
</form>
</article>
<?php if(isset($_POST['linea'])){ ?>
<article>
  <table width="85%" cellpadding="2" cellspacing="2" class="listado">
    <caption>
      <br>
    Listados de Descarga | (<?php echo $descargas->totalli; ?>)
    </caption>
    <tr>
      <th width="43" scope="col">Id</th>
      <th width="92" scope="col">Linea</th>
      <th width="103" scope="col">Buque</th>
      <th width="84" scope="col">Viaje</th>
      <th width="97" scope="col">Fecha</th>
      <th width="116" scope="col">Equipo</th>
      <th width="107" scope="col">Tipo</th>
      <th width="206" scope="col">Consignatario</th>
    </tr>
    <?php do{ ?>
    <tr>
      <td align="center"><?php echo $descargas->resultadoli['id']; ?></td>
      <td align="center"><?php echo $descargas->resultadoli['linea']; ?></td>
      <td align="center"><?php echo $descargas->resultadoli['buque']; ?></td>
      <td align="center"><?php echo $descargas->resultadoli['viaje']; ?></td>
      <td align="center"><?php echo $descargas->resultadoli['eta']; ?></td>
      <td align="center"><a href="../gatein/gatein_precarga.php?id=<?php echo $descargas->resultadoli['id']; ?>" ><span title="Ingresar"><?php echo $descargas->resultadoli['equipo']; ?></span></a></td>
      <td align="center"><?php echo $descargas->resultadoli['tipo']; ?></td>
      <td align="left"><?php echo $descargas->resultadoli['consignatario']; ?></td>
    </tr>
    <?php } while($descargas->resultadoli = mysqli_fetch_assoc($descargas->consultali)); ?>
  </table>
</article><?php } ?>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>