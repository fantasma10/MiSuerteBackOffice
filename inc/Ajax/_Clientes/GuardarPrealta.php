<?php
include("../../../inc/config.inc.php");
/*
global $RBD;

$idOrig			= (isset($_POST['idOrigen']))?$_POST['idOrigen']: 1;
$idCorr			= (isset($_POST['idCorresponsal']))?$_POST['idCorresponsal']: 438;
$NewXML			= (isset($_POST['XML']))?$_POST['XML']: "";
$NomDoc			= (isset($_POST['NombreDoc']))?$_POST['NombreDoc']: "Acta Constitutiva";
$idTip			= (isset($_POST['idTipo']))?$_POST['idTipo']: "0";
$idStatus			= (isset($_POST['status']))?$_POST['status']: "0";

$RES			= '';
$sql 			= "CALL `redefectiva`.SP_PREALTA('$idOrig','$idCorr','$NewXML','$NomDoc','$idTip');";
			
	$RESsql 	= $RBD->SP($sql);	
	if($RESsql){
		
		if(mysqli_num_rows($RESsql)){
			
			list($codigoRespuesta,$DescRespuesta,$id)=mysqli_fetch_array($RESsql);
			
			$RES .= $codigoRespuesta.'|'.$DescRespuesta.'|'.$id;

		}
		else{$RES .= '2|consulta sin resultado()'.$RBD->error();}
	}
	else{$RES .= '3|consulta sin resultado()'.$RBD->error();}
	
echo $RES;
	*/
	$idStatus			= (isset($_POST['contactos']))?$_POST['contactos']: "";	
	/*echo "<script>var tContactos = $idStatus;</script>"*/
    $Rows = explode("|",$idStatus);
	$Columnas = explode(",",$Rows[0]);
	echo "0|".$idStatus;
?>
