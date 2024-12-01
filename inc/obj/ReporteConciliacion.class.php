<?php

class ReporteConciliacion{

	public $oRdb;
	public $oWdb;
	public $dFechaInicio;
	public $dFechaFinal;

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

	public function setDFechaInicio($value){
		$this->dFechaInicio = $value;
	}

	public function getDFechaInicio(){
		return $this->dFechaInicio;
	}

	public function setDFechaFinal($value){
		$this->dFechaFinal = $value;
	}

	public function getDFechaFinal(){
		return $this->dFechaFinal;
	}

	/*
		
	*/
	public function obtenerConciliacionBanco($bAplicado = 0){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> self::getDFechaFinal(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'bAplicado',
				'value'	=> $bAplicado,
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_monitorbanco');
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
	} # obtenerConciliacionBanco

	/*
		
	*/
	public function obtenerConciliacionBancoForelo($bAgrupado = 0){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> self::getDFechaFinal(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'bAgrupado',
				'value'	=> $bAgrupado,
				'type'	=> 'i'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_monitorbancoforelo');
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
	} # obtenerConciliacionBanco

	public function obtenerConciliacionMovimientos(){
		$array_params = array(
			array(
				'name'	=> 'dFechaInicio',
				'value'	=> self::getDFechaInicio(),
				'type'	=> 's'
			),
			array(
				'name'	=> 'dFechaFinal',
				'value'	=> self::getDFechaFinal(),
				'type'	=> 's'
			)
		);

		$this->oRdb->setSDatabase('redefectiva');
		$this->oRdb->setSStoredProcedure('sp_select_monitormovimientos');
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
	} # obtenerConciliacionBanco
} # Reporte Conciliacion

?>