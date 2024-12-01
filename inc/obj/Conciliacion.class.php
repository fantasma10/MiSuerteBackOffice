<?php

class Conciliacion{

	public $oRdb;
	public $oWdb;
	public $oLog;
	public $nIdMovBanco;
	public $nIdDeposito;
	public $nIdBanco;
	public $nIdUsuario;
	public $nIdUsuarioAutorizador;
	public $sClave;
	public $oMail;
	public $sCorreo;
	public $sTemplate;

	public function setORdb($value){
		$this->oRdb = $value;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($value){
		$this->oWdb = $value;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setNIdMovBanco($value){
		$this->nIdMovBanco = $value;
	}

	public function getNIdMovBanco(){
		return $this->nIdMovBanco;
	}

	public function setNIdDeposito($value){
		$this->nIdDeposito = $value;
	}

	public function getNIdDeposito(){
		return $this->nIdDeposito;
	}

	public function setNIdBanco($nIdBanco){
		$this->nIdBanco = $nIdBanco;
	}

	public function getNIdBanco(){
		return $this->nIdBanco;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdUsuarioAutorizador($nIdUsuarioAutorizador){
		$this->nIdUsuarioAutorizador = $nIdUsuarioAutorizador;
	}

	public function getNIdUsuarioAutorizador(){
		return $this->nIdUsuarioAutorizador;
	}

	public function setSClave($sClave){
		$this->sClave = $sClave;
	}

	public function getSClave(){
		return $this->sClave;
	}

	public function setOMail($oMail){
		$this->oMail = $oMail;
	}

	public function getOMail(){
		return $this->oMail;
	}

	public function setSCorreo($value){
		$this->sCorreo = $value;
	}

	public function getSCorreo(){
		return $this->sCorreo;
	}

	public function setSTemplate($value){
		$this->sTemplate = $value;
	}

	public function getSTemplate(){
		return $this->sTemplate;
	}

	# # # # # # # # # # # # # # # # # # # # # # # #

	public function conciliacionAutomatica(){
		$array_params = array(
			array(
				'name'	=> 'nIdBanco',
				'type'	=> 'i',
				'value'	=> self::getNIdBanco()
			),
			array(
				'name'	=> 'nIdUsuario',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuario()
			)
		);

		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_CONCILIACION_AUTOMATICA');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		/*$result = $this->oWdb->fetchAll();
		echo '<pre>'; var_dump($result); echo '</pre>';*/

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Conciliacion Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # conciliacionAutomatica

	public function concilia(){
		$array_params = array(
			array(
				'name'	=> 'nIdDeposito',
				'type'	=> 'i',
				'value'	=> self::getNIdDeposito()
			),
			array(
				'name'	=> 'nIdMovBanco',
				'type'	=> 'i',
				'value'	=> self::getNIdMovBanco()
			),
			array(
				'name'	=> 'nIdUsuario',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuario()
			)
		);

		$this->oWdb->setBDebug(1);
		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_CONCILIACION_MANUAL_CALL');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$result = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> $result[0]['result_code'] != 0? false : true,
			'nCodigo'			=> $result[0]['result_code'],
			'sMensaje'			=> $result[0]['result_msg'],
			'sMensajeDetallado'	=> $result[0]['result_msg'],
			'data'				=> $result
		);
	} # concilia

	public function necesitaAutorizacion(){
		$array_params = array(
			array(
				'name'	=> 'nIdMovBanco',
				'value'	=> self::getNIdMovBanco(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_CONCILIACION_AUTORIZACION');
		$this->oRdb->setParams($array_params);

		$arrRes = $this->oRdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$array_result = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Exitosa',
			'data'		=> $array_result
		);
	} # necesitaAutorizacion

	public function autenticarAutorizador(){
		$array_params = array(
			array(
				'name'	=> 'nIdUsuarioAutorizador',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuarioAutorizador()
			),
			array(
				'name'	=> 'nIdUsuario',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuario()
			),
			array(
				'name'	=> 'sClave',
				'type'	=> 's',
				'value'	=> self::getSClave()
			),
			array(
				'name'	=> 'nIdDeposito',
				'type'	=> 'i',
				'value'	=> self::getNIdDeposito()
			),
			array(
				'name'	=> 'nIdMovBanco',
				'type'	=> 'i',
				'value'	=> self::getNIdMovBanco()
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_CONCILIACION_AUTENTICAR');
		$this->oRdb->setParams($array_params);
		$arrRes = $this->oRdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$array_result = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Ok',
			'data'		=> $array_result
		);
	} # autenticarAutorizador

	public function enviarCorreoAutorizador(){
		$oMail = new Mail();

		$oLog		= self::getOLog();
		$oRdb		= self::getORdb();
		$sCorreo	= self::getSCorreo();
		$sTemplate	= self::getSTemplate();

		$oMail = new Mail();
		$oMail->setNAutorizador("");
		$oMail->setSIp("");
		$oMail->setOLog($oLog);
		$oMail->setORdb($oRdb);
		$oMail->setSSistema("RED");
		$oMail->setSFrom("sistemas@redefectiva.com");
		$oMail->setSName("Red Efectiva");
		$oMail->setOMail();
		$oMail->setMail();

		$oMail->oMail->SMTPDebug	= 0;
		$oMail->oMail->Port			= 25;
		$oMail->oMail->Debugoutput	= 'var_dump';
		$oMail->oMail->CharSet		= 'UTF-8';
		$oMail->oMail->Subject		= "Autorizacion";
		$oMail->oMail->AddAddress($sCorreo);
		$oMail->oMail->isHTML(true);
		$oMail->oMail->Body = $sTemplate;

		if(!$oMail->oMail->Send()){
			$array_res = array(
				'bExito'			=> false,
				'nCodigo'			=> 1,
				'sMsg'				=> 'No fue posible enviar el Correo, Intente nuevamente',
				'sMensajeDetallado'	=> "1 : ".$oMail->oMail->ErrorInfo,
			);

			$this->oLog->error('No fue posible enviar el email de autorizacion a '.$sCorreo.' Error :'.$oMail->oMail->ErrorInfo);
		}
		else{
			$array_res = array(
				'bExito'			=> true,
				'nCodigo'			=> 0,
				'sMsg'				=> 'Correo Enviado',
				'sMensajeDetallado'	=> ''
			);
		}
		$oMail->oMail->__destruct();

		return $array_res;
	} # enviarCorreoAutorizador

	public function desconciliar(){
		$array_params = array(
			array(
				'name'	=> 'nIdMovBanco',
				'type'	=> 'i',
				'value'	=> self::getNIdMovBanco()
			),
			array(
				'name'	=> 'nIdUsuario',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuario()
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_CONCILIACION_DESCONCILIAR');
		$this->oWdb->setParams($array_params);
		$result = $this->oWdb->execute();

		if($result['bExito'] == false || $result['nCodigo'] !=0){
			return $result;
		}

		$result = $this->oWdb->fetchAll();

		return array(
			'bExito'	=> $result[0]['result_code'] == 0 ? true : false,
			'nCodigo'	=> $result[0]['result_code'],
			'sMensaje'	=> $result[0]['result_msg'],
			'data'		=> $result
		);
	} # desconciliar
} # Conciliacion

?>