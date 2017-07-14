<?php session_start(); 
$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
$numerodeletras=10; //numero de letras para generar el texto
$cadena = ""; //variable para almacenar la cadena generada
for($i=0;$i<$numerodeletras;$i++)
{
    $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
entre el rango 0 a Numero de letras que tiene la cadena */
}

$ahora = date("d-m-Y");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editar Contenedor</title>
</head>

<body>
<h1>Editar numero de contenedor</h1>
<h1>Equipo Serial Numero: <?php echo $_GET['serial'];?> </h1>
<p>Tengo el <a href="editarserial2.php?serial=<?php echo $_GET['serial']; ?>&key=<?php echo base64_encode($cadena);?>">codigo</a></p>
</body>
<?php

#Email->
$destinos = "laymont@gmail.com";
$sujeto = "AYAGUNA - Edicion de Serial de Equipo";
$mensaje = "----------------------------------------------------"."\n";
$mensaje .= "             Codigo de Validacion                   "."\n";
$mensaje .= "--------------------------------------------------- "."\n";
$mensaje .= "Fecha: ".$ahora."\n";
$mensaje .= "El Usuario: ".$_SESSION['variables']['nombreUsuario']."\n";
$mensaje .= "Codigo de Validacion: ".$cadena."\n";
$mensaje .= "copie el codigo y uselo para verificar el procedimiento. "."\n";
$mensaje .= "---------------------------------------------------- "."\n";
$mensaje .= "Mensaje generado automaticamente por AYAGUNA; por favor no responda este mensaje"."\n";
$header = "From: soporte@appstc.net"."\r\n";
//mail($destinos,$sujeto,$mensaje,$header);
#<-Email

?>
</html>