<?php
/*

******* ARCHIVO NECESARIO PARA DEFINIR LA CANTIDAD Y EL REGISTRO ACTUAL DE LA PGINACION *******

*/
$actual = 0;
if(isset($_POST['actual']))
	$actual = $_POST['actual'];
else
	$actual = 1;
if(isset($_POST['cant']))
	$cant = $_POST['cant'];
$actual = $actual * $cant - $cant;
if($actual < 0)
	$actual = 0;
?>