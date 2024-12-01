<?php

class ExcelFileReaderColonias extends ExcelFileReader{

	public $oRdb;
	public $oWdb;
	public $idColonia;
	public $codigoColonia;
	public $nombreColonia;
	public $tipoAsentamiento;
	public $D_mnpio;
	public $d_estado;
	public $d_ciudad;
	public $d_CP;
	public $idEntidad;
	public $c_oficina;
	public $c_tipo_asenta;
	public $numMunicipio;
	public $id_asenta_cpcons;
	public $d_zona;
	public $idCiudad;
	public $c_mnpio;
	public $c_estado;
	public $d_codigo;
	public $d_asenta;	
	public $d_tipo_asenta;
	public $c_cve_ciudad;

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

	public function setIdColonia($value){
		$this->idColonia = $value;
	}

	public function getIdColonia(){
		return $this->idColonia;
	}

	public function setCodigoColonia($value){
		$this->codigoColonia = $value;
	}

	public function getCodigoColonia(){
		return $this->codigoColonia;
	}

	public function setNombreColonia($value){
		$this->nombreColonia = $value;
	}

	public function getNombreColonia(){
		return $this->nombreColonia;
	}

	public function setTipoAsentamiento($value){
		$this->tipoAsentamiento = $value;
	}

	public function getTipoAsentamiento(){
		return $this->tipoAsentamiento;
	}

	public function setD_mnpio($value){
		$this->D_mnpio = $value;
	}

	public function getD_mnpio(){
		return $this->D_mnpio;
	}

	public function setD_estado($value){
		$this->d_estado = $value;
	}

	public function getD_estado(){
		return $this->d_estado;
	}

	public function setD_ciudad($value){
		$this->d_ciudad = $value;
	}

	public function getD_ciudad(){
		return $this->d_ciudad;
	}

	public function setD_CP($value){
		$this->d_CP = $value;
	}

	public function getD_CP(){
		return $this->d_CP;
	}

	public function setIdEntidad($value){
		$this->idEntidad = $value;
	}

	public function getIdEntidad(){
		return $this->idEntidad;
	}

	public function setC_oficina($value){
		$this->c_oficina = $value;
	}

	public function getC_oficina(){
		return $this->c_oficina;
	}

	public function setC_tipo_asenta($value){
		$this->c_tipo_asenta = $value;
	}

	public function getC_tipo_asenta(){
		return $this->c_tipo_asenta;
	}

	public function setNumMunicipio($value){
		$this->numMunicipio = $value;
	}

	public function getNumMunicipio(){
		return $this->numMunicipio;
	}

	public function setId_asenta_cpcons($value){
		$this->id_asenta_cpcons = $value;
	}

	public function getId_asenta_cpcons(){
		return $this->id_asenta_cpcons;
	}

	public function setD_zona($value){
		$this->d_zona = $value;
	}

	public function getD_zona(){
		return $this->d_zona;
	}

	public function setIdCiudad($value){
		$this->idCiudad = $value;
	}

	public function getIdCiudad(){
		return $this->idCiudad;
	}

	public function setC_mnpio($value) {
		$this->c_mnpio = $value;
	}

	public function getC_mnpio() {
		return $this->c_mnpio;
	}

	public function setC_estado($value) {
		$this->c_estado = $value;
	}

	public function getC_estado() {
		return $this->c_estado;
	}

	public function setD_codigo($value) {
		$this->d_codigo = $value;
	}

	public function getD_codigo() {
		return $this->d_codigo;
	}

	public function setD_asenta($value) {
		$this->d_asenta = $value;
	}

	public function getD_asenta() {
		return $this->d_asenta;
	}

	public function setD_tipo_asenta($value) {
		$this->d_tipo_asenta = $value;
	}

	public function getD_tipo_asenta() {
		return $this->d_tipo_asenta;
	}

	public function setC_cve_ciudad($value) {
		$this->c_cve_ciudad = $value;
	}

	public function getC_cve_ciudad() {
		return $this->c_cve_ciudad;
	}

