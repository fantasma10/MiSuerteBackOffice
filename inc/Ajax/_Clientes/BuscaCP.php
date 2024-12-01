<?php
include("../../../inc/config.inc.php");

global $RBD;

$clientCP 	= (isset($_POST['Cp']))?$_POST['Cp']:(0);

$RES			= '';
$sql 			= "SELECT `D_mnpio`,`d_estado`,`numMunicipio`,`idEntidad`  FROM `redefectiva`.`cat_colonia` WHERE `codigoColonia` =".$clientCP." GROUP BY `codigoColonia`;";
			
	$RESsql 	= $RBD->query($sql);	
	if($RESsql){
		
		if(mysqli_num_rows($RESsql)){
			
			list($nomMunicipio,$nomEdo,$idMunicipio,$idEdo)=mysqli_fetch_array($RESsql);
			$RES .= '0|'.$idMunicipio.'|'.$nomMunicipio.'|'.$idEdo.'|'.$nomEdo;
			
		}
		else{$RES .= '2|consulta sin resultado()'.$RBD->error();}
	}
	else{$RES .= '3|consulta sin resultado()'.$RBD->error();}
		
echo utf8_encode($RES);
			
?>