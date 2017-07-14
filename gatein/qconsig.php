<?php
session_start();
require_once('../clases/mygeneric_class.php');

$qconsig = new DBMySQL();
$qconsig->nombreDB($_SESSION['variables']['db']);
$qconsig->consultarDB("SELECT id,nombre FROM `consignatario` ORDER BY nombre");

echo '<select name="consig">';
echo '<option value="0">Seleccione</option>';
echo '<option value="-1">REGISTRAR NUEVO</option>';
do {
	echo "<option value=".$qconsig->resultado['id'].">".$qconsig->resultado['nombre']."</option>";
}while($qconsig->resultado = mysql_fetch_assoc($qconsig->consulta));
echo '</select>';
?>