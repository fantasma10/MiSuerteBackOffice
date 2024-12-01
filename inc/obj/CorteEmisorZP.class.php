<?php

class CorteEmisorZP{

	public $nIdCorte;
	public $nIdEstatus;
	public $nIdEmisor;
	public $nTotalOperaciones;
	public $nTotalMonto;
	public $nTotalComision;
	public $nTotalPago;
	public $dFecha;
	public $dFecPago;
	public $dFecLiquidacion;
	public $oRdb;
	public $oWdb;
	public $dFechaInicio;
	public $dFechaFin;

	public function setDFechaInicio($value){
		$this->dFechaInicio = $value;
	}

	public function getDFechaInicio(){
		return $this->dFechaInicio;
	}

	public function setDFechaFin($value){
		$this->dFechaFin = $value;
	}

	public function getDFechaFin(){
		return $this->dFechaFin;
	}
	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdEmisor($value){
		$this->nIdEmisor = $value;
	}

	public function getNIdEmisor(){
		return $this->nIdEmisor;
	}

	public function setNTotalOperaciones($value){
		$this->nTotalOperaciones = $value;
	}

	public function getNTotalOperaciones(){
		return $this->nTotalOperaciones;
	}

	public function setNTotalMonto($value){
		$this->nTotalMonto = $value;
	}

	public function getNTotalMonto(){
		return $this->nTotalMonto;
	}

	public function setNTotalComision($value){
		$this->nTotalComision = $value;
	}

	public function getNTotalComision(){
		return $this->nTotalComision;
	}

	public function setNTotalPago($value){
		$this->nTotalPago = $value;
	}

	public function getNTotalPago(){
		return $this->nTotalPago;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
	}

	public function setDFecPago($value){
		$this->dFecPago = $value;
	}

	public function getDFecPago(){
		return $this->dFecPago;
	}

	public function setDFecLiquidacion($value){
		$this->dFecLiquidacion = $value;
	}

	public function getDFecLiquidacion(){
		return $this->dFecLiquidacion;
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

	# # # # # # # # # # # # # # # # # # #

	public function listaCortes(){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicio',
				'type'	=> 's',
				'value'	=> self::getDFechaInicio()
			),
			array(
				'name'	=> 'dFechaFin',
				'type'	=> 's',
				'value'	=> self::getDFechaFin()
			),
			array(
				'name'	=> 'nIdEmisor',
				'type'	=> 'i',
				'value'	=> self::getNIdEmisor()
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_cortes_emisor');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();

		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta ok',
			'sMensajeDetalle'	=> '',
			'data'				=> $data
		);
	} # listaCortes

	public function actualizaPolizaPagoEmisor($nIdPoliza){
		$array_params = array(
			array(
				'name'	=> 'nIdComision',
				'value'	=> self::getNIdCorte(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdPoliza',
				'value'	=> $nIdPoliza,
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('zeropago');
		$this->oWdb->setSStoredProcedure('sp_update_con_corte_emisor');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Update Ok',
			'sMensajeDetallado'	=> ''
		);
	} # actualizaPolizaComision
} # CorteEmisorzeropago

?>