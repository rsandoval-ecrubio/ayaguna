<?php
include('../../config.php');
seguridad();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AYAGUNA</title>
<style type="text/css">
html{
   height:100%;
   }

body{
   background: #9FB6CD;
   background: -moz-linear-gradient(top, #C6E2FF 0%, #9FB6CD 100%);
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#C6E2FF), color-stop(100%,#9FB6CD));
   font-family: sans-serif;
   }
      
.BackIzq {
	float: left;
	width: 60px;
}

#Formulario {
	width: 90%;
	background: #eee;
	border: 1px solid #e1e1e1;
	-moz-box-shadow: 0px 0px 8px #444;
	-webkit-box-shadow: 0px 0px 8px #444;
	border-radius: 20px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px;
	margin-top: 20px;
	margin-right: auto;
	margin-bottom: auto;
	margin-left: auto;
	padding: 30px;
   }
legend{
	font-size: 14px;
	color: #445668;
	text-transform: uppercase;
	font-weight: bold;
}
label {
	float: left;
	width: 120px;
	text-align: right;
	font-size: 14px;
	color: #445668;
	text-transform: uppercase;
	text-shadow: 0px 1px 0px #f2f2f2;
	font-weight: bold;
	margin-top: 11px;
	margin-right: 20px;
	margin-bottom: 0;
	margin-left: 0;
	clear: left;
   }
   
