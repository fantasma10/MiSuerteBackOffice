<?php

class Dat_Unidad_Negocio{

	public $nIdEstatus;
	public $nIdUsuario;
	public $nIdGiro;
	public $nIdNivel;
	public $nIdProveedor;
	public $nIdUnidadNegocio;
	public $nIdRegimen;
	public $nIdTipoLiquidacion;
	public $sApellidoMaterno;
	public $sApellidoPaterno;
	public $sCelular;
	public $sNombre;
	public $sNombreComercial;
	public $sNombreContacto;
	public $sNombreImagen;
	public $sRazonSocial;
	public $sRFC;
	public $sTelefono;
	public $nIdFaseRegistroEmisor;
	public $bEstadoEmisor;
	public $oRdb;
	public $oWdb;

	public function setNIdUsuario($value){
		$this->nIdUsuario = $value;
	}

	public function getNIdUsuario(){
		return $this->nIdUsuario;
	}

	public function setNIdEstatus($value){
		$this->nIdEstatus = $value;
	}

	public function getNIdEstatus(){
		return $this->nIdEstatus;
	}

	public function setNIdGiro($value){
		$this->nIdGiro = $value;
	}

	public function getNIdGiro(){
		return $this->nIdGiro;
	}

	public function setNIdNivel($value){
		$this->nIdNivel = $value;
	}

	public function getNIdNivel(){
		return $this->nIdNivel;
	}

	public function setNIdProveedor($value){
		$this->nIdProveedor = $value;
	}

	public function getNIdProveedor(){
		return $this->nIdProveedor;
	}

	public function getNIdUnidadNegocio()
	{
	    return $this->nIdUnidadNegocio;
	}
	
	public function setNIdUnidadNegocio($value)
	{
	    $this->nIdUnidadNegocio = $value;
	}

	public function setNIdRegimen($value){
		$this->nIdRegimen = $value;
	}

	public function getNIdRegimen(){
		return $this->nIdRegimen;
	}

	public function setNIdTipoLiquidacion($value){
		$this->nIdTipoLiquidacion = $value;
	}

	public function getNIdTipoLiquidacion(){
		return $this->nIdTipoLiquidacion;
	}

	public function setSApellidoMaterno($value){
		$this->sApellidoMaterno = $value;
	}

	public function getSApellidoMaterno(){
		return $this->sApellidoMaterno;
	}

	public function setSApellidoPaterno($value){
		$this->sApellidoPaterno = $value;
	}

	public function getSApellidoPaterno(){
		return $this->sApellidoPaterno;
	}

	public function setSCelular($value){
		$this->sCelular = $value;
	}

	public function getSCelular(){
		return $this->sCelular;
	}

	public function setSNombre($value){
		$this->sNombre = $value;
	}

	public function getSNombre(){
		return $this->sNombre;
	}

	public function setSNombreComercial($value){
		$this->sNombreComercial = $value;
	}

	public function getSNombreComercial(){
		return $this->sNombreComercial;
	}

	public function setSNombreContacto($value){
		$this->sNombreContacto = $value;
	}

	public function getSNombreContacto(){
		return $this->sNombreContacto;
	}

	public function setSNombreImagen($value){
		$this->sNombreImagen = $value;
	}

	public function getSNombreImagen(){
		return $this->sNombreImagen;
	}

	public function setSRazonSocial($value){
		$this->sRazonSocial = $value;
	}

	public function getSRazonSocial(){
		return $this->sRazonSocial;
	}

	public function setSRFC($value){
		$this->sRFC = $value;
	}

	public function getSRFC(){
		return $this->sRFC;
	}

	public function setSTelefono($value){
		$this->sTelefono = $value;
	}

	public function getSTelefono(){
		return $this->sTelefono;
	}

	public function setnIdFaseRegistroEmisor($value){
		$this->nIdFaseRegistroEmisor = $value;
	}

	public function getnIdFaseRegistroEmisor(){
		return $this->nIdFaseRegistroEmisor;
	}
	
	public function setBEstadoEmisor($value){
		$this->bEstadoEmisor = $value;
	}

	public function getBEstadoEmisor(){
		return $this->bEstadoEmisor;
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


	public function select_unidad_negocio(){
		$array_params = array(
			array(
				'name'	=> 'nIdUnidadNegocio',
				'value'	=> self::getNIdUnidadNegocio(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('facturacion');
		$this->oRdb->setSStoredProcedure('SP_GetUnidadNegocio');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # select_cat_tipo_conciliacion
	
	public function select_empresas_facturacion(){
		$array_params = array(
			array(
				'name'	=> 'nIdUnidadNegocio',
				'value'	=> self::getNIdUnidadNegocio(),
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('facturacion');
		$this->oRdb->setSStoredProcedure('sp_select_empresas');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			return $resultado;
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> 'Consulta Ok',
			'sMensajeDetallado'	=> 'Consulta Ok',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # sp_select_empresas_emisor
	
} # Dat_Proveedor

?>