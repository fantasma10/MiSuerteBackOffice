<?php
error_reporting(0);
ini_set('display_errors', 0);
include("../../../inc/config.inc.php");
include("../../../inc/session.ajax.inc.php");

$idCadena           = (isset($_POST['idCadena']))?$_POST['idCadena']:'';
$idSubCadena        = (isset($_POST['idSubCadena']))?$_POST['idSubCadena']:'';
$idCorresponsal     = (isset($_POST['idCorresponsal']))?$_POST['idCorresponsal']:'';

$response = array();
//buscar numero de cuenta
if($idCadena != '' || $idSubCadena != '' || $idCorresponsal != ''){

	$categoria  = (!empty($_POST['categoria']))? $_POST['categoria'] : 0;

	switch($categoria){
		case '1':
			$oCadena = new Cadena($RBD, $WBD);
			$obj = $oCadena->load($idCadena);

			if($obj['codigoRespuesta'] == 0){
				$response = array(
					'success'	=> true,
					'showMsg'	=> 0,
					'data'		=> array(
						'txtNumCta'			=> (!empty($oCadena->NUM_CUENTA))? $oCadena->NUM_CUENTA : '',
						'txtRazonSocial'	=> utf8_encode($oCadena->getNombre()),
						'txtCalle'			=> $oCadena->getCalle(),
						'txtNoExterior'		=> $oCadena->getNext(),
						'txtNoInterior'		=> $oCadena->getNint(),
						'txtColonia'		=> $oCadena->getNombreColonia(),
						'txtMunicipio'		=> $oCadena->getNombreCiudad(),
						'txtEstado'			=> $oCadena->getNombreEstado(),
						'txtCodigoPostal'	=> $oCadena->getCP(),
						'txtPais'			=> $oCadena->getNombrePais(),
						'txtRFC'			=> ''
					)
				);
			}
			else{
				$response = array(
					'success'   => false,
					'showMsg'   => 1,
					'msg'       => $obj['descRespuesta'],
					'data'      => array()
				);
			}
		break;

		case '2':
			/*$oSub = new SubCadena($RBD, $WBD);
			$obj = $oSub->load($idSubCadena);*/

			$oSub = new Cliente($RBD, $WBD, $LOG);
			$oSub->load($idSubCadena);

			if($oSub->EXISTE){
				$response = array(
					'success'	=> true,
					'showMsg'	=> 0,
					'data'		=> array(

						'txtNumCta'			=> $oSub->NUM_CUENTA,
						'txtRazonSocial'	=> utf8_encode($oSub->NOMBRE_COMPLETO_CLIENTE),
						'txtCalle'			=> $oSub->DIRF_CALLE,
						'txtNoExterior'		=> $oSub->DIRF_NUMEROEXTERIOR,
						'txtNoInterior'		=> $oSub->DIRF_NUMEROINTERIOR,
						'txtColonia'		=> $oSub->DIRF_NOMBRE_COLONIA,
						'txtMunicipio'		=> $oSub->DIRF_NOMBRE_MUNICIPIO,
						'txtEstado'			=> $oSub->DIRF_NOMBRE_ESTADO,
						'txtCodigoPostal'	=> $oSub->DIRF_CODIGO_POSTAL,
						'txtPais'			=> $oSub->DIRF_NOMBRE_PAIS,
						'txtRFC'			=> $oSub->RFC_CLIENTE

						/*'txtNumCta'			=> ($oSub->getCuentaForelo() == "No tiene")? '' : $oSub->getCuentaForelo(),
						'txtRazonSocial'	=> $oSub->getNombre(),
						'txtCalle'			=> $oSub->getCalle(),
						'txtNoExterior'		=> $oSub->getNext(),
						'txtNoInterior'		=> $oSub->getNint(),
						'txtColonia'		=> $oSub->getNombreColonia(),
						'txtMunicipio'		=> $oSub->getNombreCiudad(),
						'txtEstado'			=> $oSub->getNombreEstado(),
						'txtCodigoPostal'	=> $oSub->getCP(),
						'txtPais'			=> $oSub->getNombrePais(),
						'txtRFC'			=> $oSub->getRFCContrato()*/
					)
				);
			}
			else{
				$response = array(
					'success'   => false,
					'showMsg'   => 1,
					'msg'       => $oSub->ERROR_MSG,
					'data'      => array()
				);
			}
		break;

		case '3':
			$oCorresponsal = new Corresponsal($RBD, $WBD);
			$obj = $oCorresponsal->load($idCorresponsal);

			if($obj['codigoRespuesta'] == 0){
				$response = array(
					'success'	=> true,
					'showMsg'	=> 0,
					'data'		=> array(
						'txtNumCta'			=> ($oCorresponsal->getNumCuenta() == "No tiene")? '' : $oCorresponsal->getNumCuenta(),
						'txtRazonSocial'	=> utf8_encode($oCorresponsal->getNombreCor()),
						'txtCalle'			=> $oCorresponsal->getCalle(),
						'txtNoExterior'		=> $oCorresponsal->getDirNExt(),
						'txtNoInterior'		=> $oCorresponsal->getDirNInt(),
						'txtColonia'		=> $oCorresponsal->getColonia(),
						'txtMunicipio'		=> $oCorresponsal->getCiudad(),
						'txtEstado'			=> $oCorresponsal->getEstado(),
						'txtCodigoPostal'	=> $oCorresponsal->getCodigoPostal(),
						'txtPais'			=> $oCorresponsal->getPais(),
						'txtRFC'			=> $oCorresponsal->getRFCContrato()
					)
				);
			}
			else{
				$response = array(
					'success'   => false,
					'showMsg'   => 1,
					'msg'       => $obj['descRespuesta'],
					'data'      => array()
				);
			}
		break;
	}
}

echo json_encode($response);

?>