<?php
require_once('../config.php');
require_once('../clases/seguridad_class.php');
require_once('../clases/class.MySQL.php');

//seguridad();
unset($_SESSION['index']);
$total = array();
$totalc = array();

$numeracion = 0;
$linea = $_SESSION['variables']['linea'];
$resultado = 0;

$lineas = new MySQL(USERDB);
$lineas->Consultar(sprintf("SELECT nombre AS linea FROM lineas WHERE id = %d",$linea));

$recaps = new MySQL(USERDB);
$recaps->Consultar(sprintf("SELECT inv.linea, teq.tipo, COUNT(*) AS cantidad FROM inventario AS inv, tequipos AS teq WHERE inv.c = 0 AND inv.tcont = teq.id AND inv.linea = %d GROUP BY inv.tcont, inv.linea",$linea));

$recapsCondicion = new MySQL(USERDB);
$recapsCondicion->Consultar(sprintf("SELECT inv.linea, teq.tipo, COUNT(*) AS cantidad, inv.condicion FROM inventario AS inv, tequipos AS teq WHERE inv.c = 0 AND inv.tcont = teq.id AND inv.linea = %d GROUP BY inv.tcont, inv.linea, inv.condicion ORDER BY teq.tipo, inv.condicion",$linea));
 
if(isset($_POST['container']) and !empty($_POST['container'])){
	$container = $_POST['container'];
	$tracking = new MySQL(USERDB);
	$tracking->Consultar(sprintf("SELECT * FROM tracking WHERE id = %d AND contenedor = '%s'",$linea,$container));
	$resultado = $tracking->Total;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>AYAGUNA</title>
<link href="../css/estilo_general_cli.css" rel="stylesheet" type="text/css">
<link href="tabs.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/validaciones.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function()
    {
        $("#lista").tablesorter();
    }
);
</script>
</head>
<body>
<header><?php include(INCLUDE_DIR.'menu_cli_inc.php');?></header>
<div id="wrapper">
<h1>Linea: <?php echo $_SESSION['online'] = $lineas->Resultado['linea']; ?></h1>
<!-- Botón que activa el panel -->
<a href="#" id="abre_tab">
  <div id="tab"> 
        <div id="tab_interna">
        
        </div>
    </div> 
</a>
<!-- Panel oculto -->
<div id="panel">
    <div class="contenido">
        <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <label for="container">Container #</label>
  <input name="container" type="text" id="container" maxlength="11" onBlur="ISO6346(this.id);">
  <input type="submit" name="button" id="button" value="Track">
</form>
<div id="resultado">&nbsp;</div>
<?php if($resultado > 0){?>
<p>Contenedor: <?php echo $tracking->Resultado['contenedor']; ?><br>
Tipo:<?php echo $tracking->Resultado['tipo']; ?></p>
<table cellpadding="0" class="listado" id="lista" >
  <caption>
    Tracking 
  </caption>
  <thead>
    <tr>
      <th>Mov.</th>
      <th>Arribo</th>
      <th>Ingreso</th>
      <th>EIR</th>
      <th>Consig.</th>
      <th>Estatus</th>
      <th>Condicion</th>
      <th>Obs.</th>
      <th>Patio</th>
      <th>Salida</th>
      </tr>
  </thead>
  <tbody>
    <?php do { ?>
    <tr>
      <td align="right"><?php echo $numeracion = $numeracion + 1;?></td>
      <td><?php echo $tracking->Resultado['fdb']; ?></td>
      <td align="center"><?php echo $tracking->Resultado['frd']; ?></td>
      <td><?php echo $tracking->Resultado['eir_r']; ?></td>
      <td align="center"><a title="<?php echo $tracking->Resultado['consignatario']; ?>" href="#">Ver</a></td>
      <td align="center"><?php estatus($tracking->Resultado['status']); ?></td>
      <td align="center"><?php condicion($tracking->Resultado['condicion']); ?></td>
      <td align="center"><a href="#" title="<?php echo $tracking->Resultado['obs']; ?>">Ver</a></td>
      <td align="center"><?php echo $tracking->Resultado['patio']; ?></td>
      <td align="right"><?php echo $tracking->Resultado['fdespims']; ?></td>
      </tr>
    <?php }while($tracking->Resultado = mysqli_fetch_assoc($tracking->Consulta))?>
  </tbody>
</table>
<?php } ?> 
    </div>    
</div>
<script type="text/javascript" language="javascript">
(function($){
  var $contenido = $(".contenido").hide(),
      $tab = $('#tab'),
      $tab_interna = $('#tab_interna'),
      $panel = $('#panel')
      $abre_tab = $('a#abre_tab');
     
  $abre_tab.on('click',function(e){ e.preventDefault();});
   
  $tab.toggle(
    function(){
      $tab
        .stop()
        .animate({
          right: "720px"
        },500, function(){
          $tab_interna.addClass('expandida');
        });
      $panel
        .stop()
        .animate({
          width: "720px",
          opacity: 0.8
        }, 500, function(){
          $contenido.fadeIn('slow');
        });
    },
    function(){
      $contenido.fadeOut('slow', function() {
        $tab
          .stop()
          .animate({
            right: "0"
          },500, function(){
            $tab_interna.removeClass();
          });
        $panel
          .stop()
          .animate({
            width: "0",
            opacity: 0.1
          }, 500);
      });
    }
  );
})(jQuery);
</script>
<table width="100%" class="recaps"><caption>Resumen por Tipos</caption>
  <tr>
    <th>Tipo</th>
    <th>Cant</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td><?php echo $recaps->Resultado['tipo']; ?></td>
    <td><div align="right"><?php echo $total[] = $recaps->Resultado['cantidad']; ?></div></td>
  </tr>
  <?php }while($recaps->Resultado = mysqli_fetch_assoc($recaps->Consulta));?>
  <tr>
    <th>Sub-Total:</th>
    <th><div align="center"><?php echo array_sum($total); ?></div></th>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" class="recaps">
  <caption>
    Resumen por Condicion
    </caption>
  <tr>
    <th>Tipo</th>
    <th>Cant</th>
    <th>Condicion</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td><?php echo $recapsCondicion->Resultado['tipo']; ?></td>
    <td><div align="right"><?php echo $totalc[] = $recapsCondicion->Resultado['cantidad']; ?></div></td>
    <td align="center"><?php condicion($recapsCondicion->Resultado['condicion']); ?></td>
  </tr>
  <?php }while($recapsCondicion->Resultado = mysqli_fetch_assoc($recapsCondicion->Consulta));?>
  <tr>
    <th>Sub-Total:</th>
    <th><div align="center"><?php echo array_sum($totalc); ?></div></th>
    <th>&nbsp;</th>
  </tr>
</table>
</div>
<footer><?php include(INCLUDE_DIR.'pie_inc.php'); ?></footer>
</body>
</html>
