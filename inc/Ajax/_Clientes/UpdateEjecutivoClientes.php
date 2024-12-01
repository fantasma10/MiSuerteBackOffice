<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

global $RBD;
global $WBD;

$id             = (isset($_POST['id']))?$_POST['id']: 0;
$idEjecutivo	= (isset($_POST['idEjecutivo']))?$_POST['idEjecutivo']: '';
$tipoCliente	= (isset($_POST['idTipoCliente']))?$_POST['idTipoCliente']: 0;


$FROM = "";		$WHERE = "";	$INSERT = "";
if ( $tipoCliente == 1 ) {
	$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCADENA`($id);";
	$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCADENA`($id, $idEjecutivo, {$_SESSION['idU']});";
	$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCADENA`($id, $idEjecutivo, $fecVigen, {$_SESSION['idU']});";
}

if ( $tipoCliente == 2 ) {
	$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOSUBCADENA`($id);";
	$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOSUBCADENA`($id, $idEjecutivo, {$_SESSION['idU']});";
	$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOSUBCADENA`($id, $idEjecutivo, $fecVigen, {$_SESSION['idU']});";
}
	
if ( $tipoCliente == 3 ) {
	$sql = "CALL `redefectiva`.`SP_EXISTE_EJECUTIVOCORRESPONSAL`($id);";
	$sql2 = "CALL `redefectiva`.`SP_UPDATE_EJECUTIVOCORRESPONSAL`($id, $idEjecutivo, {$_SESSION['idU']});";
	$sql3 = "CALL `redefectiva`.`SP_INSERT_EJECUTIVOCORRESPONSAL`($id, $idEjecutivo, $fecVigen, {$_SESSION['idU']});";
}


$RES = '';
if ( $tipoCliente > 0 ) {

	$RESsql 	= $RBD->SP($sql);	
	
	if ( mysqli_num_rows($RESsql) > 0 ) {
		
		$WBD->SP($sql2);

		if ( $WBD->error() == '' ) {
			$RES = "0|Se ha actualizado correctamente el ejecutivo";
		} else {
			$RES = "2|Error al asignar el ejecutivo".$sql2;
		}
		
	} else {
	
		$fecVigen = date('Y-m-d', strtotime('+10 Year'));

		$WBD->SP($sql3);
		
		if ( $WBD->error() == '' ) {
			$RES = "0|Se a asignado correctamente el ejecutivo";	
		} else {
			$RES = "1|Error al asignar el ejecutivo";	
		}
	}
				
	echo $RES;
}
			
?>