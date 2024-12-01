<?php

class ConfiguracionAutorizacion{

	public $oRdb;
	public $oWdb;
	public $oLog;
	public $nIdAutorizacion;
	public $sClave;
	public $nIdUsuario;
	public $sCorreo;
	public $nMonto;
	public $nDias;
	public $nIdBanco;
	public $nIdEstatus;
	public $sBuscar;
	public $nStart;
	public $nLimit;
	public $nSortCol;
	public $sSortDir;

	public function setSBuscar($value){
		$this->sBuscar = $value;
	}

	public function getSBuscar(){
		return $this->sBuscar;
	}

	public function setNStart($value){
		$this->nStart = $value;
	}

	public function getNStart(){
		return $this->nStart;
	}

	public function setNLimit($value){
		$this->nLimit = $value;
	}

	public function getNLimit(){
		return $this->nLimit;
	}

	public function setNSortCol($value){
		$this->nSortCol = $value;
	}

	public function getNSortCol(){
		return $this->nSortCol;
	}

	public function setSSortDir($value){
		$this->sSortDir = $value;
	}

	public function getSSortDir(){
		return $this->sSortDir;
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

	public function setOLog($value){
		$this->oLog = $value;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setNIdAutorizacion($value){
		$this->nIdAutorizacion = $value;
	}

	public function getNIdAutorizacion(){
		return $this->nIdAutorizacion;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setSClave($sClave){
		$this->sClave = $sClave;
	}

	public function getSClave(){
		return $this->sClave;
	}

	public function setSCorreo($value){
		$this->sCorreo = $value;
	}

	public function getSCorreo(){
		return $this->sCorreo;
	}

	public function setNMonto($value){
		$this->nMonto = $value;
	}

	public function getNMonto(){
		return $this->nMonto;
	}

	public function setNDias($value){
		$this->nDias = $value;
	}

	public function getNDias(){
		return $this->nDias;
	}

	public function setNIdBanco($value){
		$this->nIdBanco = $value;
	}

	public function getNIdBanco(){
		return $this->nIdBanco;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	# # # # # # # # # # # # # # # # # # # # #

	public function insertar(){
		$array_params = array(
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
				'name'	=> 'nMonto',
				'type'	=> 'd',
				'value'	=> self::getNMonto()
			),
			array(
				'name'	=> 'nDias',
				'type'	=> 'i',
				'value'	=> self::getNDias()
			),
			array(
				'name'	=> 'nIdBanco',
				'type'	=> 'i',
				'value'	=> self::getNIdBanco()
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_INSERT_CONFIGURACIONCUENTA');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$last_insert_id = $this->oWdb->lastInsertId();

		self::setNIdAutorizacion($last_insert_id);

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Configuracion Correcta',
			'sMensajeDetallado'	=> '',
			'data'				=> array()
		);
	} # insertar

	public function consultar(){
		$array_params = array(
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdBanco',
				'value'	=> self::getNIdBanco(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nMonto',
				'value'	=> self::getNMonto(),
				'type'	=> 'd'
			),
			array(
				'name'	=> 'nDias',
				'value'	=> self::getNDias(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'str',
				'value'	=> self::getSBuscar(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'start',
				'value'	=> self::getNStart(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'limit',
				'value'	=> self::getNLimit(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sortCol',
				'value'	=> self::getNSortCol(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sortDir',
				'value'	=> self::getSSortDir(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_SELECT_CONFAUTORIZACION');
		$this->oRdb->setParams($array_params);

		$arrRes = $this->oRdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$array_result = $this->oRdb->fetchAll();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Ok',
			'data'		=> $array_result,
			'nTotal'	=> $this->oRdb->numRows()
		);
	} # consultar
} # ConfiguracionAutorizacion

?>