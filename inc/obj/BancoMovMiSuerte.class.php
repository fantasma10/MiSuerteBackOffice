<?php

class BancoMovMiSuerte{

	public $idMovBanco;
	public $idEstatus;
	public $idRegistro;
	public $idTipoMov;
	public $idTipoTrx;
	public $idBanco;
	public $idMovimiento;
	public $bReferencia;
	public $cuenta;
	public $importe;
	public $referencia;
	public $archivo;
	public $autorizacion;
	public $fecBanco;
	public $fecBusqueda;
	public $fecAplicacion;
	public $fecRegistro;
	public $fecMovimiento;
	public $dFecConciliacion;
	public $nIdPoliza;
	public $oRdb;
	public $oWdb;

	public function setIdMovBanco($value){
		$this->idMovBanco = $value;
	}

	public function getIdMovBanco(){
		return $this->idMovBanco;
	}

	public function setIdEstatus($value){
		$this->idEstatus = $value;
	}

	public function getIdEstatus(){
		return $this->idEstatus;
	}

	public function setIdRegistro($value){
		$this->idRegistro = $value;
	}

	public function getIdRegistro(){
		return $this->idRegistro;
	}

	public function setIdTipoMov($value){
		$this->idTipoMov = $value;
	}

	public function getIdTipoMov(){
		return $this->idTipoMov;
	}

	public function setIdTipoTrx($value){
		$this->idTipoTrx = $value;
	}

	public function getIdTipoTrx(){
		return $this->idTipoTrx;
	}

	public function setIdBanco($value){
		$this->idBanco = $value;
	}

	public function getIdBanco(){
		return $this->idBanco;
	}

	public function setIdMovimiento($value){
		$this->idMovimiento = $value;
	}

	public function getIdMovimiento(){
		return $this->idMovimiento;
	}

	public function setBReferencia($value){
		$this->bReferencia = $value;
	}

	public function getBReferencia(){
		return $this->bReferencia;
	}

	public function setCuenta($value){
		$this->cuenta = $value;
	}

	public function getCuenta(){
		return $this->cuenta;
	}

	public function setImporte($value){
		$this->importe = $value;
	}

	public function getImporte(){
		return $this->importe;
	}

	public function setReferencia($value){
		$this->referencia = $value;
	}

	public function getReferencia(){
		return $this->referencia;
	}

	public function setArchivo($value){
		$this->archivo = $value;
	}

	public function getArchivo(){
		return $this->archivo;
	}

	public function setAutorizacion($value){
		$this->autorizacion = $value;
	}

	public function getAutorizacion(){
		return $this->autorizacion;
	}

	public function setFecBanco($value){
		$this->fecBanco = $value;
	}

	public function getFecBanco(){
		return $this->fecBanco;
	}

	public function setFecBusqueda($value){
		$this->fecBusqueda = $value;
	}

	public function getFecBusqueda(){
		return $this->fecBusqueda;
	}

	public function setFecAplicacion($value){
		$this->fecAplicacion = $value;
	}

	public function getFecAplicacion(){
		return $this->fecAplicacion;
	}

	public function setFecRegistro($value){
		$this->fecRegistro = $value;
	}

	public function getFecRegistro(){
		return $this->fecRegistro;
	}

	public function setFecMovimiento($value){
		$this->fecMovimiento = $value;
	}

	public function getFecMovimiento(){
		return $this->fecMovimiento;
	}

	public function setDFecConciliacion($value){
		$this->dFecConciliacion = $value;
	}

	public function getDFecConciliacion(){
		return $this->dFecConciliacion;
	}

	public function setNIdPoliza($value){
		$this->nIdPoliza = $value;
	}

	public function getNIdPoliza(){
		return $this->nIdPoliza;
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

	# # # # # # # # # # # # # # # # # # # # # # # # #

	public function listaMovimientos($dFechaInicio, $dFechaFinal){
		$array_params = array(
			array(
				'name'	=> 'nIdEstatus',
				'value'	=> self::getIdEstatus(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> $dFechaInicio,
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> $dFechaFinal,
				'type'	=> 's'
			)
		);

		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_bancomovs');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] > 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'nTotal'			=> count($data)
		);
	} # listaMovimientos
} # BancoMovMiSuerte

?>