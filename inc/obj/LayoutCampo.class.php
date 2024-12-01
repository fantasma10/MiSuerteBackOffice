<?php

class LayoutCampo{

	public $nIdLayout;
	public $nIdCampo;
	public $nIdEstatus;
	public $nIdUsuario;
	public $sPosicion;
	public $sTitulo;

	public function setNIdLayout($value){
		$this->nIdLayout = $value;
	}

	public function getNIdLayout(){
		return $this->nIdLayout;
	}

	public function setNIdCampo($value){
		$this->nIdCampo = $value;
	}

	public function getNIdCampo(){
		return $this->nIdCampo;
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

	public function setSPosicion($value){
		$this->sPosicion = $value;
	}

	public function getSPosicion(){
		return $this->sPosicion;
	}

	public function setSTitulo($value){
		$this->sTitulo = $value;
	}

	public function getSTitulo(){
		return $this->sTitulo;
	}
} # LayoutCampo

?>