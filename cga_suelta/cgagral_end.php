<?php 
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php'); 
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
?>
<?php
$lvl_auth = $_SESSION['nivel'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
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
<link rel="stylesheet" type="text/css" href="../css/estilo_general.css"/>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<!--ESTO ES DEL OTRO VINCULO PARA PROBAR -->
<script type="text/javascript" src="../select/select_dependientes_3_niveles.js"></script>
<script src="../js/jquery-1.2.6.js" type="text/javascript"></script>
<script src="../js/ui.datepicker.js" type="text/javascript"></script>
<link href="../jquery.ui-1.5.2/themes/ui.datepicker.css" rel="stylesheet" type="text/css" />
<!--////////////fin////////////////////// -->

<style type="text/css">
<!--
#act_rec {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:225px;
	z-index:1;
	background-color: #FFFFFF;
}
#act_rec_cg {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:225px;
	z-index:1;
	background-color: #FFFFFF;
	
}
-->
</style>
<style type="text/css">
<!--
#pase_salida {
	position:absolute;
	left:192px;
	top:121px;
	width:616px;
	height:228px;
	z-index:2;
	background-color: #FFFFFF;
}
-->
</style>
</head>

<body>
<div class="info" id="info">
  <h2 align="center">Acta de recepción - Carga General </h2>
  <hr />
  <form id="form1" name="form1" method="post" action="qry_actas.php">
    <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="50%" align="center">Finalizar Proceso</td>
        <td width="50%" align="center">Impresión</td>
      </tr>
      <tr>
        <td align="center">Finalizar</td>
        <td align="center"><a href="print_actas.php?actaprint=<?php echo $_SESSION['acta']; ?>" target="_blank">Acta#: <?php echo $_SESSION['acta']; ?></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  <hr />
</div>
</body>
</html>