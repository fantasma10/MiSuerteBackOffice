<?php

class Proveedor{

	public $nIdProveedor;
	public $oRdb;
	public $oWdb;

	public function setNIdProveedor($nIdProveedor){
		$this->nIdProveedor = $nIdProveedor;
	}

	public function getNIdProveedor(){
		return $this->nIdProveedor;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function getORdb(){
		return $this->oRdb;
	}

	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	public function getOWdb(){
		return $this->oWdb;
	}

	# # # # # # # # # # # # # # # # # #

	public function listaCombo(){
		$array_params = array(
			array(
				'name'	=> 'nIdProveedor',
				'value'	=> self::getNIdProveedor(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_proveedor');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> false,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # listaCombo
} # Proveedor

?>