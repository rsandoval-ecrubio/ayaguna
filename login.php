<html>
<head>
<title>AYAGUNA - ACCESO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body,td,th {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 14px;
}
#apDiv1 {
	-moz-border-radius:7px;
	-webkit-border-radius:7px;
	position:absolute;
	top:222px;
	width:200px;
	height:115px;
	z-index:2;
	overflow: visible;
	visibility: visible;
	left: 64%;
	background-color: #FFF;
	opacity:0.9;
}

.inputText {
	font-family: Calibri, "Calibri Bold Caps";
	font-size: 12px;
	font-weight: bold;
	color: #000;
	background-color: #CCC;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border: 1px solid #A2C4EA;
	text-align: center;
}
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- ImageReady Slices (login.ai) -->
<div id="apDiv1">
  <form id="acceso" name="acceso" method="post" action="procesador.php">
    <table width="195" align="center">
      <caption style="color:#F00">
        <strong>
          <?php if(isset($_GET['Error'])){ echo $_GET['Error']; }else{ echo "Acceso"; } ?>
      </strong>
      </caption>
      <tr>
        <td width="58"><strong>Usuario:</strong></td>
        <td width="140"><label for="usuario3"></label>
          <input name="usuario" type="text" class="inputText" id="usuario3" size="14" maxlength="12" /></td>
      </tr>
      <tr>
        <td><strong>Clave:</strong></td>
        <td><label for="clave"></label>
          <input name="clave" type="password" class="inputText" id="clave" size="14" maxlength="12" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Entrar" /></td>
      </tr>
    </table>
  </form>
</div>
<table width="800" height="350" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
	<tr>
		<td height="179" colspan="2" align="left" valign="top">
			<img src="login/images/login_02.jpg" width="142" height="179" alt=""></td>
		<td align="left" valign="top">
			<img src="login/images/login_03.jpg" width="141" height="179" alt=""></td>
		<td colspan="2" align="left" valign="top">
			<img src="login/images/login_04.jpg" width="142" height="179" alt=""></td>
		<td height="350" rowspan="2">
			<img src="login/images/login_05.jpg" width="377" height="350" alt=""></td>
  </tr>
	<tr>
		<td>
			<img src="login/images/login_06.jpg" width="1" height="171" alt=""></td>
		<td align="left" valign="top">
			<img src="login/images/login_07.jpg" width="141" height="171" alt=""></td>
		<td align="left" valign="top">
			<img src="login/images/login_08.jpg" width="141" height="171" alt=""></td>
		<td align="left" valign="top">
			<img src="login/images/login_09.jpg" width="141" height="171" alt=""></td>
		<td>
			<img src="login/images/login_10.jpg" width="1" height="171" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
<p align="center" style="font-size:16px;">Dele un vistazo a <a href="../ceq/acceso.php" target="_blank">Ayaguna 2.0</a> (Beta Alpha)<br>
Acceso a Clientes <a href="http://appstc.net/ceq/acceso.php">Aqui</a></p>
</body>
</html>