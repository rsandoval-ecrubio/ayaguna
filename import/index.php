<?php 
require('../config.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Importar</title>
</head>

<body>
<?php include(INCLUDE_DIR.'header_inc.php'); ?>
<div id="content">
  <p><a href="../admin/index.php">Regresar</a></p>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    	<input type="hidden" name="MAX_FILE_SIZE" value="5242880">
		Subir este archivo: <br><br>
		<input name="userfile" type="file"><br><br>
		<input type="submit" value="Subir">
    </form>
    <div class="resultado">
    <?php
	?>
    </div>
</div>
<?php include(INCLUDE_DIR.'pie_inc.php'); ?>
</body>
</html>