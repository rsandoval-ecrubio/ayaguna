<?php 
session_start();
require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prueba Variables</title>
</head>

<body>
<pre>
<?php 
print_r($_SESSION);
echo UDB.'-'.md5(PDB).'-'.USERDB;
?>
</pre>
</body>
</html>