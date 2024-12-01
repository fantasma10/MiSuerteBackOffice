<?php

/*	error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idCosto		= (!empty($_POST['idCosto']))? $_POST['idCosto'] : 0;
	$idTipoForelo	= (!empty($_POST['idTipoForelo']))? $_POST['idTipoForelo'] : 0;
	$idCliente		= (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);

	$oAf->load($idCliente);

	$oAf->TIPOFORELO = $idTipoForelo;
	$idCostoOriginal = $oAf->IDCOSTO;
	$oAf->IDCOSTO = $idCosto;

	$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`($oAf->IDCOSTO)");
	$res = mysqli_fetch_assoc($sql);

	$oAf->MAXIMOPUNTOS = $res['maximoPuntos'];
	$oAf->IDVERSION = $res['idVersion'];

	$response =	$oAf->guardarDatosGenerales();

	if($response["success"] == true){
		$response["showMsg"] = 0;

		// si es forelo compartido se crea la referencia bancaria
		if($oAf->TIPOFORELO == 1){
			if($oAf->IDREFERENCIABANCARIA == 0){
				$response = $oAf->crearReferenciaBancaria();

				if($response["success"] == true){
					$response["showMsg"] = 0;

					$oAf->IDREFERENCIABANCARIA = $response['data']['idReferencia'];

					// crear las cuotas
					$oAf->load($idCliente);
					//echo "crear las cuotas";
					$response = $oAf->crearCuotas();

					if($response["success"] == true){
						$response["showMsg"] = 0;
					}
					else{
						$response["showMsg"]	= 1;
						$response["msg"]		= "Ha ocurrido un error al crear las Cuotas";
					}
				}
				else{
					$response["showMsg"]	= 1;
					$response["msg"]		= "Ha ocurrido un error al crear la Referencia Bancaria, inténtelo de nuevo";
				}
			}
			else{
				if($idCostoOriginal != $idCosto){
					$oAf->load($idCliente);
					//echo "crear las cuotas";
					$response = $oAf->crearCuotas();

					if($response["success"] == true){
						$response["showMsg"] = 0;
					}
					else{
						$response["showMsg"]	= 1;
						$response["msg"]		= "Ha ocurrido un error al crear las Cuotas";
					}

				}
			}
		}
		else{
			if($oAf->IDREFERENCIABANCARIA > 0){
				$response = $oAf->eliminarForelo();

				if($response["success"] == true){
					$response["showMsg"] = 0;

					//$oAf->IDREFERENCIABANCARIA = $response['data']['idReferencia'];
				}
				else{
					$response["showMsg"]	= 1;
					$response["msg"]		= "Ha ocurrido un error al crear la Referencia Bancaria, inténtelo de nuevo";
				}
			}
		}
	}
	else{
		$response["showMsg"]	= 1;
		$response["msg"]		= "No ha sido posible guardar el Paquete Seleccionado";
	}

	$oAf->prepararCliente();

	echo json_encode($response);
?>