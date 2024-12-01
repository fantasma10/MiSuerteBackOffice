<?php

class Cat_Banco{

	public $nIdBanco;
	public $nIdEstatus;
	public $nIdEmpleado;
	public $sNombreBanco;
	public $sDescripcion;
	public $sClave;
	public $oRdb;
	public $oWdb;

	public function setNIdBanco($value) {
		$this->nIdBanco = $value;
	}

	public function getNIdBanco() {
		return $this->nIdBanco;
	}

	public function setNIdEstatus($value) {
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus() {
		return $this->nIdEstatus;
	}

	public function setNIdEmpleado($value) {
		$this->nIdEmpleado = $value;
	}

	public function getNIdEmpleado() {
		return $this->nIdEmpleado;
	}

	public function setSNombreBanco($value) {
		$this->sNombreBanco = $value;
	}

	public function getSNombreBanco() {
		return $this->sNombreBanco;
	}

	public function setSDescripcion($value) {
		$this->sDescripcion = $value;
	}

	public function getSDescripcion() {
		return $this->sDescripcion;
	}

	public function setSClave($value) {
		$this->sClave = $value;
	}

	public function getSClave() {
		return $this->sClave;
	}

	public function setORdb($value) {
		$this->oRdb = $value;
	}

	public function getORdb() {
		return $this->oRdb;
	}

	public function setOWdb($value) {
		$this->oWdb = $value;
	}

	public function getOWdb() {
		return $this->oWdb;
	}

	public function sp_select_banco(){
		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_banco');
		$this->oRdb->setParams(array());

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # sp_select_banco

	Public function bancoSPEI(){	
		$array_params = array();
		$this->oRdb-> setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_bancos_spei');
		$this->oRdb->setParams($array_params);
		
		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}
		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		if(count($data) == 1){
			$data = $data[0];
		}

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	
	}
} # Cat_Banco

?>