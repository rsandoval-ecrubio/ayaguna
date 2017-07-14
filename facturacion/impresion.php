<?php 
session_start();
require('../config.php');
$database_conexion = "appstc_ayaguna_jmp";
$username_conexion = "appstc";
$password_conexion = "nVgXi3HT40";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conexion,$conexion);

$valorfact = $_SESSION['correlativo'];

$factura = "select fact_facturas.correlativo, fact_facturas.fecha, fact_clientes.nombre_rsocial, fact_clientes.rif, fact_clientes.direccion, fact_clientes.telefono1, fact_renglones.articulo, fact_facturas.cant, fact_facturas.contenedor, fact_facturas.punitario, fact_facturas.ttl_item,  fact_facttotales.subtotal, fact_facttotales.iva, fact_facttotales.total FROM fact_facturas, fact_clientes, fact_renglones, fact_facttotales WHERE fact_facturas.articulo = fact_renglones.id and fact_facturas.correlativo = '$valorfact' and fact_facturas.cliente = fact_clientes.id and fact_facttotales.idfactura = '$valorfact'";
$muestra = mysql_query($factura, $conexion) or die("ERROR AQUI");
$valores = mysql_fetch_assoc($muestra);

$factura2 = "select fact_facturas.correlativo, fact_facturas.fecha, fact_clientes.nombre_rsocial, fact_clientes.rif, fact_clientes.direccion, fact_clientes.telefono1, fact_renglones.articulo, fact_facturas.cant, fact_facturas.contenedor, fact_facturas.punitario, fact_facttotales.subtotal, fact_facttotales.iva, fact_facttotales.total FROM fact_facturas, fact_clientes, fact_renglones, fact_facttotales WHERE fact_facturas.articulo = fact_renglones.id and fact_facturas.correlativo = '$valorfact' and fact_facturas.cliente = fact_clientes.id and fact_facttotales.idfactura = '$valorfact'";
$muestra2 = mysql_query($factura2, $conexion) or die("ERROR AQUI");
$valores2 = mysql_fetch_assoc($muestra2);

$conte = "select contenedor from fact_facturas where correlativo = '$valorfact' group by contenedor";
$doconte = mysql_query($conte, $conexion) or die (mysql_error());
$filac = mysql_fetch_assoc($doconte);

$detalles = "SELECT fact_facttotales.depcheque, fact_facttotales.montodepcheque, fact_bancos.banco, fact_facttotales.retislr, fact_facttotales.retiva FROM fact_facttotales, fact_bancos WHERE fact_facttotales.banco = fact_bancos.id and fact_facttotales.idfactura = '$valorfact'";
$edetalles = mysql_query($detalles, $conexion) or die (mysql_error());
$rowdet = mysql_fetch_assoc($edetalles);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="Javascript">
function imprimir() {
print();
}
</script>
<style>
#centrado {
	width: 600px;
	margin: 50px auto 0 auto;
}

body {
	font-size:12px;
	font-family: "Times New Roman";
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body onload="imprimir();">
<div id="centrado">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">FACTURA Nº <?php echo $_SESSION['correlativo']; ?></td>
  </tr>
  <tr>
    <td align="right">FECHA: <?php echo $valores['fecha']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="83%">RAZON SOCIAL: <?php echo $valores['nombre_rsocial']; ?></td>
        <td width="17%">RIF: <?php echo $valores['rif']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>DIRECCION:<?php echo $valores['direccion']; ?></td>
  </tr>
  <tr>
    <td>TELEFONO: <?php echo $valores['telefono1']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="11%" align="center">CANTIDAD</td>
        <td width="64%" align="center">DESCRIPCION</td>
        <td width="13%" align="center">P. UNITARIO</td>
        <td width="12%" align="center">P. TOTAL</td>
      </tr>
      
      <tr>
        <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php do { ?>
          <tr>
            <td width="12%" align="right"><?php echo $valores['cant']; ?>&nbsp;&nbsp;</td>
            <td width="63%"><?php echo $valores['articulo']; ?></td>
            <td width="13%" align="right"><?php echo $valores['punitario']; ?></td>
            <td width="12%" align="right"><?php echo $valores['ttl_item']; ?></td>
            </tr>
          <?php } while ($valores = mysql_fetch_assoc($muestra)); ?>
          </table></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td width="26%" colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr>
        <td width="15%">CONTENDOR</td>
        <td width="59%" rowspan="2" valign="top"><?php do { echo $filac['contenedor']."<br>"; } while ($filac = mysql_fetch_assoc($doconte)); ?></td>
        <td colspan="2" rowspan="2" align="center"><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="51%">SUBTOTAL</td>
            <td width="49%" align="right"><?php echo $valores2['subtotal']; ?></td>
          </tr>
          <tr>
            <td>IVA 12%</td>
            <td align="right"><?php echo $valores2['iva']; ?></td>
          </tr>
          <tr>
            <td>TOTAL</td>
            <td align="right"><?php echo $valores2['total']; ?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" rowspan="2"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="50%" height="89" valign="top"><p>CANCELACION.<br />
          DEPOSITO/CHEQUE#:&nbsp;<?php echo $rowdet['depcheque']; ?><br />
          PAGADO CON/AL BANCO:&nbsp;<?php echo $rowdet['banco']; ?><br />
          RET ISLR:&nbsp;<?php echo $rowdet['retislr']; ?><br />
          RET IVA:&nbsp;<?php echo $rowdet['retiva']; ?>
        </p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
</body>
</html>