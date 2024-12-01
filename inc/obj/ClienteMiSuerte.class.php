<?php

class ClienteMiSuerte{

	public $nIdCliente;
	public $nIdEstatus;
	public $sRFC;
	public $sRazonSocial;
	public $sNombreComercial;
	public $nNeteo;
	public $nDiasLiquidacionPagos;
	public $nDiasPagoComisiones;
	public $nIdDireccion;
	public $nIdContacto;
	public $nImporteComision;
	public $nPorcentajeComision;
	public $nIdComprobanteDomicilio;
	public $nIdContrato;
	public $nIdActaConstitutiva;
	public $sCLABE;
	public $sNombreBeneficiario;
	public $sEmail;
	public $sTelefono;
	public $numerica;
	public $alfanumerica;
	public $nIdUsuario;
	public $oRdb;
	public $oWdb;

	public function setNIdCliente($value){
		$this->nIdCliente = $value;
	}

	public function getNIdCliente(){
		return $this->nIdCliente;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setSRFC($value){
		$this->sRFC = $value;
	}

	public function getSRFC(){
		return $this->sRFC;
	}

	public function setSRazonSocial($value){
		$this->sRazonSocial = $value;
	}

	public function getSRazonSocial(){
		return $this->sRazonSocial;
	}

	public function setSNombreComercial($value){
		$this->sNombreComercial = $value;
	}

	public function getSNombreComercial(){
		return $this->sNombreComercial;
	}

	public function setNNeteo($value){
		$this->nNeteo = $value;
	}

	public function getNNeteo(){
		return $this->nNeteo;
	}

	public function setNDiasLiquidacionPagos($value){
		$this->nDiasLiquidacionPagos = $value;
	}

	public function getNDiasLiquidacionPagos(){
		return $this->nDiasLiquidacionPagos;
	}

	public function setNDiasPagoComisiones($value){
		$this->nDiasPagoComisiones = $value;
	}

	public function getNDiasPagoComisiones(){
		return $this->nDiasPagoComisiones;
	}

	public function setNIdDireccion($value){
		$this->nIdDireccion = $value;
	}

	public function getNIdDireccion(){
		return $this->nIdDireccion;
	}

	public function setNIdContacto($value){
		$this->nIdContacto = $value;
	}

	public function getNIdContacto(){
		return $this->nIdContacto;
	}

	public function setNImporteComision($value){
		$this->nImporteComision = $value;
	}

	public function getNImporteComision(){
		return $this->nImporteComision;
	}

	public function setNPorcentajeComision($value){
		$this->nPorcentajeComision = $value;
	}

	public function getNPorcentajeComision(){
		return $this->nPorcentajeComision;
	}

	public function setNIdComprobanteDomicilio($value){
		$this->nIdComprobanteDomicilio = $value;
	}

	public function getNIdComprobanteDomicilio(){
		return $this->nIdComprobanteDomicilio;
	}

	public function setNIdContrato($value){
		$this->nIdContrato = $value;
	}

	public function getNIdContrato(){
		return $this->nIdContrato;
	}

	public function setNIdActaConstitutiva($value){
		$this->nIdActaConstitutiva = $value;
	}

	public function getNIdActaConstitutiva(){
		return $this->nIdActaConstitutiva;
	}

	public function setSCLABE($value){
		$this->sCLABE = $value;
	}

	public function getSCLABE(){
		return $this->sCLABE;
	}

	public function setSNombreBeneficiario($value){
		$this->sNombreBeneficiario = $value;
	}

	public function getSNombreBeneficiario(){
		return $this->sNombreBeneficiario;
	}

	public function setSEmail($value){
		$this->sEmail = $value;
	}

	public function getSEmail(){
		return $this->sEmail;
	}

	public function setSTelefono($value){
		$this->sTelefono = $value;
	}

	public function getSTelefono(){
		return $this->sTelefono;
	}

	public function setNumerica($value){
		$this->numerica = $value;
	}

	public function getNumerica(){
		return $this->numerica;
	}

	public function setAlfanumerica($value){
		$this->alfanumerica = $value;
	}

	public function getAlfanumerica(){
		return $this->alfanumerica;
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

	# # # # # # # # # # # # # # # # # # # # #

	public function lista(){
		$array_params = array();

		/*
		$this->oRdb->setSDatabase('pronosticos');
		$this->oRdb->setSStoredProcedure('sp_select_cliente');
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
		*/
		$this->oWdb->setSDatabase('pronosticos');
		$this->oWdb->setSStoredProcedure('sp_select_cliente');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	}  # lista
} # ClienteMiSuerte

?>