<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;

$grupo			= (isset($_POST['grupo']))?$_POST['grupo']: 0;
$giro			= (isset($_POST['giro']))?$_POST['giro']: 0;
$nombre			= (isset($_POST['nombre']))?$_POST['nombre']: '';
$telefono1			= (isset($_POST['telefono1']))?$_POST['telefono1']: '';
$telefono2			= (isset($_POST['telefono2']))?$_POST['telefono2']: '';
$fax			= (isset($_POST['fax']))?$_POST['fax']: '';
$email			= (isset($_POST['email']))?$_POST['email']: '';
$referencia			= (isset($_POST['referencia']))?$_POST['referencia']: 0;
$usuarioalta			= (isset($_POST['usuarioalta']))?$_POST['usuarioalta']: 0;


$RES		= '';

$sql 		= "SELECT `idCadena`
				FROM `redefectiva`.`dat_cadena`
				WHERE (`idGrupo` = ".$grupo."
				AND  `idcGiro` = ".$giro." AND `nombreCadena` = '".$nombre."');";
$RESsql 	= $RBD->query($sql);	

if(mysqli_num_rows($RESsql) == 0){				
	
	/*$sql 	= "INSERT INTO `redefectiva`.`dat_cadena`(`idGrupo`, `idcGiro`, `nombreCadena`, `telefono1`, `telefono2`,`fax`,`email`,`idcReferencia`,`idUsuarioAlta`,`fecAltaCadena`,`idEstatusCadena`,`idEmpleado`) 
	VALUES ($grupo,$giro,'$nombre','$telefono1','$telefono2','fax','$email',$referencia,$usuarioalta,NOW(),0,".$_SESSION['idU'].");";*/
	
$sql = "CALL `redefectiva`.SPA_ALTACADENA($grupo,$giro,'$nombre','$telefono1','$telefono2','fax','$email',$referencia,$usuarioalta,".$_SESSION['idU'].");";
	$RBD->SP($sql);
	if($RBD->error() == '')
	{
		$RES = "0|Se a insertado correctamente";
	}
	else
	{
		$RES = "2|".$RBD->error();
	}	
}else{$RES .= '3|El codigo ya esta siendo utilizado por esa Entidad';}	

		
		
echo $RES;
			
?>