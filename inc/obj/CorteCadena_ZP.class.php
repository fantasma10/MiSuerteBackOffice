<?php

class CorteCadena_ZP{

	public $nIdComision;
	public $nIdEstatus;
	public $nYear;
	public $nMonth;
	public $nIdCadena;
	public $nTotalOperaciones;
	public $nAdicional;
	public $nTotalMonto;
	public $nTotalComision;
	public $nTotalAdicional;
	public $nTotalFactura;
	public $nTotalPago;
	public $dFecha;
	public $dFecPago;
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

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
	}

	public function setNTotalOperaciones($value){
		$this->nTotalOperaciones = $value;
	}

	public function getNTotalOperaciones(){
		return $this->nTotalOperaciones;
	}

	public function setNAdicional($value){
		$this->nAdicional = $value;
	}

	public function getNAdicional(){
		return $this->nAdicional;
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

	public function setNTotalAdicional($value){
		$this->nTotalAdicional = $value;
	}

	public function getNTotalAdicional(){
		return $this->nTotalAdicional;
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

	# # # # # # # # # # # # # # # # # # # # # # #

	public function listaPeriodos(){
		$array_params = array();

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_periodo_cortecadena');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
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
	} # listaPeriodos

	/*
		Se utiliza para listar los cortes que ya han sido pagados
	*/
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
			),
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('zeropago');
		$this->oRdb->setSStoredProcedure('sp_select_cortes_cadena');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
		}

		$data = $this->oRdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # listaCortes
}  # CorteCadena

?>