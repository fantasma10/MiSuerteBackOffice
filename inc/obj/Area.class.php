<?php

class Area{

	public $nIdArea;
	public $nIdEstatus;
	public $sNombre;
	public $dFecAlta;
	public $dFecMov;
	public $nIdUsuario;
	public $oWdb;
	public $oRdb;

	public function setNIdArea($value){
		$this->nIdArea = $value;
	}

	public function getNIdArea(){
		return $this->nIdArea;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setSNombre($value){
		$this->sNombre = $value;
	}

	public function getSNombre(){
		return $this->sNombre;
	}

	public function setDFecAlta($value){
		$this->dFecAlta = $value;
	}

	public function getDFecAlta(){
		return $this->dFecAlta;
	}

	public function setDFecMov($value){
		$this->dFecMov = $value;
	}

	public function getDFecMov(){
		return $this->dFecMov;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setOWdb($value){
		$this->oWdb = $value;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	public function setORdb($value){
		$this->oRdb = $value;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	# # # # # # # # # # # # # # # # # # # # #

	public function consultar(){
		$array_params = array(
			array(
				'name'	=> 'nIdArea',
				'value'	=> self::getNIdArea(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_area');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> false,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # consulta

} # Area

?>