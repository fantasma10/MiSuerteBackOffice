<?php
include("../../../inc/config.inc.php");

global $RBD;

$idClave		= (isset($_POST['idClave']))?$_POST['idClave']: 0;
$XML			= (isset($_POST['XML']))?$_POST['XML']: "";
$idTip			= (isset($_POST['idTipo']))?$_POST['idTipo']: "0";
$idStatus		= (isset($_POST['idStatus']))?$_POST['idStatus']: "0";

$RES			= '';
$sql 			= "CALL `redefectiva`.SP_UPDATEXMLPREALTA('$idClave','$XML','$idTip','$idStatus');";
			
	$RESsql 	= $RBD->SP($sql);	
	if($RESsql){
		
		if(mysqli_num_rows($RESsql)){
			
			list($codigoRespuesta,$DescRespuesta)=mysqli_fetch_array($RESsql);
			
			$RES .= $codigoRespuesta.'|'.$DescRespuesta;

		}
		else{$RES .= '2|consulta sin resultado()'.$RBD->error();}
	}
	else{$RES .= '3|consulta sin resultado()'.$RBD->error();}
		
echo $RES;
			
?>