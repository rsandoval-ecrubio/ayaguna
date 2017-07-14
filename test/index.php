<?php 
session_start();
//-->Conexion
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "localhost";
$database_conexion = "imssisc_overseas";
$username_conexion = "root";
$password_conexion = "";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
//<--Conexion
//require_once('../Connections/conexion.php');
//Consulta tabla tequipos
mysql_select_db($database_conexion,$conexion);
$sqltxt = "SELECT id, tipo FROM tequipos WHERE id NOT IN (13,14) ORDER BY tipo";
$sqlrun = mysql_query($sqltxt,$conexion)or die(mysql_error()." No se pudo consultar los tipos de equipo");
$sqlfile = mysql_fetch_assoc($sqlrun);
$sqltotal = mysql_num_rows($sqlrun);

//Pinta
//Variables
//Izquierda
$marcardmg['i1'] = NULL;
$marcardmg['i2'] = NULL;
$marcardmg['i3'] = NULL;
$marcardmg['i4'] = NULL;
$marcardmg['i5'] = NULL;
//Derecha
$marcardmg['r1'] = NULL;
$marcardmg['r2'] = NULL;
$marcardmg['r3'] = NULL;
$marcardmg['r4'] = NULL;
$marcardmg['r5'] = NULL;
//Superior
$marcardmg['t1'] = NULL;
$marcardmg['t2'] = NULL;
$marcardmg['t3'] = NULL;
$marcardmg['t4'] = NULL;
$marcardmg['t5'] = NULL;
//Inferior
$marcardmg['b1'] = NULL;
$marcardmg['b2'] = NULL;
$marcardmg['b3'] = NULL;
$marcardmg['b4'] = NULL;
$marcardmg['b5'] = NULL;
//Frente
$marcardmg['fi'] = NULL;
$marcardmg['fd'] = NULL;
//Detras
$marcardmg['rei'] = NULL;
$marcardmg['red'] = NULL;
//Interior
$marcardmg['oi'] = NULL;
$marcardmg['od'] = NULL;

//Omitir->
if(isset($_POST['lado']) and isset($_POST['dano']) and isset($_POST['tipo'])){
//Omitir->

//Tipo de equipo
$tipoequipo = $_POST['tipo'];
//Daños
///*
if(!empty($_POST['panel'])){
	$strdmg[] = $_POST['lado'].$_POST['panel'].$_POST['dano'];
}else {
	$strdmg[] = $_POST['lado'].$_POST['dano'];
}
//*/
//$strdmg[] = NULL;
$tipos = array(1=>5,2=>5,3=>5,4=>5,5=>5,6=>5,7=>11,8=>11,9=>11,10=>11,11=>11,13=>0,14=>0,15=>11,16=>5,17=>5);
$buscarTipo = array_key_exists($tipoequipo,$tipos);
switch($tipos[$tipoequipo]){
	case $tipos[$tipoequipo] == 5:
	$lados = array('I1'=>'i1','I2'=>'i2','I3'=>'i3','I4'=>'i4','I5'=>'i5','R1'=>'r1','R2'=>'r2','R3'=>'r3','R4'=>'r4','R5'=>'r5',
				     'T1'=>'t1','T2'=>'t2','T3'=>'t3','T4'=>'t4','T5'=>'t5','B1'=>'b1','B2'=>'b2','B3'=>'b3','B4'=>'b4','B5'=>'b5',
					 'FI'=>'fi','FD'=>'fd','REI'=>'rei','RED'=>'red','RF'=>'rf');
	break;
	case $tipos[$tipoequipo] == 11;
	$lados = array('I1'=>'i1','I2'=>'i1','I3'=>'i2','I4'=>'i2','I5'=>'i3','I6'=>'i3','I7'=>'i4','I8'=>'i4','I9'=>'i5','I10'=>'i5',
				   'I11'=>'i5','R1'=>'r1','R2'=>'r1','R3'=>'r2','R4'=>'r2','R5'=>'r3','R6'=>'r3','R7'=>'r4','R8'=>'r4','R9'=>'r5',
				   'R10'=>'r5','R11'=>'r5','T1'=>'t1','T2'=>'t1','T3'=>'t2','T4'=>'t2','T5'=>'t3','T6'=>'t3','T7'=>'t4','T8'=>'t4',
				   'T9'=>'t5','T10'=>'t5','T11'=>'t5','B1'=>'b1','B2'=>'b1','B3'=>'b2','B4'=>'b2','B5'=>'b3','B6'=>'b3','B7'=>'b4',
				   'B8'=>'b4','B9'=>'b5','B10'=>'b5','B11'=>'b5','FI'=>'fi','FD'=>'fd','REI'=>'rei','RED'=>'red','RF'=>'rf');
	break;
}

//Contar los daños reportados y normalizar para bucle for
$totaldmg = count($strdmg) -1;
for($i=0;$i<=$totaldmg;$i++){
	
		#Si el segundo caracter es una letra
		$caracterDos = substr($strdmg[$i],1,1); 
		if (preg_match('/[A-Z]/m', $caracterDos)){
			#El daño es delante o detras
			if(strlen($strdmg[$i]) < 4){
				$lado = substr($strdmg[$i],0,2);
				$marcardmg[$lados[$lado]] = substr($strdmg[$i],-1);				
			}else if(strlen($strdmg[$i]) > 3){
				$lado = substr($strdmg[$i],0,3);
				$marcardmg[$lados[$lado]] = substr($strdmg[$i],-1);
			}
		}else {
			#De lo contrario
			if(strlen($strdmg[$i]) < 4){
				
				$lado3 = substr($strdmg[$i],0,2);
				$marcardmg[$lados[$lado3]] = substr($strdmg[$i],-1);
			}else if(strlen($strdmg[$i]) > 3){
				$lado4 = substr($strdmg[$i],0,3);
				$marcardmg[$lados[$lado4]] = substr($strdmg[$i],-1);
			}
		}
}
//<-Fin omitir
}
//<-Fin omitir
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AYAGUNA</title>
<script language="javascript">
function indicaPaneles(){
	var tipo = document.getElementById('tipo').value;
	var paneles = null;
	var strE20 = new Array (1,2,3,4,5,6,16,17);
	var strE40 = new Array(7,8,9,10,11,15);
	var Go = false;
	var panel = document.getElementById("panel");
	if(Go == false){
		for(x=0;x<=strE20.length;x++){
			if(strE20[x] == tipo){
				paneles = 5;
				Go2 = true;
			}else{
				Go2 = false;
			}
		}
	}
	
	if(Go2 == false){
		for(i=0;i<=strE40.length;i++){
			if(strE40[i] == tipo){
				paneles = 11;
				Go = true;
				Go2 = true;
			}else {
				Go = false;
				Go2 = false;
			}
		}
	}
	
	//alert(paneles);
	if(paneles == 5){
		var opciones = new Array('Seleccione',1,2,3,4,5);
		for(var j=0;j<opciones.length;j++){
			panel.options[j] = new Option(opciones[j]);
		}
	}else if(paneles == 11){
		var opciones = new Array('Seleccione',1,2,3,4,5,6,7,8,9,10,11);
		for(var y=0;y<opciones.length;y++){
			panel.options[y] = new Option(opciones[y]);
		}
	}
}

