<?php 
session_start();
require('../../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toadmin_inc.php');
include(INCLUDE_DIR.'pie_inc.php');

mysql_select_db($database_conexion,$conexion);

//QUERY DE VIAJES
$_pagi_sql = "SELECT * FROM consignatario";

$_pagi_cuantos = 15;
$_pagi_nav_num_enlaces = 3;
$_pagi_nav_anterior = "&lt;";
$_pagi_nav_siguiente = "&gt;";
include('../../funciones/paginar.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<link href="../../css/estilo_general.css" rel="stylesheet" type="text/css" />
<!--////////////fin////////////////////// -->
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.info {
	width: 900px;
	padding: 4px;
}
#info {
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	margin-top: 0px;
}
#index {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
#index tr td {
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
</style>
</head>
<body>
<div class="info" id="info">
<h2 align="center">Tablas - Viaje</h2>
  <hr />
  <fieldset>
  <table id="pf_sortableTable" cellpadding="0" width="60%">
  <caption>
Listado de Viajes
  </caption>
    <thead>
      <tr>
        <th colspan="6" axis="number"><?php echo $_pagi_navegacion; ?></th>
        </tr>
      <tr>
        <th axis="number">#</th>
        <th axis="string">RIF</th>
        <th axis="string">NOMBRE</th>
        <th axis="string">P. CONTACTO</th>
        <th axis="date">TELEF</th>
        <th axis="date">EMAIL</th>
      </tr>
    </thead>
    <tbody>
	<?php while($row = mysql_fetch_array($_pagi_result)){ ?>
      <tr>
        <td class="center"><?php echo $row['id']; ?></td>
        <td align="center"><?php echo $row['rif']; ?></td>
        <td align="center"><?php echo $row['nombre']; ?></td>
        <td align="center"><?php echo $row['pcontacto']; ?></td>
        <td align="center"><?php echo $row['telf']; ?></td>
        <td align="center"><?php echo $row['email']; ?></td>
      </tr>
	  <?php }  ?>
    </tbody>
    <tfoot>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tfoot>
</table>
</fieldset>
</div>
<script type="text/javascript">
// BeginWebWidget phatfusion_sortableTable: pf_sortableTable1

		var pf_sortableTable1 = {};
		window.addEvent('domready', function(){
			pf_sortableTable1 = new sortableTable('pf_sortableTable1', {overCls: 'over'});
		});
	

// EndWebWidget phatfusion_sortableTable: pf_sortableTable1
    </script>
</div>
</body>
</html>