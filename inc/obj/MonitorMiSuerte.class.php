<?php

class MonitorMiSuerte{

	public $nIdCliente = 0;
	public $oRdb;
	public $oWdb;
	public $oEmail;

	public function setNIdCliente($nIdCliente){
		$this->nIdCliente = $nIdCliente;
	}

	public function getNIdCliente(){
		return $this->nIdCliente;
	}

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

	public function setOEmail($oEmail){
		$this->oEmail = $oEmail;
	}

	public function getOEmail(){
		return $this->oEmail;
	}

	# # # # # # # # # # # # # # # # # # # # # # # #

	public function obtenerMonitor(){
		$array_params = array(
			array(
				'name'	=> 'nIdCliente',
				'type'	=> 'i',
				'value'	=> self::getNIdCliente()
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_monitor');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # obtenerMonitor

	public function obtenerMonitorUltimaSemana(){
		$array_params = array(
			array(
				'name'	=> 'nIdCliente',
				'value'	=> self::getNIdCliente(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_monitor_sietedias');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # obtenerMonitorUltimaSemana

	public function obtenerUltimaOperacion(){
		$array_params = array(
			array(
				'name'	=> 'nIdCliente',
				'type'	=> 'i',
				'value'	=> self::getNIdCliente()
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_monitor_ultimaoperacion');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # obtenerUltimaOperacion

	public function enviarAlerta($array_correos, $sTemplate){
		$oMail = $this->oEmail;

		foreach($array_correos as $sCorreo){
			$oMail->oMail->AddAddress($sCorreo);
		}

		$oMail->oMail->addReplyTo('sistemas@redefectiva.com', 'Sistemas');
		$oMail->oMail->IsHTML(true);
		$oMail->oMail->Subject  	= "Alerta Inactividad";
		$oMail->oMail->isHTML(true);
		$oMail->oMail->Body     	= $sTemplate;

		if(!$oMail->oMail->Send()){
			$array_res = array(
				'bExito'			=> false,
				'nCodigo'			=> 1,
				'sMensaje'			=> 'No fue posible enviar el Correo de Notificacion',
				'sMensajeDetallado'	=> "1 : ".$oMail->oMail->ErrorInfo,
			);

			//$this->oLog->error('No fue posible enviar el email de autorizacion a '.$sCorreo.' Error :'.$oMail->MAIL->ErrorInfo);
		}
		else{
			$array_res = array(
				'bExito'			=> true,
				'nCodigo'			=> 0,
				'sMensaje'				=> 'Correo Enviado',
				'sMensajeDetallado'	=> ''
			);
		}

		return $array_res;
	} # enviarAlerta
} # MonitorMiSuerte

?>