<?php
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idProveedor		= (isset($_POST['idProveedor']))? $_POST['idProveedor'] : 0;
	$idTipoProveedor	= (isset($_POST['idTipoProveedor']) && $_POST['idTipoProveedor'] >= 0)? $_POST['idTipoProveedor'] : 0;
	$RES = '';

	if($idTipoProveedor == 0){
		$sql = "CALL redefectiva.SPA_LOADPROVEEDOR($idProveedor)";
	}
	else if($idTipoProveedor == 1){
		$sql = "CALL `redefectiva`.`SP_ACREEDOR_LOAD`($idProveedor, '', 0)";
	}

	$result = $RBD->SP($sql);

	$data = array();

	if(!$RBD->error()){
		if(mysqli_num_rows($result) > 0){

			$rfc = mysqli_fetch_assoc($result);
			$data['RFC'] = $rfc['RFC'];
			$data['RazonSocial'] = $rfc['razonSocial'];
			$data['NumCta'] = $rfc['numCuenta'];
			$data['NumCuenta'] = $rfc['numCuenta'];

			$sqlD = $RBD->query("CALL `redefectiva`.`SP_GET_DIRECCION_PROVEEDOR`(0, '{$data['RFC']}')");
			if(!$RBD->error()){
				$res = mysqli_fetch_assoc($sqlD);
				$data['Calle']			= (!empty($res['calle']))? $res['calle'] : '';
				$data['NoExterior']		= (!empty($res['numeroExterior']))? $res['numeroExterior'] : '';
				$data['NoInterior']		= (!empty($res['numeroInterior']))? $res['numeroInterior'] : '';
				$data['Colonia']		= (!empty($res['nombreColonia']))? $res['nombreColonia'] : '';
				$data['Municipio']		= (!empty($res['nombreCiudad']))? $res['nombreCiudad'] : '';
				$data['Estado']			= (!empty($res['nombreEstado']))? $res['nombreEstado'] : '';
				$data['CodigoPostal']	= (!empty($res['codigoPostal']))? $res['codigoPostal'] : 0;
				$data['Pais']			= (!empty($res['nombrePais']))? $res['nombrePais'] : '';
			}
		}
		else{

		}
	}
	else{

	}

	echo json_encode(array(
		'data'	=> $data,
	));
?>