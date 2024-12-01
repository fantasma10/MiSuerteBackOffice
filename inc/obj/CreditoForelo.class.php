<?php

class CreditoForelo{

	public $nIdCredito;
	public $nIdEstatus;
	public $nIdUsuario;
	public $nIdMovimiento;
	public $nIdTipoCobro;
	public $nIdMovimientoCargo;
	public $nIdMovBanco;
	public $dFecCobro;
	public $dFecCobroReal;
	public $dFecRegistro;
	public $oRdb;
	public $oWdb;

	public function setNIdCredito($value){
		$this->nIdCredito = $value;
	}

	public function getNIdCredito(){
		return $this->nIdCredito;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdMovimiento($value){
		$this->nIdMovimiento = $value;
	}

	public function getNIdMovimiento(){
		return $this->nIdMovimiento;
	}

	public function setNIdTipoCobro($value){
		$this->nIdTipoCobro = $value;
	}

	public function getNIdTipoCobro(){
		return $this->nIdTipoCobro;
	}

	public function setNIdMovimientoCargo($value){
		$this->nIdMovimientoCargo = $value;
	}

	public function getNIdMovimientoCargo(){
		return $this->nIdMovimientoCargo;
	}

	public function setNIdMovBanco($value){
		$this->nIdMovBanco = $value;
	}

	public function getNIdMovBanco(){
		return $this->nIdMovBanco;
	}

	public function setDFecCobro($value){
		$this->dFecCobro = $value;
	}

	public function getDFecCobro(){
		return $this->dFecCobro;
	}

	public function setDFecCobroReal($value){
		$this->dFecCobroReal = $value;
	}

	public function getDFecCobroReal(){
		return $this->dFecCobroReal;
	}

	public function setDFecRegistro($value){
		$this->dFecRegistro = $value;
	}

	public function getDFecRegistro(){
		return $this->dFecRegistro;
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

	# # # # # # # # # # # # # # # # # # # # # # # # # # # #

	public function insertarCredito(){
		$array_params = array(
			array(
				'name'	=> 'nIdMovimiento',
				'type'	=> 'i',
				'value'	=> self::getNIdMovimiento()
			),
			array(
				'name'	=> 'nIdTipoCobro',
				'type'	=> 'i',
				'value'	=> self::getNIdTipoCobro()
			),
			array(
				'name'	=> 'dFecCobro',
				'type'	=> 's',
				'value'	=> self::getDFecCobro()
			),
			array(
				'name'	=> 'nIdUsuario',
				'type'	=> 'i',
				'value'	=> self::getNIdUsuario()
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_insert_creditoforelo');
		$this->oWdb->setParams($array_params);

		$arrRes = $this->oWdb->execute();

		if($arrRes['nCodigo'] != 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$last_insert_id = $this->oWdb->lastInsertId();

		self::setNIdCredito($last_insert_id);

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Credito Creado Correctamente',
			'data'		=> array()
		);
	} # insertarCredito

	public function lista($array_params){
		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_movimientos_credito');
		$this->oRdb->setParams($array_params);

		$arrRes = $this->oRdb->execute();

		if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
			return $arrRes;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$num_rows =  $this->oRdb->foundRows();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Ok',
			'data'		=> $data,
			'num_rows'	=> $num_rows
		);
	} # consultar

	public function cobrarAForelo($array_params){
		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_insert_creditoforelo_cobraraforelo');
		$this->oWdb->setParams($array_params);

		$result = $this->oWdb->execute();

		if($result['nCodigo'] != 0 || $result['bExito'] == false){
			return $result;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Cobro realizado Correctamente',
			'data'		=> $data
		);
	} # cobrarAForelo

	public function cobrarABanco($array_params){
		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('sp_insert_creditoforelo_call');
		$this->oWdb->setParams($array_params);

		$result = $this->oWdb->execute();

		if($result['nCodigo'] != 0 || $result['bExito'] == false){
			return $result;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Cobro realizado Correctamente',
			'data'		=> $data
		);
	} # cobrarABanco

} # CreditoForelo

?>