function nopanel(){
	var lado = document.getElementById("lado").value;
	var sinpanel = new Array('FI','FD','REI','RED');
	var resultado = sinpanel.indexOf(lado);
	if(resultado != -1){
		document.getElementById("panel").disabled = true;
	}else {
		document.getElementById("panel").disabled = false;
	}
}

function reeferTemp(){
	var dmg = document.getElementById('dano').value;
	if(dmg == 'REF'){
		document.getElementById('divtemp').style.display="inline";
		document.getElementById('menupanel').style.display="none";
		document.getElementById('side').style.display="none";
	}else{
		document.getElementById('divtemp').style.display="none";
		document.getElementById('menupanel').style.display="inline";
		document.getElementById('side').style.display="inline";
	}
}
</script>
</head>

<body onload="document.getElementById('panel').disabled=true;">
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for="dano">Tipo</label>
  <select name="tipo" id="tipo" onblur="indicaPaneles()" >
    <option value="0">Seleccione</option>
    <?php do { ?>
    <option value="<?php echo $sqlfile['id'];?>"><?php echo $sqlfile['tipo'];?></option>
    <?php } while($sqlfile = mysql_fetch_assoc($sqlrun));?>
  </select>
  <label for="dano">Daño</label>
  <select name="dano" id="dano" onchange="reeferTemp();">
    <option value="0">Seleccione</option>
    <option value="D">Golpe</option>
    <option value="H">Agujero</option>
    <option value="C">Roto</option>
    <option value="B">Rozadura</option>
    <option value="M">Falla</option>
    <option value="BR">Quebradura</option>
    <option value="BAT">Bateria</option>
    <option value="REF">Refrigeracion</option>
  </select>
   <div id="divtemp" style="display:none">
    <label for="temp">Temperatura</label>
    <input name="temp" type="text" id="temp" size="2" maxlength="4" />
  </div>
  <div id="side" style="display:inline">
  <label for="lado">Lado</label>
  <select name="lado" id="lado" onchange="nopanel()">
    <option>Seleccione</option>
    <option value="I">Izquierdo</option>
    <option value="R">Derecho</option>
    <option value="FI">Frente I</option>
    <option value="FD">Frente D</option>
    <option value="REI">Detras I</option>
    <option value="RED">Detras D</option>
    <option value="T">Arriba</option>
    <option value="B">Abajo</option>
  </select></div>
  <div id="menupanel" style="display:inline">
  <label for="panel">Panel</label>
  <select name="panel" id="panel" >
    <option>Seleccione</option>
  </select>
  </div>
  <input type="submit" name="button" id="button" value="Submit" />
