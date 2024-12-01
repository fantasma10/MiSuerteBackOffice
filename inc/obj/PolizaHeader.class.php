<?php

class PolizaHeader{

	public $nIdPoliza;
	public $sTipo;
	public $dFecha;
	public $nIdTipoPoliza;
	public $sFolio;
	public $nIdClase;
	public $nIdDiario;
	public $sConcepto;
	public $nIdSistOrig;
	public $nImpresa;
	public $nAjuste;
	public $nIdUsuario;
	public $nIdEstatus;
	public $oRdb;
	public $oWdb;
	public $sDatabase = 'redefectiva';

	public function setSDatabase($sDatabase){
		$this->sDatabase = $sDatabase;
	}

	public function getSDatabase(){
		return $this->sDatabase;
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

	public function setNIdPoliza($value){
		$this->nIdPoliza = $value;
	}

	public function getNIdPoliza(){
		return $this->nIdPoliza;
	}

	public function setSTipo($value){
		$this->sTipo = $value;
	}

	public function getSTipo(){
		return $this->sTipo;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
	}

	public function setNIdTipoPoliza($value){
		$this->nIdTipoPoliza = $value;
	}

	public function getNIdTipoPoliza(){
		return $this->nIdTipoPoliza;
	}

	public function setSFolio($value){
		$this->sFolio = $value;
	}

	public function getSFolio(){
		return $this->sFolio;
	}

	public function setNIdClase($value){
		$this->nIdClase = $value;
	}

	public function getNIdClase(){
		return $this->nIdClase;
	}

	public function setNIdDiario($value){
		$this->nIdDiario = $value;
	}

	public function getNIdDiario(){
		return $this->nIdDiario;
	}

	public function setSConcepto($value){
		$this->sConcepto = $value;
	}

	public function getSConcepto(){
		return $this->sConcepto;
	}

	public function setNIdSistOrig($value){
		$this->nIdSistOrig = $value;
	}

	public function getNIdSistOrig(){
		return $this->nIdSistOrig;
	}

	public function setNImpresa($value){
		$this->nImpresa = $value;
	}

	public function getNImpresa(){
		return $this->nImpresa;
	}

	public function setNAjuste($value){
		$this->nAjuste = $value;
	}

	public function getNAjuste(){
		return $this->nAjuste;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	# # # # # # # # # # # # # # # # # # # #

	public function guardar(){
		$array_params = array(
			array(
				'name'	=> 'sTipo',
				'value'	=>	self::getSTipo(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFecha',
				'value'	=>	self::getDFecha(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdTipoPoliza',
				'value'	=>	self::getNIdTipoPoliza(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sFolio',
				'value'	=>	self::getSFolio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdClase',
				'value'	=>	self::getNIdClase(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdDiario',
				'value'	=>	self::getNIdDiario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'sConcepto',
				'value'	=>	self::getSConcepto(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdSistOrig',
				'value'	=>	self::getNIdSistOrig(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nImpresa',
				'value'	=>	self::getNImpresa(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nAjuste',
				'value'	=>	self::getNAjuste(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=>	self::getNIdUsuario(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdEstatus',
				'value'	=>	self::getNIdEstatus(),
				'type'	=> 'i'
			)
		);

		$sDatabase = self::getSDatabase();

		$this->oWdb->setSDatabase($sDatabase);
		$this->oWdb->setSStoredProcedure('sp_insert_poliza');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$resultado = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();
		if($resultado[0]['result_code'] == 0){
			self::setNIdPoliza($resultado[0]['nIdPoliza']);
		}

		return array(
			'bExito'	=> $resultado[0]['result_code'] == 0 ? true : false,
			'nCodigo'	=> $resultado[0]['result_code'],
			'sMensaje'	=> $resultado[0]['result_msg'],
			'data'		=> $resultado
		);
	} # guardar

	public function cargar(){
		$array_params = array(
			array(
				'name'	=> 'nIdPoliza',
				'value'	=> self::getNIdPoliza(),
				'type'	=> 'i'
			)
		);

		$sDatabase = self::getSDatabase();
		$this->oWdb->setSDatabase($sDatabase);
		$this->oWdb->setSStoredProcedure('sp_select_polizalayoutheader');
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
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data
		);
	} # cargar
} # LayoutHeader

?>