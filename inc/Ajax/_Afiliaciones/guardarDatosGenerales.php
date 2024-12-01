<?php

	error_reporting(0);
	ini_set('display_errors', 0);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


	$idAfiliacion	= (!empty($_POST['idAfiliacion']))	? $_POST['idAfiliacion']	: -1;
	$idCliente		= (!empty($_POST['idCliente']))		? $_POST['idCliente'] 		: -1;
	
	$idCadena			= (isset($_POST['idCadena']) AND $_POST['idCadena'] >= 0)	? $_POST['idCadena'] 							: -1;
	$idGrupo			= (isset($_POST['idGrupo']) AND $_POST['idGrupo'] >= 0)		? $_POST['idGrupo'] 							: -1;
	$idReferencia		= (!empty($_POST['idReferencia']))							? $_POST['idReferencia'] 						: -1;
	$idTipoAcceso		= (!empty($_POST['idTipoAcceso']))							? $_POST['idTipoAcceso'] 						: -1;
	$familias			= (!empty($_POST['familias']))								? $_POST['familias'] 							: '';
	$tipoPersona		= (!empty($_POST['tipoPersona']))							? $_POST['tipoPersona'] 						: -1;
	$RFC				= (!empty($_POST['RFC']))									? $_POST['RFC'] 								: "";
	$idGiro				= (!empty($_POST['idGiro']))								? $_POST['idGiro'] 								: -1;
	$idNivel			= (!empty($_POST['idNivel']))								? $_POST['idNivel'] 							: -1;
	$idDireccion		= (!empty($_POST['idDireccion']))							? $_POST['idDireccion'] 						: 0;
	$idRepLegal			= (!empty($_POST['idRepLegal']))							? $_POST['idRepLegal'] 							: 0;
	$razonSocial		= (!empty($_POST['razonSocial']))							? trim(urldecode($_POST['razonSocial'])) 		: "";
	$nombrePersona		= (!empty($_POST['nombrePersona']))							? trim(urldecode($_POST['nombrePersona']))		: "";
	$apPPersona			= (!empty($_POST['apPPersona']))							? trim(urldecode($_POST['apPPersona'])) 		: "";
	$apMPersona			= (!empty($_POST['apMPersona']))							? trim(urldecode($_POST['apMPersona'])) 		: "";
	$fecAltaRPPC		= (!empty($_POST['fecAltaRPPC']))							? $_POST['fecAltaRPPC'] 						: "0000-00-00";
	$telefono			= (!empty($_POST['telefono']))								? $_POST['telefono'] 							: "";
	$email				= (!empty($_POST['email']))									? trim(urldecode($_POST['email'])) 				: "";
	$idPais				= (!empty($_POST['idPais']))								? $_POST['idPais'] 								: "";
	$calleDireccion		= (!empty($_POST['calleDireccion']))						? trim(urldecode($_POST['calleDireccion'])) 	: "";
	$numeroIntDireccion	= (!empty($_POST['numeroIntDireccion']))					? trim(urldecode($_POST['numeroIntDireccion']))	: "";
	$numeroExtDireccion	= (!empty($_POST['numeroExtDireccion']))					? trim(urldecode($_POST['numeroExtDireccion']))	: "";
	$cpDireccion		= (!empty($_POST['cpDireccion']))							? $_POST['cpDireccion'] 						: "";
	$idcColonia			= (!empty($_POST['idcColonia']))							? $_POST['idcColonia'] 							: -1;
	$idcEntidad			= (!empty($_POST['idcEntidad']))							? $_POST['idcEntidad'] 							: -1;
	$idcMunicipio		= (!empty($_POST['idcMunicipio']))							? $_POST['idcMunicipio'] 						: -1;
	$idLocalidad		= (!empty($_POST['idLocalidad']))							? $_POST['idLocalidad'] 						: 0;
	$nombreRepLegal		= (!empty($_POST['nombreRepLegal']))						? urldecode($_POST['nombreRepLegal'])			: "";
	$apPRepreLegal		= (!empty($_POST['apPRepreLegal']))							? trim(urldecode($_POST['apPRepreLegal'])) 		: "";
	$apMRepreLegal		= (!empty($_POST['apMRepreLegal']))							? trim(urldecode($_POST['apMRepreLegal'])) 		: "";
	$RFCRepreLegal		= (!empty($_POST['RFCRepreLegal']))							? trim(urldecode($_POST['RFCRepreLegal'])) 		: "";
	$idTipoIdent		= (!empty($_POST['idTipoIdent']))							? $_POST['idTipoIdent'] 						: 0;
	$numIdentificacion	= (!empty($_POST['numIdentificacion']))						? trim(urldecode($_POST['numIdentificacion'])) 	: "";
	$figPolitica		= (isset($_POST['figPolitica']))							? 1												: 0;
	$famPolitica		= (isset($_POST['famPolitica']))							? 1 											: 0;
	$origen				= (isset($_POST['origen']))									? $_POST['origen']								: 1;
	$esEdicion			= false;
	
	$error = "";
	if($idCadena == -1){
		//$error .= "- Cadena Inválida\n";
		$error .= "- Favor de introducir una Cadena válida.\n";
	}
	if($idGrupo == -1){
		//$error .= "- Grupo Inválido\n";
		$error .= "- Favor de introducir un Grupo válido.\n";
	}
	if($idReferencia == -1){
		//$error .= "Referencia Inválida\n";
		$error .= "- Favor de introducir una Referencia válida.\n";
	}
	if($idGiro == -1){
		//$error .= "Giro Inválido\n";
		$error .= "- Favor de introducir un Giro válido.\n";
	}
	if($idcColonia == -1){
		//$error .= "Colonia Inválida\n";
		$error .= "- Favor de introducir una Colonia válida.\n";
	}
	if($idcEntidad == -1){
		//$error .= "Estado Inválido\n";
		$error .= "Favor de introducir un Estado válido.\n";
	}
	if($idcMunicipio == -1){
		//$error .= "Ciudad Inválida\n";
		$error .= "Favor de introducir una Ciudad válida.\n";
	}
	if($numeroExtDireccion == 0 || !is_numeric($numeroExtDireccion)){
		$error .= "Favor de introducir un Número Exterior válido.\n";
	}
	
	/*if($error == ""){

	}
	else{
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> $error,
			'success'	=> false
		);
	}*/
	
	if($error != ""){
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> $error,
			'success'	=> false
		);
		echo json_encode($response);
		exit();	
	}

	$idAfiliacion = (!empty($_POST['idAfiliacion']))? $_POST['idAfiliacion'] : 0;

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);

	$oAf->load($idCliente);
	
	if($idCliente > 0){
		$oAf->ID_CLIENTE = $idCliente;
		$esEdicion = true;
	}
	$respuesta = array();

	$siguiente = 0;

	if($oAf->ERROR_CODE == 0){
		$siguiente = 1;
	}
	else{
		$response = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'msg'		=> 'No ha sido posible Cargar los Datos de la Afiliación',
			'errmsg'	=> $oAf->ERROR_CODE." : ".$oAf->ERROR_MSG
		);
	}

	$oAf->IDCADENA				= $idCadena;
	$oAf->IDGRUPO				= $idGrupo;
	$oAf->IDREFERENCIA			= $idReferencia;
	$oAf->IDTIPOACCESO			= $idTipoAcceso;
	$oAf->IDTIPOPERSONA			= $tipoPersona;
	$oAf->RFC					= strtoupper($RFC);
	$oAf->IDGIRO				= $idGiro;
	$oAf->RAZONSOCIAL			= utf8_decode($razonSocial);
	$oAf->NOMBREPERSONA			= utf8_decode($nombrePersona);
	$oAf->APATERNOPERSONA		= utf8_decode($apPPersona);
	$oAf->AMATERNOPERSONA		= utf8_decode($apMPersona);
	$oAf->FECHACONSITUTUCION	= $fecAltaRPPC;
	$oAf->TELEFONO				= str_replace("-", "", $telefono);
	$oAf->CORREO				= $email;
	$oAf->IDPAIS				= $idPais;
	$oAf->CALLE					= utf8_decode($calleDireccion);
	$oAf->NUMEROINTERIOR		= $numeroIntDireccion;
	$oAf->NUMEROEXTERIOR		= $numeroExtDireccion;
	$oAf->CODIGOPOSTAL			= $cpDireccion;
	$oAf->IDCOLONIA				= $idcColonia;
	$oAf->IDENTIDAD				= $idcEntidad;
	$oAf->IDMUNICIPIO			= $idcMunicipio;
	$oAf->IDLOCALIDAD			= $idLocalidad;
	$oAf->NOMBREREPLEGAL		= utf8_decode($nombreRepLegal);
	$oAf->APATERNOREPLEGAL		= utf8_decode($apPRepreLegal);
	$oAf->AMATERNOREPLEGAL		= utf8_decode($apMRepreLegal);
	$oAf->RFCREPLEGAL			= strtoupper($RFCRepreLegal);
	$oAf->IDTIPOIDENTIFICACION	= $idTipoIdent;
	$oAf->NUMEROIDENTIFICACION	= $numIdentificacion;
	$oAf->FIGPOLITICA			= $figPolitica;
	$oAf->FAMPOLITICA			= $famPolitica;
	$oAf->ID_DIRECCION			= $idDireccion;
	$oAf->IDNIVEL				= $idNivel;
	//var_dump("ID_REPLEGAL: $oAf->ID_REPLEGAL");
	$oAf->ID_REPLEGAL			= $idRepLegal;
	$oAf->FAMILIAS				= $familias;
	$oAf->IDVERSION				= (empty($oAf->IDVERSION))? 0 : $oAf->IDVERSION;
	
	//var_dump("ID_REPLEGAL: $oAf->ID_REPLEGAL");
	//var_dump("RFCREPLEGAL: $oAf->RFCREPLEGAL");
	
	/* verificar que el rfc capturado no se encuentre en la base de datos */
	//echo "CALL `afiliacion`.`SP_CLIENTE_VERIFICAR_RFC`('".$oAf->RFC."')";
	$sql = $RBD->query("CALL `afiliacion`.`SP_CLIENTE_VERIFICAR_RFC`('".$oAf->RFC."', $idCliente)");
	//var_dump("CALL `afiliacion`.`SP_CLIENTE_VERIFICAR_RFC`('".$oAf->RFC."', $idCliente)");
	if(!$RBD->error()){
		$res = mysqli_fetch_assoc($sql);
		$encontrado = $res['encontrado'];

		if($encontrado <= 0){
			$query = $RBD->query();
			$siguiente = 1;

			if($idNivel > 1){
				$nombreRepLegal = utf8_decode($nombreRepLegal);
				$apPRepreLegal = utf8_decode($apPRepreLegal);
				$apMRepreLegal = utf8_decode($apMRepreLegal);
				$sql2 = $RBD->query("CALL `afiliacion`.`SP_FIND_REPRESENTANTELEGAL`($oAf->IDTIPOIDENTIFICACION, '$oAf->NUMEROIDENTIFICACION', '$oAf->RFCREPLEGAL', $oAf->ID_REPLEGAL)");
				//var_dump("CALL `afiliacion`.`SP_FIND_REPRESENTANTELEGAL`($oAf->IDTIPOIDENTIFICACION, '$oAf->NUMEROIDENTIFICACION', '$oAf->RFCREPLEGAL', $oAf->ID_REPLEGAL)");
				if(!$RBD->error()){
					$res = mysqli_fetch_assoc($sql2);
					$cuenta = $res['cuenta'];

					if($cuenta == 0){
						$siguiente = 1;
					}
					else{
						$siguiente = 1;
						$idRepEncontrado = $res['id'];
						$oAf->IDREPLEGAL = $idRepEncontrado;
						/*$siguiente = 0;
						$response = array(
							'showMsg'	=> 1,
							'msg'		=> 'Ya existe un Representante Legal con los Datos Capturados',
							'errmsg'	=> $resp['errmsg']
						);*/
					}
				}
				else{
					$siguiente = 0;
					$response = array(
						'showMsg'	=> 1,
						'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
						'errmsg'	=> $RBD->error(),
						'tip'		=> 'validar representante legal'
					);	
				}
			}
		}
		else{
			$siguiente = 0;
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Ya existe un Cliente con el RFC capturado',
				'errmsg'	=> $resp['errmsg']
			);	
		}
	}
	else{
		$siguiente = 0;
		$response = array(
			'showMsg'	=> 1,
			'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
			'errmsg'	=> $RBD->error(),
			"tip"		=> 'rfc'
		);
	}

	if($siguiente == 1){
		$resp = $oAf->guardarDatosGenerales();

		if($resp['success'] == true){
			if($resp['data']['idCliente'] > 0){
				$siguiente = 2;
				$oAf->ID_CLIENTE = $resp['data']['idCliente'];
			}
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
				'errmsg'	=> $resp['errmsg'],
				'tip'		=> "generales"
			);
		}
	}

	if($siguiente == 2){
		if($familias != ''){
			$resp = $oAf->guardarFamilias();

			if($resp['success'] == true){
				$siguiente = 3;
			}
			else{
				$response = array(
					'showMsg'	=> 1,
					'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
					'tip'		=> "familias",
					'errmsg'	=> $resp['errmsg']
				);
			}
		}
		else{
			$siguiente = 3;
		}
	}

	if($siguiente == 3){
		if($origen == 0){
			$siguiente = 4;
			
			if ( !$esEdicion ) {
				$oAf->IDDIRECCION = $idDireccion;
			} else if ( $esEdicion && ($oAf->IDDIRECCION != $idDireccion && $idDireccion != 0) ) {
				$oAf->IDDIRECCION = $idDireccion;
			}

			$response = array(
				'showMsg'	=> 0,
				'success'	=> true,
				'msg'		=> '',
				'errmsg'	=> '',
				'data'		=> array('idDireccion' => $oAf->IDDIRECCION)
			);
						
		}else{
			if ( $esEdicion ) {
				$oAf->IDDIRECCION = 0;
			}
			$oAf->IDTIPODIR = 2;
			$resp = $oAf->guardarDireccion();

			if($resp['success'] == true){
				if($resp['data']['idDireccion'] > 0){
					$oAf->IDDIRECCION = $resp['data']['idDireccion'];
					$siguiente = 4;

					$response = array(
						'showMsg'	=> 0,
						'success'	=> true,
						'msg'		=> '',
						'errmsg'	=> '',
						'data'		=> array('idDireccion' => $oAf->IDDIRECCION)
					);
				}
			}
			else{
				$response = array(
					'showMsg'	=> 1,
					'msg'		=> 'Ha ocurrido un error, inténtelo nuevamente',
					'errmsg'	=> $res['errmsg'],
					'tip'		=> 'Direccion'
				);
			}
		}
	}

	if($siguiente == 4 && $oAf->IDNIVEL > 1){
		$resp = $oAf->guardarRepresentanteLegal();

		if($resp['success'] == true){
			if($resp['data']['idRepLegal'] > 0){
				$oAf->IDREPLEGAL = $resp['data']['idRepLegal'];
				//$oAf->guardarDatosGenerales();
				$siguiente = 4;
			}
		}
		else{
			$response = array(
				'showMsg'	=> 1,
				'msg'		=> 'Ya existe un Representante Legal con el mismo tipo y número de identificación. Favor de introducir datos nuevos.',
				'errmsg'	=> $resp['errmsg'],
				'tip'		=> 'Representante Legal'
			);
		}
	}

	if ($siguiente > 0) {
		$respo = $oAf->guardarDatosGenerales();
		$response['data']['idCliente'] = $oAf->ID_CLIENTE;
		$oAf->prepararCliente();
	}

	echo json_encode($response);
?>