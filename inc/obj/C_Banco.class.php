<?php

class C_Banco{

	public $nIdBanco;
	public $nIdEstatus;
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

	public function storeBanco(){
		$oBanco = new Cat_Banco();
		$oBanco->setORdb($this->oRdb);
		$oBanco->setOWdb($this->oWdb);

		$resultado = $oBanco->sp_select_banco();

		return $resultado;
	} # storeBanco
} # C_Banco

?>