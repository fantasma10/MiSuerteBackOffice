<?php

class BancoMov{

	public $oRdb;
	public $oWdb;
	public $oLog;
	public $idMovBanco;
	public $idEstatus;
	public $idRegistro		= '';
	public $idTipoMov;
	public $idTipoTrx		= 0;
	public $idBanco;
	public $idMovimiento	= 0;
	public $bReferencia;
	public $cuenta;
	public $importe;
	public $referencia;
	public $archivo			= '';
	public $autorizacion;
	public $fecBanco;
	public $fecBusqueda		= '0000-00-00';
	public $fecAplicacion;
	public $fecRegistro;
	public $fecMovimiento;

	public $dFechaInicio;
	public $dFechaFinal;
	public $idMovBanco2;
	public $nIdUsuario;
	public $dFechaFiltro;
	public $nPerfil			= 1;

	public function setNPerfil($nPerfil){
		$this->nPerfil = $nPerfil;
	}

	public function getNPerfil(){
		return $this->nPerfil;
	}

	public function setIdMovBanco2($nIdMovBanco2){
		$this->nIdMovBanco2 = $nIdMovBanco2;
	}

	public function getIdMovBanco2(){
		return $this->nIdMovBanco2;
	}

	public function setNIdUsuario($nIdUsuario){
		$this->nIdUsuario = $nIdUsuario;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setOLog($oLog){
		$this->oLog = $oLog;
	}

	public function getOLog(){
		return $this->oLog;
	}

	public function setIdMovBanco($value){
		$this->idMovBanco = $value;
	}

	public function getIdMovBanco(){
		return $this->idMovBanco;
	}

	public function setIdEstatus($value){
		$this->idEstatus = $value;
	}

	public function getIdEstatus(){
		return $this->idEstatus;
	}

	public function setIdRegistro($value){
		$this->idRegistro = $value;
	}

	public function getIdRegistro(){
		return $this->idRegistro;
	}

	public function setIdTipoMov($value){
		$this->idTipoMov = $value;
	}

	public function getIdTipoMov(){
		return $this->idTipoMov;
	}

	public function setIdTipoTrx($value){
		$this->idTipoTrx = $value;
	}

	public function getIdTipoTrx(){
		return $this->idTipoTrx;
	}

	public function setIdBanco($value){
		$this->idBanco = $value;
	}

	public function getIdBanco(){
		return $this->idBanco;
	}

	public function setIdMovimiento($value){
		$this->idMovimiento = $value;
	}

	public function getIdMovimiento(){
		return $this->idMovimiento;
	}

	public function setBReferencia($value){
		$this->bReferencia = $value;
	}

	public function getBReferencia(){
		return $this->bReferencia;
	}

	public function setCuenta($value){
		$this->cuenta = $value;
	}

	public function getCuenta(){
		return $this->cuenta;
	}

	public function setImporte($value){
		$this->importe = $value;
	}

	public function getImporte(){
		return $this->importe;
	}

	public function setReferencia($value){
		$this->referencia = $value;
	}

	public function getReferencia(){
		return $this->referencia;
	}

	public function setArchivo($value){
		$this->archivo = $value;
	}

	public function getArchivo(){
		return $this->archivo;
	}

	public function setAutorizacion($value){
		$this->autorizacion = $value;
	}

	public function getAutorizacion(){
		return $this->autorizacion;
	}

	public function setFecBanco($value){
		$this->fecBanco = $value;
	}

	public function getFecBanco(){
		return $this->fecBanco;
	}

	public function setFecBusqueda($value){
		$this->fecBusqueda = $value;
	}

	public function getFecBusqueda(){
		return $this->fecBusqueda;
	}

	public function setFecAplicacion($value){
		$this->fecAplicacion = $value;
	}

	public function getFecAplicacion(){
		return $this->fecAplicacion;
	}

	public function setFecRegistro($value){
		$this->fecRegistro = $value;
	}

	public function getFecRegistro(){
		return $this->fecRegistro;
	}

	public function setFecMovimiento($value){
		$this->fecMovimiento = $value;
	}

	public function getFecMovimiento(){
		return $this->fecMovimiento;
	}

	public function setDFechaInicio($dFechaInicio){
		$this->dFechaInicio = $dFechaInicio;
	}

	public function getDFechaInicio(){
		return $this->dFechaInicio;
	}

	public function setDFechaFinal($dFechaFinal){
		$this->dFechaFinal = $dFechaFinal;
	}

	public function getDFechaFinal(){
		return $this->dFechaFinal;
	}

	public function setDFechaFiltro($value){
		$this->dFechaFiltro = $value;
	}

	public function getDFechaFiltro(){
		return $this->dFechaFiltro;
	}

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # #

	public function insertar(){

		$array_params = array(
			array(
				'name'	=>'idRegistro',
				'value'	=> self::getIdRegistro(),
				'type'	=> 's'
			),
			array(
				'name'	=>'idTipoMov',
				'value'	=> self::getIdTipoMov(),
				'type'	=> 'i'
			),
			array(
				'name'	=>'idTipoTrx',
				'value'	=> self::getIdTipoTrx(),
				'type'	=> 'i'
			),
			array(
				'name'	=>'idBanco',
				'value'	=> self::getIdBanco(),
				'type'	=> 'i'
			),
			array(
				'name'	=>'bReferencia',
				'value'	=> self::getBReferencia(),
				'type'	=> 'i'
			),
			array(
				'name'	=>'cuenta',
				'value'	=> self::getCuenta(),
				'type'	=> 's'
			),
			array(
				'name'	=>'importe',
				'value'	=> self::getImporte(),
				'type'	=> 'd'
			),
			array(
				'name'	=>'referencia',
				'value'	=> self::getReferencia(),
				'type'	=> 's'
			),
			array(
				'name'	=>'archivo',
				'value'	=> self::getArchivo(),
				'type'	=> 's'
			),
			array(
				'name'	=>'autorizacion',
				'value'	=> self::getAutorizacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=>'fecBanco',
				'value'	=> self::getFecBanco(),
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('SP_BANCO_REGISTRAMOVBANCOMER');
		$this->oWdb->setParams($array_params);

		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] > 0){
			return $arrRes;
		}

		$result = $this->oWdb->fetchAll();

		//echo '<pre>'; var_dump($result); echo '</pre>';

		$this->oWdb->closeStmt();

		$nCodigo	= $result[0]['result_code'];
		$sMsg		= $result[0]['result_msg'];

		return array(
			'bExito'		=> ($nCodigo != 0)? false : true,
			'nCodigo'		=> $nCodigo,
			'sMensaje'		=> $sMsg,
			'sMsgError'		=> $sMsg
		);
	} # insertar

	public function consultar(){
		$array_params = array(
			array(
				'name'	=> 'nIdBanco',
				'type'	=> 'i',
				'value'	=> self::getIdBanco()
			),
			array(
				'name'	=> 'nNumCuenta',
				'type'	=> 's',
				'value'	=> self::getCuenta()
			),
			array(
				'name'	=> 'nNumAutorizacion',
				'type'	=> 's',
				'value'	=> self::getAutorizacion()
			),
			array(
				'name'	=> 'dFechaInicio',
				'type'	=> 's',
				'value'	=> self::getDFechaInicio()
			),
			array(
				'name'	=> 'dFechaFinal',
				'type'	=> 's',
				'value'	=> self::getDFechaFinal()
			),
			array(
				'name'	=> 'nIdEstatus',
				'type'	=> 's',
				'value'	=> self::getIdEstatus()
			),
			array(
				'name'	=> 'dFechaFiltro',
				'type'	=> 'i',
				'value'	=> self::getDFechaFiltro()
			),
			array(
				'name'	=> 'nPerfil',
				'type'	=> 'i',
				'value'	=> self::getNPerfil()
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_SELECT_BANCOMOVS');
		$this->oRdb->setParams($array_params);
		$arrRes	= $this->oRdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$data	= $this->oRdb->fetchAll();
		$count	= $this->oRdb->numRows();

		$this->oRdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Exitosa',
			'data'		=> $data,
			'count'		=> $count
		);
	} # consultar

	public function unificar(){
		$array_params = array(
			array(
				'name'	=> 'idMovBanco',
				'value'	=> self::getIdMovBanco(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'idMovBanco2',
				'value'	=> self::getIdMovBanco2(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('SP_CONCILIACION_UNIFICAR');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$result = $this->oWdb->fetchAll();

		return array(
			'nCodigo'	=> $result[0]['result_code'],
			'bExito'	=> $result[0]['result_code'] != 0? false : true,
			'sMensaje'	=> $result[0]['result_msg'],
			'data'		=> $result
		);
	} # unificar

	public function corregir(){
		$array_params = array(
			array(
				'name'	=> 'idMovBanco',
				'value'	=> self::getIdMovBanco(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'idMovBanco2',
				'value'	=> self::getIdMovBanco2(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdUsuario',
				'value'	=> self::getNIdUsuario(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_conciliacion_corregir');
		$this->oWdb->setParams($array_params);
		$arrRes = $this->oWdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$result = $this->oWdb->fetchAll();

		return array(
			'nCodigo'	=> $result[0]['result_code'],
			'bExito'	=> $result[0]['result_code'] != 0? false : true,
			'sMensaje'	=> $result[0]['result_msg'],
			'data'		=> $result
		);
	}
} # EstadoCuentaMovimientos

?>