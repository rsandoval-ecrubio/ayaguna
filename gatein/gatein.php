<?php
session_start();
require('../config.php');
require_once('../Connections/conexion.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

/*                   

*/
mysql_select_db($database_conexion, $conexion);
$query_linea = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC";
$linea = mysql_query($query_linea, $conexion) or die(mysql_error());
$row_linea = mysql_fetch_assoc($linea);
$totalRows_linea = mysql_num_rows($linea);

mysql_select_db($database_conexion, $conexion);
$query_tipo = "SELECT id, tipo FROM tequipos ORDER BY tipo ASC";
$tipo = mysql_query($query_tipo, $conexion) or die(mysql_error());
$row_tipo = mysql_fetch_assoc($tipo);
$totalRows_tipo = mysql_num_rows($tipo);

mysql_select_db($database_conexion, $conexion);
$query_consig = "SELECT id, nombre FROM consignatario ORDER BY nombre ASC";
$consig = mysql_query($query_consig, $conexion) or die(mysql_error());
$row_consig = mysql_fetch_assoc($consig);
$totalRows_consig = mysql_num_rows($consig);

mysql_select_db($database_conexion, $conexion);
$query_patios = "SELECT * FROM patios ORDER BY patio ASC";
$patios = mysql_query($query_patios, $conexion) or die(mysql_error());
$row_patios = mysql_fetch_assoc($patios);
$totalRows_patios = mysql_num_rows($patios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AYAGUNA</title>
<script src="../js/funciones.js" type="text/javascript"></script>
<script src="select_dependientes_3_niveles.js" type="text/javascript"></script>
<script src="../js/validaciones.js" type="text/javascript"></script>
<script src="verificarEQ.js" type="text/javascript"></script>
<script type="text/javascript">
// The following should be put in your external js file,
// with the rest of your ondomready actions.
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('La informacion requerida esta incompleta o contiene errores :\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}
function FdmFrd(){
	
	var fdm = gatein.fdm.value;
	var fdmano = fdm.substring(0,4);
	var fdmmes = fdm.substring(5,7) - 1;
	var fdmdia = fdm.substring(8,10);
	var fechafdm = new Date(fdmano, fdmmes,fdmdia);
	
	var frd = gatein.frd.value;
	var frdano = frd.substring(0,4);
	var frdmes = frd.substring(5,7) - 1;
	var frddia = frd.substring(8,10);
	var fechafrd = new Date(frdano, frdmes, frddia);
	
	if(fdm > frd){
		gatein.fdm.focus();
		alert("La fecha de recepcion no puede ser menor a la del despacho");
	}
}
</script>
<script type="text/javascript" language="javascript">
//Crear nuevo consignatario
function NuevoReg(){
	var AntReg = document.getElementById('consignatario').selectedIndex;
	var NuevoInput = document.getElementById('nuevoConsig');
	if(AntReg == 1){
		NuevoInput.style.display = 'block';
	}
}
</script>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<style>
#consignatario {
	width: 220px;
}
#newconsig {
	width: 220px;
	text-transform: capitalize;
}
</style>
</head>
<body>
<div id="wrapper">
  <div id="content">
    <div id="modulo_title">
      <h2>MOVIMIENTO DE ENTRADA</h2>
    </div>
    <form action="procesar_gatein.php" method="post" id="gatein">
      <table width="620">
        <tr>
          <th colspan="6"><div align="left">DATOS GENERALES DEL INGRESO</div></th>
        </tr>
        <tr>
          <td><div align="right">EIR:</div></td>
          <td><input name="eir" type="text" class="txtImportante" id="eir" onblur="validaeir(this.id)" onkeypress="return permite(event, 'num')" size="8" maxlength="6" required="required"/></td>
          <td><div align="right">Factura</div></td>
          <td><input name="fact" type="text" id="fact" size="12" /></td>
          <td><div align="right">Pase</div></td>
          <td><input name="paset" type="text" id="paset" size="12" /></td>
        </tr>
        <tr>
          <td><div align="right">Linea:</div></td>
          <td><select name="linea" id="linea" onchange="cargaContenido(this.id)" onblur="validaMenu(this.id)" >
            <option value="-1">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_linea['id']?>"><?php echo $row_linea['nombre']?></option>
            <?php
} while ($row_linea = mysql_fetch_assoc($linea));
  $rows = mysql_num_rows($linea);
  if($rows > 0) {
      mysql_data_seek($linea, 0);
	  $row_linea = mysql_fetch_assoc($linea);
  }
?>
          </select></td>
          <td><div align="right">Buque:</div></td>
          <td><select name="select2" disabled="disabled" id="select2" onblur="validaMenu(this.id)" >
            <option value="-1">Select</option>
          </select></td>
          <td><div align="right">Viaje:</div></td>
          <td><select name="select3" id="select3" disabled="disabled" onblur="validaMenu(this.id)" >
            <option value="-1">Select</option>
          </select></td>
        </tr>
        <tr>
          <td><div align="right">Equipo:</div></td>
          <td><div>
            <input name="contenedor" type="text" id="contenedor" onblur="validarContenedor(this.id,this.value); verificaExistencia(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase(); compUsuario(event);" size="12" maxlength="11" />
            <input name="validacion" type="text" class="txtImportante" id="validacion" size="1" readonly="readonly" />
            <div class="errorBig" id="DivDestino"></div>
          </div></td>
          <td><div align="right">Tipo:</div></td>
          <td><select required aria-required="true"  name="tipo_cont" id="tipo_cont" onblur="validaMenu(this.id)" >
            <option value="0">Seleccione el tipo </option>
            <?php
