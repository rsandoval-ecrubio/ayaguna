<?php
//Vaciar
session_start();
unset($_SESSION['dmg']);
header('Location: reporte.php');
?>
