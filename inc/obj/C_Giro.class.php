<?php

class C_Giro{

	public $nIdGiro;
	public $sNombreGiro;
	public $oRdb;
	public $oWdb;

	public function setNIdGiro($value){
		$this->nIdGiro = $value;
	}

	public function getNIdGiro(){
		return $this->nIdGiro;
	}

	public function setSNombreGiro($value){
		$this->sNombreGiro = $value;
	}

	public function getSNombreGiro(){
		return $this->sNombreGiro;
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

	public function storeGiro(){
		$oGiro = new Cat_Giro();
		$oGiro->setORdb($this->oRdb);
		$oGiro->setOWdb($this->oWdb);

		$resultado = $oGiro->sp_select_giro();

		return $resultado;
	} # storeGiro

} # C_Giro

?>