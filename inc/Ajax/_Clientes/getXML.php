<?php
include("../../../inc/config.inc.php");


	$idStatus			= (isset($_POST['contactos']))?$_POST['contactos']: "";	
	$idStatus			= (isset($_POST['contactos']))?$_POST['contactos']: "";	
	$idStatus			= (isset($_POST['contactos']))?$_POST['contactos']: "";	
	$idStatus			= (isset($_POST['contactos']))?$_POST['contactos']: "";	
	$idStatus			= (isset($_POST['contactos']))?$_POST['contactos']: "";	
	
	/*echo "<script>var tContactos = $idStatus;</script>"*/
    $Rows = explode("|",$idStatus);
	$Columnas = explode(",",$Rows[0]);
	echo "0|".$idStatus;
?>
