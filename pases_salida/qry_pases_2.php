<?php
session_start();
require('../config.php');
/////////////////////////////////////////////////////////////////////
$pase = $_SESSION['idpase'];
$Qqry = "SELECT * from pase_salida where idpase = '$pase'";
$Qexe = mysql_query($Qqry, $conexion) or die(mysql_error());
$fila_p = mysql_fetch_assoc($Qexe);
$fecha_pase = $fila_p['fch_hora'];
/////////////////////////////////////////////////////////////////////
if(!empty($_POST['campos'])) {
$aLista=array_keys($_POST['campos']);
//$sQuery="DELETE FROM inventario_cg where id IN (".implode(',',$aLista).")";
$sQuery="UPDATE inventario_cg SET idpase ='$pase', fecha_pase = '$fecha_pase', in_out = '1' where idinventario_cs IN (".implode(',',$aLista).")";
$execute_ok = mysql_query($sQuery, $conexion) or die(mysql_error());
if($execute_ok = true) { header("location:index_pases.php?cont_pase=ok&con_valores=true"); } else { header("location:add_items_pases?error=true"); }
}

?>