<?php
session_start();
require('../config.php');
include(INCLUDE_DIR.'header_inc.php');
include(INCLUDE_DIR.'toindex_inc.php');
include(INCLUDE_DIR.'pie_inc.php');
seguridad();
?>
<?php
//Datos del Acta
$time = $_SESSION['time'] = $_POST['fch_hora'];
$chofer = $_SESSION['chofer'] = $_POST['nom_ape_chfer'];
$cedula = $_SESSION['cedula'] = $_POST['cedula'];
$transporte = $_SESSION['transporte'] = $_POST['transporte'];
$placa = $_SESSION['placa'] = $_POST['placa'];
$origen = $_SESSION['origen'] = $_POST['origenA']."-".$_POST['origenB'];
$factpack = $_SESSION['factpack'] = $_POST['fact_pack'];

//Datos del Equipo
$linea = $_SESSION['linea'] = $_POST['linea'];
$buque = $_SESSION['buque'] = $_POST['select2'];
$viaje = $_SESSION['viaje'] = $_POST['select3'];
$consignatario = $_SESSION['consignatario'] = $_POST['consignatario'];
$fdm = $_SESSION['fdm'] = $_POST['fdm'];
$lote = $_SESSION['lote'] = $_POST['lote'];
$equipo = $_SESSION['equipo'] = $_POST['contenedor'];
$tipo = $_SESSION['tipo'] = $_POST['tipo_cont'];
$estatus = $_SESSION['estatus'] = $_POST['estatus'];
$eir = $_SESSION['eir'] = $_POST['eir'];
if (!empty($_SESSION['dmg'])){
	$rep_dano = implode(",",$_SESSION['dmg']);
}else {
	$rep_dano = NULL;
}
$condicion = $_SESSION['condicion'] = $_POST['condicion'];
$bl = $_SESSION['bl'] = $_POST['bl'];
$precinto = $_SESSION['precinto'] = $_POST['precinto'];
$fact = $_SESSION['fact'] = $_POST['fact_pack'];
$ubicacion = $_SESSION['ubicacion'] = $_POST['ubicacion'];
$obs = $_SESSION['obs'] = $_POST['observ'];
$auditoria = $_SESSION['auditoria'] = $_SESSION['auth'];

//Seleccionar Db
mysql_select_db($database_conexion,$conexion);
//Consultar
$container = $_POST['contenedor'];
$sprun = mysql_query("SELECT COUNT(c) AS registrado FROM inventario WHERE contenedor = '$container' AND c = 0; ",$conexion)or die(mysql_error());
$sprow = mysql_fetch_assoc($sprun);
$registro = $sprow['registrado'];

//echo "funcion: ".$sprow['registrado'];

