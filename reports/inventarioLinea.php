<?php 
require_once('../config.php');
//Nuevo modelo
require_once('../clases/seguridad_class.php');
require_once('../clases/class.MySQL.php');
require_once('../stmtgral.php');
$seguridad = new Seguridad;
$seguridad->getDato();
$seguridad->valida();
seguridad();
unset($_SESSION['linea']);

//Lineas
$lineas = new MySQL(USERDB);
$lineas->Consultar("SELECT id, nombre FROM lineas WHERE activo=0;");

if(isset($_POST['linea'])){
	$linea = $_POST['linea'];
	
	//Recaps 20
	$recap20 = new MySQL(USERDB);
	$recap20->Consultar("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '2%' AND linea =".$linea." GROUP BY tipo ORDER BY tipo;");
	$recap20Total = 0;
	
	//Recaps 40
	$recap40 = new MySQL(USERDB);
	$recap40->Consultar("SELECT tipo, COUNT(*) AS cantidad FROM existenciagral WHERE tipo LIKE '4%' AND linea =".$linea." GROUP BY tipo ORDER BY tipo;");
	$recap40Total = 0;
	
	//Inventario General
	$inventario = new MySQL(USERDB);
	$consultaInvTxt = sprintf("CALL `inventarioLinea`('%s');",$linea);
	$inventario->Consultar($consultaInvTxt);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ayaguna</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include(INCLUDE_DIR.'menu_inc.php'); ?>
<div id="wrapper">
<p>&nbsp;</p>
<form action="" method="post" enctype="application/x-www-form-urlencoded" name="busqueda">
  <fieldset>
    <legend>Seleccionar</legend>
    <label>Linea
      <select name="linea" id="linea">
      <option value="-1">Linea</option>
      <?php do{ ?>
      <option value="<?php echo $lineas->Resultado['id'];?>"><?php echo htmlentities($lineas->Resultado['nombre']);?></option>
      <?php }while($lineas->Resultado = mysqli_fetch_assoc($lineas->Consulta));?>
      </select>
    </label>
    <input type="submit" name="button" id="button" value="Enviar" />
  </fieldset>
</form>
<?php if(isset($inventario->Total) and $inventario->Total > 0){?>
<table width="400" class="resumen" id="resumen">
  <tr>
        <th>Equipo de 20&quot;</th>
        <th>Equipos de 40&quot;</th>
    </tr>
      <tr>
        <td valign="top"><table width="100%" class="recaps">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr><?php do{ ?>
            <tr>
              <td><?php echo $recap20->Resultado['tipo'];?></td>
              <td><div align="right"><?php $recap20Total = $recap20->Resultado['cantidad'] + $recap20Total; echo $recap20->Resultado['cantidad'];?></div></td>
            </tr>
            <tr><?php }while($recap20->Resultado = mysqli_fetch_assoc($recap20->Consulta));?>
              <th>Sub-Total:</th>
              <th><div align="center"><?php echo $recap20Total;?></div></th>
            </tr>
        </table></td>
        <td valign="top"><table width="100%" class="recaps">
          <tr>
            <th>Tipo</th>
            <th>Cant</th>
          </tr><?php do{ ?>
            <tr>
              <td><?php echo $recap40->Resultado['tipo'];?></td>
              <td><div align="right"><?php $recap40Total = $recap40->Resultado['cantidad'] + $recap40Total; echo $recap40->Resultado['cantidad'];?></div></td>
            </tr><?php }while ($recap40->Resultado = mysqli_fetch_assoc($recap40->Consulta)); ?>
            <tr>
              <th>Sub-Total:</th>
              <th><div align="center"><?php echo $recap40Total;?></div></th>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><strong>Total de Equipos: <?php echo $recap20Total + $recap40Total;?></strong></td>
      </tr>
    </table>
<table width="98%" align="center" cellpadding="0" class="listado" id="listado" ><caption>Inventario General</caption>
  <thead>
    <tr>
      <th axis="number">Equipo</th>
      <th>Tipo</th>
      <th>Estatus</th>
      <th>Condicion</th>
      <th>Buque</th>
      <th>viaje</th>
      <th>Arrivo</th>
      <th>Descarga</th>
      <th>Ingreso</th>
      <th>EIR</th>
      <th>Patio</th>
      <th>Precinto</th>
      <th>B/L</th>
      <th>Consignatario</th>
      <th>D-Pais</th>
      <th>D-Patio</th>
    </tr>
  </thead>
  <tbody><?php do{ ?>
    <tr>
      <td axis="string"><?php echo $inventario->Resultado['contenedor'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['tipo'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['estatus'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['condicion'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['buque'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['viaje'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['fdb'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['fdm'];?></td>
      <td axis="date"><?php echo $inventario->Resultado['frd'];?></td>
      <td axis="number"><?php echo $inventario->Resultado['eir_r'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['patio'];?></td>
      <td axis="number"><?php echo $inventario->Resultado['precinto'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['bl'];?></td>
      <td axis="string"><?php echo $inventario->Resultado['consignatario'];?></td>
      <td axis="number"><?php echo $inventario->Resultado['dpais'];?></td>
      <td axis="number"><?php echo $inventario->Resultado['dpatio'];?></td>
    </tr><?php }while($inventario->Resultado = mysqli_fetch_assoc($inventario->Consulta)) ?>
  </tbody>
  	<tr>
    	<td colspan="16">&nbsp;</td>
    </tr>
  <tfoot>
  </tfoot>
</table>
<?php } ?>
</div>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>
<?php
if(isset($_POST['linea']) and $_POST['linea'] <> 0){
	$lineas->Liberar();
	$recap20->Liberar(); 
	$recap40->Liberar();
	$inventario->Liberar();
}
?>