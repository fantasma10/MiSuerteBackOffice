<?php

class EstatusPronosticos{

	public $oRdb;
	public $oWdb;
	public $nIdEstatus;
	public $sNombre;

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

	# # # # # # # # # # # # # # # # # # # #

	public function listaCombo(){
		$array_params = array(
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_estatus');
		$this->oWdb->setParams($array_params);
		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$resultado = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Lista Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $resultado
		);
	}# listaCombo
} # EstatusPronosticos

?>