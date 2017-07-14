<?php
session_start();
include('config.php');
include(CLASES.'class_Mysqli.php');
//include('../clases/class_Mysqli.php');

$resultados = -1;

if(isset($_POST['number'])){
	$contenedor = $_POST['number'];
	$tracking = new DBMySQLi();
	$tracking->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT * FROM tracking WHERE contenedor = '%s' ORDER BY frd DESC;",$contenedor);
	$tracking->Consulta($sql);
	$resultados = $tracking->Num_resultados;
	
	#Comprobar Tabla Inventario OLD
	$comprobar = new DBMySQLi();
	$comprobar->Datosconexion(UDB,PDB,USERDB);
	$comprobar->Consulta("show tables like 'inventariold';");
	if($comprobar->Num_resultados > 0){
		#Buscar en tabla Inventario OLD
		$archivado = new DBMySQLi();
		$archivado->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT `lineas`.`id` AS `id`,`lineas`.`nombre` AS `nombre`,`inventariold`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventariold`.`fdb` AS `fdb`,`inventariold`.`frd` AS `frd`,`inventariold`.`eir_r` AS `eir_r`,`inventariold`.`fact` AS `fact`,`inventariold`.`status` AS `status`,`inventariold`.`condicion` AS `condicion`,`inventariold`.`obs` AS `obs`,`patios`.`patio` AS `patio`,`consignatario`.`nombre` AS `consignatario`,`inventariold`.`fdespims` AS `fdespims`,`inventariold`.`eir_d` AS `eir_d`,`inventariold`.`status_d` AS `status_d`,`inventariold`.`booking` AS `booking`,`inventariold`.`c` AS `c` FROM ((((`inventariold`JOIN `lineas`)JOIN `tequipos`)JOIN `patios`)JOIN `consignatario`)WHERE ((`lineas`.`id` = `inventariold`.`linea`) AND (`tequipos`.`id` = `inventariold`.`tcont`) AND (`patios`.`id` = `inventariold`.`patio`) AND (`consignatario`.`id` = `inventariold`.`consignatario`) AND inventariold.contenedor = '%s') ORDER BY `inventariold`.`fdespims`",$contenedor);
		$archivado->Consulta($sql);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>tracking</title>
<style type="text/css">
#track {
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	width: 90%;
	float: right;
}
</style>
</head>

<body>
<div id="track">
<form id="tracking" name="tracking" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  <label>Container:
    <input name="number" type="text" class="mayuscula" id="number" size="12" maxlength="11" />
  </label>
  <input type="submit" name="trackButton" id="trackButton" value="Buscar" />
  <input type="submit" name="button" id="button" value="Limpiar" />
</form>
<br />
<div class="resultlitle" id="trackresult">
  <?php if ($resultados > 0) { // Show if recordset not empty ?>
  <p><span class="strongtext14">Linea:</span> <span class="strongtext14bw"><?php echo $tracking->Filas['nombre']; ?></span></p>
    <p><span class="strongtext14">Equipo:</span> <span class="strongtext14bw"><?php echo $tracking->Filas['contenedor']; ?></span> <span>&nbsp; <span class="strongtext14">Tipo:</span></span><span class="strongtext14bw"><?php echo $tracking->Filas['tipo']; ?></span></p>
    <table width="100%" align="center" id="trackresults">
      <caption>
        Movimientos
        </caption>
      <tr>
        <th scope="col">Arribo</th>
        <th scope="col">Entrada</th>
        <th scope="col">EIR</th>
        <th scope="col">Estatus</th>
        <th scope="col">Condicion</th>
        <th width="18%" scope="col">Obs</th>
        <th scope="col">Patio</th>
        <th scope="col">Consignatario</th>
        <th scope="col">Salida</th>
        <th scope="col">EIR</th>
        <th scope="col">FACT</th>
        <th scope="col">Estatus</th>
        <th scope="col">Booking</th>
        <th scope="col"><span title="En Inventario o Devuelto">INV/DEV</span></th>
      </tr>
      <?php do { ?>
        <tr>
          <td><div align="center"><?php echo $tracking->Filas['fdb']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['frd']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['eir_r']; ?></div></td>
          <td><div align="center"><?php estatus($tracking->Filas['status']); ?></div></td>
          <td><div align="center"><?php condicion($tracking->Filas['condicion']); ?></div></td>
          <td><div style="font-size:10px"><?php echo $tracking->Filas['obs']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['patio']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['consignatario']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['fdespims']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['eir_d']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['fact']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['status_d']; ?></div></td>
          <td><div align="center"><?php echo $tracking->Filas['booking']; ?></div></td>
          <td><div align="center"><?php inout($tracking->Filas['c']); ?></div></td>
        </tr>
        <?php } while ($tracking->Filas = mysqli_fetch_assoc($tracking->Consulta)); ?>
    </table>
    <!--Inventario Archivado-->
    <?php if($archivado->Num_resultados > 0){ ?>
    <table width="100%" align="center" id="trackresults">
      <caption>
        Movimientos
        (Archivado)
      </caption>
      <tr>
        <th scope="col">Arribo</th>
        <th scope="col">Entrada</th>
        <th scope="col">EIR</th>
        <th scope="col">Estatus</th>
        <th scope="col">Condicion</th>
        <th width="18%" scope="col">Obs</th>
        <th scope="col">Patio</th>
        <th scope="col">Consignatario</th>
        <th scope="col">Salida</th>
        <th scope="col">EIR</th>
        <th scope="col">FACT</th>
        <th scope="col">Estatus</th>
        <th scope="col">Booking</th>
        <th scope="col"><span title="En Inventario o Devuelto">INV/DEV</span></th>
      </tr>
      <?php do { ?>
        <tr>
          <td><div align="center"><?php echo $archivado->Filas['fdb']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['frd']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['eir_r']; ?></div></td>
          <td><div align="center"><?php estatus($archivado->Filas['status']); ?></div></td>
          <td><div align="center"><?php condicion($archivado->Filas['condicion']); ?></div></td>
          <td><div style="font-size:10px"><?php echo $archivado->Filas['obs']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['patio']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['consignatario']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['fdespims']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['eir_d']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['fact']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['status_d']; ?></div></td>
          <td><div align="center"><?php echo $archivado->Filas['booking']; ?></div></td>
          <td><div align="center"><?php inout($archivado->Filas['c']); ?></div></td>
        </tr>
        <?php } while ($archivado->Filas = mysqli_fetch_assoc($archivado->Consulta)); ?>
    </table><?php } ?>
    <!--Inventario Archivado-->
    <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
</div>
</div>
</body>
</html>

