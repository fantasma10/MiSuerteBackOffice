<?php
	include("../../../inc/config.inc.php");

	global $RBD;
	
	$estado		= (isset($_GET['idEdo']))?$_GET['idEdo']: "";
	$idRelDoc	= (isset($_GET['idRel']))?$_GET['idRel']: "";
	$n			= (isset($_GET['nom']))?$_GET['nom']: "";
	
	$trozos = explode(".", $_FILES['file_cabecera']['name']);  
	$extension = end($trozos);  


	copy($_FILES['file_cabecera']['tmp_name'],"../docs/".$n.".".$extension);
	
	
	$sql2 		= "CALL `redefectiva`.SP_UPDATERELDOC(".$idRelDoc.",1);";
	$RESsql2 	= $RBD->SP($sql2);	
	if($RESsql2){
		if(mysqli_num_rows($RESsql2) == 1){				
			list($CodigoRespuesta, $MsgRespuesta) = mysqli_fetch_array($RESsql2);
			if($CodigoRespuesta > 0)
			{
				//$this->LOG->error("Relacion Documentos Failed: ".$MsgRespuesta." ".$CodigoRespuesta);
				$RES .= $CodigoRespuesta.'|'.$MsgRespuesta;
				break;
			}
			
		}
	}else{$RES .= '2|Error en relacion Documento';}
				
  	/*$target_filepath = "../docs/" . basename($_FILES['file_cabecera']['name']);
	move_uploaded_file($_FILES['file_cabecera']['tmp_name'], $target_filepath);*/

	header("Location:../catalogos/docs.php?nombre=".$n."&idEdo=1&idRel=".$idRelDoc);
	
?>