</form>
<table width='600'>
  <tr>
    <td width='50%'><table width='292' border='0'  height='116' background='equipment.png'><caption>IZQUIERDO</caption>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr id='I'>
        <td id='0' width='20%' height='50'><div align='center'><?php echo $marcardmg['i1']; ?></div>&nbsp;</td>
        <td id='1' width='20%'><div align='center'><?php echo $marcardmg['i2']; ?></div>&nbsp;</td>
        <td id='2' width='20%'><div align='center'><?php echo $marcardmg['i3']; ?></div>&nbsp;</td>
        <td id='3' width='20%'><div align='center'><?php echo $marcardmg['i4']; ?></div>&nbsp;</td>
        <td id='4' width='20%'><div align='center'><?php echo $marcardmg['i5']; ?></div>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width='50%'><table width='292' border='0'  height='116' background='equipment.png'><caption>DERECHO</caption>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr id='R'>
        <td id='5' width='20%' height='50'><div align='center'><?php echo $marcardmg['r1']; ?></div>&nbsp;</td>
        <td id='6' width='20%'><div align='center'><?php echo $marcardmg['r2']; ?></div>&nbsp;</td>
        <td id='7' width='20%'><div align='center'><?php echo $marcardmg['r3']; ?></div>&nbsp;</td>
        <td id='8' width='20%'><div align='center'><?php echo $marcardmg['r4']; ?></div>&nbsp;</td>
        <td id='9' width='20%'><div align='center'><?php echo $marcardmg['r5']; ?></div>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width='600'>
  <tr>
    <td width='50%'><table width='292' border='0'  height='116' background='equipment.png'><caption>SUPERIOR</caption>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr id='T'>
        <td id='0' width='20%' height='50'><div align='center'><?php echo $marcardmg['t1']; ?></div>&nbsp;</td>
        <td id='1' width='20%'><div align='center'><?php echo $marcardmg['t2']; ?></div>&nbsp;</td>
        <td id='2' width='20%'><div align='center'><?php echo $marcardmg['t3']; ?></div>&nbsp;</td>
        <td id='3' width='20%'><div align='center'><?php echo $marcardmg['t4']; ?></div>&nbsp;</td>
        <td id='4' width='20%'><div align='center'><?php echo $marcardmg['t5']; ?></div>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width='50%'><table width='292' border='0'  height='116' background='equipment.png'><caption>INFERIOR</caption>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr id='B'>
        <td id='5' width='20%' height='50'><div align='center'><?php echo $marcardmg['b1']; ?></div>&nbsp;</td>
        <td id='6' width='20%'><div align='center'><?php echo $marcardmg['b2']; ?></div>&nbsp;</td>
        <td id='7' width='20%'><div align='center'><?php echo $marcardmg['b3']; ?></div>&nbsp;</td>
        <td id='8' width='20%'><div align='center'><?php echo $marcardmg['b4']; ?></div>&nbsp;</td>
        <td id='9' width='20%'><div align='center'><?php echo $marcardmg['b5']; ?></div>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width='600'>
  <tr>
    <td width='33%' valign="top"><div align='center'><table width='104' height='118' border='0' background='equipment_front.png'><caption>
    DETRAS
    </caption>
      <tr id='F'>
        <td id='0' width='20%' height='50'><div align='center'><?php echo $marcardmg['fi']; ?></div>&nbsp;</td>
        <td id='1' width='20%'><div align='center'><?php echo $marcardmg['fd']; ?></div>&nbsp;</td>
      </tr>
    </table></div></td>
    <td width='33%' valign="top"><div align='center'><table width='104' height='118' border='0' background='equipment_rear.png'><caption>
    FRENTE
    </caption>
      <tr id='RE'>
        <td id='5' width='20%' height='50'><div align='center'><?php echo $marcardmg['rei']; ?></div>&nbsp;</td>
        <td id='6' width='20%'><div align='center'><?php echo $marcardmg['red']; ?></div>&nbsp;</td>
      </tr>
    </table></div></td>
    <td width='33%' valign="top"><div align='center'>
      <table width='150' height='96' border='0' background='equipment_inside.png'>
        <caption>
          INTERIOR
          </caption>
        <tr id='RE2'>
          <td id='52' width='20%' height='50'><div align='center'><?php echo $marcardmg['oi']; ?></div>
            &nbsp;</td>
          <td id='62' width='20%'><div align='center'><?php echo $marcardmg['od']; ?></div>
            &nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<table width="600">
  <tr>
    <td width="50%" valign="top"><div align="center"><table width="120" height="95" background="equipment_reefer.png"><caption>REEFER</caption>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($sqlrun);
?>