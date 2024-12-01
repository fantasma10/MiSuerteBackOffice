<?php

class EstatusCorteComision{

	public $nIdEstatus;
	public $sNombre;
	public $oRdb;
	public $owdb;

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

	public function setORdb($value){
		$this->oRdb = $value;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOwdb($value){
		$this->owdb = $value;
	}

	public function getOwdb(){
		return $this->owdb;
	}

	# # # # # # # # # # # # # # # # # # #

	public function listaCombo(){
		$array_params = array(
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getNIdEstatus(),
				'type'	=> 'i'
			)
		);

		$this->owdb->setSDatabase('pronosticos');
		$this->owdb->setSStoredProcedure('sp_select_estatus_cortecomision');
		$this->owdb->setParams($array_params);

		$resultado = $this->owdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data		= $this->owdb->fetchAll();
		$num_rows	= $this->owdb->numRows();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'num_rows'			=> $num_rows
		);
	} # listaCombo

} # EstatusCorteComision

?>