do {  
?>
            <option value="<?php echo $row_tipo['id']?>"><?php echo $row_tipo['tipo']?></option>
            <?php
} while ($row_tipo = mysql_fetch_assoc($tipo));
  $rows = mysql_num_rows($tipo);
  if($rows > 0) {
      mysql_data_seek($tipo, 0);
	  $row_tipo = mysql_fetch_assoc($tipo);
  }
?>
          </select></td>
          <td><div align="right">Estatus:</div></td>
          <td><select name="estatus" id="estatus">
            <option value="1">FULL</option>
            <option value="0" selected="selected">EMPTY</option>
          </select></td>
        </tr>
        <tr>
          <td><div align="right">F. Muelle:</div></td>
          <td><input name="fdm" type="date" id="fdm" onblur="validaFecha(this.id)" value="<?php echo date('Y-m-d');?>" size="10" maxlength="10" /> 
          *Despacho de muelle</td>
          <td><div align="right">F. Recep.:</div></td>
          <td><input name="frd" type="date" id="frd" onblur="validaFecha(this.id); FdmFrd()" value="<?php echo date('Y-m-d');?>" size="10" maxlength="10" /></td>
          <td><div align="right">Condicion:</div></td>
          <td><select name="condicion" id="condicion">
            <option value="1" selected="selected">OPR-1</option>
            <option value="2">OPR-2</option>
            <option value="3">OPR-3</option>
            <option value="0">DMG</option>
            <option value="4">N-OPR</option>
          </select></td>
        </tr>
        <tr>
          <td><div align="right">Consignatario:</div></td>
          <td colspan="3"><select required aria-required="true"  name="consignatario" id="consignatario" onblur="validaMenu(this.id);NuevoReg();" >
            <option value="0">Seleccion</option>
            <option value="-1">Nuevo</option>
            <?php
do {  
?>
            <option value="<?php echo $row_consig['id']?>"><?php echo $row_consig['nombre']?></option>
            <?php
} while ($row_consig = mysql_fetch_assoc($consig));
  $rows = mysql_num_rows($consig);
  if($rows > 0) {
      mysql_data_seek($consig, 0);
	  $row_consig = mysql_fetch_assoc($consig);
  }
?>
          </select>
          <div id="nuevoConsig" style="display:none"><input name="newconsig" type="text" id="newconsig" /></div></td>
          <td><div align="right">B/L:</div></td>
          <td><input name="bl" type="text" id="bl" onblur="validarBL(this.id)" onkeypress="return permite(event, 'num_car')" onkeyup="this.value=this.value.toUpperCase()" size="16" /></td>
        </tr>
        <tr>
          <td><div align="right">Ubicacion:</div></td>
          <td><select required aria-required="true"  name="ubicacion" id="ubicacion">
            <option value="0">Seleccion</option>
            <?php
do {  
?>
            <option value="<?php echo $row_patios['id']?>"><?php echo $row_patios['patio']?></option>
            <?php
} while ($row_patios = mysql_fetch_assoc($patios));
  $rows = mysql_num_rows($patios);
  if($rows > 0) {
      mysql_data_seek($patios, 0);
	  $row_patios = mysql_fetch_assoc($patios);
  }
?>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="right">Precinto:</div></td>
          <td><input name="precinto" type="text" id="precinto" onblur="validaCampo(this.id)" onkeypress="return permite(event, 'num_car')" size="16" /></td>
        </tr>
        <tr>
          <td><div align="right">Observaciones</div></td>
          <td colspan="5"><textarea name="obs" id="obs" cols="40" rows="3"></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><input name="enviar" type="submit" disabled="disabled" id="enviar" onclick="YY_checkform('gatein','eir','#q','0','Campo \'eir\' no es valido.','contenedor','#q','0','Campo \'contenedor\' No es valido.','fdm','#q','0','Campo \'fdm\' No es valido.','frd','#q','0','Campo \'frd\' No es valido.','linea','#q','1','Campo \'linea\' No es valido.','select2','#q','1','Campo \'select2\' No es valido.','select3','#q','1','Campo \'select3\' No es valido.','tipo_cont','#q','1','Campo \'tipo_cont\' No es valido.','consignatario','#q','1','Campo \'consignatario\' No es valido.','ubicacion','#q','1','Campo \'ubicacion\' No es valido.');return document.MM_returnValue" value="Continuar" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><script type="text/javascript">
			var ejemplo = new Date();
			document.write('fecha ' + fecha); 
            </script>
            &nbsp;</td>
        </tr>
      </table>
    </form>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($linea);

mysql_free_result($tipo);

mysql_free_result($consig);

mysql_free_result($patios);
?>
