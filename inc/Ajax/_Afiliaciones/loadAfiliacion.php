<?php

	error_reporting(0);
	ini_set('display_errors', 0);

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	//include($_SERVER['DOCUMENT_ROOT']."/inc/obj/AfiliacionCliente.php");

	function acentos($txt){
		return (!preg_match("!!u", $txt))? utf8_encode($txt) : $txt;
	}

	$idAfiliacion = (!empty($_POST['idAfiliacion']))? $_POST['idAfiliacion'] : 0;
	$real = (isset($_POST['real']) && $_POST['real'] == "0")? true : false;

	$oAf = new AfiliacionCliente($RBD, $WBD, $LOG);

	if(!$real){

		$oAf->load($idAfiliacion);
	}
	else{

		$oAf->loadClienteReal($idAfiliacion, $real);	
	}

	//echo "<pre>".var_dump($oAf)."</pre>";

	$respuesta = array();

	if($oAf->ERROR_CODE == 0){
		$CostoTotal = $oAf->PAGO_PENDIENTE/*$oAf->NUMEROCORRESPONSALES * $oAf->COSTO*/;

		$pagoPendiente = $CostoTotal - $importe;

		$tel="";
		$telefono = str_split($oAf->TELEFONO);

		foreach($telefono AS $t){
			$contador++;
			$tel .= $t;
			if($contador == 2){
				$contador = 0;
				$tel .="-";
			}
		}

		$tel = trim($tel, "-");

		$maximo = ($oAf->MAXIMOPUNTOS == 0)? $oAf->MINIMOPUNTOS : $oAf->MAXIMOPUNTOS;
		$pagoTotal = $maximo * $oAf->COSTO;
		$pagoTotal = $CostoTotal/*number_format($pagoTotal, 2)*/;

		$respuesta = array(
			'showMsg'	=> 0,
			'success'	=> true,
			'msg'		=> '',
			'errmsg'	=> '',
			'data'		=> array(
				'idNivel'				=> $oAf->IDNIVEL,
				'familias'				=> $oAf->FAMILIAS,
				'idTipoAcceso'			=> $oAf->IDTIPOACCESO,
				'idCadena'				=> $oAf->IDCADENA,
				'txtCadena'				=> acentos($oAf->NOMBRECADENA),
				'idCliente'				=> $oAf->ID_CLIENTE,
				'idDireccion'			=> $oAf->ID_DIRECCION,
				'idDireccion2'			=> $oAf->IDDIRECCION,
				'idRepLegal'			=> $oAf->ID_REPLEGAL,
				'idGrupo'				=> $oAf->IDGRUPO,
				'idReferencia'			=> $oAf->IDREFERENCIA,
				'tipoPersona'			=> $oAf->IDTIPOPERSONA,
				'idGiro'				=> $oAf->IDGIRO,
				'RFC'					=> $oAf->RFC,
				'razonSocial'			=> acentos($oAf->RAZONSOCIAL),
				'nombreCompletoCliente'	=> acentos($oAf->NOMBRE_COMPLETO_CLIENTE),
				'nombrePersona'			=> acentos($oAf->NOMBREPERSONA),
				'apPPersona'			=> acentos($oAf->APATERNOPERSONA),
				'apMPersona'			=> acentos($oAf->AMATERNOPERSONA),
				'fecAltaRPPC'			=> $oAf->FECHACONSITUTUCION,
				'telefono'				=> $tel,
				'email'					=> $oAf->CORREO,
				'nombreRepLegal'		=> acentos($oAf->NOMBREREPLEGAL),
				'apPRepreLegal'			=> acentos($oAf->APATERNOREPLEGAL),
				'apMRepreLegal'			=> acentos($oAf->AMATERNOREPLEGAL),
				'RFCRepreLegal'			=> $oAf->RFCREPLEGAL,
				'idTipoIdent'			=> $oAf->IDTIPOIDENTIFICACION,
				'numIdentificacion'		=> $oAf->NUMEROIDENTIFICACION,
				'figPolitica'			=> $oAf->FIGPOLITICA,
				'famPolitica'			=> $oAf->FAMPOLITICA,
				'calleDireccion'		=> acentos($oAf->CALLE),
				'idPais'				=> $oAf->IDPAIS,
				'idcEntidad'			=> $oAf->IDENTIDAD,
				'idcMunicipio'			=> $oAf->IDMUNICIPIO,
				'idcColonia'			=> $oAf->IDCOLONIA,
				'cpDireccion'			=> $oAf->CODIGOPOSTAL,
				'numeroIntDireccion'	=> $oAf->NUMEROINTERIOR,
				'numeroExtDireccion'	=> $oAf->NUMEROEXTERIOR,
				'idCosto'				=> $oAf->IDCOSTO,
				'tipoForelo'			=> $oAf->TIPOFORELO,
				'comisiones'			=> $oAf->COMISIONES,
				'reembolso'				=> $oAf->REEMBOLSO,
				'idCuenta'				=> $oAf->IDCUENTA,
				'beneficiario'			=> acentos($oAf->BENEFICIARIO),
				'numCuenta'				=> $oAf->NUMCUENTA,
				'idBanco'				=> $oAf->IDBANCO,
				'descripcion'			=> acentos($oAf->DESCRIPCION),
				'idEstatusCuenta'		=> $oAf->IDESTATUSCUENTA,
				'CLABE'					=> $oAf->CLABE,
				'txtBanco'				=> $oAf->NOMBREBANCO,
				'idRefBancaria'			=> $oAf->IDREFERENCIABANCARIA,
				'referenciaBancaria'	=> $oAf->REFERENCIABANCARIA,
				'costo'					=> "\$".number_format($oAf->COSTO, 2),
				'numeroCorresponsales'	=> $oAf->NUMEROCORRESPONSALES,
				'minimoPuntos'			=> $oAf->MINIMOPUNTOS,
				'maximoPuntos'			=> $oAf->MAXIMOPUNTOS,
				'CostoTotal'			=> "\$".number_format($CostoTotal,2),
				'idTerminos'			=> $oAf->IDTERMINOS,
				'idEstatusTerminos'		=> $oAf->IDESTATUSTERMINOS,
				'nombreNivel'			=> acentos($oAf->NOMBRENIVEL),
				'lblTipoForelo'			=> $oAf->LBLTIPOFORELO,
				'COMPLETO_NIVEL'		=> $oAf->completoExpediente(),
				'COMPLETO_GENERALES'	=> $oAf->completoGenerales(),
				'COMPLETO_DIRECCION'	=> $oAf->completoDireccionFiscal(),
				'COMPLETO_REPRESENTANTE'=> $oAf->completoRepresentanteLegal(),
				'COMPLETO_FORELO'		=> $oAf->completoTipoForelo(),
				'COMPLETO_CONF_CUENTA'	=> $oAf->completoConfiguracionCuenta(),
				'pagoTotal'				=> "\$".$pagoTotal
			)
		);
	}
	else{
		$respuesta = array(
			'showMsg'	=> 1,
			'success'	=> false,
			'msg'		=> 'No ha sido posible Cargar los Datos de la Afiliación',
			'errmsg'	=> $oAf->ERROR_CODE." : ".$oAf->ERROR_MSG
		);
	}

	echo json_encode($respuesta);
?>