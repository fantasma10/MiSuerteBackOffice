<?php

class C_Colonia{

	public $sCodigoPostal;
	public $oRdb;
	public $oWdb;

	public function setSCodigoPostal($value) {
		$this->sCodigoPostal = $value;
	}

	public function getSCodigoPostal() {
		return $this->sCodigoPostal;
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

	public function storeColonia(){
		$oColonia = new Cat_Colonia();
		$oColonia->setORdb($this->oRdb);
		$oColonia->setOWdb($this->oWdb);
		$oColonia->setNCodigoColonia($this->sCodigoPostal);

		return $oColonia->sp_select_colonias();
	} # storeColonia
} # C_Colonia

?>