input {
	width: 140px;
	height: 35px;
	background: #5E768D;
	background: -moz-linear-gradient(top, #C6E2FF 0%, #9FB6CD 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#C6E2FF), color-stop(100%,#9FB6CD));
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-box-shadow: 0px 1px 0px #C6E2FF;
	-webkit-box-shadow: 0px 1px 0px #C6E2FF2;
	font-family: sans-serif;
	font-size: 14px;
	color: #191970;
	text-transform: uppercase;
	text-shadow: 0px -1px 0px #C6E2FF;
	margin-top: 0;
	margin-right: 20;
	margin-bottom: 10px;
	margin-left: 0;
	padding-top: 2px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 10px;
   }

select {
	width: auto;
	height: 35px;
	background: #5E768D;
	background: -moz-linear-gradient(top, #002c3c 0%, #204c5c 20%); /* firefox */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#002c3c), color-stop(20%,#204c5c)); /* webkit */
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-box-shadow: 0px 1px 0px #f2f2f2;
	-webkit-box-shadow: 0px 1px 0px #f2f2f2;
	font-family: sans-serif;
	font-size: 14px;
	color: #191970;
	text-transform: uppercase;
	text-shadow: 0px -1px 0px #334f71;
	margin-top: 0;
	margin-right: 0;
	margin-bottom: 10px;
	margin-left: 0;
	padding-top: 2px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 10px;
   }   

input::-webkit-input-placeholder  {
   color: #191970; 
   text-shadow: 0px -1px 0px #38506b; 
   text-transform:capitalize;
   }   
   
input:-moz-placeholder {
   color: #191970; 
   text-shadow: 0px -1px 0px #38506b; 
   text-transform:capitalize;
   }
   
textarea {
	width: auto;
	height: auto;
	background: #BCD2EE;
	background: -moz-linear-gradient(top, #BCD2EE 0%, #BCD2EE 20%); /* firefox */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#BCD2EE), color-stop(20%,#BCD2EE)); /* webkit */
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-box-shadow: 0px 1px 0px #f2f2f2;
	-webkit-box-shadow: 0px 1px 0px #f2f2f2;
	font-family: sans-serif;
	font-size: 14px;
	color: #f2f2f2;
	text-transform: uppercase;
	text-shadow: 0px -1px 0px #334f71;
	resize: none;
	margin-top: 0;
	margin-right: 0;
	margin-bottom: 20px;
	margin-left: 0;
	padding-top: 12px;
	padding-right: 20px;
	padding-bottom: 0px;
	padding-left: 20px;
   }
   
textarea::-webkit-input-placeholder  {
   color: #ddd; 
   text-shadow: 0px -1px 0px #38506b; 
   text-transform:capitalize;
   }

textarea:-moz-placeholder {
   color: #ddd; 
   text-shadow: 0px -1px 0px #38506b; 
   text-transform:capitalize;
   }

input:focus, textarea:focus {
   background: #BCD2EE;
   background: -moz-linear-gradient(top, #BCD2EE 0%, #BCD2EE 20%); /* firefox */
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#BCD2EE), color-stop(20%,#BCD2EE)); /* webkit */
   }

input[type=submit]{
	width: 90px;
	height: 52px;
	float: right;
	-moz-box-shadow: 0px 0px 5px #999;
	-webkit-box-shadow: 0px 0px 5px #999;
	border: 1px solid #556f8c;
	background: -moz-linear-gradient(top, #BCD2EE 0%, #BCD2EE 20%); /* firefox */
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#BCD2EE), color-stop(20%,#BCD2EE)); /* webkit */
	cursor: pointer;
	margin-top: 0;
	margin-right: 7px;
	margin-bottom: 0;
	margin-left: 0;
	padding-top: 5px;
	padding-right: 7px;
	padding-bottom: 5px;
	padding-left: 7px;
   }

input[type=submit]:hover {
   width: 90px; height: 52px; 
   float: right; 
   padding: 10px 15px; 
   margin: 0 15px 0 0;
   -moz-box-shadow: 0px 0px 5px #999;
   -webkit-box-shadow: 0px 0px 5px #999;
   border: 1px solid #556f8c;
   background: -moz-linear-gradient(top, #BCD2EE 0%, #BCD2EE 20%); /* firefox */
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#BCD2EE), color-stop(20%,#BCD2EE)); /* webkit */
   cursor: pointer;
   }            
}
</style>
</head>

<body>
<header><?php include(INCLUDE_DIR.'header_inc.php'); ?></header>
<nav><?php echo ATRASLink; ?></nav>
<article>
<form id="Formulario" name="Formulario" method="post" action="">
  <fieldset>
    <legend>Ingreso</legend>
      <p>
        <label for="eir"></label>
        <input type="number" name="eir" id="eir" placeholder="EIR" require_onced />

        <label for="factura"></label>
        <input type="number" name="factura" id="factura" placeholder="Factura" />

        <label for="pase"></label>
        <input type="number" name="pase" id="pase" placeholder="Pase" />
      </p>
       <hr />
      <p><legend>Datos del Viaje</legend><br />
        <label for="linea"></label>
        <select name="linea" id="linea">
          <option value="0">Seleccione la Linea</option>
        </select>
        <label for="buque"></label>
        <select name="buque" id="buque">
        	<option value="0">Seleccione el Buque</option>
        </select>
        <label for="viaje"></label>
        <select name="viaje" id="viaje">
        	<option value="0">Seleccione el Viaje</option>
        </select>
    </p>
   	<hr />
      <p><legend>Datos del Contenedor</legend><br />
        <label for="contenedor"></label>
        <input type="text" name="contenedor" id="contenedor" placeholder="Serial de Contenedor" require_onced />
        <label for="tipo"></label>
        <select name="tipo" id="tipo">
        	<option value="0">Tipo de Contenedor</option>
        </select>
        <label for="condicion"></label>
        <select name="condicion" id="condicion">
        	<option value="0">Condicion</option>
        </select>
        <br />
        <label for="bl"></label>
        <input type="text" name="bl" id="bl" placeholder="B/L" />
        
        <label for="precinto"></label>
        <input type="text" name="precinto" id="precinto" placeholder="Precinto" />
      </p>
       <hr />
       <p>
       <label for="fmuelle">Fecha</label>
       <input name="fmuelle" type="date" id="fmuelle" placeholder="Fecha Despacho" input.value="aaaa-mm-dd" title="Muelle" />
       
       <label for="fingreso"></label>
       <input type="date" name="fingreso" id="fingreso" placeholder="Fecha Ingreso" input.value="aaaa-mm-dd" title="Ingreso" />
       </p>
       <label for="consignatario"></label>
        <select name="consignatario" id="consignatario">
        	<option value="0">Consignatario</option>
        </select>

        <label for="ubicacion"></label>
    <select name="ubicacion" id="ubicacion">
        	<option value="0">Seleccione el patio</option>
        </select>
        <br />
       	<label for="obs">Observaciones</label>
   	<textarea name="obs" id="obs" cols="45" rows="5"></textarea>
    <input type="submit" name="button" id="button" value="Enviar" />  
  </fieldset>
</form>
</article>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>