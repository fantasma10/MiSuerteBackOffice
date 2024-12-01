<?php

class TipoMovimiento{

	public $idTipoMovimiento;
	public $descTipoMovimiento;
	public $idEstatusTipoMovimiento;
	public $fecMovTipoMovimiento;
	public $idEmpleado;
	public $oRdb;
	public $oWdb;

	public function setIdTipoMovimiento($value){
		$this->idTipoMovimiento = $value;
	}

	public function getIdTipoMovimiento(){
		return $this->idTipoMovimiento;
	}

	public function setDescTipoMovimiento($value){
		$this->descTipoMovimiento = $value;
	}

	public function getDescTipoMovimiento(){
		return $this->descTipoMovimiento;
	}

	public function setIdEstatusTipoMovimiento($value){
		$this->idEstatusTipoMovimiento = $value;
	}

	public function getIdEstatusTipoMovimiento(){
		return $this->idEstatusTipoMovimiento;
	}

	public function setFecMovTipoMovimiento($value){
		$this->fecMovTipoMovimiento = $value;
	}

	public function getFecMovTipoMovimiento(){
		return $this->fecMovTipoMovimiento;
	}

	public function setIdEmpleado($value){
		$this->idEmpleado = $value;
	}

	public function getIdEmpleado(){
		return $this->idEmpleado;
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

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # #

	public function getLista(){
		$array_params = array();

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('SP_CAT_TIPOMOVIMIENTO_LOAD');
		$this->oRdb->setParams($array);

		$result = $this->oRdb->execute();

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			return $result;
		}

		$data = $this->oRdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Cuentas Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'nRows'				=> count($data)
		);
	} # getLista

} # TipoMovimiento

?>