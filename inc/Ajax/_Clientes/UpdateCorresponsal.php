<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;

$id              =  (isset($_POST['id']))?$_POST['id']: 0;
$grupo			= (isset($_POST['grupo']))?$_POST['grupo']: 0;
$cadena         = (isset($_POST['cadena']))?$_POST['cadena']: 0;
$subcadena         = (isset($_POST['subcadena']))?$_POST['subcadena']: 0;
$giro			= (isset($_POST['giro']))?$_POST['giro']: 0;
$nombre			= (isset($_POST['nombre']))?$_POST['nombre']: '';
$tel1			= (isset($_POST['tel1']))?$_POST['tel1']: '';
$tel2			= (isset($_POST['tel2']))?$_POST['tel2']: '';
$fax			= (isset($_POST['fax']))?$_POST['fax']: '';
$email            = (isset($_POST['email']))?$_POST['email']: '';
$referencia            = (isset($_POST['referencia']))?$_POST['referencia']: 0;
$usuarioalta            = (isset($_POST['usuarioalta']))?$_POST['usuarioalta']: 0;
$status            = (isset($_POST['status']))?$_POST['status']: '';


$RES		= '';

/*$sql 		= "SELECT `idEntity`
				FROM `data_gateway`.`conf_entity`
				WHERE (`idEntity` = ".$id.");";
$RESsql 	= $RBD->query($sql);	

if(mysqli_num_rows($RESsql)){			*/
	
	$sql 	= "UPDATE `redefectiva`.`dat_cadena` SET `id_Grupo`= $grupo, `idCadena` = $cadena, `idSubCadena` = $subcadena,`idcGiro`= $giro, `nombreCadena`= $nombre, `telefono1`= $tel1, `telefono2`= $tel2, `fax`= $fax, `email`= $email, `idcReferencia` = $referencia, `idUsuarioAlta` = $usuarioalta, `fecMovCadena` = NOW(), `idEstatusCadena` = $status, `idEmpleado` = ".$_SESSION['idU']." WHERE (`idCadena` = ".$id.");";
	
	$RBD->query($sql);
	
	if($RBD->error() == '')
	{
		$RES = "0|Se a actualizado correctamente";
	}
	else
	{
		$RES = "2|".$RBD->error();
	}
			
//}else{$RES .= '3|El id no existe, favor de revisar';}

echo $RES;
			
?>