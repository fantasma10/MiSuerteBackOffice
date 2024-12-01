<?php
$pemiso		= (isset($_POST['pemiso']))?$_POST['pemiso']: false; if($pemiso){

include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;

$idS			= (isset($_POST['idSeccion']))?$_POST['idSeccion']: -1;
$idU			= (isset($_POST['idUsuario']))?$_POST['idUsuario']: -1;
$Tipo			= (isset($_POST['tipo']))?$_POST['tipo']: -1;


$sql1 ="SELECT * FROM `data_acceso`.`in_permisos_saire` WHERE `idUsuario` = ".$idU." AND `idSeccion` = ".$idS.";";
$RES		= '1|Error al buscar el permiso Consulta';

$RESsql 	= $RBD->query($sql1);	
if(mysqli_num_rows($RESsql)){
	$sql2 ="UPDATE `data_acceso`.`in_permisos_saire` SET `idTipo`=".$Tipo.",`idEmpleado`=".$_SESSION['idU']." WHERE `idUsuario`= ".$idU." AND `idSeccion` = ".$idS.";";
	$RBD->query($sql2);
	if($RBD->error() == '')
	{
		$RES = "0|Se a Actualizado correctamente";
	}
	else
	{
		$RES = "2|".$RBD->error();
	}
			
}else{
	$sql3 ="INSERT INTO `data_acceso`.`in_permisos_saire`(`idPerfilSAIRE`, `idUsuario`, `idSeccion`, `idTipo`, `idEstatusPermiso`, `fecMovPermiso`, `idEmpleado`) VALUES (-1,".$idU.",".$idS.",".$Tipo.",0,NOW(),".$_SESSION['idU'].");";
	
	$RBD->query($sql3);
	if($RBD->error() == '')
	{
		$RES = "0|Se a Actualizado correctamente";
	}
	else
	{
		$RES = "3|".$RBD->error();
	}
}	


		
echo $RES;
}else{header("location: ../../../main.php");		}	
?>