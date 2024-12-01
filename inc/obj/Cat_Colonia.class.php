<?php

class Cat_Colonia{

	public $nIdColonia;
	public $nCodigoColonia;
	public $sNombreColonia;
	public $sTipoAsentamiento;
	public $D_mnpio;
	public $d_estado;
	public $d_ciudad;
	public $d_CP;
	public $nIdEntidad;
	public $c_oficina;
	public $c_tipo_asenta;
	public $nNumMunicipio;
	public $id_asenta_cpcons;
	public $d_zona;
	public $nIdCiudad;
	public $oRdb;
	public $oWdb;

	public function setNIdColonia($value) {
		$this->nIdColonia = $value;
	}

	public function getNIdColonia() {
		return $this->nIdColonia;
	}

	public function setNCodigoColonia($value) {
		$this->nCodigoColonia = $value;
	}

	public function getNCodigoColonia() {
		return $this->nCodigoColonia;
	}

	public function setSNombreColonia($value) {
		$this->sNombreColonia = $value;
	}

	public function getSNombreColonia() {
		return $this->sNombreColonia;
	}

	public function setSTipoAsentamiento($value) {
		$this->sTipoAsentamiento = $value;
	}

	public function getSTipoAsentamiento() {
		return $this->sTipoAsentamiento;
	}

	public function setD_mnpio($value) {
		$this->D_mnpio = $value;
	}

	public function getD_mnpio() {
		return $this->D_mnpio;
	}

	public function setD_estado($value) {
		$this->d_estado = $value;
	}

	public function getD_estado() {
		return $this->d_estado;
	}

	public function setD_ciudad($value) {
		$this->d_ciudad = $value;
	}

	public function getD_ciudad() {
		return $this->d_ciudad;
	}

	public function setD_CP($value) {
		$this->d_CP = $value;
	}

	public function getD_CP() {
		return $this->d_CP;
	}

	public function setNIdEntidad($value) {
		$this->nIdEntidad = $value;
	}

	public function getNIdEntidad() {
		return $this->nIdEntidad;
	}

	public function setC_oficina($value) {
		$this->c_oficina = $value;
	}

	public function getC_oficina() {
		return $this->c_oficina;
	}

	public function setC_tipo_asenta($value) {
		$this->c_tipo_asenta = $value;
	}

	public function getC_tipo_asenta() {
		return $this->c_tipo_asenta;
	}

	public function setNNumMunicipio($value) {
		$this->nNumMunicipio = $value;
	}

	public function getNNumMunicipio() {
		return $this->nNumMunicipio;
	}

	public function setId_asenta_cpcons($value) {
		$this->id_asenta_cpcons = $value;
	}

	public function getId_asenta_cpcons() {
		return $this->id_asenta_cpcons;
	}

	public function setD_zona($value) {
		$this->d_zona = $value;
	}

	public function getD_zona() {
		return $this->d_zona;
	}

	public function setNIdCiudad($value) {
		$this->nIdCiudad = $value;
	}

	public function getNIdCiudad() {
		return $this->nIdCiudad;
	}

	public function setORdb($value) {
		$this->oRdb = $value;
	}

	public function getORdb() {
		return $this->oRdb;
	}

	public function setOWdb($value) {
		$this->oWdb = $value;
	}

	public function getOWdb() {
		return $this->oWdb;
	}

	public function sp_select_colonias(){
		$array_params = array(
			array(
				'name'	=> 'sCodigoPostal',
				'value'	=> self::getNCodigoColonia(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('paycash_one');
		$this->oRdb->setSStoredProcedure('sp_select_colonias');
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
	} # sp_select_colonias
} # Cat_Colonia

?>