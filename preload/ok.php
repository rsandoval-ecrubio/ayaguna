<?php require_once('../Connections/conexion.php'); ?>
<?php session_start(); 
if(isset($_GET['linea']) and !empty($_GET['linea'])){
	$_SESSION['intLinea'] = $_GET['linea'];
	
	$msg = "Linea: Validada";
}else {
	$msg = "Linea: Invalida";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OK</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>
<h1>El archivo se cargo correctamente en el servidor, sin embargo aun no termina el proceso de importar los datos</h1>
<p><?php echo $msg; ?></p>
<h2>Siguiente paso &gt; <a href="upload/reader.php">importar datos</a></h2>
</body>
</html>
