<?php

	error_reporting(0);
	ini_set('display_errors', 0);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$CLIENTE = new Cliente($RBD, $WBD, $LOG);
	$CLIENTE->load($idCliente);

	$respuesta = array();

	$date = new DateTime($CLIENTE->FECHA_REGISTRO);
	$fechaRegistro = $date->format('Y-m-d');

	$labelNombre = "";
	if($CLIENTE->ID_REGIMEN == 1){
		$labelNombre = "Nombre";
	}
	if($CLIENTE->ID_REGIMEN == 2){
		$labelNombre = "Razón Social";
	}
	if($CLIENTE->ID_REGIMEN == 3){
		if(!empty($CLIENTE->RAZONSOCIAL)){
			$labelNombre = "Razón Social";
		}
		else{
			$labelNombre = "Nombre";
		}
	}

	if($oAf->ERROR_CODE == 0){

		$contador = 0;
		$tel="";
		$telefono = str_replace("-", "", $CLIENTE->TELEFONO);
		$telefono = str_split($telefono);

		foreach($telefono AS $t){
			$contador++;
			$tel .= $t;
			if($contador == 2){
				$contador = 0;
				$tel .="-";
			}
		}

		$tel = trim($tel, "-");
		$respuesta = array(
			'showMsg'	=> 0,
			'success'	=> true,
			'msg'		=> '',
			'errmsg'	=> '',
			'data'		=> array(
				'idCliente'					=>	$CLIENTE->ID_CLIENTE,
				'idDireccion'				=>	$CLIENTE->ID_DIRECCION,
				'idGrupo'					=>	$CLIENTE->ID_GRUPO,
				'idCadena'					=>	$CLIENTE->ID_CADENA,
				'idGiro'					=>	$CLIENTE->ID_GIRO,
				'idReferencia'				=>	$CLIENTE->ID_REFERENCIA,
				'idEstatus'					=>	$CLIENTE->ID_ESTATUS,
				'idVersion'					=>	$CLIENTE->ID_VERSION,
				'idRepresentantelegal'		=>	$CLIENTE->ID_REPRESENTANTELEGAL,
				'idIva'						=>	$CLIENTE->ID_IVA,
				'idRegimen'					=>	$CLIENTE->ID_REGIMEN,
				'idNivel'					=>	$CLIENTE->ID_NIVEL,
				'idTipoIdent'				=>	$CLIENTE->ID_TIPOIDENTIFICACION,
				'nombreGrupo'				=>	$CLIENTE->NOMBRE_GRUPO,
				'nombreCadena'				=>	$CLIENTE->NOMBRE_CADENA,
				'nombreGiro'				=>	$CLIENTE->NOMBRE_GIRO,
				'nombreCliente'				=>	$CLIENTE->NOMBRE_CLIENTE,
				'nombreCompletoCliente'		=>	$CLIENTE->NOMBRE_COMPLETO_CLIENTE,
				'nombreReferencia'			=>	$CLIENTE->NOMBRE_REFERENCIA,
				'nombreVersion'				=>	$CLIENTE->NOMBRE_VERSION,
				'nombreRepresentantelegal'	=>	$CLIENTE->NOMBRE_REPRESENTANTELEGAL,
				'nombreRepLegal'			=>	$CLIENTE->NOMBRE_REPLEGAL,
				'nombreEstatus'				=>	$CLIENTE->NOMBRE_ESTATUS,
				'nombreIva'					=>	$CLIENTE->NOMBRE_IVA,
				'nombreRegimen'				=>	$CLIENTE->NOMBRE_REGIMEN,
				'nombreNivel'				=>	$CLIENTE->NOMBRE_NIVEL,
				'nombreTipoIdentificacion'	=>	$CLIENTE->NOMBRE_TIPOIDENTIFICACION,
				'nombreCliente'				=>	$CLIENTE->NOMBRE_CLIENTE,
				'nombreUsuarioAlta'			=>	$CLIENTE->NOMBRE_USUARIOALTA,
				'nombreTipoAcceso'			=>	(empty($CLIENTE->NOMBRE_TIPO_ACCESO))? "N/A" : $CLIENTE->NOMBRE_TIPO_ACCESO,
				'paternoCliente'			=>	$CLIENTE->PATERNO_CLIENTE,
				'maternoCliente'			=>	$CLIENTE->MATERNO_CLIENTE,
				'paternoRepLegal'			=>	$CLIENTE->PATERNO_REPRESENTANTELEGAL,
				'maternoRepLegal'			=>	$CLIENTE->MATERNO_REPRESENTANTELEGAL,
				'rfcCliente'				=>	$CLIENTE->RFC_CLIENTE,
				'rfcRepresentantelegal'		=>	$CLIENTE->RFC_REPRESENTANTELEGAL,
				'telefono'					=>	$tel,
				'correo'					=>	isset($CLIENTE->CORREO)? $CLIENTE->CORREO : "",
				'fechaRegistro'				=>	$fechaRegistro,
				'numeroCorresponsales'		=>	$CLIENTE->NUMERO_CORRESPONSALES,
				'numeroIdentificacion'		=>	$CLIENTE->NUMERO_IDENTIFICACION,
				'saldoCuenta'				=>	$CLIENTE->SALDO_CUENTA,
				'lblsaldoCuenta'			=>	"\$".number_format($CLIENTE->SALDO_CUENTA, 2),
				'forelo'					=>	$CLIENTE->FORELO,
				'lblforelo'					=>	"\$".number_format($CLIENTE->FORELO, 2),
				'dirfIdColonia'				=>	$CLIENTE->DIRF_ID_COLONIA,
				'dirfIdMunicipio'			=>	$CLIENTE->DIRF_ID_MUNICIPIO,
				'dirfIdEstado'				=>	$CLIENTE->DIRF_ID_ESTADO,
				'dirfIdPais'				=>	$CLIENTE->DIRF_ID_PAIS,
				'dirfCalle'					=>	$CLIENTE->DIRF_CALLE,
				'dirfNumerointerior'		=>	$CLIENTE->DIRF_NUMEROINTERIOR,
				'dirfNumeroexterior'		=>	$CLIENTE->DIRF_NUMEROEXTERIOR,
				'dirfNombre_colonia'		=>	$CLIENTE->DIRF_NOMBRE_COLONIA,
				'dirfNombre_municipio'		=>	$CLIENTE->DIRF_NOMBRE_MUNICIPIO,
				'dirfNombre_estado'			=>	$CLIENTE->DIRF_NOMBRE_ESTADO,
				'dirfNombre_pais'			=>	$CLIENTE->DIRF_NOMBRE_PAIS,
				'dirfCodigo_postal'			=>	$CLIENTE->DIRF_CODIGO_POSTAL,
				'referenciaBancaria'		=>	$CLIENTE->REFERENCIA_BANCARIA,
				'famPolitica'				=>	$CLIENTE->FAM_POLITICA,
				'figPolitica'				=>	$CLIENTE->FIG_POLITICA,
				'labelNombre'				=>	$labelNombre,
				'labelFamPolitica'			=>	($CLIENTE->FAM_POLITICA == 1)? 'Sí' : 'No',
				'labelFigPolitica'			=>	($CLIENTE->FIG_POLITICA == 1)? 'Sí' : 'No',
				'direccionCompleta'			=>	$CLIENTE->getDireccion(),
				'numCuenta'					=>	$CLIENTE->NUM_CUENTA,
				'razonSocial'				=>	$CLIENTE->RAZON_SOCIAL,
				/* EJECUTIVOS */
				'idEjecutivoVenta'				=>	$CLIENTE->ID_EJECUTIVOVENTA,
				'idEjecutivoCuenta'				=>	$CLIENTE->ID_EJECUTIVOCUENTA,
				'idEjecutivoAfiliacionInter'	=>	$CLIENTE->ID_EJECUTIVOAFILIACION_INTERMEDIO,
				'idEjecutivoAfiliacionAvanz'	=>	$CLIENTE->ID_EJECUTIVOAFILIACION_AVANZADO,
				'nombreEjecutivoVenta'			=>	$CLIENTE->NOMBRE_EJECUTIVOVENTA,
				'nombreEjecutivoCuenta'			=>	$CLIENTE->NOMBRE_EJECUTIVOCUENTA,
				'nombreEjecutivoAfiliacionInter'=>	$CLIENTE->NOMBRE_EJECUTIVOAFILIACION_INTERMEDIO,
				'nombreEjecutivoAfiliacionAvanz'=>	$CLIENTE->NOMBRE_EJECUTIVOAFILIACION_AVANZADO,
				'familias'						=>	$CLIENTE->FAMILIAS
			)
		);
	}
	else{
		$respuesta = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'msg'		=> 'No ha sido posible Cargar los Datos del Cliente',
			'errmsg'	=> $oAf->ERROR_CODE." : ".$oAf->ERROR_MSG
		);
	}

	echo json_encode($respuesta);
?>