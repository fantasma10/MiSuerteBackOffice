<?php

class Cat_TipoOperacion{

	public $nIdTipoOperacion;
	public $sNombreTipoOperacion;
	public $nIdUsuario;
	public $dFecAlta;
	public $dFecMov;
	public $nIdEstatus;
	public $oRdb;
	public $oWdb;
	public $oLog;

	public function setNIdTipoOperacion($value){
		$this->nIdTipoOperacion = $value;
	}

	public function getNIdTipoOperacion(){
		return $this->nIdTipoOperacion;
	}

	public function setSNombreTipoOperacion($value){
		$this->sNombreTipoOperacion = $value;
	}

	public function getSNombreTipoOperacion(){
		return $this->sNombreTipoOperacion;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setDFecAlta($value){
		$this->dFecAlta = $value;
	}

	public function getDFecAlta(){
		return $this->dFecAlta;
	}

	public function setDFecMov($value){
		$this->dFecMov = $value;
	}

	public function getDFecMov(){
		return $this->dFecMov;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
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

	public function carga_catalogo(){

		$array_params = array(
			array(
				'name'	=> 'nIdTipoOperacion',
				'value' => self::getNIdTipoOperacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value' => self::getNIdEstatus(),
				'type' => 'i'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_SELECT_TIPOOPERACION');
		$this->oRdb->setParams($array_params);
		$this->oRdb->setBDebug(1);

		$arrResult = $this->oRdb->execute();

		if($arrResult['bExito'] == false){
			return $arrResult;
		}

		$array = $this->oRdb->fetchAll();

		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $array
		);

	} # carga_catalogo

} # Cat_TipoOperacion

?>