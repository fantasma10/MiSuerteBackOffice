<?php

class CuentaContableRE{

	public $numCuenta;
	public $idEmpleado;
	public $idCadena;
	public $idSubCadena;
	public $idCorresponsal;
	public $idTipoLiqReembolso;
	public $idTipoLiqComision;
	public $serie;
	public $saldoCuenta;
	public $saldoComisiones;
	public $saldoCredito;
	public $saldoMinimo;
	public $tipoFORELO;
	public $nivelForelo;
	public $FORELO;
	public $CREDITO;
	public $ctaContable;
	public $nombreCuenta;

	public function setNumCuenta($value){
		$this->numCuenta = $value;
	}

	public function getNumCuenta(){
		return $this->numCuenta;
	}

	public function setIdEmpleado($value){
		$this->idEmpleado = $value;
	}

	public function getIdEmpleado(){
		return $this->idEmpleado;
	}

	public function setIdCadena($value){
		$this->idCadena = $value;
	}

	public function getIdCadena(){
		return $this->idCadena;
	}

	public function setIdSubCadena($value){
		$this->idSubCadena = $value;
	}

	public function getIdSubCadena(){
		return $this->idSubCadena;
	}

	public function setIdCorresponsal($value){
		$this->idCorresponsal = $value;
	}

	public function getIdCorresponsal(){
		return $this->idCorresponsal;
	}

	public function setIdTipoLiqReembolso($value){
		$this->idTipoLiqReembolso = $value;
	}

	public function getIdTipoLiqReembolso(){
		return $this->idTipoLiqReembolso;
	}

	public function setIdTipoLiqComision($value){
		$this->idTipoLiqComision = $value;
	}

	public function getIdTipoLiqComision(){
		return $this->idTipoLiqComision;
	}

	public function setSerie($value){
		$this->serie = $value;
	}

	public function getSerie(){
		return $this->serie;
	}

	public function setSaldoCuenta($value){
		$this->saldoCuenta = $value;
	}

	public function getSaldoCuenta(){
		return $this->saldoCuenta;
	}

	public function setSaldoComisiones($value){
		$this->saldoComisiones = $value;
	}

	public function getSaldoComisiones(){
		return $this->saldoComisiones;
	}

	public function setSaldoCredito($value){
		$this->saldoCredito = $value;
	}

	public function getSaldoCredito(){
		return $this->saldoCredito;
	}

	public function setSaldoMinimo($value){
		$this->saldoMinimo = $value;
	}

	public function getSaldoMinimo(){
		return $this->saldoMinimo;
	}

	public function setTipoFORELO($value){
		$this->tipoFORELO = $value;
	}

	public function getTipoFORELO(){
		return $this->tipoFORELO;
	}

	public function setNivelForelo($value){
		$this->nivelForelo = $value;
	}

	public function getNivelForelo(){
		return $this->nivelForelo;
	}

	public function setFORELO($value){
		$this->FORELO = $value;
	}

	public function getFORELO(){
		return $this->FORELO;
	}

	public function setCREDITO($value){
		$this->CREDITO = $value;
	}

	public function getCREDITO(){
		return $this->CREDITO;
	}

	public function setCtaContable($value){
		$this->ctaContable = $value;
	}

	public function getCtaContable(){
		return $this->ctaContable;
	}

	public function setNombreCuenta($value){
		$this->nombreCuenta = $value;
	}

	public function getNombreCuenta(){
		return $this->nombreCuenta;
	}

	public function setORdb($oRdb){
		$this->oRdb = $oRdb;
	}

	public function setOWdb($oWdb){
		$this->oWdb = $oWdb;
	}

	# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


	/*
		Buscar la cuenta de forelo a partir de la cuenta contable
	*/
	public function obtenerCuentaForelo(){
		$array_params = array(
			array(
				'name'	=> 'nNumCuentaContable',
				'value'	=> self::getCtaContable(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_numcuenta');
		$this->oRdb->setParams($array_params);

		$arrRes	= $this->oRdb->execute();

		if($arrRes['nCodigo'] > 0 || $arrRes['bExito'] == false){
			return $arrRes;
		}

		$data	= $this->oRdb->fetchAll();
		$count	= $this->oRdb->numRows();

		$this->oRdb->closeStmt();

		return array(
			'bExito'	=> true,
			'nCodigo'	=> 0,
			'sMensaje'	=> 'Consulta Exitosa',
			'data'		=> $data,
			'count'		=> $count
		);
	} # obtenerCuentaForelo

} # CuentaContableRE

?>