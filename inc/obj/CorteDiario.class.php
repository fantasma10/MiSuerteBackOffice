<?php

class CorteDiario{

	public $nIdNivelConciliacion;
	public $nIdCorte;
	public $nIdEstatus;
	public $nIdCadena;
	public $nIdPoliza;
	public $nTotalOperaciones;
	public $nTotalMonto;
	public $nTotalComision;
	public $nTotalComisionEspecial;
	public $dFecha;
	public $nIdSubCadena;
	public $nIdCorresponsal;
	public $oRdb;
	public $oWdb;

	public function setNIdNivelConciliacion($value){
		$this->nIdNivelConciliacion = $value;
	}

	public function getNIdNivelConciliacion(){
		return $this->nIdNivelConciliacion;
	}

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

	public function setNIdCadena($value){
		$this->nIdCadena = $value;
	}

	public function getNIdCadena(){
		return $this->nIdCadena;
	}

	public function setNIdPoliza($value){
		$this->nIdPoliza = $value;
	}

	public function getNIdPoliza(){
		return $this->nIdPoliza;
	}

	public function setNTotalOperaciones($value){
		$this->nTotalOperaciones = $value;
	}

	public function getNTotalOperaciones(){
		return $this->nTotalOperaciones;
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

	public function setNTotalComisionEspecial($value){
		$this->nTotalComisionEspecial = $value;
	}

	public function getNTotalComisionEspecial(){
		return $this->nTotalComisionEspecial;
	}

	public function setDFecha($value){
		$this->dFecha = $value;
	}

	public function getDFecha(){
		return $this->dFecha;
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

	/*
		Obtiene los cortes diarios de cualquier nivel (debe indicarse el nivel)
	*/
	public function sp_select_corte(){
		$array_params = array(
			array(
				'name'	=> 'nIdNivelConciliacion',
				'value'	=> self::getNIdNivelConciliacion(),
				'type'	=> 'i'
			),
			array(
				'name'	=> 'nIdCorte',
				'value'	=> self::getNIdCorte(),
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
			)
		);

		$this->oRdb->setSDatabase('data_contable');
		$this->oRdb->setSStoredProcedure('sp_select_corte');
		$this->oRdb->setParams($array_params);

		$resultado = $this->oRdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
		}

		$data = $this->oRdb->fetchAll();
		$this->oRdb->closeStmt();

		$found_rows = $this->oRdb->foundRows();
		$this->oRdb->closeStmt();

		return array(
			'bExito'			=> true,
			'nCodigo'			=> 0,
			'sMensaje'			=> '',
			'sMensajeDetallado'	=> '',
			'data'				=> $data,
			'found_rows'		=> $found_rows
		);
	} # sp_select_corte

	public function sp_liberar_corte(){
		$array_params = array(
			array(
				'name'	=> 'nIdCorte',
				'value'	=> self::getNIdCorte(),
				'type'	=> 'i'
			)
		);

		$this->oWdb->setSDatabase('data_contable');
		$this->oWdb->setSStoredProcedure('sp_modificar_estatus');
		$this->oWdb->setParams($array_params);

		$resultado = $this->oWdb->execute();

		if($resultado['bExito'] == false || $resultado['nCodigo'] != 0){
			echo json_encode($resultado);
			exit();
		}

		$data = $this->oWdb->fetchAll();
		$this->oWdb->closeStmt();

		$datos = $data[0];
		$nCodigo	= $datos['nCodigo'];
		$sMensaje	= $datos['sMensaje'];

		$bExito = ($nCodigo == 0)? true : false;

		return array(
			'bExito'			=> $bExito,
			'nCodigo'			=> $nCodigo,
			'sMensaje'			=> $sMensaje,
			'sMensajeDetallado'	=> '',
			'data'				=> $data
		);
	} # sp_liberar_corte
} # CorteDiario

?>