	public function validarColonias(){

		$resultado = self::truncate_temp_colonias();

		if(!$resultado['bExito']){
			return $resultado;
		}

		$array_props = array(
			0	=>	'd_codigo',
			1	=>	'd_asenta',
			2	=>	'd_tipo_asenta',
			3	=>	'D_mnpio',
			4	=>	'd_estado',
			5	=>	'd_ciudad',
			6	=>	'd_CP',
			7	=>	'c_estado',
			8	=>	'c_oficina',
			9	=>	'c_CP',
			10	=>	'c_tipo_asenta',
			11	=>	'c_mnpio',
			12	=>	'id_asenta_cpcons',
			13	=>	'd_zona',
			14	=>	'c_cve_ciudad'
		);

		$this->loadDataSets();

		$data	= $this->getArrayDataSets();
		$cuenta = 1;

		$nInsertadas	= 0;
		$nError			= 0;

		$cuenta			= 1;
		$nRegs			= $this->getNTotalDataSets();

		foreach($data AS $key => $fila){
			if($cuenta > 1){

				foreach($fila AS $prop => $value){
					$sProp = $array_props[$prop];

					if(property_exists('ExcelFileReaderColonias', $sProp)){
						$this->$sProp = utf8_decode($value);
					}

					$this->numMunicipio		= $this->c_mnpio * 1;
					$this->idEntidad		= $this->c_estado * 1;
					$this->codigoColonia	= $this->d_codigo * 1;
					$this->nombreColonia	= $this->d_asenta;
					$this->tipoAsentamiento	= $this->d_tipo_asenta;
					$this->D_mnpio			= $this->D_mnpio;
					$this->d_ciudad			= $this->d_ciudad;
					$this->idCiudad			= $this->c_cve_ciudad;
				}

				$resultado = self::_guardarColonia();

				if($resultado['bExito']){
					$nInsertadas+=1;
				}
				else{
					$nError+=1;
				}
			}

			$cuenta = 2;
		}

		if($nInsertadas > 0){
			$resultado = self::obtenerQuerys($nRegs);
		}

		$resultado['nInsertadas']	= $nInsertadas;
		$resultado['nError']		= $nError;

		return $resultado;
	} # validarColonias

	private function _guardarColonia(){
		$array_params = array(
			array(
				'name'		=> 'P_idColonia',
				'value'		=> null,
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_codigoColonia',
				'value'		=> self::getCodigoColonia(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_nombreColonia',
				'value'		=> self::getNombreColonia(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_tipoAsentamiento',
				'value'		=> self::getTipoAsentamiento(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_D_mnpio',
				'value'		=> self::getD_mnpio(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_d_estado',
				'value'		=> self::getD_estado(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_d_ciudad',
				'value'		=> self::getD_ciudad(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_d_CP',
				'value'		=> self::getD_CP(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_idEntidad',
				'value'		=> self::getIdEntidad(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_c_oficina',
				'value'		=> self::getC_oficina(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_c_tipo_asenta',
				'value'		=> self::getC_tipo_asenta(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_numMunicipio',
				'value'		=> self::getNumMunicipio(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_id_asenta_cpcons',
				'value'		=> self::getId_asenta_cpcons(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_d_zona',
				'value'		=> self::getD_zona(),
				'type'		=> 's'
			),
			array(
				'name'		=> 'P_idCiudad',
				'value'		=> self::getIdCiudad(),
				'type'		=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('temp_sp_insert_colonia_temp');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		$this->oWdb->closeStmt();

		return $resultado;
	} # _guardarColonia

	function obtenerQuerys($cuenta){
		$array_params = array(
			array(
				'name'		=> 'nIdEntidad',
				'value'		=> self::getIdEntidad(),
				'type'		=> 'i'
			),
			array(
				'name'		=> 'P_limit',
				'value'		=> $cuenta,
				'type'		=> 'i'
			)
		);

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('temp_sp_colonias_querys');
		$this->oWdb->setParams($array_params);

		$this->oWdb->setBDebug(1);

		$resultado = $this->oWdb->execute();
		
		$data = $this->oWdb->fetchAll();

		$this->oWdb->closeStmt();

		$array_query_inserts = array();
		$array_query_updates = array();

		foreach($data as $key => $row){
			if(!empty($row['query_update'])){
				$array_query_updates[] = $row['query_update'];
			}
			if(!empty($row['query_insert'])){
				$array_query_inserts[] = $row['query_insert'];
			}
		}

		$resultado['updates'] = $array_query_updates;
		$resultado['inserts'] = $array_query_inserts;

		return $resultado;
	} # obtenerQuerys

	private function truncate_temp_colonias(){
		$array_params = array();

		$this->oWdb->setSDatabase('redefectiva');
		$this->oWdb->setSStoredProcedure('temp_sp_truncate_colonias');
		$this->oWdb->setParams($array_params);

		$this->oWdb->setBDebug(1);

		$resultado = $this->oWdb->execute();

		$this->oWdb->closeStmt();

		return $resultado;
	}
} # Excel Colonias
?>