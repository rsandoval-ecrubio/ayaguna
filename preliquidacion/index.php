<?php
session_start();

$db = $_SESSION['variables']['ndb'];
$var1 = $_GET['var1'];
$var2 = $_GET['var2'];

/* Bases de datos */
#1 =>"appstc_ayaguna_jmp"
#2 =>"appstc_ayaguna_menfel"
#3 =>"appstc_ayaguna_conslg"
#4 =>"appstc_ayaguna_gonavi"
#5 =>"appstc_ayaguna_multimenfel"
#6 =>"appstc_ayaguna_multiorion"
#7 =>"appstc_ayaguna_daqui"
			   
$paginas = array(1 =>"pre_jmp.php",
				 2 =>"pre_menfel.php",
				 3 =>"pre_conslg",
				 4 =>NULL,
				 5 =>NULL,
				 6 =>NULL,
				 7 =>NULL
				 );			   

$vinculo = sprintf("Location: %s?var1=%s&var2=%s",$paginas[$db],$var1,$var2);
header($vinculo);
?>