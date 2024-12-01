<?php
$pemiso		= (isset($_POST['pemiso']))?$_POST['pemiso']: false; if($pemiso){

include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;

$correo				= (isset($_POST['correo']))?$_POST['correo']: '';
$idperfil			= (isset($_POST['idperfil']))?$_POST['idperfil']: 0;
$nombreusuario		= (isset($_POST['nombreusuario']))?$_POST['nombreusuario']: '';
$paternousuario		= (isset($_POST['paternousuario']))?$_POST['paternousuario']: '';
$maternousuario		= (isset($_POST['maternousuario']))?$_POST['maternousuario']: '';

$RES		= '';

$sql 		= "SELECT `correo`
				FROM `data_acceso`.`in_usuarioad`
				WHERE (`correo` = '".$correo."');";
$RESsql 	= $RBD->query($sql);	

if(mysqli_num_rows($RESsql) == 0){				
	
	$sql 	= "INSERT INTO `data_acceso`.`in_usuarioad`(`correo`, `idPerfilSAIRE`, `nombreUsuario`, `paternoUsuario`, `maternoUsuario`, `idEstatusUsuario`, `fecMovUsuario`, `idEmpleado`)
	VALUES ('$correo',$idperfil,'$nombreusuario','$paternousuario','$maternousuario', 0,NOW(), ".$_SESSION['idU'].");";
	
	$RBD->query($sql);
	if($RBD->error() == '')
	{
		$RES = "0|Se a insertado correctamente";
	}
	else
	{
		$RES = "2|".$RBD->error();
	}	
}else{$RES .= '3|El correo ya esta siendo utilizado por un Usuario';}	

		
		
echo $RES;
}else{header("location: ../../../main.php");		}	
?>