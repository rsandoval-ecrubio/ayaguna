<?php
//session_start();
require('../config.php');
require('../clases/mygeneric_class.php');

$id = $_GET['id'];
$ver = new DBMySQL;
$ver->nombreDB(USERDB);
$sql = sprintf("SELECT * FROM imagephp WHERE idcontenedor = %d;",$id);
$ver->consultarDB($sql);

$ruta = "fotosequipos/";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mostrar</title>
</head>

<body>

<?php do{ ?>
<img src="<?php echo $ruta.$ver->resultado['nombrefoto'];?>"></br>
<?php }while($ver->resultado = mysql_fetch_assoc($ver->consulta)); ?>
</body>
</html>