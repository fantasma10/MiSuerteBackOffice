<?php
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idProveedor = (isset($_POST['idProveedor']))?$_POST['idProveedor']:0;
	$RES = '';			
	$sql = "CALL redefectiva.SPA_LOADPROVEEDOR($idProveedor)";
	$result = $RBD->SP($sql);
	if($RBD->error() == '')
	{
		if(mysqli_num_rows($result) > 0){
		
			$RFC = mysqli_fetch_assoc($result);
			$RES = '0|Si se encontro el RFC|';
                        $RES.= $RFC["RFC"].'|';
                        $RES.= $RFC["razonSocial"] . '|';
                        $RES.= $RFC["numCuenta"] . '|';
			
		}else{$RES .= '2|No se Encontraron datos del Proveedor';}	
	}else{$RES .= '3|'.$sql.' '.$RBD->error();}	

	
	echo $RES;
?>