<?php

class CorteComisionEmisorZP{

	public $nIdComision;
	public $nIdEstatus;
	public $nYear;
	public $nMonth;
	public $nIdEmisor;
	public $nTotalOperaciones;
	public $nComision;
	public $nTotalMonto;
	public $nTotalComision;
	public $nTotalFactura;
	public $nTotalPago;
	public $dFechaInicio;
	public $dFechaFin;
	public $dFecLiquidacion;
	public $dFecRegistro;
	public $dFecMovimiento;
	public $oRdb;
	public $oWdb;

	public function setNIdComision($value){
		$this->nIdComision = $value;
	}

	public function getNIdComision(){
		return $this->nIdComision;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNYear($value){
		$this->nYear = $value;
	}

	public function getNYear(){
		return $this->nYear;
	}

	public function setNMonth($value){
		$this->nMonth = $value;
	}

	public function getNMonth(){
		return $this->nMonth;
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

	public function setNComision($value){
		$this->nComision = $value;
	}

	public function getNComision(){
		return $this->nComision;
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

	public function setNTotalFactura($value){
		$this->nTotalFactura = $value;
	}

	public function getNTotalFactura(){
		return $this->nTotalFactura;
	}

	public function setNTotalPago($value){
		$this->nTotalPago = $value;
	}

	public function getNTotalPago(){
		return $this->nTotalPago;
	}

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

	public function setDFecLiquidacion($value){
		$this->dFecLiquidacion = $value;
	}

	public function getDFecLiquidacion(){
		return $this->dFecLiquidacion;
	}

	public function setDFecRegistro($value){
		$this->dFecRegistro = $value;
	}

	public function getDFecRegistro(){
		return $this->dFecRegistro;
	}

	public function setDFecMovimiento($value){
		$this->dFecMovimiento = $value;
	}

	public function getDFecMovimiento(){
		return $this->dFecMovimiento;
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

	# # # # # # # # # # # # # # # # # # # # #

	public function listaPeriodos(){
		$array_params = array();

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_periodo_comemisor');
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
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # listaPeriodos

	public function listaCortes(){
		$array_params = array(
			array(
				'name'	=> 'nYear',
				'value'	=> self::getNYear(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nMonth',
				'value'	=> self::getNMonth(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_comision_ganada');
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
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # listaCortes

	public function actualizaPolizaComision($nIdPoliza){
		$array_params = array(
			array(
				'name'	=> 'nIdComision',
				'value'	=> self::getNIdComision(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdPoliza',
				'value'	=> $nIdPoliza,
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('zeropago');
		$this->oWdb->setSStoredProcedure('sp_update_con_com_emisor');
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
} # CorteComisionEmisorzeropago

?>