if($registro != 0){
	$error = 1; //Contenedor en sistema
}else {
	$error = 0;
	//Datos del viaje
	$sqltxtViaje = "SELECT * FroM viajes WHERE id = '$viaje'";
	$sqlrunViaje = mysql_query($sqltxtViaje,$conexion) or die(mysql_error());
	$filaViaje = mysql_fetch_assoc($sqlrunViaje);
	$numViaje = mysql_num_rows($sqlrunViaje);
	if($numViaje > 0){
		$error = 0;
		$viajeDate = $filaViaje['ad'];
	}else {
		$error = 2; //Viaje sin fecha de arribo
	}	
if($error == 0){
	
//Registrar acta
mysql_select_db($database_conexion,$conexion);
$sqltxt = "INSERT INTO acta_recepcion (fch_hora, nom_ape_chfer, cedula, transporte, placa, origen, factpack, nula, auditoria) VALUES ('$time', '$chofer', '$cedula', '$transporte', '$placa','$origen', '$factpack', 0, 1)"; 
$sqlrun = mysql_query($sqltxt,$conexion) or die(mysql_error());

//Numero de Acta registrada
$id_acta = mysql_insert_id();
$acta_eir = $_SESSION['eir_x_acta'] = $id_acta;

//MODIFICADO POR SAMUEL MEDINA PARA GENERAR CODIGO DE BARRAS
//CREO RANDOM, ALMACENO EN SESSION Y BD
		$random1 = mt_rand(2, 888);
		$random2 = mt_rand(2, 999);
		$random3 = (int)$id_acta;
		$cod_gen1 = $_SESSION['barcod'] = $random1.$random3.$random2;
		$qry_acta2 = "UPDATE acta_recepcion SET codigo_b_actas = '$cod_gen1' WHERE idacta = '$id_acta'";
		$exec_acta2 = mysql_query($qry_acta2,$conexion) or die(mysql_error());

//Registrar Equipo en inventario
$sqltxt_eq = "INSERT INTO inventario (acta, linea, buque, viaje, tcont, contenedor, lote, fdb, fdm, frd, eir_r, rep_dano, `status`, condicion, precinto, bl, patio, consignatario, auditoria, codigo_b_actas) VALUES ('$id_acta','$linea','$buque','$viaje','$tipo','$equipo','$lote','$viajeDate','$fdm','$ahora','$eir','$rep_dano','$estatus','$condicion','$precinto','$bl','$ubicacion','$consignatario','$auditoria','$cod_gen1')";
$sqlrun_eq = mysql_query($sqltxt_eq,$conexion) or die(mysql_error());

//Numero del registro del contenedor
$id_equipo = mysql_insert_id();

//REGISTRAR DATOS PARA EL EIR CORRESPONDIENTE A EL CONTENEDOR
$vartime = explode(" ",$time);
$varfecha = $vartime[0];
$varhoras = $vartime[1];

$qry_eir = "INSERT INTO eir (eir_acta, eir_contenedor, eir_estado, eir_precinto, eir_BL, eir_buque, eir_viaje, eir_hora, eir_fecha, eir_tam_cont, eir_transportista, eir_fecha_entrega, eir_placa_entrega, eir_rep_trans_entrega, eir_cedula_entrega) VALUES ('$id_acta', '$equipo', '$estatus', '$precinto', '$bl', '$buque', '$viaje', '$varhoras', '$varfecha', '$tipo', '$linea', '$varfecha', '$placa', '$chofer', '$cedula')";
$exe_eir = mysql_query($qry_eir,$conexion) or die(mysql_error());

$idpre = $_SESSION['idpre'];
mysql_query("UPDATE precarga SET ingresado = 1 WHERE id = '$idpre'",$conexion) or die(mysql_error()." Error: no se actualizo tabla precarga");
unset($_SESSION['idpre']);

//REGISTRO DEL ULTIMO EIR CREADO
$_SESSION['eir_actual'] = mysql_insert_id();

//Vaciar variable de daños
$_SESSION['dannos'] = $_SESSION['dmg'];
unset($_SESSION['dmg']);

}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>AYAGUNA</title>
<script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript" src="../js/lightbox.js"></script>
<link rel="stylesheet" type="text/css" href="../css/default.css"/>
<link rel="stylesheet" type="text/css" href="../css/lightbox.css"/>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>
</head>
<body>
    <div id="act_rec">
      <fieldset id="acta">
      <h2>
        <legend>Movimientos - Recepcion - Acta de recepcion - <?php echo $time = date("Y-m-d H:i:s"); ?></legend>
      </h2>
      <?php if($error == 0){ ?>
      <h1>Registro exitoso</h1>
      <p><a href="print_actas.php?acta=<?php echo $id_acta; ?>" target="_blank">Imprimir Acta</a></p>
      <p><a href="#" target="_blank">Generar EIR</a></p>
      <?php } ?>
      <?php if($error > 0){ ?>
      <h1>Error<?php echo "  ".$error; ?></h1>
      <?php if($error == 1){?><p class="errorBig">El equipo que esta intentado registrar ya se encuentra en el inventario.</p><?php }?>
      <?php if($error == 2){?><p class="errorBig">El viaje indicado no tiene fecha de arribo asignada</p><?php }?>
      <?php } ?>
      </fieldset>
</div>
</body>
</html>