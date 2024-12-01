<?php
	header("Content-type: text/html; charset=utf-8");
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;	

	switch ($tipo) {
		case 1:
			$nCodigoPostal	= (isset($_POST['nCodigoPostal']) && trim($_POST['nCodigoPostal']) != '')? $_POST['nCodigoPostal'] : '';
			$nIdPais		= (isset($_POST['nIdPais']) && trim($_POST['nIdPais']) != '')? $_POST['nIdPais'] : 164;
  
			$sQuery = "call redefectiva.SP_BUSCARCOLONIA('$nCodigoPostal');";

			$resultcuenta = $WBD->query($sQuery);
			$arrColonias	= array();
			while($resColonias  = mysqli_fetch_array($resultcuenta)){
				$arrRES			= $resColonias;
				$arrColonias[]	= array(
					'nIdEstado'			=> $arrRES[2],
					'sDEstado'			=> utf8_encode($arrRES[5]),
					'nNumMunicipio'		=> $arrRES[3],
					'sDMunicipio'		=> utf8_encode($arrRES[4]),
					'nIdColonia'		=>$arrRES[0],
					'sNombreColonia'	=> utf8_encode($arrRES[1])
				);
			}

			echo json_encode(array(
				'bExito'	=> true,
				'nCodigo'	=> 0,
				'sMensaje'	=> 'Ok',
				'data'		=> $arrColonias
			));
			break;
		
		default:
			break;
	}
?>