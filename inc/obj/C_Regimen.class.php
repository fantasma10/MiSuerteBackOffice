<?php

class C_Regimen{

	public $nIdRegimen;
	public $sNombre;
	public $nIdEstatus;
	public $oRdb;
	public $oWdb;

	public function setNIdRegimen($value){
		$this->nIdRegimen = $value;
	}

	public function getNIdRegimen(){
		return $this->nIdRegimen;
	}

	public function setSNombre($value){
		$this->sNombre = $value;
	}

	public function getSNombre(){
		return $this->sNombre;
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

	public function storeRegimen(){
		$oRegimen = new Cat_Regimen();
		$oRegimen->setORdb($this->oRdb);
		$oRegimen->setOWdb($this->oWdb);

		$resultado = $oRegimen->sp_select_regimen();

		return $resultado;
	} # storeRegimen

} # C_Regimen

?>