<?php

class PeriodoCorte{

	public $oRdb;
	public $oWdb;

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

	# # # # # # # # # # # # # # # # #

	public function proveedorCorteComision(){
		$array_params = array();

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_periodo_cortecomision');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # proveedorCorteComision

} # PeriodosCortes

?>