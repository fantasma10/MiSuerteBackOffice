<?php

class CorteComisionCliente{

	public $nIdCorte;
	public $nIdEstatus;
	public $nIdCliente;
	public $nTotalOperaciones;
	public $nMonto;
	public $nComision;
	public $nImporteVentaIndirecta;
	public $nTotalPago;
	public $dFechaInicio;
	public $dFechaFin;
	public $dFechaPago;
	public $dFechaLiquidacion;
	public $nIdUsuario;
	public $oRdb;
	public $oWdb;

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

	public function setNIdCliente($value){
		$this->nIdCliente = $value;
	}

	public function getNIdCliente(){
		return $this->nIdCliente;
	}

	public function setNTotalOperaciones($value){
		$this->nTotalOperaciones = $value;
	}

	public function getNTotalOperaciones(){
		return $this->nTotalOperaciones;
	}

	public function setNMonto($value){
		$this->nMonto = $value;
	}

	public function getNMonto(){
		return $this->nMonto;
	}

	public function setNComision($value){
		$this->nComision = $value;
	}

	public function getNComision(){
		return $this->nComision;
	}

	public function setNImporteVentaIndirecta($value){
		$this->nImporteVentaIndirecta = $value;
	}

	public function getNImporteVentaIndirecta(){
		return $this->nImporteVentaIndirecta;
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

	public function setDFechaPago($value){
		$this->dFechaPago = $value;
	}

	public function getDFechaPago(){
		return $this->dFechaPago;
	}

	public function setDFechaLiquidacion($value){
		$this->dFechaLiquidacion = $value;
	}

	public function getDFechaLiquidacion(){
		return $this->dFechaLiquidacion;
	}

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
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

	# # # # # # # # # # # # # # # # # # # # # # # #

	public function obtenerCorteMensual(){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFin',
				'value'	=> self::getDFechaFin(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'nIdCliente',
				'value'	=> self::getNIdCliente(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_cortecliente_periodo');
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

	} # obtenerCorteMensual
} # CorteComisionCliente

?>