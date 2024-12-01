<?php

class ConciliacionOperacion{

	public $nIdCorte;
	public $nIdNivelConciliacion;
	public $nIdCadena;
	public $nIdSubCadena;
	public $nIdCorresponsal;
	public $nIdArchivo;
	public $oRdb;
	public $oWdb;

	public function setNIdCorte($value){
		$this->nIdCorte = $value;
	}

	public function getNIdCorte(){
		return $this->nIdCorte;
	}

	public function setNIdNivelConciliacion($value){
		$this->nIdNivelConciliacion = $value;
	}

	public function getNIdNivelConciliacion(){
		return $this->nIdNivelConciliacion;
	}

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
	}

	public function setNIdSubCadena($value){
		$this->nIdSubCadena = $value;
	}

	public function getNIdSubCadena(){
		return $this->nIdSubCadena;
	}

	public function setNIdCorresponsal($value){
		$this->nIdCorresponsal = $value;
	}

	public function getNIdCorresponsal(){
		return $this->nIdCorresponsal;
	}

	public function setNIdArchivo($value){
		$this->nIdArchivo = $value;
	}

	public function getNIdArchivo(){
		return $this->nIdArchivo;
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

	public function conciliar(){
		return $this->_conciliar();
	} # conciliar

	private function _conciliar(){
		$array_params = array(
			array(
				'name'	=> 'nIdCorte',
				'value'	=> self::getNIdCorte(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdNivelConciliacion',
				'value'	=> self::getNIdNivelConciliacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCadena',
				'value'	=> self::getNIdCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdSubCadena',
				'value'	=> self::getNIdSubCadena(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCorresponsal',
				'value'	=> self::getNIdCorresponsal(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdArchivo',
				'value'	=> self::getNIdArchivo(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_conciliar');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if(!$resultado['bExito'] || $resultado['nCodigo'] != 0){
			$resultado['sMensaje'] = 'Ha ocurrido un error al realizar la conciliacion';
			return $resultado;
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		$datos		= $data[0];
		$bExito		= ($datos['nCodigo'] == 0)? true : false;
		$nCodigo	= $datos['nCodigo'];
		$sMensaje	= $datos['sMensaje'];

		return array(
			'bExito'			=> $bExito,
			'nCodigo'			=> $nCodigo,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> ''
		);
	} # _conciliarCadena
} # Conciliacion

?>